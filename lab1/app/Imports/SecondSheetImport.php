<?php

namespace App\Imports;

use App\Models\Activity;
use App\Models\Discipline;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SecondSheetImport implements ToModel, WithChunkReading, WithColumnLimit
{
    public function model(array $row)
    {
        $groupId = Group::where('GroupName', $row[2])->value('id');
        $disciplineId = Discipline::where('DisciplineName', $row[3])->value('id');
        if (is_int($row[0]) && is_int($groupId) && is_int($row[1]) && is_int($disciplineId)) {
            return new Activity([
                'Date' => Date::excelToDateTimeObject($row[0]),
                'Course' => $row[1],
                'GroupId' => Group::where('GroupName', $row[2])->value('id'),
                'DisciplineId' => Discipline::where('DisciplineName', $row[3])->value('id'),
                'Lections' => $row[4],
                'Practics' => $row[5],
                'Labs' => $row[6],
                'Modules' => $row[7],
                'SemesterConsultations' => $row[8],
                'ExamConsultations' => $row[9],
                'Passes' => $row[10],
                'Exams' => $row[11],
                'Courseworks' => $row[12],
                'BachelorsFQW' => $row[13],
                'SpecialistsFQW' => $row[14],
                'MastersFQW' => $row[15],
                'PracticsManagement' => $row[16],
                'GrandExams' => $row[17],
                'FQWReviewing' => $row[18],
                'AspirantsManagement' => $row[19],
                'FQWPresenting' => $row[20],
                'Others' => $row[21]
            ]);
        }
        return null;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function endColumn(): string
    {
        return 'V';
    }
}
