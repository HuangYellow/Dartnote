<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     * @group user
     */
    public function it_should_save_modified_bio_and_language()
    {
        $this->be($user = factory(User::class)->create());

        $this->put(route('users.update', auth()->user()->nickname), [
            'bio' => 'hello, world',
            'language' => 'en'
        ]);

        $this->assertDatabaseHas('users', [
            'bio' => 'hello, world',
            'language' => 'en'
        ]);
    }
}
