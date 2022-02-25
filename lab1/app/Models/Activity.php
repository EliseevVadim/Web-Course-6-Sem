<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['Date', 'Course', 'GroupId', 'DisciplineId', 'Lections', 'Practics', 'Labs',
        'Modules', 'SemesterConsultations', 'ExamConsultations', 'Passes', 'Exams', 'Courseworks',
        'BachelorsFQW', 'SpecialistsFQW', 'MastersFQW', 'PracticsManagement', 'GrandExams', 'FQWReviewing',
        'AspirantsManagement', 'FQWPresenting', 'Others'];
}
