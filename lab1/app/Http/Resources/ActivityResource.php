<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->Date,
            'course' => $this->Course,
            'group' => $this->GroupName,
            'discipline' => $this->DisciplineName,
            'lections' => $this->Lections,
            'practics' => $this->Practics,
            'labs' => $this->Labs,
            'modules' => $this->Modules,
            'semesterConsultations' => $this->SemesterConsultations,
            'examConsultations' => $this->ExamConsultations,
            'passes' => $this->Passes,
            'exams' => $this->Exams,
            'courseworks' => $this->Courseworks,
            'bachelorsFQW' => $this->BachelorsFQW,
            'specialistsFQW' => $this->SpecialistsFQW,
            'mastersFQW' => $this->MastersFQW,
            'practicsManagement' => $this->PracticsManagement,
            'grandExams' => $this->GrandExams,
            'FQWReviewing' => $this->FQWReviewing,
            'FQWPresenting' => $this->FQWPresenting,
            'aspirantsManagement' => $this->AspirantsManagement,
            'others' => $this->Others,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
