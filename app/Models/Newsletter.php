<?php

namespace App\Models;

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
        'class_room_id'
    ];
}
