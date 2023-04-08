<?php

namespace App\Core\User\Commands\CreateUser;

use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_create_user()
    {
        $faker = Factory::create();

        $model = new CreateUserModel();
        $model->name = $faker->words(3, true);
        $model->email = $faker->email();
        $model->password = $faker->password();

        $command = $this->app->make(ICreateUser::class);
        $user = $command->execute($model);

        self::assertEquals($user->name, $model->name);
        self::assertEquals($user->email, $model->email);
        self::assertEquals($user->password, $model->password);
    }
}
