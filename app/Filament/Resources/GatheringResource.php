<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GatheringResource\Pages;
use App\Filament\Resources\GatheringResource\RelationManagers\GuestsRelationManager;
use App\Models\Gathering;
use App\Models\Template;
use App\Support\VietQrBanks;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class GatheringResource extends Resource
{
    protected static ?string $model = Gathering::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Quản lý Thiệp';

    protected static ?string $navigationLabel = 'Thiệp Hội ngộ';

    protected static ?string $modelLabel = 'Thiệp Hội ngộ';

    protected static ?string $pluralModelLabel = 'Danh sách Thiệp Hội ngộ';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make('Hội ngộ')
                ->tabs([
                    Tab::make('Thông tin chung')
                        ->schema([
                            TextInput::make('title')
                                ->label('Tên buổi hội ngộ')
                                ->placeholder('VD: Kèo tất niên anh em 2026')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Set $set, Get $get, ?string $state): void {
                                    if (blank($get('slug')) && filled($state)) {
                                        $set('slug', str($state)->slug()->toString());
                                    }
                                })
                                ->maxLength(255)
                                ->columnSpanFull(),

                            TextInput::make('slug')
                                ->label('Slug sự kiện')
                                ->placeholder('VD: tat-nien-anh-em-2026')
                                ->required(fn (string $operation): bool => $operation === 'edit')
                                ->unique(ignoreRecord: true)
                                ->rule('regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                                ->helperText('Chỉ phần tên sự kiện, không thêm “hoi-ngo”. Link chung: /hoi-ngo/{slug}; link cá nhân: /hoi-ngo/{slug}/{ten-khach}.'),

                            TextInput::make('host_name')
                                ->label('Người/Ban đứng ra mời')
                                ->placeholder('VD: Hội anh em 12A3'),

                            Select::make('template_id')
                                ->label('Mẫu giao diện')
                                ->relationship('template', 'name', fn ($query) => $query
                                    ->where('type', TemplateResource::TYPE_GATHERING)
                                    ->where('is_active', true)
                                    ->orderBy('name'))
                                ->default(fn () => Template::query()
                                    ->where('type', TemplateResource::TYPE_GATHERING)
                                    ->where('view_path', 'templates.gathering-cheers')
                                    ->value('id'))
                                ->searchable()
                                ->preload()
                                ->helperText('Chưa có mẫu nào trong Kho giao diện thì hệ thống vẫn dùng mẫu “Kèo thân tình” mặc định.'),

                            Select::make('user_id')
                                ->relationship('user', 'name')
                                ->label('Khách hàng sở hữu')
                                ->searchable()
                                ->preload()
                                ->hidden(fn (): bool => auth()->user()?->isCustomer() ?? false)
                                ->dehydrated(fn (): bool => ! (auth()->user()?->isCustomer() ?? false)),

                            DatePicker::make('event_date')
                                ->label('Ngày tổ chức')
                                ->native(false),

                            DateTimePicker::make('event_time')
                                ->label('Giờ bắt đầu')
                                ->seconds(false)
                                ->native(false),

                            TextInput::make('venue_name')
                                ->label('Tên địa điểm')
                                ->placeholder('VD: Quán Bia Hơi Hà Nội')
                                ->maxLength(255),

                            TextInput::make('venue_address')
                                ->label('Địa chỉ')
                                ->maxLength(255),

                            TextInput::make('map_url')
                                ->label('Link Google Maps')
                                ->url()
                                ->maxLength(500)
                                ->columnSpanFull(),

                            TextInput::make('contact_name')
                                ->label('Người liên hệ')
                                ->maxLength(255),

                            TextInput::make('contact_phone')
                                ->label('Số điện thoại liên hệ')
                                ->tel()
                                ->maxLength(30),
                        ])
                        ->columns(2),

                    Tab::make('Lời mời & lịch trình')
                        ->schema([
                            TextInput::make('content.invitation_headline')
                                ->label('Câu mời nổi bật')
                                ->default('Kèo này không được vắng mặt')
                                ->maxLength(255)
                                ->columnSpanFull(),

                            RichEditor::make('content.introduction')
                                ->label('Nội dung lời mời chung')
                                ->default('<p>Đủ lâu rồi chúng ta chưa ngồi lại với nhau. Mời bạn đến một buổi gặp gỡ thật vui, kể chuyện cũ và cụng ly cho những ngày mới.</p><p><strong>Có mặt là vui, vắng mặt là tiếc.</strong></p>')
                                ->toolbarButtons(['bold', 'italic', 'underline', 'h2', 'h3', 'bulletList', 'orderedList', 'link', 'redo', 'undo'])
                                ->columnSpanFull(),

                            TextInput::make('content.dress_code')
                                ->label('Dress code (nếu có)')
                                ->placeholder('VD: Áo tối màu, lên đồ thoải mái'),

                            TextInput::make('content.menu_note')
                                ->label('Ghi chú cho khách')
                                ->placeholder('VD: Có thể gửi xe ở tầng hầm'),

                            Textarea::make('content.host_note')
                                ->label('Lời nhắn của người mời')
                                ->placeholder('VD: Mỗi người bớt một lý do, thêm một cuộc vui nhé!')
                                ->rows(3)
                                ->columnSpanFull(),

                            Repeater::make('content.schedule')
                                ->label('Lịch trình')
                                ->addActionLabel('Thêm mốc')
                                ->default([
                                    ['time' => '18:00', 'title' => 'Có mặt và gọi món', 'description' => 'Anh em điểm danh, vào bàn.'],
                                    ['time' => '19:00', 'title' => 'Khai tiệc', 'description' => 'Cụng ly mở màn và ôn chuyện cũ.'],
                                ])
                                ->schema([
                                    TextInput::make('time')->label('Giờ')->placeholder('18:00')->maxLength(30),
                                    TextInput::make('title')->label('Nội dung')->required()->maxLength(255),
                                    Textarea::make('description')->label('Mô tả')->rows(2)->columnSpanFull(),
                                ])
                                ->columns(2)
                                ->columnSpanFull(),
                        ]),

                    Tab::make('Ảnh & chia sẻ')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('cover')
                                ->label('Ảnh nền thiệp')
                                ->collection('cover')
                                ->image()
                                ->imageEditor()
                                ->maxSize(10240)
                                ->helperText('Không bắt buộc. Nếu chưa có, template dùng nền màu mặc định.')
                                ->columnSpanFull(),

                            SpatieMediaLibraryFileUpload::make('share')
                                ->label('Ảnh chia sẻ Facebook/Zalo')
                                ->collection('share')
                                ->image()
                                ->imageEditor()
                                ->maxSize(10240)
                                ->columnSpanFull(),

                            SpatieMediaLibraryFileUpload::make('gallery')
                                ->label('Album ảnh không khí')
                                ->collection('gallery')
                                ->multiple()
                                ->reorderable()
                                ->image()
                                ->imageEditor()
                                ->maxFiles(12)
                                ->maxSize(10240)
                                ->helperText('Tối đa 12 ảnh. Album chỉ hiện khi có ảnh; dùng cho khoảnh khắc, bàn tiệc hoặc ảnh nhóm.')
                                ->columnSpanFull(),
                        ]),

                    Tab::make('Bố cục Ký ức')
                        ->schema([
                            TextInput::make('content.layout.hero_kicker')
                                ->label('Dòng giới thiệu trên hero')
                                ->placeholder('VD: Hội cựu nhân viên · Hội ngộ 2026')
                                ->maxLength(255)
                                ->columnSpanFull(),

                            Textarea::make('content.layout.hero_title')
                                ->label('Tiêu đề lớn trên hero')
                                ->placeholder('VD: Hẹn gặp lại những người bạn cũ')
                                ->helperText('Mẫu “Ký ức dựng xây”. Có thể xuống dòng bằng Enter.')
                                ->rows(2)
                                ->maxLength(255)
                                ->columnSpanFull(),

                            Textarea::make('content.layout.hero_note')
                                ->label('Đoạn giới thiệu trên hero')
                                ->rows(3)
                                ->maxLength(500)
                                ->columnSpanFull(),

                            TextInput::make('content.layout.hero_photo_label')
                                ->label('Nhãn ảnh hero')
                                ->placeholder('VD: Laird Việt Nam')
                                ->maxLength(255),

                            Textarea::make('content.layout.hero_photo_caption')
                                ->label('Chú thích ảnh hero')
                                ->rows(2)
                                ->maxLength(500),

                            Repeater::make('content.layout.timeline')
                                ->label('Hai dấu mốc kỷ niệm')
                                ->addActionLabel('Thêm dấu mốc')
                                ->default([
                                    ['date' => 'Ngày ấy', 'title' => 'Những kỷ niệm còn đây', 'description' => 'Những con người từng đồng hành và một chặng đường đáng nhớ.'],
                                    ['date' => 'Ngày gặp lại', 'title' => 'Hẹn gặp lại nhau', 'description' => 'Một cuộc hẹn để cùng nhìn lại và nối tiếp những kết nối đã từng có.'],
                                ])
                                ->schema([
                                    TextInput::make('date')->label('Mốc thời gian')->required()->maxLength(50),
                                    TextInput::make('title')->label('Tiêu đề')->required()->maxLength(255),
                                    Textarea::make('description')->label('Mô tả')->rows(2)->columnSpanFull(),
                                ])
                                ->columns(2)
                                ->columnSpanFull(),

                            TextInput::make('content.layout.milestone_label')
                                ->label('Nhãn ảnh kỷ niệm 1')
                                ->placeholder('VD: Tư liệu kỷ niệm')
                                ->maxLength(255),

                            Textarea::make('content.layout.milestone_heading')
                                ->label('Tiêu đề khu ảnh kỷ niệm 1')
                                ->placeholder('VD: Một dấu mốc để nhớ')
                                ->rows(2)
                                ->maxLength(255),

                            TextInput::make('content.layout.milestone_date')
                                ->label('Mốc thời gian cho ảnh 1')
                                ->placeholder('VD: 01 / 02 · 11.06.2014')
                                ->maxLength(100),

                            TextInput::make('content.layout.milestone_title')
                                ->label('Tiêu đề ảnh kỷ niệm 1')
                                ->maxLength(255),

                            Textarea::make('content.layout.milestone_description')
                                ->label('Chú thích ảnh kỷ niệm 1')
                                ->rows(3)
                                ->columnSpanFull(),

                            TextInput::make('content.layout.team_label')
                                ->label('Nhãn ảnh kỷ niệm 2')
                                ->placeholder('VD: Những gương mặt năm ấy')
                                ->maxLength(255),

                            Textarea::make('content.layout.team_heading')
                                ->label('Tiêu đề khu ảnh kỷ niệm 2')
                                ->placeholder('VD: Tập thể ngày ấy')
                                ->rows(2)
                                ->maxLength(255),

                            Textarea::make('content.layout.team_intro')
                                ->label('Mô tả ảnh kỷ niệm 2')
                                ->rows(3)
                                ->columnSpanFull(),

                            TextInput::make('content.layout.team_credit_label')
                                ->label('Nhãn caption ảnh 2')
                                ->placeholder('VD: Ký ức tập thể')
                                ->maxLength(255),

                            Textarea::make('content.layout.team_credit')
                                ->label('Caption ảnh 2')
                                ->rows(2)
                                ->columnSpanFull(),
                        ])
                        ->columns(2),

                    Tab::make('QR đóng quỹ')
                        ->schema([
                            Toggle::make('content.payment.enabled')
                                ->label('Hiển thị QR đóng quỹ trên thiệp')
                                ->helperText('Bật khi cần khách chuyển khoản trước hoặc đóng quỹ cho buổi hội ngộ.')
                                ->default(false)
                                ->live()
                                ->columnSpanFull(),

                            Select::make('content.payment.bank_bin')
                                ->label('Ngân hàng nhận tiền')
                                ->options(fn (): array => VietQrBanks::options())
                                ->searchable()
                                ->preload()
                                ->helperText('Chỉ chọn tên ngân hàng. Hệ thống tự dùng đúng mã VietQR, không phải nhập mã.')
                                ->visible(fn (Get $get): bool => (bool) $get('content.payment.enabled')),

                            TextInput::make('content.payment.account_number')
                                ->label('Số tài khoản')
                                ->maxLength(100)
                                ->visible(fn (Get $get): bool => (bool) $get('content.payment.enabled')),

                            TextInput::make('content.payment.account_holder')
                                ->label('Chủ tài khoản')
                                ->maxLength(255)
                                ->visible(fn (Get $get): bool => (bool) $get('content.payment.enabled')),

                            TextInput::make('content.payment.amount')
                                ->label('Mức đóng góp / người')
                                ->numeric()
                                ->minValue(0)
                                ->suffix('đ')
                                ->placeholder('VD: 500000')
                                ->helperText('Thiết lập riêng cho từng thiệp; để trống nếu không muốn ấn định số tiền.')
                                ->visible(fn (Get $get): bool => (bool) $get('content.payment.enabled')),

                            Textarea::make('content.payment.account_info')
                                ->label('Thông tin tài khoản')
                                ->placeholder("Ngân hàng: ...\nSố TK: ...\nChủ TK: ...")
                                ->helperText('Không bắt buộc. Nếu ảnh QR đã có đủ thông tin thì để trống, đúng như thiệp cưới.')
                                ->rows(4)
                                ->visible(fn (Get $get): bool => (bool) $get('content.payment.enabled')),

                            SpatieMediaLibraryFileUpload::make('payment_qr')
                                ->label('Ảnh QR dự phòng')
                                ->collection('payment_qr')
                                ->image()
                                ->imageEditor()
                                ->maxSize(10240)
                                ->helperText('Không cần upload khi đã chọn ngân hàng và điền số tài khoản. Chỉ dùng làm QR dự phòng.')
                                ->visible(fn (Get $get): bool => (bool) $get('content.payment.enabled')),

                            TextInput::make('content.payment.transfer_prefix')
                                ->label('Tiền tố nội dung chuyển khoản')
                                ->default('HOINGO')
                                ->helperText('Link chung dùng đúng tiền tố này; sau xác nhận, link riêng tự ghép thêm mã khách. VD: HOINGO anh-minh.')
                                ->maxLength(50)
                                ->visible(fn (Get $get): bool => (bool) $get('content.payment.enabled')),

                            DatePicker::make('content.payment.deadline')
                                ->label('Hạn đóng quỹ (nếu có)')
                                ->native(false)
                                ->visible(fn (Get $get): bool => (bool) $get('content.payment.enabled')),

                            Textarea::make('content.payment.note')
                                ->label('Lưu ý khi đóng quỹ')
                                ->placeholder('VD: Sau khi chuyển khoản, BTC sẽ xác nhận trong nhóm.')
                                ->rows(3)
                                ->visible(fn (Get $get): bool => (bool) $get('content.payment.enabled'))
                                ->columnSpanFull(),
                        ])
                        ->columns(2),

                    Tab::make('Trạng thái & SEO')
                        ->schema([
                            Select::make('status')
                                ->label('Trạng thái')
                                ->options(['draft' => 'Bản nháp', 'published' => 'Đã xuất bản'])
                                ->default('draft')
                                ->required(),

                            Toggle::make('is_active')
                                ->label('Cho phép truy cập công khai')
                                ->default(true)
                                ->required(),

                            Toggle::make('can_share')
                                ->label('Cho phép chia sẻ')
                                ->default(true)
                                ->required(),

                            TextInput::make('content.seo.title')
                                ->label('Tiêu đề SEO / chia sẻ')
                                ->maxLength(160)
                                ->columnSpanFull(),

                            Textarea::make('content.seo.description')
                                ->label('Mô tả SEO / chia sẻ')
                                ->rows(3)
                                ->maxLength(300)
                                ->columnSpanFull(),

                            \Filament\Forms\Components\Placeholder::make('public_url')
                                ->label('Link thiệp chung')
                                ->content(function (?Gathering $record): HtmlString {
                                    if (! $record?->slug) {
                                        return new HtmlString('<span style="color:#64748b">Lưu thiệp trước để lấy link chung và thêm khách mời riêng.</span>');
                                    }

                                    $url = route('gathering.show', ['gathering' => $record->slug]);

                                    return new HtmlString('<a href="'.e($url).'" target="_blank" style="color:#2563eb;font-weight:600">'.e($url).'</a>');
                                })
                                ->visibleOn('edit')
                                ->columnSpanFull(),
                        ])
                        ->columns(2),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Buổi hội ngộ')->searchable()->sortable()->weight('bold')->description(fn (Gathering $record) => $record->host_name),
                TextColumn::make('event_time')->label('Thời gian')->dateTime('H:i d/m/Y')->sortable(),
                TextColumn::make('venue_name')->label('Địa điểm')->searchable()->toggleable(),
                TextColumn::make('guests_count')->counts('guests')->label('Khách mời')->sortable(),
                TextColumn::make('status')->label('Trạng thái')->badge()->color(fn (string $state): string => $state === 'published' ? 'success' : 'gray')->formatStateUsing(fn (string $state): string => $state === 'published' ? 'Đã xuất bản' : 'Bản nháp'),
                IconColumn::make('is_active')->label('Hiển thị')->boolean(),
            ])
            ->actions([
                Action::make('open')
                    ->label('Mở thiệp')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Gathering $record): string => route('gathering.show', ['gathering' => $record->slug]))
                    ->openUrlInNewTab()
                    ->visible(fn (Gathering $record): bool => $record->status === 'published' && $record->is_active),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [GuestsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGatherings::route('/'),
            'create' => Pages\CreateGathering::route('/create'),
            'edit' => Pages\EditGathering::route('/{record}/edit'),
        ];
    }
}
