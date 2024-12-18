<?php

namespace App\Models;

class Country extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    // =================================== Relations ================================= //

    /**
     * The Comment
     */
    public function nurseries()
    {
        return $this->belongsToMany(Nursery::class);
    }
    /**
     * The Comment
     */
    public function branch()
    {
        return $this->belongsToMany(Branch::class);
    }
}
