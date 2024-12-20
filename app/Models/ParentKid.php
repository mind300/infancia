<?php

namespace App\Models;

class ParentKid extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'job',
        'emergency_phone',
        'nursery_id',
        'branch_id',
        'user_id'
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
        return $this->hasMany(Kid::class, 'parent_id');
    }
}
