<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReunionRsvpResource\Pages;
use App\Models\ReunionRsvp;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class ReunionRsvpResource extends Resource
{
    protected static ?string $model = ReunionRsvp::class;

    protected static ?string $navigationGroup = 'Quản lý Thiệp';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Khách xác nhận';
    protected static ?string $modelLabel = 'Khách xác nhận';
    protected static ?string $pluralModelLabel = 'Danh sách Khách xác nhận';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (!auth()->user()->hasRole('super_admin')) {
            $query->whereHas('reunion', function (Builder $q) {
                $q->where('user_id', auth()->id());
            });
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('reunion_id')
                    ->relationship('reunion', 'slug', function (Builder $query) {
                        if (!auth()->user()->hasRole('super_admin')) {
                            return $query->where('user_id', auth()->id());
                        }
                        return $query;
                    })
                    ->label('Thuộc Thiệp')
                    ->disabledOn('edit')
                    ->required(),
                TextInput::make('name')
                    ->label('Họ tên')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Số điện thoại')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('guest_count')
                    ->label('Số lượng người (Bao gồm bản thân)')
                    ->required()
                    ->numeric()
                    ->default(1),
                Textarea::make('note')
                    ->label('Lời nhắn (hoặc Lớp)')
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'attending' => 'Sẽ tham dự',
                        'declined' => 'Không thể tham dự',
                        'pending' => 'Chưa chắc chắn',
                    ])
                    ->required()
                    ->default('attending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reunion.slug')
                    ->label('Thuộc Thiệp')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Họ tên')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Số ĐT')
                    ->searchable(),
                TextColumn::make('guest_count')
                    ->label('Số Người')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->colors([
                        'success' => 'attending',
                        'danger' => 'declined',
                        'warning' => 'pending',
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'attending' => 'Sẽ tham dự',
                        'declined' => 'Không',
                        'pending' => 'Chưa chắc',
                        default => $state,
                    })
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Ngày gửi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()->slideOver(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReunionRsvps::route('/'),
        ];
    }
}
