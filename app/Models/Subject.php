<?php

namespace App\Models;

class Subject extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'nursery_id',
        'branch_id',
    ];

    // =================================== Relations ================================= //
    /**
     * The Comment
     */
    public function nurseries()
    {
        return $this->belongsTo(Nursery::class);
    }

    /**
     * The Comment
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * The Comment
     */
    public function followUps()
    {
        return $this->belongsToMany(FollowUp::class, 'followup_subject', 'subject_id', 'followup_id')
            ->withTimestamps();
    }
}
