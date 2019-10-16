<?php

namespace App\Console\Commands\Customer;

use Illuminate\Console\Command;
use App\Customer\ManagerCustomer;
use App\Models\Customer;
use Illuminate\Support\Facades\Artisan;

class CustomerMigration extends Command
{
    protected $signature = 'customer:migrations {id?} {--refresh}';

    protected $description = 'Run migrations customer';

    private $customer;

    public function __construct(ManagerCustomer $customer)
    {
        parent::__construct();

        $this->customer = $customer;
    }

    public function handle()
    {

        if ($id = $this->argument('id')) {

            $customer = Customer::find($id);

            if ($customer) {
                $this->execCommand($customer);
            }

            return;
        }

        $customers = Customer::all();

        foreach ($customers as $customer) {
            $this->execCommand($customer);
        }
    }

    public function execCommand(Customer $customer)
    {
        $command = $this->option('refresh') ? 'migrate:refresh' : 'migrate';

        $this->customer->setConnection($customer);

        $this->info("Connecting company {$customer->name}");

        Artisan::call($command, [
            '--force' => true,
            '--path' => '/database/migrations/customer'
        ]);

        $this->info("End connecting company {$customer->name}");
        $this->info("----------------------------------------");
    }
}
