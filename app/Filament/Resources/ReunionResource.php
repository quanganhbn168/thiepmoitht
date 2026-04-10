<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReunionResource\Pages;
use App\Models\Reunion;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Facades\Filament;

// Form Components
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\DateTimePicker;

// Table Components
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class ReunionResource extends Resource
{
    protected static ?string $model = Reunion::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Thiệp Họp Lớp';
    protected static ?string $modelLabel = 'Thiệp Họp Lớp';
    protected static ?string $pluralModelLabel = 'Danh sách Thiệp Họp Lớp';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('super_admin');
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
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->visibleOn('edit')
                                    ->helperText('Đường dẫn tự động tạo. VD: trpt-que-vo-1-12a1-2001'),

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
                                    ->afterStateUpdated(function (\Filament\Forms\Set $set, $state) {
                                        if (!$state) return;
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
                                            if ($diff > 0) $set('content.schoolInfo.anniversary', $diff . ' Năm');
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
                                    ->placeholder('VD: Trở về thanh xuân, Khung trời kỷ niệm')
                                    ->default('Trở Về Thanh Xuân')
                                    ->maxLength(255),
                                TextInput::make('teacher_name')
                                    ->label('Tên GVCN')
                                    ->maxLength(255),
                                Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->label('Khách hàng sở hữu'),
                            ])->columns(2),

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
                                        'bold', 'italic', 'underline', 'strike',
                                        'h2', 'h3', 'bulletList', 'orderedList', 'link', 'redo', 'undo',
                                    ])
                                    ->default('<p><strong>Trân trọng kính mời:</strong> Ban Giám hiệu các thời kỳ, quý thầy cô giáo cùng toàn thể các bạn cựu học sinh niên khóa 2003-2006.</p><p>Thời gian trôi qua thật nhanh... mới ngày nào chúng ta còn là những cô cậu học trò hồn nhiên dưới mái trường THPT Quế Võ Số 2 thân yêu, vậy mà đã tròn 20 năm kể từ ngày chia tay.</p><p>Hai mươi năm – mỗi người một hành trình, một ngả rẽ riêng. Nhưng chắc chắn rằng, trong sâu thẳm trái tim mỗi người vẫn luôn lưu giữ vẹn nguyên những ký ức của một thời áo trắng.</p><p>✨ Nhân dịp kỷ niệm <strong>20 năm ngày ra trường</strong>, Ban liên lạc trân trọng kính mời Ban Giám hiệu, quý thầy cô giáo cùng toàn thể các bạn khóa 2003–2006 trở về tham dự buổi hội ngộ đầy ý nghĩa.</p><p>💛 Đây là dịp để chúng ta cùng gặp lại nhau, ôn lại những kỷ niệm đẹp và bày tỏ lòng tri ân sâu sắc tới Ban Giám hiệu cùng quý thầy cô.</p><p>💐 Rất mong sự hiện diện của quý thầy cô và toàn thể các bạn để buổi hội ngộ thêm trọn vẹn, ấm áp và đáng nhớ.</p><p><strong>Hẹn gặp lại – Thanh xuân của chúng ta!</strong></p>')
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
                                            'phone' => ''
                                        ]
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
                            ])->columns(2),

                        Tab::make('Lịch trình (Timeline)')
                            ->schema([
                                Forms\Components\Repeater::make('content.timeline')
                                    ->label('Các hoạt động trong ngày')
                                    ->schema([
                                        Forms\Components\TextInput::make('time')
                                            ->label('Thời gian')
                                            ->placeholder('VD: 7h00 - 8h00')
                                            ->required(),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Tiêu đề hoạt động')
                                            ->placeholder('VD: Đón tiếp đại biểu')
                                            ->required(),
                                        Forms\Components\Textarea::make('description')
                                            ->label('Mô tả chi tiết')
                                            ->rows(2),
                                        Forms\Components\Toggle::make('is_highlight')
                                            ->label('Tô đậm (Highlight)')
                                            ->default(false),
                                    ])
                                    ->columns(2)
                                    ->collapsible()
                                    ->cloneable()
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Hiệu ứng & Cấu hình')
                            ->schema([
                                Select::make('status')
                                    ->options([
                                        'draft' => 'Bản nháp',
                                        'preview' => 'Xem trước',
                                        'published' => 'Đã xuất bản',
                                    ])
                                    ->required()
                                    ->default('draft'),
                                Select::make('tier')
                                    ->options([
                                        'standard' => 'Tiêu chuẩn',
                                        'pro' => 'Pro (Cao cấp)',
                                    ])
                                    ->required()
                                    ->default('standard'),
                                Select::make('falling_effect')
                                    ->options([
                                        'none' => 'Không có',
                                        'leaves' => 'Lá mùa thu',
                                        'snow' => 'Tuyết rơi',
                                        'hearts' => 'Trái tim',
                                    ])
                                    ->default('leaves')
                                    ->label('Hiệu ứng rơi'),
                                Toggle::make('show_invitation_wrapper')
                                    ->label('Hiển thị mở thiệp')
                                    ->default(true),
                                Toggle::make('show_preload')
                                    ->label('Hiển thị Loading')
                                    ->default(false),
                                Toggle::make('can_share')
                                    ->label('Cho phép chia sẻ')
                                    ->default(true),
                                Toggle::make('is_auto_approve_messages')
                                    ->label('Duyệt lời chúc tự động')
                                    ->default(false),
                            ])->columns(2),

                        Tab::make('Hình ảnh & Video')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('share')
                                    ->collection('share')
                                    ->label('Ảnh Nền Hero & Chia sẻ (Share Facebook/Zalo)')
                                    ->image(),
                                SpatieMediaLibraryFileUpload::make('video_cover')
                                    ->collection('video_cover')
                                    ->label('Ảnh Bìa Của Video Trailer')
                                    ->image(),
                                SpatieMediaLibraryFileUpload::make('video')
                                    ->collection('video')
                                    ->label('Video Trailer (MP4)')
                                    ->acceptedFileTypes(['video/mp4']),
                                FileUpload::make('background_music')
                                    ->label('File Nhạc Nền (MP3)')
                                    ->directory('reunion-music')
                                    ->acceptedFileTypes(['audio/mpeg', 'audio/mp3'])
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
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
                    ->description(fn (Reunion $record): string => url('/' . $record->slug))
                    ->copyable()
                    ->copyableState(fn (Reunion $record): string => url('/' . $record->slug))
                    ->copyMessage('Đã copy đường dẫn thiệp mời!'),
                TextColumn::make('graduation_year')
                    ->label('Niên khóa')
                    ->searchable(),

                TextColumn::make('event_date')
                    ->date('d/m/Y')
                    ->label('Ngày tổ chức')
                    ->sortable(),
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
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListReunions::route('/'),
            'create' => Pages\CreateReunion::route('/create'),
            'edit' => Pages\EditReunion::route('/{record}/edit'),
        ];
    }
}
