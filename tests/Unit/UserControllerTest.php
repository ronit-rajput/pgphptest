<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetUserCard()
    {
        $user = User::first();
        $response = $this->get('/user/'.$user->id);
        $response->assertStatus(200);
    }

    public function testUserWithInvalidId()
    {
        $response = $this->get('/user/0');
        $response->assertStatus(404);
    }
}
