<?php

namespace App\Imports;

use App\Guest;
use Maatwebsite\Excel\Concerns\ToModel;

class GuestsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Guest([
            'guest_id' => "GE-" . strtotime("now"),
            'name' => $row[0],
            'phone' => null,
            'address' => $row[1],
            'comments' => null,
            'rsvp' => $row[2],
            'is_present' => null,
            'status' => 'active',
            'is_available' => 1,
            'invitation_id' => 0
        ]);
    }
}
