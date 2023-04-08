<?php

namespace App\Infrastructure\User;

use App\Core\User\Repositories\IUserRepository;
use App\Domain\Entities\User\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_get_users()
    {
        $user = User::factory()->create();

        $repository = $this->app->make(IUserRepository::class);
        $users = $repository->all();
        $latestUser = $users->last();

        self::assertEquals($latestUser->name, $user->name);
        self::assertEquals($latestUser->email, $user->email);
    }

    public function test_can_get_users_by_name()
    {
        User::factory()->create();
        $user2 = User::factory()->create();
        User::factory()->create();

        $repository = $this->app->make(IUserRepository::class);
        $foundUser = $repository->addCriteria(new NameCriteria($user2->name))->first();

        self::assertEquals($foundUser->name, $user2->name);
        self::assertEquals($foundUser->email, $user2->email);
    }

    public function test_can_get_users_order_by_latest()
    {
        User::factory()->create();
        User::factory()->create();
        $user3 = User::factory()->create();

        $repository = $this->app->make(IUserRepository::class);
        $foundUser = $repository->addCriteria(new OrderByLatest())->first();

        self::assertEquals($foundUser->name, $user3->name);
        self::assertEquals($foundUser->email, $user3->email);
    }
}
