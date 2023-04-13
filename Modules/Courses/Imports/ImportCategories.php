<?php

namespace Modules\Courses\Imports;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Modules\Courses\Entities\Category;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;

class ImportCategories implements ToModel, SkipsEmptyRows, WithValidation, WithHeadingRow, WithBatchInserts
{
    use Importable, ValidatesRequests, SkipsFailures;
    /**
     * @param array $row
     *
     * @return Modules\Courses\Entities\Category|null
     */
    public function model(array $row): Modules\Courses\Entities\Category|Category|null
    {
        return new Category([
            'name'     => $row['name'],
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required|max:255',
        ];
    }


}
