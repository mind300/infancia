<?php

namespace App\Http\Controllers\Branches;

use App\Http\Controllers\Controller;
use App\Http\Requests\Branches\BranchRequest;
use App\Models\Branch;
use App\Models\User;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::whereBelongsTo(nursery())->get();
        return contentResponse($branches);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BranchRequest $request)
    {
        $user = User::create($request->validated() + ['password' => '12345test']);
        $branch = $user->manager_branch()->create($request->validated());
        $user->branch()->associate($branch)->save();
        $user->syncRoles(['manager']);
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        return contentResponse($branch);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BranchRequest $request, Branch $branch)
    {
        $branch->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->forceDelete();
        return messageResponse();
    }
}
