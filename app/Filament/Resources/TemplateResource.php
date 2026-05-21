<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemplateResource\Pages;
use App\Models\Template;
use App\Support\TemplateViewRegistry;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Artisan;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Get;
use Filament\Forms\Set;

class TemplateResource extends Resource
{
    protected static ?string $model = Template::class;

    public const TYPE_REUNION = 'reunion';

    public const TYPE_REUNION_TEACHER = 'reunion_teacher';

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
        return Filament::getCurrentPanel()->getId() === 'admin';
    }

    public static function canAccess(): bool
    {
        return Filament::getCurrentPanel()->getId() === 'admin'
            && (auth()->user()->isSuperAdmin() || auth()->user()->isAdmin());
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('type', array_keys(self::templateTypeOptions()));
    }

    public static function templateTypeOptions(): array
    {
        return [
            self::TYPE_REUNION => 'Thiệp họp lớp',
            self::TYPE_REUNION_TEACHER => 'Thiệp thầy cô',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Template Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Thông tin mẫu')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Tên mẫu')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\Select::make('type')
                                    ->label('Loại template')
                                    ->options(self::templateTypeOptions())
                                    ->default(self::TYPE_REUNION)
                                    ->required()
                                    ->live()
                                    ->helperText('Chọn “Thiệp thầy cô” cho các mẫu chỉ dùng ở link /thay-co.'),

                                Forms\Components\TextInput::make('view_path')
                                    ->label('Đường dẫn file Blade')
                                    ->required()
                                    ->datalist(fn (Get $get): array => TemplateViewRegistry::paths($get('type') ?: self::TYPE_REUNION))
                                    ->maxLength(255)
                                    ->placeholder('templates.que-vo-2')
                                    ->rule(function () {
                                        return function (string $attribute, $value, \Closure $fail): void {
                                            $value = (string) $value;

                                            if (! TemplateViewRegistry::exists($value)) {
                                                $fail('Không tìm thấy file Blade tương ứng trong resources/views.');
                                            }
                                        };
                                    })
                                    ->helperText('VD: resources/views/templates/que-vo-2.blade.php => templates.que-vo-2')
                                    ->columnSpanFull(),

                                Forms\Components\Hidden::make('required_tier')
                                    ->default('standard'),

                                Forms\Components\FileUpload::make('thumbnail_url')
                                    ->label('Ảnh đại diện mẫu')
                                    ->image()
                                    ->disk('public')
                                    ->directory('templates')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->maxSize(10240)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->columnSpanFull(),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Kích hoạt')
                                    ->default(true)
                                    ->required(),
                            ])
                            ->columns(2),

                        Forms\Components\Tabs\Tab::make('Cấu hình Media')
    ->schema([
        Forms\Components\Placeholder::make('media_schema_note')
            ->label('')
            ->content('Khai báo các ảnh/video mà template này cần. Có thể chỉnh bằng UI bên dưới hoặc bấm nút dán JSON nhanh.'),

        Actions::make([
            FormAction::make('paste_media_schema_json')
                ->label('Dán JSON nhanh')
                ->icon('heroicon-o-code-bracket-square')
                ->color('info')
                ->modalHeading('Dán Media Schema JSON')
                ->modalWidth('5xl')
                ->form([
                    Forms\Components\Textarea::make('media_schema_json')
                        ->label('Media Schema JSON')
                        ->rows(24)
                        ->required()
                        ->default(function (Get $get): string {
                            $schema = $get('media_schema');

                            if (! is_array($schema) || empty($schema)) {
                                $schema = TemplateResource::defaultReunionMediaSchema();
                            }

                            return json_encode(
                                $schema,
                                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                            );
                        })
                        ->helperText('Dán JSON hợp lệ có cấu trúc {"groups": [...]} rồi bấm Lưu.'),
                ])
                ->action(function (array $data, Set $set): void {
                    $json = $data['media_schema_json'] ?? '';

                    $schema = json_decode($json, true);

                    if (json_last_error() !== JSON_ERROR_NONE || ! is_array($schema)) {
                        Notification::make()
                            ->title('JSON không hợp lệ')
                            ->body(json_last_error_msg())
                            ->danger()
                            ->send();

                        return;
                    }

                    if (! isset($schema['groups']) || ! is_array($schema['groups'])) {
                        Notification::make()
                            ->title('Thiếu key groups')
                            ->body('Media schema cần có cấu trúc: {"groups": [...]}')
                            ->danger()
                            ->send();

                        return;
                    }

                    $set('media_schema', TemplateResource::sanitizeMediaSchema($schema));

                    Notification::make()
                        ->title('Đã nạp JSON vào form')
                        ->body('Anh nhớ bấm Lưu template để ghi vào database.')
                        ->success()
                        ->send();
                }),

            FormAction::make('load_default_media_schema')
                ->label('Nạp mẫu mặc định')
                ->icon('heroicon-o-photo')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Nạp cấu hình media mặc định?')
                ->modalDescription('Hành động này sẽ thay thế cấu hình hiện tại trong form bằng preset: logo, hero background, 3 ảnh hero, video cover và video.')
                ->action(function (Set $set): void {
                    $set('media_schema', TemplateResource::defaultReunionMediaSchema());

                    Notification::make()
                        ->title('Đã nạp preset media')
                        ->body('Anh nhớ bấm Lưu template để ghi vào database.')
                        ->success()
                        ->send();
                }),
        ])
            ->alignStart()
            ->columnSpanFull(),

        Forms\Components\Repeater::make('media_schema.groups')
            ->label('Nhóm media')
            ->addActionLabel('Thêm nhóm media')
            ->collapsible()
            ->cloneable()
            ->reorderable()
            ->default(TemplateResource::defaultReunionMediaSchema()['groups'])
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Tên nhóm')
                    ->placeholder('VD: Khu vực Hero, Ảnh nhận diện, Video')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Repeater::make('fields')
                    ->label('Danh sách ảnh/video')
                    ->addActionLabel('Thêm ảnh/video')
                    ->collapsible()
                    ->cloneable()
                    ->reorderable()
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('Key')
                            ->placeholder('VD: hero_photo_1')
                            ->required()
                            ->maxLength(100)
                            ->helperText('Key nội bộ, nên viết không dấu, không khoảng trắng.'),

                        Forms\Components\TextInput::make('label')
                            ->label('Tên hiển thị')
                            ->placeholder('VD: Ảnh Hero 1')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('type')
                            ->label('Loại file')
                            ->options([
                                'image' => 'Ảnh',
                                'video' => 'Video',
                            ])
                            ->default('image')
                            ->required()
                            ->live(),

                        Forms\Components\TextInput::make('collection')
                            ->label('Media collection')
                            ->placeholder('VD: hero_photo_1')
                            ->required()
                            ->maxLength(100)
                            ->helperText('Nên đặt giống Key để dễ mapping với Blade/controller.'),

                        Forms\Components\TextInput::make('max_size')
                            ->label('Dung lượng tối đa KB')
                            ->numeric()
                            ->default(fn (Get $get) => $get('type') === 'video' ? 102400 : 10240)
                            ->helperText('Ảnh: 10240 KB. Video: 102400 KB.'),

                        Forms\Components\Toggle::make('single')
                            ->label('Chỉ cho 1 file')
                            ->default(true),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ])
            ->columnSpanFull(),
    ])
    ->columns(1),

                        Forms\Components\Tabs\Tab::make('JSON nâng cao')
                            ->schema([
                                Forms\Components\Placeholder::make('json_note')
                                    ->label('')
                                    ->content('Tab này chỉ để kiểm tra nhanh cấu trúc media_schema. Bình thường anh cấu hình bằng tab “Cấu hình Media” là đủ.'),

                                Forms\Components\KeyValue::make('metadata')
                                    ->label('Metadata mở rộng')
                                    ->keyLabel('Key')
                                    ->valueLabel('Value')
                                    ->addActionLabel('Thêm metadata')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
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
                    ->label('Loại')
                    ->formatStateUsing(fn (?string $state): string => self::templateTypeOptions()[$state] ?? (string) $state)
                    ->badge()
                    ->color(fn (?string $state): string => $state === self::TYPE_REUNION_TEACHER ? 'warning' : 'info'),

                Tables\Columns\TextColumn::make('media_schema')
                    ->label('Media')
                    ->formatStateUsing(function ($state): string {
                        $groups = is_array($state) ? ($state['groups'] ?? []) : [];
                        $fieldCount = collect($groups)->sum(fn ($group) => count($group['fields'] ?? []));

                        return $fieldCount > 0
                            ? $fieldCount . ' media field'
                            : 'Chưa cấu hình';
                    })
                    ->badge()
                    ->color(function ($state): string {
                        $groups = is_array($state) ? ($state['groups'] ?? []) : [];
                        $fieldCount = collect($groups)->sum(fn ($group) => count($group['fields'] ?? []));

                        return $fieldCount > 0 ? 'success' : 'gray';
                    }),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Bật/Tắt'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Loại template')
                    ->options(self::templateTypeOptions()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('preset_reunion_hero')
                    ->label('Preset Media')
                    ->icon('heroicon-o-photo')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Gán preset media cho mẫu họp lớp?')
                    ->modalDescription('Hành động này sẽ ghi đè cấu hình media_schema hiện tại bằng preset gồm logo, hero 3 ảnh, video cover và video.')
                    ->action(function (Template $record): void {
                        $record->update([
                            'media_schema' => self::defaultReunionMediaSchema(),
                        ]);

                        Notification::make()
                            ->title('Đã gán preset media cho template')
                            ->success()
                            ->send();
                    }),
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
                        Artisan::call('templates:sync');

                        Notification::make()
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

    public static function defaultReunionMediaSchema(): array
{
    return [
        'groups' => [
            [
                'name' => 'Ảnh nhận diện',
                'fields' => [
                    [
                        'key' => 'logo',
                        'label' => 'Logo',
                        'type' => 'image',
                        'collection' => 'logo',
                        'max_size' => 10240,
                        'single' => true,
                    ],
                ],
            ],
            [
                'name' => 'Khu vực Hero',
                'fields' => [
                    [
                        'key' => 'hero_background',
                        'label' => 'Ảnh nền Hero',
                        'type' => 'image',
                        'collection' => 'hero_background',
                        'max_size' => 10240,
                        'single' => true,
                    ],
                    [
                        'key' => 'hero_photo_1',
                        'label' => 'Ảnh Hero 1',
                        'type' => 'image',
                        'collection' => 'hero_photo_1',
                        'max_size' => 10240,
                        'single' => true,
                    ],
                    [
                        'key' => 'hero_photo_2',
                        'label' => 'Ảnh Hero 2',
                        'type' => 'image',
                        'collection' => 'hero_photo_2',
                        'max_size' => 10240,
                        'single' => true,
                    ],
                    [
                        'key' => 'hero_photo_3',
                        'label' => 'Ảnh Hero 3',
                        'type' => 'image',
                        'collection' => 'hero_photo_3',
                        'max_size' => 10240,
                        'single' => true,
                    ],
                ],
            ],
            [
                'name' => 'Video',
                'fields' => [
                    [
                        'key' => 'video_cover',
                        'label' => 'Ảnh bìa Video',
                        'type' => 'image',
                        'collection' => 'video_cover',
                        'max_size' => 10240,
                        'single' => true,
                    ],
                    [
                        'key' => 'video',
                        'label' => 'Video Trailer MP4',
                        'type' => 'video',
                        'collection' => 'video',
                        'max_size' => 102400,
                        'single' => true,
                    ],
                ],
            ],
        ],
    ];
}

    public static function sanitizeMediaSchema(mixed $schema): array
    {
        if (!is_array($schema)) {
            return [];
        }

        $groups = collect($schema['groups'] ?? [])
            ->filter(fn ($group): bool => is_array($group))
            ->map(function (array $group): array {
                $group['fields'] = collect($group['fields'] ?? [])
                    ->filter(fn ($field): bool => is_array($field))
                    ->reject(fn (array $field): bool => ($field['collection'] ?? $field['key'] ?? null) === 'share')
                    ->values()
                    ->all();

                return $group;
            })
            ->values()
            ->all();

        $schema['groups'] = $groups;

        return $schema;
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
