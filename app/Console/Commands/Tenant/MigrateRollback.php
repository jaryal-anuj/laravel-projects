<?php

namespace App\Console\Commands\Tenant;


use App\Tenant\Database\DatabaseManager;
use Illuminate\Contracts\Events\Dispatcher;
use App\Tenant\Traits\Console\FetchesTenant;
use Illuminate\Database\Migrations\Migrator;
use App\Tenant\Traits\Console\AcceptsMultipleTenant;
use Illuminate\Database\Console\Migrations\RollbackCommand;


class MigrateRollback extends RollbackCommand
{


    use FetchesTenant,AcceptsMultipleTenant;

    protected $description = 'Rollback migrations for tenants';
    protected $db;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Migrator $migrator,DatabaseManager $db)
    {
        parent::__construct($migrator);
        $this->setName('tenants:rollback');
        $this->specifyParameters();
        $this->db = $db;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(!$this->confirmToProceed()){
            return;
        }

        $this->input->setOption('database','tenant');

        $this->tenants($this->option('tenants'))->each(function($tenant){


            $this->db->createConnection($tenant);


            $this->db->connectToTenant();
            parent::handle();
            $this->db->purge();
        });

    }



    protected function getMigrationPaths()
    {

        return [database_path('migrations/tenant')];
    }
}
