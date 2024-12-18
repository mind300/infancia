<?php

namespace App\Models;

class ClassRoom extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'from',
        'to',
        'has_meals',
        'has_subjects',
        'branch_id',
        'nursery_id'
    ];

    // =================================== Relations ================================= //

    /**
     * The Comment
     */
    public function nurseries()
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
    public function kids()
    {
        return $this->hasMany(Kid::class);
    }
}
