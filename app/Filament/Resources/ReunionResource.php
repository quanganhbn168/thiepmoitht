<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReunionResource\Pages;
use App\Models\Reunion;
use App\Models\Template;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

// Form Components
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Components\Placeholder;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

// Table Components
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class ReunionResource extends Resource
{
    protected static ?string $model = Reunion::class;

    private const DEFAULT_TEMPLATE_VIEW = 'templates.standard';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Thiệp Họp Lớp';

    protected static ?string $modelLabel = 'Thiệp Họp Lớp';

    protected static ?string $pluralModelLabel = 'Danh sách Thiệp Họp Lớp';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Reunion Details')
                    ->tabs([
                        Tab::make('Thông tin chung')
                            ->schema([
                                TextInput::make('slug')
                                    ->label('Đường dẫn')
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->visibleOn('edit')
                                    ->helperText('Đường dẫn tự động tạo. VD: thpt-que-vo-1-12a1-2001'),

                                TextInput::make('school_name')
                                    ->label('Tên trường cũ')
                                    ->maxLength(255),

                                TextInput::make('class_name')
                                    ->label('Tên lớp')
                                    ->maxLength(255),

                                TextInput::make('graduation_year')
                                    ->label('Niên khóa / Năm tốt nghiệp')
                                    ->helperText('VD: Nhập 2006 máy tự gán "2003-2006" và "20 Năm".')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, $state): void {
                                        if (!$state) {
                                            return;
                                        }

                                        $endYear = null;

                                        if (preg_match('/^(\d{4})$/', $state, $matches)) {
                                            $endYear = (int) $matches[1];
                                            $set('graduation_year', ($endYear - 3) . '-' . $endYear);
                                        } elseif (preg_match('/^(\d{2})$/', $state, $matches)) {
                                            $y = (int) $matches[1];
                                            $endYear = $y > 50 ? 1900 + $y : 2000 + $y;
                                            $set('graduation_year', ($endYear - 3) . '-' . $endYear);
                                        } elseif (preg_match('/(\d{4})\s*-\s*(\d{4})/', $state, $matches)) {
                                            $endYear = (int) $matches[2];
                                        }

                                        if ($endYear) {
                                            $diff = now()->year - $endYear;

                                            if ($diff > 0) {
                                                $set('content.schoolInfo.anniversary', $diff . ' Năm');
                                            }
                                        }
                                    })
                                    ->maxLength(255),

                                TextInput::make('content.schoolInfo.anniversary')
                                    ->label('Tên mốc kỷ niệm')
                                    ->placeholder('VD: 20 Năm, 25 Năm')
                                    ->default('20 Năm')
                                    ->maxLength(255),

                                TextInput::make('content.schoolInfo.slogan')
                                    ->label('Câu Slogan nổi bật')
                                    ->placeholder('VD: Tìm lại tuổi học trò')
                                    ->default('Trở Về Thanh Xuân')
                                    ->maxLength(255),

                                TextInput::make('teacher_name')
                                    ->label('Tên GVCN')
                                    ->maxLength(255),

                                Select::make('template_id')
                                    ->label('Mẫu giao diện')
                                    ->relationship('template', 'name', fn ($query) => $query
                                        ->where('type', TemplateResource::TYPE_REUNION)
                                        ->where('is_active', true)
                                        ->orderBy('name'))
                                    ->default(fn () => Template::query()
                                        ->where('type', TemplateResource::TYPE_REUNION)
                                        ->where('view_path', self::DEFAULT_TEMPLATE_VIEW)
                                        ->value('id'))
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set): void {
                                        // Field upload động sẽ tự reload theo template_id.
                                    })
                                    ->helperText('Mẫu Blade nhận cùng bộ biến từ controller. VD: templates.que-vo-2'),

                                Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->label('Khách hàng sở hữu')
                                    ->searchable()
                                    ->preload(),
                            ])
                            ->columns(2),

                        Tab::make('Nội dung & Lời mời')
                            ->schema([
                                TextInput::make('content.invitation_greeting')
                                    ->label('Lời xưng hô (Mở đầu)')
                                    ->placeholder('VD: Quý thầy cô & Các bạn')
                                    ->default('Quý thầy cô & Các bạn')
                                    ->columnSpanFull(),

                                RichEditor::make('content.open_letter')
                                    ->label('Nội dung Thư ngỏ')
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'h2',
                                        'h3',
                                        'bulletList',
                                        'orderedList',
                                        'link',
                                        'redo',
                                        'undo',
                                    ])
                                    ->default('<p><strong>Trân trọng kính mời:</strong> Ban Giám hiệu các thời kỳ, quý thầy cô giáo cùng toàn thể các bạn cựu học sinh niên khóa 2003-2006.</p><p>Thời gian trôi qua thật nhanh... mới ngày nào chúng ta còn là những cô cậu học trò hồn nhiên dưới mái trường THPT Quế Võ Số 2 thân yêu, vậy mà đã tròn 20 năm kể từ ngày chia tay.</p><p>Hai mươi năm – mỗi người một hành trình, một ngả rẽ riêng. Nhưng chắc chắn rằng, trong sâu thẳm trái tim mỗi người vẫn luôn lưu giữ vẹn nguyên những ký ức của một thời áo trắng.</p><p>✨ Nhân dịp kỷ niệm <strong>20 năm ngày ra trường</strong>, Ban liên lạc trân trọng kính mời Ban Giám hiệu, quý thầy cô giáo cùng toàn thể các bạn khóa 2003–2006 trở về tham dự buổi hội ngộ đầy ý nghĩa.</p><p>💛 Đây là dịp để chúng ta cùng gặp lại nhau, ôn lại những kỷ niệm đẹp và bày tỏ lòng tri ân sâu sắc tới Ban Giám hiệu cùng quý thầy cô.</p><p>💐 Rất mong sự hiện diện của quý thầy cô và toàn thể các bạn để buổi hội ngộ thêm trọn vẹn, ấm áp và đáng nhớ.</p><p><strong>Hẹn gặp lại – Thanh xuân của chúng ta!</strong></p>')
                                    ->columnSpanFull(),

                                Fieldset::make('Thiệp thầy cô giáo riêng')
                                    ->schema([
                                        Toggle::make('content.teacher_invitation.enabled')
                                            ->label('Thiệp thầy cô giáo riêng')
                                            ->helperText('Bật để có thêm link riêng /thay-co, vẫn dùng chung thời gian, địa điểm, media và lịch trình của thiệp này.')
                                            ->live()
                                            ->default(false)
                                            ->columnSpanFull(),

                                        Select::make('content.teacher_invitation.template_id')
                                            ->label('Mẫu giao diện cho thầy cô')
                                            ->options(fn (): array => Template::query()
                                                ->where('type', TemplateResource::TYPE_REUNION_TEACHER)
                                                ->where('is_active', true)
                                                ->orderBy('name')
                                                ->pluck('name', 'id')
                                                ->all())
                                            ->searchable()
                                            ->preload()
                                            ->required(fn (Get $get): bool => (bool) $get('content.teacher_invitation.enabled'))
                                            ->helperText('Template này chỉ dùng cho link thầy cô, dữ liệu sự kiện vẫn lấy từ thiệp họp lớp hiện tại.')
                                            ->visible(fn (Get $get): bool => (bool) $get('content.teacher_invitation.enabled'))
                                            ->columnSpanFull(),

                                        Placeholder::make('teacher_invitation_url')
                                            ->label('Link thiệp thầy cô')
                                            ->content(function (?Reunion $record): HtmlString {
                                                if (!$record?->slug) {
                                                    return new HtmlString('<span style="color: #64748b;">Lưu thiệp trước để lấy link thầy cô.</span>');
                                                }

                                                $url = url('/' . $record->slug . '/thay-co');

                                                return new HtmlString(
                                                    '<a href="' . e($url) . '" target="_blank" style="color: #2563eb; font-weight: 600;">' . e($url) . '</a>'
                                                );
                                            })
                                            ->visible(fn (Get $get): bool => (bool) $get('content.teacher_invitation.enabled'))
                                            ->columnSpanFull(),

                                        TextInput::make('content.teacher_invitation.greeting')
                                            ->label('Lời xưng hô riêng')
                                            ->placeholder('VD: Kính gửi Quý thầy cô giáo')
                                            ->default('Kính gửi Quý thầy cô giáo')
                                            ->visible(fn (Get $get): bool => (bool) $get('content.teacher_invitation.enabled'))
                                            ->columnSpanFull(),

                                        RichEditor::make('content.teacher_invitation.open_letter')
                                            ->label('Thư ngỏ riêng cho thầy cô')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'strike',
                                                'h2',
                                                'h3',
                                                'bulletList',
                                                'orderedList',
                                                'link',
                                                'redo',
                                                'undo',
                                            ])
                                            ->default('<p><strong>Trân trọng kính mời:</strong> Quý thầy cô giáo đã từng giảng dạy, dìu dắt tập thể chúng em.</p><p>Nhân dịp ngày hội ngộ, tập thể cựu học sinh kính mong được đón quý thầy cô về tham dự, cùng ôn lại những kỷ niệm đẹp dưới mái trường xưa.</p><p>Sự hiện diện của quý thầy cô là niềm vinh dự và là món quà ý nghĩa nhất đối với tập thể chúng em.</p><p><strong>Ban liên lạc trân trọng kính mời.</strong></p>')
                                            ->visible(fn (Get $get): bool => (bool) $get('content.teacher_invitation.enabled'))
                                            ->columnSpanFull(),

                                        TextInput::make('content.teacher_invitation.seo.title')
                                            ->label('Tiêu đề SEO / Share riêng')
                                            ->placeholder('VD: Thư Mời Thầy Cô | Trường THPT Quế Võ 1')
                                            ->maxLength(160)
                                            ->visible(fn (Get $get): bool => (bool) $get('content.teacher_invitation.enabled')),

                                        Textarea::make('content.teacher_invitation.seo.description')
                                            ->label('Mô tả SEO / Share riêng')
                                            ->placeholder('VD: Trân trọng kính mời quý thầy cô về tham dự buổi hội ngộ...')
                                            ->rows(3)
                                            ->maxLength(300)
                                            ->visible(fn (Get $get): bool => (bool) $get('content.teacher_invitation.enabled')),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),

                                Fieldset::make('Thư cảm ơn')
                                    ->schema([
                                        Toggle::make('content.thank_you_letter.enabled')
                                            ->label('Bật thư cảm ơn')
                                            ->helperText('Bật để có thêm link riêng /thu-cam-on, dùng chung thời gian, địa điểm, media và lịch trình của thiệp này.')
                                            ->live()
                                            ->afterStateUpdated(function (Set $set, Get $get, bool $state): void {
                                                if (!$state) {
                                                    return;
                                                }

                                                if (blank($get('content.thank_you_letter.greeting'))) {
                                                    $set('content.thank_you_letter.greeting', 'Kính gửi Quý mạnh thường quân');
                                                }

                                                if (blank($get('content.thank_you_letter.open_letter'))) {
                                                    $set('content.thank_you_letter.open_letter', '<p>Ban tổ chức chương trình hội ngộ xin được gửi lời cảm ơn chân thành tới Quý mạnh thường quân đã quan tâm, đồng hành và sẻ chia cùng tập thể cựu học sinh.</p><p>Sự ủng hộ quý báu của Quý vị không chỉ góp thêm nguồn lực để chương trình được chuẩn bị chu đáo, mà còn lan tỏa tinh thần gắn kết, nghĩa tình và trách nhiệm với mái trường xưa.</p><p>Nhờ những tấm lòng ấy, ngày trở về của thầy cô và các thế hệ học trò có thêm nhiều khoảnh khắc ấm áp, trọn vẹn và đáng nhớ.</p><p>Ban tổ chức trân trọng ghi nhận sự đồng hành của Quý vị, kính chúc Quý vị cùng gia đình luôn mạnh khỏe, bình an, hạnh phúc và thành công.</p><p><strong>Xin trân trọng cảm ơn.</strong></p>');
                                                }

                                                if (blank($get('content.thank_you_letter.seo.title'))) {
                                                    $set('content.thank_you_letter.seo.title', 'Thư Cảm Ơn | Chương trình hội ngộ');
                                                }

                                                if (blank($get('content.thank_you_letter.seo.description'))) {
                                                    $set('content.thank_you_letter.seo.description', 'Ban tổ chức trân trọng cảm ơn Quý mạnh thường quân đã đồng hành, ủng hộ và sẻ chia cùng chương trình hội ngộ.');
                                                }

                                                if (blank($get('content.thank_you_letter.recipients'))) {
                                                    $set('content.thank_you_letter.recipients', [
                                                        [
                                                            'name' => '',
                                                            'role' => 'Mạnh thường quân',
                                                            'note' => 'Đã đồng hành, ủng hộ và sẻ chia cùng chương trình.',
                                                            'code' => '',
                                                        ],
                                                    ]);
                                                }
                                            })
                                            ->default(false)
                                            ->columnSpanFull(),

                                        Placeholder::make('thank_you_letter_url')
                                            ->label('Link thư cảm ơn')
                                            ->content(function (?Reunion $record): HtmlString {
                                                if (!$record?->slug) {
                                                    return new HtmlString('<span style="color: #64748b;">Lưu thiệp trước để lấy link thư cảm ơn.</span>');
                                                }

                                                $url = url('/' . $record->slug . '/thu-cam-on');

                                                return new HtmlString(
                                                    '<a href="' . e($url) . '" target="_blank" style="color: #2563eb; font-weight: 600;">' . e($url) . '</a>'
                                                );
                                            })
                                            ->visible(fn (Get $get): bool => (bool) $get('content.thank_you_letter.enabled'))
                                            ->columnSpanFull(),

                                        TextInput::make('content.thank_you_letter.greeting')
                                            ->label('Lời xưng hô')
                                            ->placeholder('VD: Kính gửi Quý mạnh thường quân')
                                            ->default('Kính gửi Quý mạnh thường quân')
                                            ->visible(fn (Get $get): bool => (bool) $get('content.thank_you_letter.enabled'))
                                            ->columnSpanFull(),

                                        RichEditor::make('content.thank_you_letter.open_letter')
                                            ->label('Nội dung thư cảm ơn')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'strike',
                                                'h2',
                                                'h3',
                                                'bulletList',
                                                'orderedList',
                                                'link',
                                                'redo',
                                                'undo',
                                            ])
                                            ->default('<p>Ban tổ chức xin gửi lời cảm ơn chân thành tới Quý mạnh thường quân đã đồng hành, ủng hộ và sẻ chia cùng chương trình hội ngộ.</p><p>Sự đóng góp quý báu của Quý vị là nguồn động viên lớn, giúp chương trình được chuẩn bị chu đáo, ấm áp và ý nghĩa hơn.</p><p>Ban tổ chức trân trọng ghi nhận tấm lòng của Quý vị và kính chúc Quý vị cùng gia đình luôn mạnh khỏe, bình an, hạnh phúc và thành công.</p><p><strong>Xin trân trọng cảm ơn.</strong></p>')
                                            ->visible(fn (Get $get): bool => (bool) $get('content.thank_you_letter.enabled'))
                                            ->columnSpanFull(),

                                        TextInput::make('content.thank_you_letter.seo.title')
                                            ->label('Tiêu đề SEO / Share riêng')
                                            ->placeholder('VD: Thư Cảm Ơn | Trường THPT Quế Võ 1')
                                            ->maxLength(160)
                                            ->visible(fn (Get $get): bool => (bool) $get('content.thank_you_letter.enabled')),

                                        Textarea::make('content.thank_you_letter.seo.description')
                                            ->label('Mô tả SEO / Share riêng')
                                            ->placeholder('VD: Ban tổ chức trân trọng cảm ơn Quý mạnh thường quân đã đồng hành...')
                                            ->rows(3)
                                            ->maxLength(300)
                                            ->visible(fn (Get $get): bool => (bool) $get('content.thank_you_letter.enabled')),

                                        Repeater::make('content.thank_you_letter.recipients')
                                            ->label('Danh sách người/đơn vị nhận thư cảm ơn')
                                            ->helperText('Mỗi dòng có một mã link riêng. VD mã “nguyen-van-a” sẽ mở ở /thu-cam-on/nguyen-van-a.')
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('Tên người/đơn vị')
                                                    ->placeholder('VD: Anh Nguyễn Văn A')
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(function (Set $set, Get $get, ?string $state): void {
                                                        if (blank($get('code')) && filled($state)) {
                                                            $set('code', Str::slug($state));
                                                        }
                                                    })
                                                    ->required(),

                                                TextInput::make('role')
                                                    ->label('Vai trò/ghi chú ngắn')
                                                    ->placeholder('VD: Mạnh thường quân, Nhà tài trợ...'),

                                                TextInput::make('code')
                                                    ->label('Mã link')
                                                    ->helperText('Không dấu, không khoảng trắng. VD: nguyen-van-a')
                                                    ->required(),

                                                Textarea::make('note')
                                                    ->label('Lời ghi nhận riêng')
                                                    ->placeholder('VD: Đã đồng hành, ủng hộ và sẻ chia cùng chương trình.')
                                                    ->rows(2)
                                                    ->columnSpanFull(),
                                            ])
                                            ->columns(3)
                                            ->defaultItems(1)
                                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Người nhận thư')
                                            ->visible(fn (Get $get): bool => (bool) $get('content.thank_you_letter.enabled'))
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),

                                Repeater::make('content.organizers')
                                    ->label('Thông tin Ban Tổ Chức / Đầu mối liên hệ')
                                    ->schema([
                                        TextInput::make('role')
                                            ->label('Vai trò/Chức danh')
                                            ->placeholder('VD: Trưởng ban, Lớp trưởng...'),

                                        TextInput::make('name')
                                            ->label('Họ Tên'),

                                        TextInput::make('phone')
                                            ->label('SĐT Liên hệ')
                                            ->tel(),
                                    ])
                                    ->columns(3)
                                    ->minItems(1)
                                    ->defaultItems(1)
                                    ->default([
                                        [
                                            'role' => 'T/M Ban liên lạc – Trưởng Ban tổ chức',
                                            'name' => '',
                                            'phone' => '',
                                        ],
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Sự kiện & Địa điểm')
                            ->schema([
                                DateTimePicker::make('event_time')
                                    ->label('Ngày & Giờ tổ chức')
                                    ->displayFormat('H:i - d/m/Y')
                                    ->columnSpanFull(),

                                TextInput::make('venue_name')
                                    ->label('Tên địa điểm')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Textarea::make('venue_address')
                                    ->label('Địa chỉ chi tiết')
                                    ->columnSpanFull(),

                                Textarea::make('map_iframe')
                                    ->label('Google Maps iFrame')
                                    ->columnSpanFull(),

                                TextInput::make('map_url')
                                    ->label('Link Google Maps')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Tab::make('Lịch trình (Timeline)')
                            ->schema([
                                Actions::make([
                                    FormAction::make('loadDefaultTimeline')
                                        ->label('Nạp mẫu lịch trình')
                                        ->icon('heroicon-o-clock')
                                        ->color('success')
                                        ->requiresConfirmation()
                                        ->modalHeading('Nạp mẫu lịch trình họp lớp?')
                                        ->modalDescription('Hành động này sẽ thay thế lịch trình hiện tại bằng mẫu mặc định.')
                                        ->action(function (Set $set): void {
                                            $newState = [];

                                            foreach (self::defaultTimelineItems() as $item) {
                                                $newState[(string) Str::uuid()] = $item;
                                            }

                                            $set('content.timeline', $newState);

                                            Notification::make()
                                                ->success()
                                                ->title('Đã nạp mẫu lịch trình!')
                                                ->send();
                                        }),

                                    FormAction::make('importJson')
                                        ->label('Nhập nhanh lịch trình từ JSON')
                                        ->icon('heroicon-m-code-bracket')
                                        ->color('warning')
                                        ->form([
                                            Textarea::make('json_data')
                                                ->label('Dán dữ liệu JSON vào đây')
                                                ->placeholder(json_encode(self::defaultTimelineItems(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
                                                ->required()
                                                ->rows(14),
                                        ])
                                        ->action(function (array $data, Set $set): void {
                                            $json = json_decode($data['json_data'], true);

                                            if (!is_array($json)) {
                                                Notification::make()
                                                    ->danger()
                                                    ->title('Lỗi định dạng JSON')
                                                    ->body('Hãy chắc chắn mã bạn dán là một mảng JSON hợp lệ!')
                                                    ->send();

                                                return;
                                            }

                                            $newState = [];

                                            foreach ($json as $item) {
                                                $newState[(string) Str::uuid()] = [
                                                    'time' => $item['time'] ?? '',
                                                    'title' => $item['title'] ?? '',
                                                    'description' => $item['description'] ?? '',
                                                    'is_highlight' => (bool) ($item['is_highlight'] ?? false),
                                                ];
                                            }

                                            $set('content.timeline', $newState);

                                            Notification::make()
                                                ->success()
                                                ->title('Nhập JSON thành công!')
                                                ->send();
                                        }),
                                ])
                                    ->alignEnd()
                                    ->columnSpanFull(),

                                Repeater::make('content.timeline')
                                    ->label('Các hoạt động trong ngày')
                                    ->schema([
                                        TextInput::make('time')
                                            ->label('Thời gian')
                                            ->placeholder('VD: 7h00 - 8h00')
                                            ->required(),

                                        TextInput::make('title')
                                            ->label('Tiêu đề hoạt động')
                                            ->placeholder('VD: Đón tiếp đại biểu')
                                            ->required(),

                                        Textarea::make('description')
                                            ->label('Mô tả chi tiết')
                                            ->rows(2),

                                        Toggle::make('is_highlight')
                                            ->label('Tô đậm (Highlight)')
                                            ->default(false),
                                    ])
                                    ->columns(2)
                                    ->collapsible()
                                    ->cloneable()
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Thông báo')
                            ->schema([
                                Placeholder::make('notification_url')
                                    ->label('Link trang thông báo')
                                    ->content(function (?Reunion $record): HtmlString {
                                        if (!$record?->slug) {
                                            return new HtmlString('<span style="color: #64748b;">Lưu thiệp trước để lấy link thông báo.</span>');
                                        }

                                        $url = url('/' . $record->slug . '/thong-bao');

                                        return new HtmlString(
                                            '<a href="' . e($url) . '" target="_blank" style="color: #2563eb; font-weight: 600;">' . e($url) . '</a>'
                                        );
                                    })
                                    ->columnSpanFull(),

                                Toggle::make('content.notification.enabled')
                                    ->label('Bật trang thông báo')
                                    ->helperText('Bật để dùng link /thong-bao riêng cho chương trình.')
                                    ->live()
                                    ->default(false)
                                    ->columnSpanFull(),

                                TextInput::make('content.notification.title')
                                    ->label('Tiêu đề trang')
                                    ->placeholder('VD: Thông báo chương trình hội ngộ')
                                    ->default('Thông báo chương trình hội ngộ')
                                    ->maxLength(160)
                                    ->visible(fn (Get $get): bool => (bool) $get('content.notification.enabled')),

                                Textarea::make('content.notification.description')
                                    ->label('Mô tả ngắn')
                                    ->placeholder('VD: Lịch trình chính thức ngày trở về thanh xuân...')
                                    ->rows(3)
                                    ->maxLength(300)
                                    ->default('Lịch trình chính thức và những thông tin cần lưu ý cho ngày hội ngộ.')
                                    ->visible(fn (Get $get): bool => (bool) $get('content.notification.enabled')),

                                Toggle::make('content.notification.show_video')
                                    ->label('Hiện video trailer nếu có')
                                    ->default(true)
                                    ->visible(fn (Get $get): bool => (bool) $get('content.notification.enabled')),

                                Toggle::make('content.notification.show_organizers')
                                    ->label('Hiện danh sách ban liên lạc')
                                    ->default(true)
                                    ->visible(fn (Get $get): bool => (bool) $get('content.notification.enabled')),

                                SpatieMediaLibraryFileUpload::make('media_notification_share')
                                    ->collection('notification_share')
                                    ->disk('public')
                                    ->label('Ảnh share riêng trang thông báo')
                                    ->image()
                                    ->imageEditor()
                                    ->maxFiles(1)
                                    ->maxSize(10240)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->helperText('Nên dùng tỷ lệ 1200x630. Nếu bỏ trống sẽ dùng ảnh share chung.')
                                    ->visible(fn (Get $get): bool => (bool) $get('content.notification.enabled'))
                                    ->columnSpanFull(),

                                Actions::make([
                                    FormAction::make('loadNotificationTimeline')
                                        ->label('Nạp timeline thông báo')
                                        ->icon('heroicon-o-clock')
                                        ->color('success')
                                        ->requiresConfirmation()
                                        ->modalHeading('Nạp mẫu timeline cho trang thông báo?')
                                        ->modalDescription('Hành động này sẽ thay thế timeline thông báo hiện tại bằng mẫu ngắn gọn.')
                                        ->action(function (Set $set): void {
                                            $newState = [];

                                            foreach (self::defaultNotificationTimelineItems() as $item) {
                                                $newState[(string) Str::uuid()] = $item;
                                            }

                                            $set('content.notification.timeline', $newState);

                                            Notification::make()
                                                ->success()
                                                ->title('Đã nạp timeline thông báo!')
                                                ->send();
                                        }),
                                ])
                                    ->alignEnd()
                                    ->visible(fn (Get $get): bool => (bool) $get('content.notification.enabled'))
                                    ->columnSpanFull(),

                                Repeater::make('content.notification.timeline')
                                    ->label('Timeline trang thông báo')
                                    ->schema([
                                        TextInput::make('time')
                                            ->label('Thời gian')
                                            ->placeholder('VD: 06:00 - 07:45')
                                            ->required(),

                                        TextInput::make('title')
                                            ->label('Tiêu đề')
                                            ->placeholder('VD: Ký ức thanh xuân')
                                            ->required(),

                                        Textarea::make('description')
                                            ->label('Mô tả')
                                            ->rows(2),

                                        Toggle::make('is_highlight')
                                            ->label('Tô đậm')
                                            ->default(false),
                                    ])
                                    ->columns(2)
                                    ->collapsible()
                                    ->cloneable()
                                    ->reorderable()
                                    ->default(self::defaultNotificationTimelineItems())
                                    ->visible(fn (Get $get): bool => (bool) $get('content.notification.enabled'))
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Tab::make('Hiệu ứng & Cấu hình')
                            ->schema([
                                Select::make('status')
                                    ->label('Trạng thái')
                                    ->options([
                                        'draft' => 'Bản nháp',
                                        'preview' => 'Xem trước',
                                        'published' => 'Đã xuất bản',
                                    ])
                                    ->required()
                                    ->default('draft'),

                                Select::make('falling_effect')
                                    ->label('Hiệu ứng rơi')
                                    ->options([
                                        'none' => 'Không có',
                                        'leaves' => 'Lá mùa thu',
                                        'snow' => 'Tuyết rơi',
                                        'hearts' => 'Trái tim',
                                    ])
                                    ->default('leaves'),

                                Toggle::make('show_invitation_wrapper')
                                    ->label('Hiển thị mở thiệp')
                                    ->default(true),

                                Toggle::make('show_preload')
                                    ->label('Hiển thị Loading')
                                    ->default(false),

                                Toggle::make('is_auto_approve_messages')
                                    ->label('Duyệt lời chúc tự động')
                                    ->default(false),
                            ])
                            ->columns(2),

                        Tab::make('Hình ảnh & Video')
                            ->schema(fn (Get $get): array => self::makeTemplateMediaFields($get('template_id')))
                            ->columns(2),

                        Tab::make('Album các lớp')
                            ->schema([
                                Placeholder::make('class_albums_note')
                                    ->label('')
                                    ->content(new HtmlString(
                                        '<div style="padding: 12px; color: #475569; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
                                            <strong>Album các lớp:</strong><br>
                                            Có thể thêm từng lớp thủ công, hoặc upload 1 file ZIP để import hàng loạt.
                                            Bên trong ZIP nên có các thư mục con như A1, A2, A3... Mỗi thư mục con chứa ảnh của lớp đó.
                                        </div>'
                                    ))
                                    ->columnSpanFull(),

                                Toggle::make('content.album_masonry_enabled')
                                    ->label('Hiển thị album dạng Masonry')
                                    ->helperText('Dùng cho trường hợp ảnh không chia theo lớp. Template hỗ trợ sẽ mặc định mở bố cục masonry, tối đa 100 ảnh.')
                                    ->default(true)
                                    ->columnSpanFull(),

                                Actions::make([
                                    FormAction::make('importClassAlbumZip')
                                        ->label('Import ZIP album')
                                        ->icon('heroicon-o-archive-box-arrow-down')
                                        ->color('warning')
                                        ->modalHeading('Import album các lớp từ ZIP')
                                        ->modalDescription('Upload 1 file ZIP. Mỗi thư mục con trong ZIP sẽ được tạo thành một album lớp.')
                                        ->modalSubmitActionLabel('Import album')
                                        ->modalCancelActionLabel('Hủy')
                                        ->closeModalByClickingAway(false)
                                        ->form([
                                            FileUpload::make('zip_file')
                                                ->label('File ZIP album')
                                                ->disk('local')
                                                ->directory('tmp/reunion-class-album-zips')
                                                ->acceptedFileTypes([
                                                    'application/zip',
                                                    'application/x-zip-compressed',
                                                    'multipart/x-zip',
                                                    'application/octet-stream',
                                                ])
                                                ->multiple()
                                                ->maxFiles(1)
                                                ->maxSize(512000)
                                                ->storeFiles(true)
                                                ->required()
                                                ->helperText('Bên trong ZIP gồm các thư mục con A1, A2, A3... mỗi thư mục chứa ảnh của lớp đó.')
                                                ->columnSpanFull(),
                                        ])
                                        ->action(function (array $data, Set $set, ?Reunion $record): void {
                                            if (!$record) {
                                                Notification::make()
                                                    ->danger()
                                                    ->title('Vui lòng lưu thiệp trước')
                                                    ->body('Anh cần tạo/lưu thiệp trước rồi mới import ZIP album.')
                                                    ->send();

                                                return;
                                            }

                                            $zipPath = self::normalizeUploadedFilePath($data['zip_file'] ?? null);

                                            if (!$zipPath) {
                                                Notification::make()
                                                    ->danger()
                                                    ->title('Chưa có file ZIP')
                                                    ->body('Anh upload file ZIP trước rồi bấm import.')
                                                    ->send();

                                                return;
                                            }

                                            try {
                                                $albums = self::importClassAlbumZip($record, $zipPath);

                                                $content = $record->content ?? [];
                                                $content['class_albums'] = $albums;

                                                $record->update([
                                                    'content' => $content,
                                                ]);

                                                $set('content.class_albums', self::hydrateClassAlbumUploadState($albums));

                                                Notification::make()
                                                    ->success()
                                                    ->title('Import album thành công')
                                                    ->body('Đã import ' . count($albums) . ' album lớp từ file ZIP.')
                                                    ->send();
                                            } catch (\Throwable $e) {
                                                Notification::make()
                                                    ->danger()
                                                    ->title('Import ZIP thất bại')
                                                    ->body($e->getMessage())
                                                    ->send();
                                            }
                                        }),
                                ])
                                    ->alignEnd()
                                    ->columnSpanFull(),

                                Repeater::make('content.class_albums')
                                    ->label('Danh sách lớp và album ảnh')
                                    ->addActionLabel('Thêm lớp')
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Lớp mới')
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Tên lớp')
                                            ->placeholder('VD: A1, 12A1, Thầy/Cô giáo')
                                            ->required()
                                            ->maxLength(100),

                                        FileUpload::make('cover_image')
                                            ->label('Ảnh đại diện của lớp')
                                            ->disk('public')
                                            ->directory('reunion-class-albums/covers')
                                            ->visibility('public')
                                            ->image()
                                            ->imageEditor()
                                            ->acceptedFileTypes([
                                                'image/jpeg',
                                                'image/png',
                                                'image/webp',
                                            ])
                                            ->maxSize(10240)
                                            ->helperText('Không bắt buộc. Nếu bỏ trống, hệ thống dùng ảnh đầu tiên trong album.')
                                            ->columnSpanFull(),

                                        FileUpload::make('photos')
                                            ->label('Ảnh album của lớp')
                                            ->disk('public')
                                            ->directory('reunion-class-albums/photos')
                                            ->visibility('public')
                                            ->multiple()
                                            ->appendFiles()
                                            ->reorderable()
                                            ->maxFiles(100)
                                            ->image()
                                            ->imagePreviewHeight('140')
                                            ->panelLayout('grid')
                                            ->acceptedFileTypes([
                                                'image/jpeg',
                                                'image/png',
                                                'image/webp',
                                            ])
                                            ->maxSize(10240)
                                            ->helperText('Tối đa 100 ảnh cho mỗi album.')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->collapsible()
                                    ->cloneable()
                                    ->reorderable()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Tab::make('Nhạc nền')
                            ->schema([
                                FileUpload::make('background_music')
                                    ->label('File Nhạc Nền (MP3)')
                                    ->disk('public')
                                    ->directory('reunion-music')
                                    ->visibility('public')
                                    ->acceptedFileTypes(['audio/mpeg', 'audio/mp3'])
                                    ->maxSize(20480)
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('SEO & Chia sẻ')
                            ->schema([
                                Placeholder::make('seo_share_note')
                                    ->label('')
                                    ->content(new HtmlString(
                                        '<div style="padding: 12px; color: #475569; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
                                            <strong>SEO & chia sẻ:</strong><br>
                                            Nội dung ở đây dùng cho title, mô tả và ảnh preview khi gửi link qua Zalo/Facebook.
                                        </div>'
                                    ))
                                    ->columnSpanFull(),

                                Toggle::make('can_share')
                                    ->label('Cho phép chia sẻ')
                                    ->default(true),

                                TextInput::make('content.seo.title')
                                    ->label('Tiêu đề SEO / Share')
                                    ->placeholder('VD: Thư Mời Họp Lớp | Trường THPT Quế Võ 1')
                                    ->maxLength(160)
                                    ->helperText('Nếu bỏ trống, hệ thống tự lấy theo tên trường.'),

                                Textarea::make('content.seo.description')
                                    ->label('Mô tả SEO / Share')
                                    ->placeholder('VD: Trân trọng kính mời thầy cô và các bạn về dự buổi họp lớp...')
                                    ->rows(4)
                                    ->maxLength(300)
                                    ->helperText('Nên viết 120-180 ký tự để hiển thị đẹp khi chia sẻ.')
                                    ->columnSpanFull(),

                                SpatieMediaLibraryFileUpload::make('media_share')
                                    ->collection('share')
                                    ->disk('public')
                                    ->label('Ảnh share Facebook/Zalo')
                                    ->image()
                                    ->imageEditor()
                                    ->maxFiles(1)
                                    ->maxSize(10240)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->helperText('Nên dùng ảnh tỷ lệ 1200x630 để preview đẹp khi gửi link.')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    private static function makeTemplateMediaFields(?int $templateId): array
    {
        if (!$templateId) {
            return [
                Placeholder::make('template_media_empty')
                    ->label('')
                    ->content(new HtmlString(
                        '<div style="padding: 12px; color: #6b7280;">Vui lòng chọn mẫu giao diện trước để hiển thị các trường upload ảnh/video.</div>'
                    ))
                    ->columnSpanFull(),
            ];
        }

        $template = Template::query()->find($templateId);
        $schema = is_array($template?->media_schema) ? $template->media_schema : [];
        $groups = $schema['groups'] ?? [];

        if (empty($groups)) {
            return [
                Placeholder::make('template_media_not_configured')
                    ->label('')
                    ->content(new HtmlString(
                        '<div style="padding: 12px; color: #6b7280;">Mẫu này chưa cấu hình media_schema. Vào Kho Giao diện → Edit template → Tab Cấu hình Media để thêm.</div>'
                    ))
                    ->columnSpanFull(),
            ];
        }

        $components = [];

        foreach ($groups as $groupIndex => $group) {
            $fields = $group['fields'] ?? [];

            if (empty($fields)) {
                continue;
            }

            $fieldComponents = [];

            foreach ($fields as $field) {
                if (($field['collection'] ?? $field['key'] ?? null) === 'share') {
                    continue;
                }

                $fieldComponent = self::makeMediaUploadField($field);

                if ($fieldComponent) {
                    $fieldComponents[] = $fieldComponent;
                }
            }

            if (!empty($fieldComponents)) {
                $components[] = Fieldset::make($group['name'] ?? ('Nhóm media ' . ($groupIndex + 1)))
                    ->schema($fieldComponents)
                    ->columns(2)
                    ->columnSpanFull();
            }
        }

        if (empty($components)) {
            return [
                Placeholder::make('template_media_no_fields')
                    ->label('')
                    ->content(new HtmlString(
                        '<div style="padding: 12px; color: #6b7280;">media_schema có groups nhưng chưa có field hợp lệ.</div>'
                    ))
                    ->columnSpanFull(),
            ];
        }

        return $components;
    }

    private static function makeMediaUploadField(array $field): ?SpatieMediaLibraryFileUpload
    {
        $key = $field['key'] ?? null;
        $label = $field['label'] ?? $key;
        $type = $field['type'] ?? 'image';
        $collection = $field['collection'] ?? $key;
        $maxSize = (int) ($field['max_size'] ?? ($type === 'video' ? 102400 : 10240));
        $single = (bool) ($field['single'] ?? true);

        if (!$key || !$collection) {
            return null;
        }

        $component = SpatieMediaLibraryFileUpload::make('media_' . $collection)
            ->collection($collection)
            ->disk('public')
            ->label($label)
            ->maxSize($maxSize)
            ->columnSpanFull();

        if ($single) {
            $component->maxFiles(1);
        }

        if ($type === 'video') {
            return $component
                ->acceptedFileTypes(['video/mp4']);
        }

        return $component
            ->image()
            ->imageEditor()
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    private static function defaultTimelineItems(): array
    {
        return [
            [
                'time' => '7h00-8h00',
                'title' => 'Đón tiếp thầy cô và các bạn',
                'description' => 'Giao lưu, nhận áo đồng phục và chụp ảnh lưu niệm tại backdrop.',
                'is_highlight' => false,
            ],
            [
                'time' => '8h00-8h30',
                'title' => 'Văn nghệ chào mừng',
                'description' => 'Các tiết mục văn nghệ đặc sắc do cựu học sinh biểu diễn.',
                'is_highlight' => false,
            ],
            [
                'time' => '8h30-8h45',
                'title' => 'Phát biểu khai mạc',
                'description' => 'Tuyên bố lý do, giới thiệu đại biểu và khai mạc chương trình.',
                'is_highlight' => true,
            ],
            [
                'time' => '8h45-9h00',
                'title' => 'Phát biểu của Thầy Hiệu trưởng cũ',
                'description' => 'Lắng nghe những chia sẻ đầy kỷ niệm từ Thầy hiệu trưởng nhiệm kỳ 2003-2006.',
                'is_highlight' => false,
            ],
            [
                'time' => '9h00-9h15',
                'title' => 'Phát biểu của Thầy Hiệu trưởng đương nhiệm',
                'description' => 'Thầy hiệu trưởng hiện tại phát biểu về sự phát triển của nhà trường.',
                'is_highlight' => false,
            ],
            [
                'time' => '9h15-9h30',
                'title' => 'Phát biểu của Học sinh',
                'description' => 'Đại diện cựu học sinh gửi lời tri ân sâu sắc tới mái trường và thầy cô.',
                'is_highlight' => false,
            ],
            [
                'time' => '9h30-10h00',
                'title' => 'Tặng quà tri ân Thầy cô giáo',
                'description' => 'Gửi tặng những món quà ý nghĩa đến các thầy cô nguyên là giáo viên giảng dạy khóa 2003-2006.',
                'is_highlight' => true,
            ],
            [
                'time' => '10h00-10h15',
                'title' => 'Tặng quà Nhà trường',
                'description' => 'Tập thể cựu học sinh dâng tặng hoa và kỷ vật cho trường THPT Quế Võ 2.',
                'is_highlight' => false,
            ],
            [
                'time' => '10h15-10h30',
                'title' => 'Chúc mừng BGH',
                'description' => 'Tập thể Ban tổ chức lên tặng hoa và chúc sức khỏe Ban Giám Hiệu.',
                'is_highlight' => false,
            ],
            [
                'time' => '10h30-10h45',
                'title' => 'Trao bằng vinh danh BTC',
                'description' => 'Vinh danh cảm ơn các cá nhân Tập thể BTC đã tích cực kết nối và xây dựng chương trình.',
                'is_highlight' => false,
            ],
            [
                'time' => '11h00-11h30',
                'title' => 'Chụp ảnh dạo quanh trường xưa',
                'description' => 'Di chuyển quanh sân trường, các góc lớp để cùng nhau lưu lại bức ảnh Thanh Xuân.',
                'is_highlight' => true,
            ],
        ];
    }

    private static function defaultNotificationTimelineItems(): array
    {
        return [
            [
                'time' => '06:00 - 07:45',
                'title' => 'Ký ức thanh xuân',
                'description' => 'Đón tiếp, check-in và gặp gỡ đầu ngày.',
                'is_highlight' => false,
            ],
            [
                'time' => '08:00 - 09:40',
                'title' => 'Gặp gỡ và tri ân',
                'description' => 'Văn nghệ chào mừng, phát biểu và tri ân thầy cô.',
                'is_highlight' => true,
            ],
            [
                'time' => '09:40 - 10:00',
                'title' => 'Khoảnh khắc gắn kết',
                'description' => 'Tri ân nhà tài trợ, giao lưu sân khấu và lưu lại kỷ niệm.',
                'is_highlight' => false,
            ],
            [
                'time' => '10:00 - 11:00',
                'title' => 'Chụp ảnh kỷ niệm',
                'description' => 'Chụp ảnh theo lớp, cùng giáo viên chủ nhiệm và tham quan trường xưa.',
                'is_highlight' => true,
            ],
            [
                'time' => '11:00 - 13:30',
                'title' => 'Liên hoan và giao lưu',
                'description' => 'Dùng tiệc, kết nối và chia sẻ những câu chuyện sau nhiều năm gặp lại.',
                'is_highlight' => false,
            ],
            [
                'time' => '13:30 - 14:00',
                'title' => 'Bế mạc và hẹn gặp lại',
                'description' => 'Tổng kết, chụp ảnh tập thể và gửi lời hẹn ngày trở về tiếp theo.',
                'is_highlight' => false,
            ],
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('school_name')
                    ->label('Trường')
                    ->searchable(),

                TextColumn::make('class_name')
                    ->label('Lớp / Link thiệp')
                    ->searchable(['class_name', 'slug'])
                    ->placeholder('(Cả khóa/Trống)')
                    ->description(fn (Reunion $record): string => url('/' . $record->slug))
                    ->copyable()
                    ->copyableState(fn (Reunion $record): string => url('/' . $record->slug))
                    ->copyMessage('Đã copy đường dẫn thiệp mời!'),

                TextColumn::make('graduation_year')
                    ->label('Niên khóa')
                    ->searchable(),

                TextColumn::make('event_time')
                    ->dateTime('H:i d/m/Y')
                    ->label('Ngày tổ chức')
                    ->sortable(),

                TextColumn::make('template.name')
                    ->label('Mẫu')
                    ->badge()
                    ->color('info'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),

                Action::make('view_demo')
                    ->label('Xem Thiệp')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Reunion $record): string => url('/' . $record->slug))
                    ->openUrlInNewTab(),

                Action::make('view_teacher_invitation')
                    ->label('Xem Thiệp Thầy Cô')
                    ->icon('heroicon-o-academic-cap')
                    ->visible(fn (Reunion $record): bool => (bool) data_get($record->content, 'teacher_invitation.enabled', false))
                    ->url(fn (Reunion $record): string => url('/' . $record->slug . '/thay-co'))
                    ->openUrlInNewTab(),

                Action::make('view_thank_you_letter')
                    ->label('Xem Thư Cảm Ơn')
                    ->icon('heroicon-o-heart')
                    ->visible(fn (Reunion $record): bool => (bool) (
                        data_get($record->content, 'thank_you_letter.enabled', false)
                        ?: data_get($record->content, 'benefactor_thank_you.enabled', false)
                    ))
                    ->url(fn (Reunion $record): string => url('/' . $record->slug . '/thu-cam-on'))
                    ->openUrlInNewTab(),

                Action::make('view_notification')
                    ->label('Xem Thông Báo')
                    ->icon('heroicon-o-megaphone')
                    ->visible(fn (Reunion $record): bool => (bool) data_get($record->content, 'notification.enabled', false))
                    ->url(fn (Reunion $record): string => url('/' . $record->slug . '/thong-bao'))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    private static function normalizeUploadedFilePath(mixed $state): ?string
    {
        return self::normalizeUploadedFilePaths($state)[0] ?? null;
    }

    public static function normalizeClassAlbumsForStorage(mixed $albums): array
    {
        if (!is_iterable($albums)) {
            return [];
        }

        $normalizedAlbums = collect($albums)
            ->filter(fn ($album): bool => is_array($album))
            ->map(function (array $album): array {
                $album['cover_image'] = self::normalizeUploadedFilePath($album['cover_image'] ?? null);
                $album['photos'] = self::normalizeUploadedFilePaths($album['photos'] ?? []);

                return $album;
            })
            ->values()
            ->all();

        return self::sortClassAlbums($normalizedAlbums);
    }

    private static function sortClassAlbums(array $albums): array
    {
        return collect($albums)
            ->sort(fn (array $first, array $second): int => strnatcasecmp(
                (string) ($first['name'] ?? ''),
                (string) ($second['name'] ?? '')
            ))
            ->values()
            ->all();
    }

    private static function normalizeUploadedFilePaths(mixed $state): array
    {
        if (blank($state)) {
            return [];
        }

        if (is_string($state)) {
            return [self::normalizePublicDiskPath($state)];
        }

        if (is_object($state) && method_exists($state, 'getRealPath')) {
            return [$state->getRealPath()];
        }

        if (!is_array($state)) {
            return [];
        }

        $paths = [];

        foreach ($state as $item) {
            $paths = array_merge($paths, self::normalizeUploadedFilePaths($item));
        }

        return array_values(array_filter($paths, fn ($path) => filled($path)));
    }

    private static function normalizePublicDiskPath(string $path): string
    {
        $path = trim(str_replace('\\', '/', $path));

        if ($path === '') {
            return $path;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            $urlPath = parse_url($path, PHP_URL_PATH);

            if (is_string($urlPath) && Str::startsWith($urlPath, '/storage/')) {
                return ltrim(Str::after($urlPath, '/storage/'), '/');
            }

            return $path;
        }

        if (Str::startsWith($path, '/storage/')) {
            return ltrim(Str::after($path, '/storage/'), '/');
        }

        if (Str::startsWith($path, 'storage/')) {
            return ltrim(Str::after($path, 'storage/'), '/');
        }

        return $path;
    }

    private static function hydrateClassAlbumUploadState(array $albums): array
    {
        return collect($albums)
            ->map(function (array $album): array {
                $album['cover_image'] = self::makeFileUploadState($album['cover_image'] ?? null);
                $album['photos'] = self::makeFileUploadState($album['photos'] ?? []);

                return $album;
            })
            ->all();
    }

    private static function makeFileUploadState(mixed $state): array
    {
        return collect(self::normalizeUploadedFilePaths($state))
            ->mapWithKeys(fn (string $path): array => [(string) Str::uuid() => $path])
            ->all();
    }

    private static function importClassAlbumZip(Reunion $record, string $zipPath): array
    {
        $fullZipPath = file_exists($zipPath)
            ? $zipPath
            : Storage::disk('local')->path($zipPath);

        if (!file_exists($fullZipPath)) {
            throw new \RuntimeException('Không tìm thấy file ZIP đã upload.');
        }

        $zip = new \ZipArchive();

        if ($zip->open($fullZipPath) !== true) {
            throw new \RuntimeException('Không mở được file ZIP.');
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        $albumsByClass = [];
        $entries = [];

        try {
            for ($index = 0; $index < $zip->numFiles; $index++) {
                $entryName = $zip->getNameIndex($index);

                if (!is_string($entryName)) {
                    continue;
                }

                $relativePath = ltrim(str_replace('\\', '/', $entryName), '/');

                if ($relativePath === '' || str_ends_with($relativePath, '/')) {
                    continue;
                }

                $entries[] = [
                    'index' => $index,
                    'path' => $relativePath,
                ];
            }

            usort(
                $entries,
                fn (array $first, array $second): int => strnatcasecmp($first['path'], $second['path'])
            );

            foreach ($entries as $entry) {
                $relativePath = $entry['path'];

                if (str_contains($relativePath, '../') || str_starts_with($relativePath, '__MACOSX/')) {
                    continue;
                }

                $fileName = basename($relativePath);

                if (str_starts_with($fileName, '._')) {
                    continue;
                }

                $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (!in_array($extension, $allowedExtensions, true)) {
                    continue;
                }

                $parts = collect(explode('/', $relativePath))
                    ->filter(fn (string $part): bool => $part !== '' && $part !== '.')
                    ->values();

                if ($parts->count() < 2) {
                    continue;
                }

                $className = $parts->count() >= 3
                    ? $parts->get(1)
                    : $parts->get(0);

                if (!$className || str_starts_with($className, '__MACOSX')) {
                    continue;
                }

                $safeClassSlug = Str::slug($className) ?: 'album-' . substr(md5($className), 0, 8);
                $originalName = pathinfo($fileName, PATHINFO_FILENAME);
                $safeOriginalName = Str::slug($originalName) ?: 'anh';
                $safeFileName = Str::random(8) . '-' . $safeOriginalName . '.' . $extension;

                $targetPath = 'reunion-class-albums/' . $record->id . '/' . $safeClassSlug . '/' . $safeFileName;
                $contents = $zip->getFromIndex($entry['index']);

                if ($contents === false) {
                    throw new \RuntimeException('Không đọc được file trong ZIP: ' . $relativePath);
                }

                Storage::disk('public')->put($targetPath, $contents);

                $albumsByClass[$className][] = $targetPath;
            }
        } finally {
            $zip->close();
        }

        if (empty($albumsByClass)) {
            throw new \RuntimeException('Không tìm thấy ảnh hợp lệ trong ZIP. ZIP cần có thư mục con, ví dụ A1/anh1.jpg.');
        }

        $newAlbums = collect($albumsByClass)
            ->map(function (array $photos, string $className) {
                return [
                    'name' => $className,
                    'cover_image' => $photos[0] ?? null,
                    'photos' => $photos,
                ];
            })
            ->values();

        $oldAlbums = collect(self::normalizeClassAlbumsForStorage(data_get($record->content, 'class_albums', [])));

        return self::sortClassAlbums($oldAlbums
            ->reject(fn ($album) => $newAlbums->pluck('name')->contains($album['name'] ?? null))
            ->merge($newAlbums)
            ->values()
            ->all());
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
            'index' => Pages\ListReunions::route('/'),
            'create' => Pages\CreateReunion::route('/create'),
            'edit' => Pages\EditReunion::route('/{record}/edit'),
        ];
    }
}
