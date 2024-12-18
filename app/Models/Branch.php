<?php

namespace App\Models;

class Branch extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'country_id',
        'city_id',
        'address',
        'manager_id',
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
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * The Comment
     */
    public function classes()
    {
        return $this->hasMany(Nursery::class);
    }
}
