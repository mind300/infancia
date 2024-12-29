<?php

namespace App\Http\Controllers\ClassRooms;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassRooms\ClassRoomRequest;
use App\Http\Requests\ClassRooms\ClassRoomSubjectRequest;
use Illuminate\Http\Request;
use App\Models\ClassRoom;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classrooms = ClassRoom::branchScope($request)->paginate(10);
        return contentResponse($classrooms->load('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassRoomRequest $request)
    {
        $classroom = ClassRoom::create($request->validated());
        return messageResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function assignSubject(ClassRoomSubjectRequest $request, ClassRoom $classroom)
    {
        $classroom->subjects()->sync(collect($request->validated('subjects'))->pluck('subject_id'));
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ClassRoom $classroom)
    {
        return contentResponse($request->no_kids == 'true' ?  $classroom->load('subjects') : $classroom->load('subjects', 'kids'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassRoomRequest $request, ClassRoom $classroom)
    {
        $classroom->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassRoom $classroom)
    {
        $classroom->forceDelete();
        return messageResponse();
    }
}
