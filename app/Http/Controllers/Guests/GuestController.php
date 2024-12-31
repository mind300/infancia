<?php

namespace App\Http\Controllers\Guests;

use App\Http\Controllers\Controller;
use App\Models\Nursery;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nurseries = Nursery::where('status', 'approved')->get();
        return contentResponse($nurseries);
    }

    /**
     * Display the specified resource.
     */
    public function show(Nursery $nursery)
    {
        return contentResponse($nursery->load('media','services','contacts', 'reviews'));
    }
}
