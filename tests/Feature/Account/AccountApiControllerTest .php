<?php

namespace Tests\Feature;

use App\Models\User;
use Modules\Account\App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AccountApiControllerTest extends TestCase
{
  use RefreshDatabase;

  public function admin_can_access_all_accounts()
  {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $account1 = Account::factory()->create(['user_id' => 1]); // Conta de um usuário regular
    $account2 = Account::factory()->create(['user_id' => 2]); // Conta de outro usuário regular

    $this->actingAs($admin, 'api');

    $response = $this->getJson(route('api.accounts.index'));

    $response->assertStatus(200)
      ->assertJsonCount(2);
  }

  public function regular_user_can_access_own_accounts_only()
  {
    $user = User::factory()->create();
    $user->assignRole('user');

    $account1 = Account::factory()->create(['user_id' => $user->id]);
    $account2 = Account::factory()->create(['user_id' => 2]);

    $this->actingAs($user, 'api');

    $response = $this->getJson(route('api.accounts.index'));

    $response->assertStatus(200)
      ->assertJsonCount(1)
      ->assertJsonFragment(['id' => $account1->id]); 
  }
}
