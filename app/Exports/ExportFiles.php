<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportFiles implements FromCollection, WithHeadingRow, WithHeadings
{
    protected $result, $columns;

    public function __construct($result)
    {
        $this->result = collect($result);
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return ($this->result);
    }

    public function headings(): array
    {
        return [array_keys(collect($this->result)[0])];
    }
}
