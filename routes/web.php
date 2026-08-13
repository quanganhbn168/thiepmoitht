<?php

use App\Filament\Customer\Pages\CustomerDashboard;
use App\Filament\Pages\Dashboard;
use App\Http\Controllers\GatheringController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReunionController;
use App\Http\Controllers\WeddingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->to(
            request()->user()->isCustomer()
                ? CustomerDashboard::getUrl(panel: 'customer')
                : Dashboard::getUrl(panel: 'admin')
        );
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ====================================
// PUBLIC ROUTES (No Auth Required)
// ====================================

// Demo reunion pages
Route::get('/hop-lop-nien-khoa-1998-2001-que-vo-1', [ReunionController::class, 'showQueVoDemo'])->name('reunion.demo.que-vo');
Route::get('/hop-lop-que-vo-1-teacher', [ReunionController::class, 'showQueVoTeacherDemo'])->name('reunion.demo.que-vo-teacher');
Route::get('/hop-lop-que-vo-2', [ReunionController::class, 'showQueVo2Demo'])->name('reunion.demo.que-vo-2');
Route::post('/demo-hop-lop-rsvp', [ReunionController::class, 'storeRsvpDemo'])->name('reunion.demo.rsvp');
Route::post('/demo-hop-lop-message', [ReunionController::class, 'storeMessageDemo'])->name('reunion.demo.message');
Route::get('/{reunion:slug}/thay-co', [ReunionController::class, 'showTeacherInvitation'])->name('reunion.teacher.show');
Route::get('/{reunion:slug}/thu-cam-on/{recipient?}', [ReunionController::class, 'showThankYouLetter'])->name('reunion.thank-you.show');
Route::get('/{reunion:slug}/thu-cam-on-lop/{class}', [ReunionController::class, 'showThankYouLetterByClass'])->name('reunion.thank-you-class.show');

Route::get('/{reunion:slug}/thong-bao', [ReunionController::class, 'showNotification'])->name('reunion.notification.show');
Route::post('/{reunion:slug}/rsvp', [ReunionController::class, 'storeRsvp'])->name('reunion.rsvp.store');
Route::post('/{reunion:slug}/message', [ReunionController::class, 'storeMessage'])->name('reunion.message.store');

// Hội ngộ có module và URL riêng, không dùng chung dữ liệu với thiệp họp lớp.
// Scoped bindings đảm bảo mã khách chỉ được mở trong đúng buổi hội ngộ của họ.
Route::scopeBindings()->group(function (): void {
    Route::get('/hoi-ngo/{gathering:slug}', [GatheringController::class, 'show'])->name('gathering.show');
    Route::post('/hoi-ngo/{gathering:slug}/xac-nhan', [GatheringController::class, 'storeSharedRsvp'])->name('gathering.shared-rsvp.store');
    Route::get('/hoi-ngo/{gathering:slug}/{guest:code}', [GatheringController::class, 'showInvitation'])->name('gathering.invitation.show');
    Route::post('/hoi-ngo/{gathering:slug}/{guest:code}/xac-nhan', [GatheringController::class, 'storeRsvp'])->name('gathering.rsvp.store');
});

Route::get('/thiep-cuoi/{wedding:slug}', [WeddingController::class, 'show'])->name('wedding.show');

// Fallback: /{slug} can be reunion
Route::get('/{slug}', [\App\Http\Controllers\HomeController::class, 'resolveSlug'])
    ->where('slug', '^(?!admin|tai-khoan|thiep-cuoi|dashboard|login|register|profile|payment|api).*$')
    ->name('resolve.slug');
