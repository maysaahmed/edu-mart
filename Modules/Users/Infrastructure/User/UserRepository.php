<?php
namespace Modules\Users\Infrastructure\User;

use App\Domain\Entities\User\User;
use Modules\Users\Core\User\Commands\CreateUser\CreateUserModel;
use Modules\Users\Core\User\Commands\EditUser\EditUserModel;
use Modules\Users\Core\User\Queries\GetUserPagination\GetUserPaginationModel;
use Modules\Users\Core\User\Repositories\IUserRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Users\Domain\Entities\EndUser;
use App\Enums\EnumUserTypes;
use Modules\Users\Domain\Entities\UserAccount;
use Modules\Users\Domain\Entities\VerifyUser;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Modules\Users\Infrastructure\User\Imports\ImportUsers;

class UserRepository extends Repository implements IUserRepository
{
    protected function model(): string
    {
        return EndUser::class;
    }

    public function getUserById($id): EndUser|null
    {
        return EndUser::find($id);
    }
    public function getVerifyUserByToken($token): VerifyUser|null
    {
        return VerifyUser::where('token', $token)->first();
    }

    public function getUsersPagination(GetUserPaginationModel $model): LengthAwarePaginator
    {
        return  QueryBuilder::for(EndUser::class)
            ->where('organization_id', $model->org_id)
            ->where('type', EnumUserTypes::User->value)
            ->allowedFilters(['name', 'email',
                AllowedFilter::exact('created_by'),
                AllowedFilter::exact('check_email_status'),
            ])
            ->latest()
            ->paginate();
    }
    public function createUser(CreateUserModel $model): EndUser
    {
        $user = new EndUser();
        $user->name = $model->name;
        $user->email = $model->email;
        $user->password = bcrypt($model->password);
        $user->created_by = $model->createdBy;
        $user->organization_id = $model->organization_id;
        $user->check_email_status = 0;  // 1 for verified
        $user->type =$model->type;
        $user->is_active = 1;
        $user->save();

        VerifyUser::create([
            'user_id' => $user->id,
            'token' => sha1(time())
        ]);

        return $user;
    }
    public function editUser($model): EndUser|null
    {
        $item = $this->getUserByID($model->id);

        if($item){

            $item->name = $model->name;
            $item->email = $model->email;

            if(filled($model->password)){
                $item->password = bcrypt($model->password);
            }

            $item->is_active = $model->isActive;
            $item->updated_by = $model->updatedBy;
            $save = $item->save();

            if ($save) {
                return $item;
            }
        }

        return null;
    }
    public function verifyUser($token, $password): bool|null
    {
        $verifyUser = $this->getVerifyUserByToken($token);

        if($verifyUser){

            $verifyUser->user->check_email_status = 1;
            $verifyUser->user->password = bcrypt($password);
            $save = $verifyUser->user->save();

            if ($save) {
                return true;
            }
        }

        return null;
    }

    public function deleteUser(int $id, int $deletedBy): bool
    {
        $item = $this->getUserById($id);
        $item->deleted_at = now();
        $item->deleted_by = $deletedBy;

        return  $item && $item->save();

    }

    public function importUsers($file_path): int
    {
        $import = new ImportUsers;
        $import->import($file_path);

        return $import->getRowCount();

    }

    public function completeUserData($model): EndUser|null
    {
        $item = $this->getUserByID($model->user_id);

        if($item){
            $item->name = $model->name ?? $item->name;
            $save = $item->save();
            if($item->account)
            {
                $account = $item->account;
                $account->job_title = $model->jobTitle;
                $account->area = $model->area;
                $account->date_of_birth = $model->DOB;
                $account->gender = $model->gender;
                $account->save();
            }else{
                UserAccount::create([
                    'user_id' => $model->user_id,
                    'job_title' => $model->jobTitle,
                    'area' =>  $model->area,
                    'date_of_birth' => $model->DOB,
                    'gender' => $model->gender
                ]);
            }

            if ($save) {
                return $item;
            }
        }

        return null;
    }



}
