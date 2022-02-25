<?php

namespace App\Imports;

use App\Models\Activity;
use App\Models\Group;
use App\Models\Discipline;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Excel;

class ActivitiesImport implements WithMultipleSheets
{

    public function sheets(): array
    {
        return [
            'учет' => new SecondSheetImport()
        ];
    }
}
