<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BaseModel extends Model implements HasMedia
{
    // Uses
    use HasFactory, Notifiable, InteractsWithMedia;


    // =================================== Relations ================================= //
    /**
     * The Comment
     */

    // =================================== Scopes ================================= //
    /**
     * Scope a query to only include branches.
     */
    public function scopeBranchScope(Builder $query, $request): void
    {
        $query->orWhere([['branch_id', $request->branch_id], ['nursery_id', $request->nursery_id]]);
    }
}
