<?php

namespace App\Events\Tenant;

use App\Tenant\Models\Tenant;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TenantWasCreated
{
    use Dispatchable, SerializesModels;

    public $tenant;


    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

}
