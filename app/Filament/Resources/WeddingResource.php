<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeddingResource\Pages;
use App\Models\Template;
use App\Models\Wedding;
use App\Support\VietQrBanks;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
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
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class WeddingResource extends Resource
{
    protected static ?string $model = Wedding::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'Quản lý Thiệp';

    protected static ?string $navigationLabel = 'Thiệp cưới';

    protected static ?string $modelLabel = 'Thiệp cưới';

    protected static ?string $pluralModelLabel = 'Danh sách Thiệp cưới';

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
            Tabs::make('Thiệp cưới')
                ->tabs([
                    Tab::make('Thông tin chung')
                        ->schema([
                            TextInput::make('groom_name')
                                ->label('Tên chú rể')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('bride_name')
                                ->label('Tên cô dâu')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('slug')
                                ->label('Slug thiệp')
                                ->placeholder('VD: minh-anh-va-thu-ha')
                                ->unique(ignoreRecord: true)
                                ->rule('regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                                ->helperText('Bỏ trống để hệ thống tự tạo. Link chung: /thiep-cuoi/{slug}.')
                                ->columnSpanFull(),
                            Select::make('template_id')
                                ->label('Mẫu giao diện')
                                ->relationship('template', 'name', fn ($query) => $query
                                    ->where('type', TemplateResource::TYPE_WEDDING)
                                    ->where('is_active', true)
                                    ->orderBy('name'))
                                ->default(fn () => Template::query()
                                    ->where('type', TemplateResource::TYPE_WEDDING)
                                    ->where('view_path', 'templates.wedding-modern')
                                    ->value('id'))
                                ->searchable()
                                ->preload(),
                            Select::make('user_id')
                                ->relationship('user', 'name')
                                ->label('Khách hàng sở hữu')
                                ->searchable()
                                ->preload()
                                ->hidden(fn (): bool => auth()->user()?->isCustomer() ?? false)
                                ->dehydrated(fn (): bool => ! (auth()->user()?->isCustomer() ?? false)),
                            DatePicker::make('event_date')
                                ->label('Ngày cưới')
                                ->native(false),
                            DateTimePicker::make('event_time')
                                ->label('Giờ đón khách / tiệc')
                                ->native(false)
                                ->seconds(false),
                            TextInput::make('venue_name')
                                ->label('Tên nhà hàng / địa điểm')
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

                    Tab::make('Lời mời')
                        ->schema([
                            TextInput::make('content.invitation_headline')
                                ->label('Dòng mời nổi bật')
                                ->default('Trân trọng kính mời')
                                ->maxLength(255)
                                ->columnSpanFull(),
                            RichEditor::make('content.introduction')
                                ->label('Lời mời')
                                ->default('<p>Hôn lễ của chúng tôi sẽ trọn vẹn hơn khi có sự hiện diện của bạn.</p>')
                                ->toolbarButtons(['bold', 'italic', 'underline', 'h2', 'h3', 'bulletList', 'orderedList', 'link', 'redo', 'undo'])
                                ->columnSpanFull(),
                            TextInput::make('content.groom_family')
                                ->label('Thông tin nhà trai')
                                ->placeholder('VD: Gia đình ông Nguyễn Văn A'),
                            TextInput::make('content.bride_family')
                                ->label('Thông tin nhà gái')
                                ->placeholder('VD: Gia đình ông Trần Văn B'),
                            Textarea::make('content.note')
                                ->label('Lời nhắn thêm')
                                ->rows(3)
                                ->columnSpanFull(),
                        ])
                        ->columns(2),

                    Tab::make('Ảnh & chia sẻ')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('cover')
                                ->label('Ảnh bìa thiệp')
                                ->collection('cover')
                                ->image()
                                ->imageEditor()
                                ->maxSize(10240)
                                ->columnSpanFull(),
                            SpatieMediaLibraryFileUpload::make('share')
                                ->label('Ảnh chia sẻ Facebook/Zalo')
                                ->collection('share')
                                ->image()
                                ->imageEditor()
                                ->maxSize(10240)
                                ->columnSpanFull(),
                            SpatieMediaLibraryFileUpload::make('gallery')
                                ->label('Album ảnh cưới')
                                ->collection('gallery')
                                ->multiple()
                                ->reorderable()
                                ->image()
                                ->imageEditor()
                                ->maxFiles(12)
                                ->maxSize(10240)
                                ->columnSpanFull(),
                        ]),

                    Tab::make('QR mừng cưới')
                        ->schema([
                            Toggle::make('content.payment.enabled')
                                ->label('Hiển thị QR mừng cưới trên thiệp')
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
                            Textarea::make('content.payment.account_info')
                                ->label('Thông tin tài khoản')
                                ->placeholder("Ngân hàng: ...\nSố TK: ...\nChủ TK: ...")
                                ->helperText('Không bắt buộc. Nếu ảnh QR đã có đủ thông tin thì để trống.')
                                ->rows(4)
                                ->visible(fn (Get $get): bool => (bool) $get('content.payment.enabled')),
                            SpatieMediaLibraryFileUpload::make('payment_qr')
                                ->label('Ảnh QR dự phòng')
                                ->collection('payment_qr')
                                ->image()
                                ->imageEditor()
                                ->maxSize(10240)
                                ->helperText('Không cần upload khi đã chọn ngân hàng và điền số tài khoản.')
                                ->visible(fn (Get $get): bool => (bool) $get('content.payment.enabled')),
                            TextInput::make('content.payment.transfer_note')
                                ->label('Gợi ý nội dung chuyển khoản')
                                ->maxLength(100)
                                ->visible(fn (Get $get): bool => (bool) $get('content.payment.enabled')),
                            DatePicker::make('content.payment.deadline')
                                ->label('Hạn mừng cưới (nếu có)')
                                ->native(false)
                                ->visible(fn (Get $get): bool => (bool) $get('content.payment.enabled')),
                            Textarea::make('content.payment.note')
                                ->label('Lưu ý khi gửi mừng')
                                ->rows(3)
                                ->visible(fn ($get): bool => (bool) $get('content.payment.enabled'))
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
                            Placeholder::make('public_url')
                                ->label('Link thiệp chung')
                                ->content(function (?Wedding $record): HtmlString {
                                    if (! $record?->slug) {
                                        return new HtmlString('<span style="color:#64748b">Lưu thiệp trước để lấy link chia sẻ.</span>');
                                    }

                                    $url = route('wedding.show', ['wedding' => $record->slug]);

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
                TextColumn::make('groom_name')->label('Chú rể')->searchable()->weight('bold'),
                TextColumn::make('bride_name')->label('Cô dâu')->searchable()->weight('bold'),
                TextColumn::make('event_time')->label('Thời gian')->dateTime('H:i d/m/Y')->sortable(),
                TextColumn::make('venue_name')->label('Địa điểm')->searchable()->toggleable(),
                TextColumn::make('status')->label('Trạng thái')->badge()
                    ->color(fn (string $state): string => $state === 'published' ? 'success' : 'gray')
                    ->formatStateUsing(fn (string $state): string => $state === 'published' ? 'Đã xuất bản' : 'Bản nháp'),
                IconColumn::make('is_active')->label('Hiển thị')->boolean(),
            ])
            ->actions([
                Action::make('open')
                    ->label('Mở thiệp')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Wedding $record): string => route('wedding.show', ['wedding' => $record->slug]))
                    ->openUrlInNewTab()
                    ->visible(fn (Wedding $record): bool => $record->status === 'published' && $record->is_active),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWeddings::route('/'),
            'create' => Pages\CreateWedding::route('/create'),
            'edit' => Pages\EditWedding::route('/{record}/edit'),
        ];
    }
}
