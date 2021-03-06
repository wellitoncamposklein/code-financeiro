<?php

use Illuminate\Database\Seeder;
use CodeFin\Repositories\Interfaces\BillReceiveRepository;

class BillReceivesTableSeeder extends Seeder
{
    use \CodeFin\Repositories\Traits\GetClientsTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = $this->getClients();
        $repository = app(BillReceiveRepository::class);

        factory(\CodeFin\Models\BillReceive::class,200)
            ->make()
            ->each(function ($billReceive) use ($clients, $repository){
                $client = $clients->random();
                \Landlord::addTenant($client);
                $bankAccount = $client->bankAccounts->random();
                $category = $client->categoryExpenses->random();
                $billReceive->client_id = $client->id;
                $billReceive->bank_account_id = $bankAccount->id;
                $billReceive->category_id = $category->id;
                $data = $billReceive->toArray();

                $repository->create($data);
            });
    }
}
