<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

# php artisan test --filter=AccountApiControllerTest
class AccountApiControllerTest extends TestCase
{
    
    protected User $adminUser;
    protected User $regularUser1;
    protected User $regularUser2;

    protected function setUp(): void
    {
        parent::setUp();
    
        $this->adminUser = User::role('admin')->first();
        $this->regularUser1 = User::role('user')->first();
        $this->regularUser2 = User::role('user')->skip(1)->first();
    }


    # php artisan test --filter=AccountApiControllerTest::test_admin_can_access_all_accounts
    public function test_admin_can_access_all_accounts()
    {
        $response = $this->actingAs($this->adminUser, 'api')->getJson(route('api.accounts.index'));
        $response->assertStatus(200)
            ->assertJsonCount(2);
    }

    # php artisan test --filter=AccountApiControllerTest::test_regular_user_can_access_own_accounts_only
    public function test_regular_user_can_access_own_accounts_only()
    {
        $response = $this->actingAs($this->regularUser1, 'api')->getJson(route('api.accounts.index'));
        $response->assertStatus(200)
            ->assertJsonCount(1);
    }
}
