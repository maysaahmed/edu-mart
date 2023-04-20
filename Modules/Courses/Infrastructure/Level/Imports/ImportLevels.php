<?php

namespace Modules\Courses\Infrastructure\Level\Imports;

use App\Traits\CountRows;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Modules\Courses\Domain\Entities\Level;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;

class ImportLevels implements ToModel, SkipsEmptyRows, WithValidation, WithHeadingRow, WithBatchInserts
{
    use Importable, ValidatesRequests, SkipsFailures, CountRows;

    /**
     * @param array $row
     * @return Modules\Courses\Domain\Entities|Level|null
     */
    public function model(array $row): Modules\Courses\Domain\Entities|Level|null
    {
        ++$this->rows;
        return new Level([
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
