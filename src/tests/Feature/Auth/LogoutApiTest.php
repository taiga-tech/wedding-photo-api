<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * @test
     */
    // public function should_認証済みのユーザーをログアウトさせる()
    // {
    //     $response = $this
    //         ->actingAs($this->user)
    //         ->json(
    //             'POST',
    //             route('logout'),
    //             ['X-Requested-With' => 'XMLHttpRequest']
    //         );
    //     $response->assertStatus(200);
    //     $this->assertGuest();
    // }
}
