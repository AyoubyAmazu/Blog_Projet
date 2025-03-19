<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name'  => $row[0], // Column 1 (A)
            'email' => $row[1], // Column 2 (B)
            'password' => bcrypt($row[2]), // Column 3 (C)
        ]);
    }
}
