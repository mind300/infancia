<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Meal extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'meal',
        'type',
        'branch_id',
        'nursery_id',
    ];
}
