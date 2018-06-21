<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     * @group post
     */
    public function it_should_create_by_auth()
    {
        $this->be($user = factory(User::class)->create());

        $this->post(route('posts.store', [
            'content' => 'ABCD',
            'options' => ['foo' => 'baz'],
        ]));

        $this->assertDatabaseHas('posts', [
            'user_id' => auth()->id(),
            'content' => 'ABCD',
            'options' => json_encode(['foo' => 'baz']),
        ]);
    }
}
