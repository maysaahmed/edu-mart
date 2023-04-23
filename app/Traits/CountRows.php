<?php

namespace App\Traits;

trait CountRows{

    protected $rows;

    /**
     * count excel records
     * @return int
     */
    public function getRowCount(): int
    {
        return $this->rows;
    }
}
