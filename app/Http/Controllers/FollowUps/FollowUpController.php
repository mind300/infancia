<?php

namespace App\Http\Controllers\Followups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Followups\AttendanceRequest;
use App\Http\Requests\Followups\FollowupRequest;
use App\Models\Attendance;
use App\Models\FollowUp;
use App\Models\Kid;
use Illuminate\Http\Request;

class FollowupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kids = Kid::classScope($request)->paginate(10);
        $kids->transform(function ($kid) use ($request) {
            $kid->attend = $kid->attendances()->kidScope($request)->dateScope($request)->exists();
            $kid->followup_id = $kid->followup_id = $kid->followup()->dateScope($request)->first()?->id;
            return $kid;
        });
        return contentResponse($kids);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttendanceRequest $request)
    {
        $attendance = Attendance::kidScope($request)->dateScope($request)->first();
        if (!$attendance) {
            $attendance = Attendance::create($request->validated());
            $attendance->kid->followup()->create($request->validated());
        } else {
            $attendance->forceDelete();
            $attendance->kid->followup()->dateScope($request)->delete();
        }
        return messageResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FollowupRequest $request, FollowUp $followUp)
    {
        $followUp->update($request->safe()->except(['meals', 'subjects']));
        $followUp->meals()->sync(collect($request->validated('meals'))->pluck('id'));
        $followUp->subjects()->sync(collect($request->validated('subjects'))->pluck('id'));
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(FollowUp $followup)
    {
        return contentResponse($followup->load('meals'));
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
