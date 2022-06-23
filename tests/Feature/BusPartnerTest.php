<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Permission;
use App\PermissionName;

class BusPartnerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /*
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }*/
    /*
    public function test_interacting_with_headers()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/user', ['name' => 'Sally']);
 
        $response->assertStatus(201);
    }
    */
    public function test_required_authentication_account_page(){
        //$user = User::factory()->create();
        $user = factory(User::class)->make();
 
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/en/account')->assertStatus(200);
    }
    public function test_required_authentication_not_have_partner_permission(){
        //$user = User::factory()->create();
        $user = factory(User::class)->make();
 
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/en/partner')->assertStatus(302);
    }



    public function test_has_partner_permission(){
        /*$user = factory(User::class)->make();
        $perm=factory(PermissionName::class)->make([
            'perm_name'=>'partner'
        ]);
        //$p_name=PermissionName::where('perm_name','partner')->get();
    
        $permission = factory(Permission::class)->make([
            'userid'=>$user->id,
            'permid'=>$perm->id,
            ]);
        */
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/en/partner')->assertStatus(200);
    }
    public function test_has_partner_bus_permission(){

    }
    public function test_not_has_partner_bus_permission(){

    }
}
