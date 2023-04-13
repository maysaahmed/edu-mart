<?php

namespace Modules\Courses\Imports;

use App\Traits\CountRows;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;
use Modules\Courses\Entities\Course;

class ImportCourses implements ToModel, SkipsEmptyRows, WithValidation, WithHeadingRow, WithBatchInserts
{
    use Importable, ValidatesRequests, SkipsFailures, CountRows;
    /**
     * @param array $row
     *
     * @return Modules\Courses\Entities\Course|null
     */
    public function model(array $row): Modules\Courses\Entities\Course|Course|null
    {
        ++$this->rows;
        return new Course([
            'title'     => $row['title'],
            'desc'      => $row['description'],
            'duration'  => $row['duration'],
            'price'     => $row['price'],
            'location'  => $row['location'],
            'level_id'  => $row['level_id'],
            'category_id'  => $row['category_id'],
            'provider_id'  => $row['provider_id'],

        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            '*.title' => 'required|max:255',
            '*.duration' => 'required|numeric',
            '*.price' => 'required|numeric|between:0,9999999999.99',
            '*.level_id' => 'nullable|integer|exists:levels,id',
            '*.category_id' => 'nullable|integer|exists:categories,id',
            '*.provider_id' => 'nullable|integer|exists:providers,id'
        ];
    }


}
