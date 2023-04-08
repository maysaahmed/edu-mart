<?php

namespace App\Core\User\Queries\GetUserPagination;

use App\Domain\Entities\User\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GetUserPaginationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_get_User_pagination()
    {
        User::factory()->count(55)->create();

        $query = $this->app->make(IGetUserPagination::class);

        $filter = new GetUserPaginationModel(1);
        $pagination = $query->execute($filter);

        self::assertEquals(55, $pagination->total());
        self::assertEquals(2, $pagination->lastPage());
    }

    public function test_can_get_User_pagination_by_name()
    {
        User::factory()->count(55)->create();

        $query = $this->app->make(IGetUserPagination::class);

        $filter = new GetUserPaginationModel(1);
        $pagination = $query->execute($filter);

        self::assertEquals(55, $pagination->total());
        self::assertEquals(2, $pagination->lastPage());
    }
}
