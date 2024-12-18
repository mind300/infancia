<?php

namespace App\Http\Controllers\ClassRooms;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassRooms\ClassRoomRequest;
use App\Models\Branch;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $branch_id = $request->branch_id;
        $classrooms = ClassRoom::where('branch_id', $branch_id)->paginate(10);
        return contentResponse($classrooms);
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
     * Display the specified resource.
     */
    public function show(ClassRoom $classroom)
    {
        return contentResponse($classroom);
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
