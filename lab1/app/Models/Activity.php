<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'course', 'groupId', 'disciplineId', 'lections', 'practics', 'labs',
        'modules', 'semesterConsultations', 'examConsultations', 'passes', 'exams', 'courseworks',
        'bachelorsFQW', 'specialistsFQW', 'mastersFQW', 'practicsManagement', 'grandExams', 'FQWReviewing',
        'aspirantsManagement', 'FQWPresenting', 'others'];
}
