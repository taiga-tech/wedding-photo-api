<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_新しいユーザーを作成して返却する()
    {
        $data = [
            'name' => 'vuesplashuser',
            'login_id' => 'dummydummy',
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
        ];

        $response = $this->json(
            'POST',
            route('register'),
            $data,
            ['X-Requested-With' => 'XMLHttpRequest']
        );

        // dd($response->headers->get('X-Requested-With'));

        $user = User::first();
        $this->assertEquals($data['name'], $user->name);

        $response
            ->assertStatus(201)
            ->assertJson(['name' => $user->name]);
    }
}
