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

class KidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kids = Kid::branchScope($request)->paginate(10);
        return contentResponse($kids->load('parent'));
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
        return contentResponse($kid->load('parent.user'));
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
        $birthdays = Kid::orWhereMonth([['birth_date', now()->month], ['birth_date', now()]])->get();
        return contentResponse($birthdays);
    }


    // public function birthdayKids($accessMonth)
    // {
    //     $month = ($accessMonth === 'thisMonth') ? Carbon::now()->month : Carbon::now()->addMonth()->month;

    //     $today = Carbon::today()->startOfDay();
    //     $kidsBirth = Kids::whereMonth('birthdate', $month)->where('nursery_id', nursery_id())->get();

    //     $kids = $kidsBirth->map(function ($kid) use ($today) {
    //         $birthdateKid = Carbon::parse($kid->birthdate);
    //         $birthDayThisYear = $birthdateKid->copy()->year($today->year);

    //         if ($birthDayThisYear < $today) {
    //             $birthDayThisYear->addYear();
    //         }

    //         return [
    //             'id' => $kid->id,
    //             'kid_name' => $kid->kid_name,
    //             'class' => $kid->class->name,
    //             'birthdate' => $kid->birthdate,
    //             'age' => $birthdateKid->diffInYears($today),
    //             'countdown' => $birthDayThisYear->diffInDays($today),
    //         ];
    //     });

    //     return contentResponse($kids, fetchAll('Kids Birthday Upcoming'));
    // }
}
