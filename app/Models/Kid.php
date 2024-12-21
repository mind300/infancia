<?php

namespace App\Models;

use phpDocumentor\Reflection\Types\Parent_;

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
        'classroom_id',
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
}
