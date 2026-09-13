<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedSchool extends Model
{
    protected $fillable = ['user_id', 'school_id'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}