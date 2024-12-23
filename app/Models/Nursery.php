<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

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
        return $this->belongsTo(User::class);
    }

    /**
     * The Comment
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // =================================== Scopes ================================= //
    public function scopeStatus(Builder $query, $status): void
    {
        $query->whereAny('status', $status);
    }

    // =================================== Spatie ================================= //
    /**
     * Spatie media library register
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('nursery')->singleFile();
    }
}
