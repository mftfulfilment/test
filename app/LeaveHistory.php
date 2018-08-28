<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveHistory extends Model
{
    protected $table = 'leave_history';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'snk_no','leave_no','leave_from','leave_till','reason','in_process','is_approve','is_read'
    ];
}
