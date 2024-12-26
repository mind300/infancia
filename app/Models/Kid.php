<?php

namespace App\Models;

class Kid extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'has_medical_case',
        'description_medical_case',
        'parent_id',
        'nursery_id',
        'branch_id',
        'class_room_id',
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
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * The Comment
     */
    public function parent()
    {
        return $this->belongsTo(ParentKid::class);
    }

    /**
     * The Comment
     */
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    /**
     * The Comment
     */
    public function payment_bills()
    {
        return $this->belongsToMany(PaymentBill::class, 'kids_payment_bill')->withPivot('status');
    }

    /**
     * One-to-many relationship with Attendance
     */
    public function attendance()
    {
        return $this->hasOne(Attendance::class, 'kid_id');
    }

    /**
     * One-to-many relationship with Attendance
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'kid_id');
    }

    /**
     * One-to-many relationship with Attendance
     */
    public function followup()
    {
        return $this->hasOne(Followup::class, 'kid_id');
    }

    // =================================== Spatie ================================= //
    /**
     * Spatie media library register
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('kids')->singleFile();
    }
}
