<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
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
        return new ActivityResource($activity);
    }

    public function addRecord(Request $request) {
        $request->validate([
            'date' => 'required',
            'course' => 'required',
            'group' => 'required',
            'discipline' => 'required'
        ]);
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
        $activity->fill($request->all());
        $activity->groupId = $groupId;
        $activity->disciplineId = $disciplineId;
        $activity->save();
    }

    public function updateRecord(Request $request) {
        $request->validate([
            'date' => 'required',
            'course' => 'required',
            'group' => 'required',
            'discipline' => 'required'
        ]);
        $groupId = Group::where('GroupName', $request->group)->value('id');
        $disciplineId = Discipline::where('DisciplineName', $request->discipline)->value('id');
        if ($groupId === null)
            throw new Error("Неверно указана группа. Проверьте ввод");
        if ($disciplineId === null)
            throw new Error("Неверно указан предмет. Проверьте ввод");
        $activity = Activity::find($request->id);
        $activity->fill($request->all());
        $activity->groupId = $groupId;
        $activity->disciplineId = $disciplineId;
        $activity->save();
    }

    public function deleteRecord($id) {
        Activity::destroy($id);
    }
}
