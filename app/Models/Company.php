<?php

namespace App\Models;

use App\Tenant\Models\Tenant;
use App\Tenant\Traits\IsTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model implements Tenant
{
    use HasFactory, IsTenant;

    protected $fillable = [
        'name',
        'uuid'
    ];


}
