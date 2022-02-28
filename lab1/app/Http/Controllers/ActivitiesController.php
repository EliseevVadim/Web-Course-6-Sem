<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Discipline;
use App\Models\Group;
use Illuminate\Http\Request;
use PHPUnit\Framework\Error;

class ActivitiesController extends Controller
{
    public function getActivityById(Request $request) {
        $id = $request->get('id');
        $activity = Activity::join('groups', 'activities.GroupId', '=', 'groups.id')
            ->join('disciplines', 'activities.DisciplineId', '=', 'disciplines.id')
            ->where('activities.id', '=', $id)
            ->orderByDesc('Date')
            ->select(['activities.*', 'groups.GroupName', 'disciplines.DisciplineName'])
            ->first();
        return response()->json([
            'date' => $activity->Date,
            'course' => $activity->Course,
            'group' => $activity->GroupName,
            'discipline' => $activity->DisciplineName,
            'lections' => $activity->Lections,
            'practics' => $activity->Practics,
            'labs' => $activity->Labs,
            'modules' => $activity->Modules,
            'semesterConsultations' => $activity->SemesterConsultations,
            'examConsultations' => $activity->ExamConsultations,
            'passes' => $activity->Passes,
            'exams' => $activity->Exams,
            'courseworks' => $activity->Courseworks,
            'bachelorsFQW' => $activity->BachelorsFQW,
            'specialistsFQW' => $activity->SpecialistsFQW,
            'mastersFQW' => $activity->MastersFQW,
            'practicsManagement' => $activity->PracticsManagement,
            'grandExams' => $activity->GrandExams,
            'FQWReviewing' => $activity->FQWReviewing,
            'FQWPresenting' => $activity->FQWPresenting,
            'aspirantsManagement' => $activity->AspirantsManagement,
            'others' => $activity->Others
        ]);
    }

    public function addRecord(Request $request) {
        $this->checkRequestValidity($request);
        $groupId = Group::where('GroupName', $request->group)->value('id');
        $disciplineId = Discipline::where('DisciplineName', $request->discipline)->value('id');
        if($groupId === null) {
            $group = new Group;
            $group->groupName = $request->group;
            $group->save();
            $groupId = $group->id;
        }
        if($disciplineId === null) {
            $discipline = new Discipline;
            $discipline->disciplineName = $request->discipline;
            $discipline->save();
            $disciplineId = $discipline->id;
        }
        $activity = new Activity;
        $this->fillActivityInfo($activity, $request, $groupId, $disciplineId);
        $activity->save();
    }

    public function updateRecord(Request $request) {
        $this->checkRequestValidity($request);
        $groupId = Group::where('GroupName', $request->group)->value('id');
        $disciplineId = Discipline::where('DisciplineName', $request->discipline)->value('id');
        if ($groupId === null)
            throw new Error("Неверно указана группа. Проверьте ввод");
        if ($disciplineId === null)
            throw new Error("Неверно указан предмет. Проверьте ввод");
        $activity = Activity::find($request->id);
        $this->fillActivityInfo($activity, $request, $groupId, $disciplineId);
        $activity->save();
    }

    public function deleteRecord($id) {
        Activity::destroy($id);
    }

    private function checkRequestValidity(Request $request) {
        if($request->date === "null" || $request->course === "null" || $request->discipline === "null" || $request->group === "null")
            throw new \Error();
    }

    private function fillActivityInfo(Activity $activity, Request $request, $groupId, $disciplineId) {
        $activity->date = $request->date;
        $activity->course = $request->course;
        $activity->groupId = $groupId;
        $activity->disciplineId = $disciplineId;
        $activity->lections = $request->lections !== "null" ? $request->lections : NULL;
        $activity->practics = $request->practics !== "null" ? $request->lections : NULL;
        $activity->labs = $request->labs !== "null" ? $request->lections : NULL;
        $activity->modules = $request->modules !== "null" ? $request->modules : NULL;
        $activity->semesterConsultations = $request->semesterConsultations !== "null" ? $request->semesterConsultations : NULL;
        $activity->examConsultations = $request->examConsultations !== "null" ? $request->examConsultations : NULL;
        $activity->passes = $request->passes !== "null" ? $request->passes : NULL;
        $activity->exams = $request->exams !== "null" ? $request->exams : NULL;
        $activity->courseworks = $request->courseworks !== "null" ? $request->courseworks : NULL;
        $activity->bachelorsFQW = $request->bachelorsFQW !== "null" ? $request->bachelorsFQW : NULL;
        $activity->specialistsFQW = $request->specialistsFQW !== "null" ? $request->specialistsFQW : NULL;
        $activity->mastersFQW = $request->mastersFQW !== "null" ? $request->mastersFQW : NULL;
        $activity->practicsManagement = $request->practicsManagement !== "null" ? $request->practicsManagement : NULL;
        $activity->grandExams = $request->grandExams !== "null" ? $request->grandExams : NULL;
        $activity->FQWReviewing = $request->FQWReviewing !== "null" ? $request->FQWReviewing : NULL;
        $activity->FQWPresenting = $request->FQWPresenting !== "null" ? $request->FQWPresenting : NULL;
        $activity->aspirantsManagement = $request->aspirantsManagement !== "null" ? $request->aspirantsManagement : NULL;
        $activity->others = $request->others !== "null" ? $request->others : NULL;
    }
}
