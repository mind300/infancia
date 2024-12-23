<?php

namespace App\Http\Controllers;

use App\Http\Requests\Nurseries\NurseryRequest;
use App\Models\Nursery;
use Illuminate\Http\Request;

class NurseryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nurseries = Nursery::status('pending')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nursery = Nursery::create($request->validated());
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
