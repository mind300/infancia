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
        'class_room_id',
        'branch_id',
        'nursery_id',
    ];
}
