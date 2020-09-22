<?php

namespace App\Models;

use App\Tenant\Models\Tenant;
use App\Tenant\Traits\ForSystem;
use App\Tenant\Traits\IsTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model implements Tenant
{
    use HasFactory, IsTenant,ForSystem;

    protected $fillable = [
        'name',
        'uuid'
    ];


}
