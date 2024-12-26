<?php

namespace App\Http\Controllers\PaymentBills;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentBills\PaiedRequest;
use App\Models\Kid;
use App\Models\PaymentBill;
use Illuminate\Http\Request;

class PaymentBillsHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kids = Kid::find($request->kid_id);
        return contentResponse($kids->load('payment_bills'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(PaiedRequest $request)
    {
        $paymentBill = PaymentBill::find($request->validated('payment_bill_id'));
        $paymentBill->kids()->update(['status' => 'review']);
        add_media($paymentBill, $request, 'payment bills');
        return messageResponse();
    }
}
