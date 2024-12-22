<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class BaseModel extends Model
{
    // Uses
    use HasFactory, Notifiable;


    // =================================== Relations ================================= //
    /**
     * The Comment
     */

    // =================================== Scopes ================================= //
    /**
     * Scope a query to only include branches.
     */
    public function scopeBranch(Builder $query, $request): void
    {
        $query->orWhere([['branch_id', $request->branch_id], ['nursery_id', $request->nursery_id]]);
    }
}
