<?php
namespace Modules\Users\Infrastructure\User;

use App\Core\Interfaces\Services\IImageService;
use Illuminate\Database\Eloquent\Collection;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Modules\Users\Core\User\Commands\CreateUser\CreateUserModel;
use Modules\Users\Core\User\Commands\RegisterUser\RegisterUserModel;
use Modules\Users\Core\User\Queries\GetUserPagination\GetUserPaginationModel;
use Modules\Users\Core\User\Repositories\IUserRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Users\Domain\Entities\EndUser;
use App\Enums\EnumUserTypes;
use Modules\Users\Domain\Entities\PasswordReset;
use Modules\Users\Domain\Entities\UserAccount;
use Modules\Users\Domain\Entities\VerifyUser;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Modules\Users\Infrastructure\User\Imports\ImportUsers;
use DB;
use Str;
use Hash;

class UserRepository extends Repository implements IUserRepository
{

    private IImageService $img;

    public function __construct(IImageService $img)
    {
        $this->img = $img;
    }
    protected function model(): string
    {
        return EndUser::class;
    }

    public function getUserById($id): EndUser|null
    {
        return EndUser::find($id);
    }

    public function getUserByEmail($email): EndUser|null
    {
        return EndUser::where('email' , $email)->first();
    }
    public function getVerifyUserByToken($token): VerifyUser|null
    {
        return VerifyUser::where('token', $token)->first();
    }
    public function getResetByToken($token): PasswordReset|null
    {
        return PasswordReset::where('token', $token)->first();
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

    public function getAllEndUsers(): Collection
    {
        return  EndUser::where('type', EnumUserTypes::User->value)
            ->latest()
            ->get();
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

    public function generateToken(): string
    {
        do {
            $token = Str::random(40);
        } while (PasswordReset::where("token", $token)->first() instanceof PasswordReset);
        return $token;
    }

    public function createUserToken($email):  string|null
    {
        $item = $this->getUserByEmail($email);
        if($item)
        {
            $userCheckPasswordReset = PasswordReset::where('email', $email)->count();

            $token = $this->generateToken();
            if ($userCheckPasswordReset > 0) {
                PasswordReset::where('email', $email)->delete();
            }

            DB::table('password_reset_tokens')->insert(
                ['email' => $email, 'token' => $token]
            );
            return $token;
        }
        return null;
    }
    public function verifyUser($token, $password): bool|null
    {
        $verifyUser = $this->getVerifyUserByToken($token);

        if($verifyUser){

            $verifyUser->user->check_email_status = 1;
            $verifyUser->user->password = bcrypt($password);
            $verifyUser->user->email_verified_at = now();;
            $save = $verifyUser->user->save();

            if ($save) {
                return true;
            }
        }

        return null;
    }


    public function resetPassword($token, $password): int|null
    {
        $resetToken = $this->getResetByToken($token);

        if($resetToken){
            $user = $this->getUserByEmail($resetToken->email);

            $user->password = bcrypt($password);
            $save = $user->save();

            if ($save) {
                PasswordReset::where('token', $token)->delete();
                return $user->type;
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

    public function importUsers($file_path): int|null
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


    public function registerUser(RegisterUserModel $model): EndUser
    {
        $user = new EndUser();
        $user->name = $model->first_name.' '.$model->last_name;
        $user->email = $model->email;
        $user->password = bcrypt($model->password);
        $user->check_email_status = 0;  // 1 for verified
        $user->type = 3;
        $user->is_active = 1;
        $user->save();

        VerifyUser::create([
            'user_id' => $user->id,
            'token' => sha1(time())
        ]);

        return $user;
    }

    public function verifyRegisteredUser($token): bool|null
    {
        $verifyUser = $this->getVerifyUserByToken($token);

        if($verifyUser){

            $verifyUser->user->check_email_status = 1;
            $verifyUser->user->email_verified_at = now();;
            $save = $verifyUser->user->save();

            if ($save) {
                return true;
            }
        }

        return null;
    }

    public function editProfile($model): EndUser|null
    {
        $item = $this->getUserByID($model->id);

        if($item){
            $account = UserAccount::where('user_id', $model->id)->first();
            $img_name = '';
            if(isset($model->image))
            {
                if($account && isset($account->image)){
                    $this->img->removeImage('images/profile/', $account->image);
                }
                $img_name = $this->img->uploadImage(request()->file('image'), 'images/profile/', 150, 150);
                if($account)
                    $account->image = $img_name;
            }

            if($account)
            {
                $account->gender = $model->gender;
                $account->date_of_birth = $model->dob;
                $account->graduated = $model->graduated;
                $account->education = $model->education;
                $account->university = $model->university;
                $account->industry = $model->industry;
                $account->area = $model->area;
                $account->phone = $model->phone;
                $account->save();
            }else{
                UserAccount::create([
                    'user_id' => $model->id,
                    'gender' => $model->gender,
                    'date_of_birth' => $model->dob,
                    'graduated' => $model->graduated,
                    'education' => $model->education,
                    'university' => $model->university,
                    'industry' => $model->industry,
                    'image' => $img_name,
                    'area' => $model->area,
                    'phone' => $model->phone,

                ]);
            }



            $item->name = $model->name;
            $item->email = $model->email;

            $save = $item->save();

            if ($save) {
                return $item;
            }
        }

        return null;
    }

    public function uploadImage($id, $image): string|null
    {
        $item = $this->getUserByID($id);
        if($item) {
            $account = UserAccount::where('user_id', $id)->first();

            if (isset($image)) {
                if ($account && isset($account->image)) {
                    $this->img->removeImage('images/profile/', $account->image);
                }
                $img_name = $this->img->uploadImage(request()->file('image'), 'images/profile/', 150, 150);
                if ($account){
                    $account->image = $img_name;
                    $account->save();

                }else{
                    UserAccount::create([
                        'user_id' => $id,
                        'image' => $img_name
                    ]);
                }

                return config('app.url').'/images/profile/'.$img_name;
            }
            return null;
        }
    }

    public function removeImage($id): bool|null
    {
        $item = $this->getUserByID($id);
        if($item) {
            $account = UserAccount::where('user_id', $id)->first();

            if ($account && isset($account->image)) {
                $this->img->removeImage('images/profile/', $account->image);
                $account->image = '';
                $account->save();
                return true;
            }

            return null;
        }
    }

    public function changePassword(int $id, string $newPass): EndUser|null
    {
        $item = $this->getUserById($id);

        if($item){

            $item->password = bcrypt($newPass);
            $save = $item->save();

            if ($save) {
                return $item;
            }
        }

        return null;
    }
}
