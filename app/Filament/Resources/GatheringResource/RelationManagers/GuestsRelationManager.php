<?php

namespace App\Filament\Resources\GatheringResource\RelationManagers;

use App\Models\GatheringGuest;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

class GuestsRelationManager extends RelationManager
{
    protected static string $relationship = 'guests';

    protected static ?string $title = 'Khách mời & link cá nhân';

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Tên khách mời')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(function (Set $set, Get $get, ?string $state): void {
                    if (blank($get('code')) && filled($state)) {
                        $set('code', Str::slug($state));
                    }
                })
                ->maxLength(255),
            TextInput::make('code')
                ->label('Mã link')
                ->required()
                ->helperText('Tự tạo từ tên; có thể sửa để link ngắn hơn.')
                ->rule('regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                ->maxLength(255),
            TextInput::make('greeting')
                ->label('Lời xưng hô riêng')
                ->placeholder('VD: Anh Tuấn thân mến,'),
            TextInput::make('phone')
                ->label('Số điện thoại')
                ->tel()
                ->maxLength(30),
            Textarea::make('note')
                ->label('Lời nhắn riêng')
                ->placeholder('VD: Cả nhóm mong chờ màn karaoke của ông đấy!')
                ->rows(3)
                ->columnSpanFull(),
        ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->label('Khách mời')->searchable()->weight('bold'),
                TextColumn::make('code')->label('Mã link')->toggleable(),
                TextColumn::make('rsvp_status')->label('Phản hồi')->badge()->color(fn (string $state): string => match ($state) {
                    'attending' => 'success', 'declined' => 'danger', default => 'gray',
                })->formatStateUsing(fn (string $state): string => match ($state) {
                    'attending' => 'Có mặt', 'declined' => 'Vắng mặt', default => 'Chưa phản hồi',
                }),
                TextColumn::make('responded_at')->label('Phản hồi lúc')->dateTime('H:i d/m/Y')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('invitation_url')
                    ->label('Link mời riêng')
                    ->state(fn (GatheringGuest $record): string => route('gathering.invitation.show', [
                        'gathering' => $this->getOwnerRecord()->slug,
                        'guest' => $record->code,
                    ]))
                    ->copyable()
                    ->copyMessage('Đã chép link mời riêng')
                    ->url(fn (GatheringGuest $record): string => route('gathering.invitation.show', [
                        'gathering' => $this->getOwnerRecord()->slug,
                        'guest' => $record->code,
                    ]))
                    ->openUrlInNewTab(),
            ])
            ->headerActions([
                Action::make('quick_add')
                    ->label('Nhập danh sách nhanh')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->color('success')
                    ->modalHeading('Nhập danh sách khách mời')
                    ->modalDescription('Mỗi người một dòng. Hệ thống tự tạo mã và link mời riêng cho từng người.')
                    ->modalSubmitActionLabel('Tạo danh sách khách mời')
                    ->form([
                        Textarea::make('guest_names')
                            ->label('Danh sách khách mời')
                            ->placeholder("Nguyễn Văn An\nTrần Thị Bình\nLê Minh Cường")
                            ->rows(18)
                            ->required()
                            ->helperText('Có thể paste trực tiếp từ Excel hoặc Zalo. Dòng trống sẽ được bỏ qua.'),
                    ])
                    ->action(function (array $data): void {
                        $names = collect(preg_split('/\R/u', (string) $data['guest_names']))
                            ->map(function (string $line): string {
                                $name = trim($line);

                                return trim((string) preg_replace('/^(?:[-*•]|\d+[.)])\s*/u', '', $name));
                            })
                            ->filter()
                            ->values();

                        if ($names->isEmpty()) {
                            Notification::make()
                                ->title('Chưa có tên khách mời hợp lệ')
                                ->warning()
                                ->send();

                            return;
                        }

                        $this->getOwnerRecord()->guests()->createMany(
                            $names->map(fn (string $name): array => [
                                'name' => $name,
                                'rsvp_status' => 'pending',
                            ])->all()
                        );

                        Notification::make()
                            ->title('Đã tạo ' . $names->count() . ' khách mời')
                            ->body('Mỗi người đã có một link mời riêng để copy và gửi.')
                            ->success()
                            ->send();
                    }),

                CreateAction::make()->label('Thêm từng khách'),
            ])
            ->actions([EditAction::make(), DeleteAction::make()])
            ->defaultSort('created_at', 'desc');
    }
}
