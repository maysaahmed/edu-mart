<?php

namespace App\Service\User;

//use Dingo\Api\Auth\Auth;
use App\Domain\Entities\User\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_get_users()
    {
        User::factory()->create();
        User::factory()->create();
        $latestUser = User::factory()->create();

        $user = User::factory()->create();

        $this->app->make(Auth::class)->setUser($user);
        $response = $this->get('api/users')->decodeResponseJson();
        $response->assertPath('data.0.attributes.name', $latestUser->name);
    }

    public function test_can_create_users()
    {
        $faker = Factory::create();
        $payload = [
            'name' => $faker->words(3, true),
            'email' => $faker->email(),
            'password' => $faker->password(),
        ];

        $user = User::factory()->create();
        $this->app->make(Auth::class)->setUser($user);

        $response = $this->post('api/users', $payload)->decodeResponseJson();
        $response->assertPath('data.attributes.name', $payload['name']);
        $response->assertPath('data.attributes.email', $payload['email']);
        $response->assertPath('data.attributes.password', $payload['password']);
    }
}
