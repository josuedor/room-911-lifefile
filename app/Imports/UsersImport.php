<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UsersImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'firstname' => $row[0],
            'middlename' => $row[1],
            'lastname' => $row[2],
            'identification' => $row[3],
            'email' => $row[4],
            'password' => bcrypt($row[5]),
            'status' => $row[6],
            'departments_id' => $row[7],
            'roles_id' => $row[8]
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
