<?php

namespace App\Models;

class Blog extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'main',
        'country',
        'city',
        'address',
        'manager_id',
        'nursery_id',
    ];
}
