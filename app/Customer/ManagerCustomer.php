<?php

namespace App\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ManagerCustomer
{
    public function setConnection(Customer $customer)
    {
        DB::purge('customer');

        config()->set('database.connections.customer.host', $customer->db_hostname);
        config()->set('database.connections.customer.database', $customer->db_database);
        config()->set('database.connections.customer.username', $customer->db_username);
        config()->set('database.connections.customer.password', $customer->db_password);

        DB::reconnect('customer');

        Schema::connection('customer')->getConnection()->reconnect();
    }
}
