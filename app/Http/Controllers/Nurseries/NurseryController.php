<?php

namespace App\Http\Controllers\Nurseries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Nurseries\NurseryRequest;
use App\Http\Requests\Nurseries\NurseryStatusRequest;
use App\Http\Requests\Nurseries\RateNurseryRequest;
use App\Models\Nursery;
use App\Models\User;

class NurseryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(NurseryStatusRequest $request)
    {
        $nurseries = Nursery::status($request)->paginate(10);
        return contentResponse($nurseries->load('media'));
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
    public function show(Nursery $nurseries)
    {
        return contentResponse($nurseries->load('media', 'services', 'contacts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NurseryRequest $request, Nursery $nurseries)
    {
        $nurseries->update($request->validated());
        $nurseries->user()->update($request->safe()->only(['email', 'phone']));
        $nurseries->services()->upsert($request->validated('services'), ['id'], ['content']);
        $nurseries->contacts()->upsert($request->validated('contacts'), ['id'], ['link', 'type', 'icon']);
        add_media($nurseries, $request, 'nurseries');
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function rates(RateNurseryRequest $request, Nursery $nursery)
    {
        $nursery->update(['rates' => $request->validated('rates')]);
        return messageResponse();
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nursery $nurseries)
    {
        $nurseries->forceDelete();
        return messageResponse();
    }
}
