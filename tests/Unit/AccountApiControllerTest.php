<?php

namespace Tests\Feature;

use App\Models\User;
use Modules\Account\App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AccountApiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $regularUser1;
    protected User $regularUser2;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'admin', 'guard_name' => 'api']);
        Role::create(['name' => 'user', 'guard_name' => 'api']);

        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $this->admin->assignRole('admin');

        $this->regularUser1 = User::create([
            'name' => 'Regular User 1',
            'email' => 'user1@example.com',
            'password' => bcrypt('password'),
        ]);
        $this->regularUser1->assignRole('user');

        $this->regularUser2 = User::create([
            'name' => 'Regular User 2',
            'email' => 'user2@example.com',
            'password' => bcrypt('password'),
        ]);
        $this->regularUser2->assignRole('user');

        Account::create([
            'title' => 'Conta de Luz',
            'description' => 'Pagamento da conta de luz referente ao mês de outubro.',
            'value' => 150.00,
            'due_date' => '2024-10-30',
            'status' => 'pending',
            'user_id' => $this->regularUser1->id,
        ]);

        Account::create([
            'title' => 'Conta de Água',
            'description' => 'Pagamento da conta de água referente ao mês de outubro.',
            'value' => 30.88,
            'due_date' => '2024-10-30',
            'status' => 'paid',
            'user_id' => $this->regularUser2->id,
        ]);
    }

    public function admin_can_access_all_accounts()
    {
        $response = $this->actingAs($this->admin, 'api')->getJson(route('api.accounts.index'));
        $response->assertStatus(200)
            ->assertJsonCount(2);
    }

    public function regular_user_can_access_own_accounts_only()
    {
        $response = $this->actingAs($this->admin, 'api')->getJson(route('api.accounts.index'));
        $response->assertStatus(200)
            ->assertJsonCount(1);
    }
}
