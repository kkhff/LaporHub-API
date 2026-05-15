<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Report::with('user', 'category')->get();
    }

    public function headings(): array
    {
        return ['id', 'Pelapor', 'Laporan', 'Kategori', 'Status', 'Tanggal Lapor'];
    }

    public function map($report): array
    {
        return [
            'id' => $report->id,
            'Pelapor' => $report->user->name ?? 'User Dihapus',
            'Laporan' => $report->title,
            'Kategori' => $report->category->name ?? 'Tanpa Kategori',
            'Status' => $report->status,
            'Tanggal Lapor' => $report->created_at->format('d M Y H:i')
        ];
    }
}
