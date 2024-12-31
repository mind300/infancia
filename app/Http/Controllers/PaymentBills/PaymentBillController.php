<?php

namespace App\Http\Controllers\PaymentBills;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentBills\PaymentBillRequest;
use App\Models\PaymentBill;
use Illuminate\Http\Request;

class PaymentBillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paymentRequest = PaymentBill::branchScope($request)->paginate(10);
        return contentResponse($paymentRequest);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentBillRequest $request)
    {
        $paymentRequest = PaymentBill::create($request->validated());
        $paymentRequest->kids()->attach(collect($request->validated('kids'))->pluck('id'));
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentBill $payemntbill)
    {
        return contentResponse($payemntbill->load('kids.kid_payment_bill.media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentBillRequest $request, PaymentBill $paymentBill)
    {
        $paymentBill->update($request->validated());
        $paymentBill->kids()->sync(collect($request->validated('kids'))->pluck('id'));
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentBill $paymentBill)
    {
        $paymentBill->forceDelete();
        return messageResponse();
    }
}