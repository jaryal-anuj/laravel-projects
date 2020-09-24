<?php

namespace App\Listeners\Tenant;

use App\Tenant\Models\Tenant;
use Illuminate\Filesystem\Filesystem;
use App\Events\Tenant\TenantIdentified;
use Illuminate\Contracts\Filesystem\Factory;

class UseTenantFilesystem
{
    protected $filesystem;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Factory $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Handle the event.
     *
     * @param  TenantIdentified  $event
     * @return void
     */
    public function handle(TenantIdentified $event)
    {
        //dd($this->getFilesystemConfig($event->tenant));
        $this->filesystem->set(
            'tenant', $this->createDriver($this->getFilesystemConfig($event->tenant))
        );
    }

    protected function createDriver($config)
    {
        $method = $this->getCreationMethod();

        return $this->filesystem->{$method}($config);
    }

    protected function getFilesystemConfig(Tenant $tenant)
    {
        $config = config('filesystems.disks.' . config('filesystems.default'));

        $config['root'] = $tenant->uuid;

        return $config;
    }

    protected function getCreationMethod()
    {
        return "create" . ucfirst(config('filesystems.default')) . "Driver";
    }
}
