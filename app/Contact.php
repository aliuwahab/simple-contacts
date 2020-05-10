<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    protected $dates = ['birth_date'];


    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = Carbon::parse($value);
    }

}
