<?php

namespace App\Http\Controllers\Kids;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kids\KidRequest;
use App\Models\Branch;
use App\Models\Kid;
use App\Models\ParentKid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $branch_id = $request->branch_id;
        $nursery_id = $request->nursery_id;
        $kids = Kid::orWhere([
            ['nursery_id', $nursery_id],
            ['branch_id', $branch_id]
        ])->paginate(10);
        return contentResponse($kids->load('parent'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KidRequest $request)
    {
        DB::beginTransaction();
        try {
            // Create the user
            $user = User::create(array_merge($request->validated(), ['password' => bcrypt('12345test')]));

            // Create parent data
            $parent = $user->parent()->create($request->safe()->except(['name', 'email']));

            // Create kids
            $parent->kids()->createMany($request->validated('kids'));

            DB::commit();
            return messageResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return messageResponse($e->getMessage(), false, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kid $kid)
    {
        return contentResponse($kid);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KidRequest $request, Kid $kid)
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
