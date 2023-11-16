<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    public static $FACEBOOK = 1;
    public static $TWITTER  = 2;

    public function userAccounts()
    {
        return $this->hasMany(UserAccount::class);
    }
}
