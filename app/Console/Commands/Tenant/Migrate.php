<?php

namespace App\Console\Commands\Tenant;


use App\Tenant\Database\DatabaseManager;
use App\Tenant\Traits\Console\AcceptsMultipleTenant;
use App\Tenant\Traits\Console\FetchesTenant;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Database\Console\Migrations\MigrateCommand;


class Migrate extends MigrateCommand
{


    use FetchesTenant,AcceptsMultipleTenant;

    protected $description = 'Run migrations for tenants';
    protected $db;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Migrator $migrator,Dispatcher $dispatcher,DatabaseManager $db)
    {
        parent::__construct($migrator,$dispatcher);
        $this->setName('tenants:migrate');
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
