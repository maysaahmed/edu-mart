<?php

namespace Modules\Users\Infrastructure\User\Imports;

use App\Traits\CountRows;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;
use Modules\Users\Domain\Entities\EndUser;
use Modules\Users\Domain\Entities\VerifyUser;
use App\Enums;
use Str;
use DB;
use App\Jobs\SendEmailQueueJob;

class ImportUsers implements ToCollection, SkipsEmptyRows, WithValidation, WithHeadingRow, WithBatchInserts
{
    use Importable, ValidatesRequests, SkipsFailures, CountRows;
    /**
     * @param array $row
     *
     * @return Modules\Users\Entities\EndUser|null
     */

    public function batchSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            '*.name'=> 'required|unique:users|max:255',
            '*.email'=> 'required|email|unique:users|max:255'
        ];
    }


    public function collection(Collection $rows)
    {


        //user data
        $currentUserID = request()->user()->id;
        $currentUserOrganizationId = request()->user()->organization_id;

        foreach ($rows as $row)
        {
            ++$this->rows;
            $user = new EndUser();
            $user->name = $row['name'];
            $user->email = $row['email'];
            $user->password = bcrypt(Str::random(3));
            $user->created_by = $currentUserID;
            $user->organization_id = $currentUserOrganizationId;
            $user->check_email_status = 0;  // 1 for verified
            $user->type = Enums\EnumUserTypes::User->value;
            $user->is_active = 1;
            $user->save();

             //   create row in verify user table
            VerifyUser::create([
                'user_id' => $user->id,
                'token' => sha1(time())
            ]);

            $link = env('VERIFY_FRONT_URL').'/'. $user->verifyUser->token;

            dispatch(new SendEmailQueueJob($user->email, $user->name, $link));
        }

    }
}
