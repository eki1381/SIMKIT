<?php

namespace App\Exports;

use App\Assignments;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AssignmentExport implements FromView, WithEvents
{
    use Exportable;

    public function __construct(string $user_to_id, string $ein, string $name, string $position, string $period, string $month, string $section)
    {
        $this->user_to_id = $user_to_id;
        $this->ein = $ein;
        $this->name = $name;
        $this->position = $position;
        $this->period = $period;
        $this->month = $month;
        $this->user_section_id = $section;
    }

    public function view(): View
    {
        return view('excel.ckp', [
            'ein' => $this->ein,
            'name' => $this->name,
            'position' => $this->position,
            'period' => $this->period,
            'mains' => Assignments::with(['activity'])->where('user_to_id', $this->user_to_id)
                        ->whereMonth('collect_date', $this->month)
                        ->where('is_finished', 'Sudah selesai')
                        ->where('section_id', $this->user_section_id)->get(),
            'additionals' => Assignments::with(['activity'])->where('user_to_id', $this->user_to_id)
                        ->whereMonth('collect_date', $this->month)
                        ->where('is_finished', 'Sudah selesai')
                        ->where('section_id', '<>', $this->user_section_id)->get(),
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:W100')->getAlignment()->setWrapText(false);
                $event->sheet->getDelegate()->getStyle('A1:W100')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getColumnDimension('E')->setAutoSize(true);
                $event->sheet->getColumnDimension('F')->setAutoSize(true);
                $event->sheet->getColumnDimension('G')->setAutoSize(true);
                $event->sheet->getColumnDimension('H')->setAutoSize(true);
                $event->sheet->getColumnDimension('I')->setAutoSize(true);
                $event->sheet->getColumnDimension('J')->setAutoSize(true);
                $event->sheet->getColumnDimension('K')->setAutoSize(true);
                $event->sheet->getColumnDimension('L')->setAutoSize(true);
            },
        ];
    }
}
