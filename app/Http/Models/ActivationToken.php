<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ActivationToken extends Model
{
    //

    protected  $table = "activation_tokens";
    protected $fillable = ["token","customerID"];



    public function getRouteKeyName()
    {
        return "token";
    }
}
