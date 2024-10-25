<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;

    public function countries(){
        return $this->belongsTo(country::class , 'country_id');
    }


    public function users(){
        return $this->belongsTo(User::class , 'user_id');
    }


}
