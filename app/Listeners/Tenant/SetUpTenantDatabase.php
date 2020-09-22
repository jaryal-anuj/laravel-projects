<?php

namespace App\Listeners\Tenant;

use App\Events\Tenant\TenantDatabaseCreated;
use App\Tenant\Models\Tenant;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;

class SetUpTenantDatabase
{

    public function handle(TenantDatabaseCreated $event)
    {
        if($this->migrate($event->tenant)){
            $this->seed($event->tenant);
        }

    }

    protected function migrate(Tenant $tenant){
        $migration = Artisan::call('tenants:migrate',[
            '--tenants'=>[$tenant->id]
        ]);

        return $migration ===0;
    }

    protected function seed(Tenant $tenant){
        return Artisan::call('tenants:seed',[
            '--tenants'=>[$tenant->id]
        ]);
    }
}
