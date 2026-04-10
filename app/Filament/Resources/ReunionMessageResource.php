<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReunionMessageResource\Pages;
use App\Models\ReunionMessage;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class ReunionMessageResource extends Resource
{
    protected static ?string $model = ReunionMessage::class;

    protected static ?string $navigationGroup = 'Quản lý Thiệp';
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationLabel = 'Sổ lưu bút';
    protected static ?string $modelLabel = 'Lời chúc';
    protected static ?string $pluralModelLabel = 'Sổ lưu bút';

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
                    ->label('Người gửi')
                    ->required()
                    ->maxLength(255),
                Textarea::make('content')
                    ->label('Nội dung lời chúc')
                    ->columnSpanFull()
                    ->required(),
                Toggle::make('is_approved')
                    ->label('Duyệt hiển thị')
                    ->default(true)
                    ->required(),
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
                    ->label('Người gửi')
                    ->searchable(),
                TextColumn::make('content')
                    ->label('Nội dung')
                    ->limit(50)
                    ->searchable(),
                ToggleColumn::make('is_approved')
                    ->label('Được duyệt')
                    ->sortable(),
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
            'index' => Pages\ListReunionMessages::route('/'),
        ];
    }
}
