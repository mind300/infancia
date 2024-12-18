<?php

namespace App\Models;

class Nursery extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country_id',
        'city_id',
        'address',
        'about',
        'branches_number',
        'service_id',
        'user_id'
    ];

    // =================================== Relations ================================= //

    /**
     * The Comment
     */
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    /**
     * The Comment
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * The Comment
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}