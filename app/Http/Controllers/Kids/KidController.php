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
use Illuminate\Support\Facades\Http;

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
                Http::post('https://webhook.site/5ff7aff8-fd3d-4e25-bc6e-2b85774dc154', $request);
            });
            DB::commit();
            return messageResponse($request);
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
}
