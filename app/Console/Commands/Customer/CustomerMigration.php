<?php

namespace App\Console\Commands\Customer;

use Illuminate\Console\Command;
use App\Customer\ManagerCustomer;
use App\Models\Customer;
use Illuminate\Support\Facades\Artisan;

class CustomerMigration extends Command
{
    protected $signature = 'customer:migrations';

    protected $description = 'Run migrations customer';

    private $customer;

    public function __construct(ManagerCustomer $customer)
    {
        parent::__construct();

        $this->customer = $customer;
    }

    public function handle()
    {
        $customers = Customer::all();

        foreach ($customers as $customer) {
            $this->customer->setConnection($customer);

            $this->info("Connecting company {$customer->name}");

            Artisan::call('migrate', [
                '--force' => true,
                '--path' => '/database/migrations/customer'
            ]);

            $this->info("End connecting company {$customer->name}");
            $this->info("----------------------------------------");
        }
    }
}
