<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedules\ScheduleRequest;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $schedules = ClassRoom::with(['schedules' => function ($query) use ($request) {
            $query->where([['class_room_id', $request->class_room_id], ['date' => $request->date]]);
        }])->find($request->class_room_id);
        return contentResponse($schedules);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ScheduleRequest $request, ClassRoom $classRoom)
    {
        $classRoom->schedules()->attach($request->safe());
        return messageResponse();
    }
}