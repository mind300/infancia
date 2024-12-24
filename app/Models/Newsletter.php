<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

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
    // =================================== Scopes ================================= //
    /**
     * Scope a query to only include class.
     */
    public function scopeClassPublicScope(Builder $query, $request): void
    {
        $query->orWhere([['class_room_id', $request->class_room_id], ['is_private', 0]]);
    }
}
