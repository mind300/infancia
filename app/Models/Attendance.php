<?php

namespace App\Models;

class Attendance extends BaseModel
{
    protected $fillable = [
        'kid_id',
        'class_room_id',  // Assuming this is the class the kid attended
    ];

    // =================================== Relations ================================= //

    /**
     * Inverse of the one-to-many relationship with Kid
     */
    public function kid()
    {
        return $this->belongsTo(Kid::class, 'kid_id');
    }
    /**
     * Inverse of the one-to-many relationship with ClassRoom
     */
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_room_id');
    }
}
