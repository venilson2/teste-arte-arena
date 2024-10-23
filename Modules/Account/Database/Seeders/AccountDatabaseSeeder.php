<?php

namespace Modules\Account\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Account\App\Models\Account;

class AccountDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::create([
            'title' => 'Conta de Luz',
            'description' => 'Pagamento da conta de luz referente ao mês de outubro.',
            'value' => 150.00,
            'due_date' => '2024-10-30',
            'status' => 'pending',
            'user_id' => 2, 
        ]);

        Account::create([
            'title' => 'Conta de Agua',
            'description' => 'Pagamento da conta de água referente ao mês de outubro.',
            'value' => 30.88,
            'due_date' => '2024-10-30',
            'status' => 'paid',
            'user_id' => 3, 
        ]);
    }
}
