<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    protected $fillable = ['content', 'user_id','status'];

    public function task()
    {
        return $this->belongsTo(task::class);
    }
}
