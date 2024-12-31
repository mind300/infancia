<?php

namespace App\Http\Controllers\Kids;

use App\Http\Controllers\Controller;
// Models
use App\Models\Kid;
use App\Models\User;
// DB
use Illuminate\Support\Facades\DB;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Kids\StoreKidRequest;
use App\Http\Requests\Kids\UpdateKidRequest;
use Carbon\Carbon;

class KidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kids = Kid::branchScope($request)->get();
        return contentResponse($kids->load('media','parent'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKidRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create($request->validated() + ['password' => bcrypt('12345test')]); // Create the user
            $parent = $user->parent()->create($request->safe()->except(['name', 'email'])); // Create parent data
            $parent->kids()->createMany($request->validated('kids')); // Create kids
            $parent->kids->each(function ($kid) use ($request) {
                add_media($kid, $request, 'kids');
            });
            $user->syncRoles(['parent']);
            DB::commit();
            return messageResponse();
        } catch (\Exception $error) {
            DB::rollBack();
            return messageResponse($error->getMessage(), false, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kid $kid)
    {
        return contentResponse($kid->load('media','parent.user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKidRequest $request, Kid $kid)
    {
        $kid->update($request->validated());
        add_media($kid, $request, 'kids');
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kid $kid)
    {
        $kid->forceDelete();
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function birthday()
    {
        $kids = Kid::whereMonth('birth_date', now()->month())
            ->orWhereMonth('birth_date', now()->addMonth()->month)
            ->get();

        $kids->transform(function ($kid) {
            $birthdayThisYear = Carbon::parse($kid->birth_date)->setYear(now()->year);
            if ($birthdayThisYear->isPast()) {
                $birthdayThisYear->addYear();
            }
            if (!$birthdayThisYear->isBefore(today())) {
                $kid->countdown = $birthdayThisYear->diffInDays(today(), true);
                return $kid;
            }
        });

        return messageResponse($kids);
    }
}
