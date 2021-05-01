<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeeExport implements FromQuery
{
    use Exportable;

    protected $employees;

    public function __construct($employees)
    {
        $this->employees = $employees;
    }

    public function query()
    {
        return User::query()->whereKey($this->employees);
    }
}
