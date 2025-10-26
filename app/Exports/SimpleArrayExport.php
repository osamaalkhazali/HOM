<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SimpleArrayExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /** @var array<int, string> */
    protected array $headings;

    /** @var array<int, array<int, string|int|float|null>> */
    protected array $rows;

    /**
     * @param array<int, string> $headings
     * @param array<int, array<int, string|int|float|null>> $rows
     */
    public function __construct(array $headings, array $rows)
    {
        $this->headings = $headings;
        $this->rows = $rows;
    }

    public function collection(): Collection
    {
        return collect($this->rows);
    }

    public function headings(): array
    {
        return $this->headings;
    }
}
