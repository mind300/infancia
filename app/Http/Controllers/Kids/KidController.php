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
            $parent->kids->each(function ($kid, $index) use ($request) {
                add_media($kid, $request->validated('kids'), 'kids');
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
        return contentResponse($kid->load('parent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKidRequest $request, Kid $kid)
    {
        $kid->update($request->validated());
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
}
