<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientManagement extends Model
{
    use HasFactory;
    public function getCreatedAtAttribute($value)
    {
        return $value != null ? Carbon::parse($value)->format('m/d/Y h:i:s A') : '';
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value != null ? Carbon::parse($value)->format('m/d/Y h:i:s A') : '';
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    public function status()
    {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }
}
