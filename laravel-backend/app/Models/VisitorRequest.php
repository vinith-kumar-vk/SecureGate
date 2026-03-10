<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorRequest extends Model
{
    protected $fillable = [
        'id', 'name', 'phone', 'flat', 'purpose', 'status', 'reason', 'timestamp', 'createdAt'
    ];

    public $incrementing = false;
    protected $keyType = 'string';
}
