<?php

namespace Modules\Organizations\Imports;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Modules\Organizations\Entities\Organization;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;

class ImportOrganizations implements ToModel, SkipsEmptyRows, WithValidation, WithHeadingRow, WithBatchInserts
{
    use Importable, ValidatesRequests, SkipsFailures;
    /**
     * @param array $row
     *
     * @return Modules\Organizations\Entities\Organization|null
     */
    public function model(array $row): Modules\Organizations\Entities\Organization|Organization|null
    {
        return new Organization([
            'name'     => $row['name'],
            'phone'    => $row['phone'],
            'address'  => $row['address'],
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required|unique:organizations|max:255',
            '*.phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            '*.address' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/|min:8',
        ];
    }


}
