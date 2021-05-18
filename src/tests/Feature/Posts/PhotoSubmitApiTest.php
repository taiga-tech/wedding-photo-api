<?php

namespace Tests\Feature\Posts;

use App\Models\Post;
use App\Models\PostPhotos;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhotoSubmitApiTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->photos = [];
        $this->aspects = [];
        for ($i = 1; $i <= 6; $i++) {
            array_push($this->photos, array( 'photo' => UploadedFile::fake()->image("photo{$i}.jpg") ));
            array_push($this->aspects, 1);
        }

        $this->user = User::factory()->create();
    }

    /**
     * @test
     */
    public function should_ファイルをアップロードできる()
    {
        Storage::fake('s3');

        $response = $this
            ->actingAs($this->user)
            ->json('POST', route('posts.store'), $data = [
                'nickname' => $this->faker->name,
                'message' => $this->faker->name,
                'aspect' => $this->aspects,
                'files' => $this->photos,
            ], ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(201);

        $post = Post::first();

        $this->assertEquals($data['message'], $post->message);
        $this->assertCount(6, $post->photos);

        $response
            ->assertStatus(201)
            ->assertJson(['message' => $post->message]);

        Storage::cloud()->assertExists($post->filename);
    }

    /**
     * @test
     */
    // public function should_データベースエラーの場合はファイルを保存しない()
    // {
    //     Schema::drop('post_photos');

    //     Storage::fake('s3');

    //     $response = $this
    //         ->actingAs($this->user)
    //         ->json(
    //             'POST',
    //             route('posts.store'),
    //             [
    //                 'nickname' => $this->faker->name,
    //                 'message' => $this->faker->name,
    //                 'aspect' => $this->aspects,
    //                 'files' => $this->photos,
    //             ],
    //             ['X-Requested-With' => 'XMLHttpRequest']
    //         );

    //     $response->assertStatus(500);

    //     $this->assertEquals(0, count(Storage::cloud()->files()));
    // }
}
