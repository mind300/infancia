<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'content',
        'is_private',
        'nursery_id',
        'branch_id',
    ];
}
