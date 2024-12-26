<?php

namespace App\Models;

class PaymentBill extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'desciprtion',
        'status',
        'branch_id',
        'nursery_id',
    ];

    // =================================== Relations ================================= //

    /**
     * The Comment
     */
    public function nursery()
    {
        return $this->belongsTo(Nursery::class);
    }

    /**
     * The Comment
     */
    public function kids()
    {
        return $this->belongsToMany(Kid::class, 'kids_payment_bill')->withPivot('status');
    }
}