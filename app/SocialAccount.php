<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class SocialAccount extends Model
{

    protected $fillable = ['provider_name','provider_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
