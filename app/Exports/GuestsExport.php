<?php

namespace App\Exports;

use App\Guest;
use App\Invitation;
use App\Bride;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromArray;

class GuestsExport implements FromArray, WithStyles
{
    protected $id;

    function __construct($id) {
        $this->id = $id;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getAlignment()->setWrapText(true);
    }

    public function array(): array 
    {
        $invitation = Invitation::where(['invitation_id' => $this->id])->first();
        $data = Guest::where(['invitation_id' => $invitation->id])->get();
        $brides = Bride::where(['invitation_id' => $invitation->id])->get();

        $payload = [
            ['No', 'ID', 'Name', 'Ucapan', 'Tamu Dari', 'Status']
        ];

        $no = 1;

        foreach ($data as $item) {
            $presentType = 'Tidak Hadir';
            if ($item->present_type === 'waiting-response') {
                $presentType = 'Menunggu Tanggapan';
            }
            if ($item->present_type === 'will-present') {
                $presentType = 'Akan Hadir - ' . $item->attendance;
            }
            if ($item->present_type === 'present') {
                $presentType = 'Hadir - ' . $item->attendance;
            }

            $fromBride = '';
            if ($item->bride_id) {
                foreach ($brides as $bride) {
                    if ($bride->id == $item->bride_id) {
                        $fromBride = $bride->name;
                    }
                }
            }

            array_push($payload, [
                $no,
                $item->guest_id,
                $item->name,
                $item->comments,
                $fromBride,
                $presentType,
            ]);

            $no++;
        }

        return $payload;
    }
}
