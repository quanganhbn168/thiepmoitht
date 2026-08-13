<?php

namespace Tests\Feature;

use App\Models\Gathering;
use App\Models\GatheringGuest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GatheringSharedRsvpTest extends TestCase
{
    use RefreshDatabase;

    public function test_shared_invitation_collects_a_name_and_creates_a_personal_payment_link(): void
    {
        $gathering = Gathering::query()->create([
            'slug' => 'hoi-ngo-thang-8',
            'title' => 'Hội ngộ tháng 8',
            'status' => 'published',
            'is_active' => true,
            'content' => [
                'payment' => [
                    'enabled' => true,
                    'bank_bin' => '970436',
                    'bank_name' => 'Vietcombank',
                    'account_number' => '123456789',
                    'account_holder' => 'NGUYEN VAN A',
                    'amount' => 500000,
                    'transfer_prefix' => 'HOINGO',
                ],
            ],
        ]);

        $this->get(route('gathering.show', $gathering))
            ->assertOk()
            ->assertSee('Họ và tên của bạn')
            ->assertDontSee('name="guest_count"', false)
            ->assertSee('HOINGO');

        $response = $this->post(route('gathering.shared-rsvp.store', $gathering), [
            'name' => 'Nguyễn Văn A',
            'rsvp_status' => 'attending',
            'phone' => '0912345678',
            'note' => 'Hẹn gặp mọi người.',
        ]);

        $guest = GatheringGuest::query()->sole();

        $response->assertRedirect(route('gathering.invitation.show', [
            'gathering' => $gathering,
            'guest' => $guest,
        ]));

        $this->assertDatabaseHas('gathering_guests', [
            'gathering_id' => $gathering->id,
            'name' => 'Nguyễn Văn A',
            'code' => 'nguyen-van-a',
            'rsvp_status' => 'attending',
            'guest_count' => 1,
            'phone' => '0912345678',
            'note' => 'Hẹn gặp mọi người.',
        ]);

        $this->get(route('gathering.invitation.show', [
            'gathering' => $gathering,
            'guest' => $guest,
        ]))
            ->assertOk()
            ->assertSee('500.000đ')
            ->assertSee('HOINGO nguyen-van-a');
    }
}
