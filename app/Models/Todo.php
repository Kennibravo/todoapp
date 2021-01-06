<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    const TODO_STATUS = [
        'completed',
        'pending',
    ];

    public function markTodoAsCompleteOrPending()
    {
        $status = $this->status == 'completed' ? 'pending' : 'completed';

        $this->update(['status' => $status]);

        return $status;
    }

    public function user()
    {
        return $this->belongsTo('App\User')->withDefault();
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }
}
