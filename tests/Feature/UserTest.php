<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

use \Facades\App\Services\UserSyncService;

class UserTest extends TestCase
{
    /**
     * This test will end up making the request to the Application 2
     */
    public function testUserWithSync()
    {
        $name = 'savio-test';
        $response = $this->get('/user-create/' . $name);
        $response->assertStatus(200);
        $response->assertJson([
            'name' => $name,
        ]);
    }

    /**
     * This test won't make the request to the Application 2
     */
    public function testUserWithoutSyncRealTimeStrategy()
    {
        $name = 'savio-test';

        $user = factory(User::class)->make([
            'name' => $name,
        ]);
        UserSyncService::shouldReceive('sync')->andReturn($user);

        $response = $this->get('/user-create/' . $name);
        $response->assertStatus(200);
        $response->assertJson([
            'name' => $name,
        ]);
    }
}
