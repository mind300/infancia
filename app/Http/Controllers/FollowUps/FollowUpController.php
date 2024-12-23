<?php

namespace App\Http\Controllers\FollowUps;

use App\Http\Controllers\Controller;
use App\Http\Requests\Followups\FollowUpAttendanceRequest;
use App\Http\Requests\FollowUps\FollowUpRequest;
use App\Models\Attendance;
use App\Models\FollowUp;
use App\Models\Kid;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FollowUpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = Carbon::parse($request->date);
        $kids = Kid::classScope($request)->paginate(10);
        $kids->transform(function ($kid) use ($date) {
            $kid->attend = $kid->attendances()->where('kid_id', $kid->id)->whereDay('created_at', $date)->exists();
            return $kid;
        });
        return contentResponse($kids);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FollowUpAttendanceRequest $request)
    {
        $date = Carbon::parse($request->date);
        $attendance = Attendance::where('kid_id', $request->kid_id)->whereDate('created_at', $date)->first();
        if (!$attendance) {
            Attendance::create($request->validated());
        } else {
            $attendance->forceDelete();
        }
        return messageResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FollowUpRequest $request, FollowUp $followUp)
    {
        $followUp->update($request->safe()->except(['meals', 'subjects']));
        $followUp->meals()->sync(collect($request->validated('meals'))->pluck('id'));
        $followUp->subjects()->sync(collect($request->validated('subjects'))->pluck('id'));
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(FollowUp $followUp)
    {
        return contentResponse($followUp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FollowUp $followUp)
    {
        $followUp->forceDelete();
        return messageResponse();
    }
}
