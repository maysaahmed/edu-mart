<?php

namespace App\Service\User;

use App\Common\Date\DateHelper;
use Illuminate\Database\Eloquent\Model;
use App\Service\Common\Transformer;

/**
 * Class UserTransformer
 * @package App\Service\User
 * @OA\Schema(
 *     schema="UserTransformer",
 *     type="object",
 *     title="UserTransformer",
 *     properties={
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="attributes", type="object", properties={
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="email", type="string")
 *         }),
 *         @OA\Property(property="relationships", type="array", @OA\Items({
 *
 *         })),
 *     }
 * )
 */
class UserTransformer extends Transformer
{
    function attributes(Model $model): array
    {
        return [
            'name' => $model->name,
            'email' => $model->email,
        ];
    }
}
