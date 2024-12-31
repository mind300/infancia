<?php

namespace App\Http\Controllers\PaymentBills;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentBills\PaiedRequest;
use App\Models\Kid;
use App\Models\KidPaymentBill;
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
        $paymentKidBill = KidPaymentBill::firstWhere('payment_bill_id', $request->payment_bill_id);
        $status = $request->validated('status');
        if ($request->hasFile('media')) {
            $status = 'review';
        }
        add_media($paymentKidBill, $request, 'kid payment bills ');
        $paymentKidBill->paymentBill->kids()->update(['status' => $status]);
        return messageResponse();
    }
}
