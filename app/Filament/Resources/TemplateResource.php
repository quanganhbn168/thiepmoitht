<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemplateResource\Pages;
use App\Models\Template;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TemplateResource extends Resource
{
    protected static ?string $model = Template::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-rectangle-stack';
    }

    public static function getNavigationLabel(): string
    {
        return 'Kho Giao diện';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Cài đặt';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return \Filament\Facades\Filament::getCurrentPanel()->getId() === 'admin';
    }

    public static function canAccess(): bool
    {
        return \Filament\Facades\Filament::getCurrentPanel()->getId() === 'admin' 
            && (auth()->user()->isSuperAdmin() || auth()->user()->isAdmin());
    }

    // Query filter removed to allow showing all template types

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Tên mẫu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('view_path')
                    ->label('Đường dẫn file (View Path)')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Ví dụ: templates.modern_01'),
                Forms\Components\Select::make('type')
                    ->label('Loại')
                    ->options([
                        'wedding' => 'Wedding',
                    ])
                    ->default('wedding')
                    ->required(),
                Forms\Components\Select::make('required_tier')
                    ->label('Gói yêu cầu')
                    ->options(\App\Enums\WeddingTier::optionsWithPrice())
                    ->default('basic')
                    ->required()
                    ->helperText('Khách hàng phải mua gói này hoặc cao hơn để sử dụng mẫu'),
                Forms\Components\FileUpload::make('thumbnail_url')
                    ->label('Ảnh đại diện')
                    ->image()
                    ->disk('public')
                    ->directory('templates'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Kích hoạt')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Ảnh')
                    ->defaultImageUrl('https://placehold.co/100x100?text=No+Image')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên giao diện')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (Template $record) => $record->view_path),
                Tables\Columns\TextColumn::make('type')
                    ->label('Phân loại')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'wedding' => 'success',
                        'business' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('tier')
                    ->label('Gói')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        \App\Enums\WeddingTier::PRO->value => 'warning',
                        default => 'gray', // Standard
                    })
                    ->formatStateUsing(fn (?string $state): string => \App\Enums\WeddingTier::tryFrom($state)?->label() ?? strtoupper($state)),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Bật/Tắt'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'wedding' => 'Wedding',
                        'business' => 'Business',
                    ]),
                Tables\Filters\SelectFilter::make('tier')
                    ->label('Gói dịch vụ')
                    ->options(\App\Enums\WeddingTier::options()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('sync')
                    ->label('🔄 Sync Templates')
                    ->action(function () {
                        \Artisan::call('templates:sync');
                        \Filament\Notifications\Notification::make()
                            ->title('Templates synced!')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Sync Templates')
                    ->modalDescription('Scan template files and sync to database?')
                    ->color('success'),
            ]);
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
            'index' => Pages\ListTemplates::route('/'),
            'create' => Pages\CreateTemplate::route('/create'),
            'edit' => Pages\EditTemplate::route('/{record}/edit'),
        ];
    }
}
