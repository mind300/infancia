<?php

namespace App\Http\Controllers\Nurseries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Nurseries\NurseryRequest;
use App\Http\Requests\Nurseries\NurseryStatusRequest;
use App\Models\Nursery;
use App\Models\User;
use Illuminate\Http\Request;

class NurseryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(NurseryStatusRequest $request)
    {
        $nurseries = Nursery::status($request)->paginate(10);
        return contentResponse($nurseries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NurseryRequest $request)
    {
        $user = User::create($request->validated() + ['password' => '12345test']);
        $nursery = $user->nursery()->create($request->validated());
        add_media($nursery, $request, 'nurseries');
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Nursery $nursery)
    {
        return contentResponse($nursery);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NurseryRequest $request, Nursery $nursery)
    {
        $nursery->update($request->validated());
        $nursery->user()->update($request->validated());
        add_media($nursery, $request, 'nurseries');
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nursery $nursery)
    {
        $nursery->forceDelete();
        return messageResponse();
    }
}
