<?php

namespace App\Console\Commands\Tenant;


use App\Tenant\Database\DatabaseManager;
use App\Tenant\Traits\Console\FetchesTenant;
use Illuminate\Database\Console\Seeds\SeedCommand;
use App\Tenant\Traits\Console\AcceptsMultipleTenant;
use Illuminate\Database\ConnectionResolverInterface as Resolver;



class Seed extends SeedCommand
{


    use FetchesTenant,AcceptsMultipleTenant;

    protected $description = 'Run seedfor tenants';
    protected $db;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Resolver $resolver,DatabaseManager $db)
    {
        parent::__construct($resolver);
        $this->setName('tenants:seed');
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

}
