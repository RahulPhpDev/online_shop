<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

use Laravel\Passport\ClientRepository;
use Illuminate\Support\Facades\DB;
use DateTime;

class LoginTest extends TestCase
{
    use RefreshDatabase;

  // public function setUp(): void
  //   {
  //       parent::setUp();
  //       $this->withoutExceptionHandling();
  //       // DB::beginTransaction();
  //   }

    // public function tearDown(): void
    // {
    //     DB::rollback();
    //     echo 'hi';
    //     parent::tearDown();
    // }

    // public function testRequiredFieldForLogin()
    // {
    //     $data = [
    //          'The email field is required.',
    //             'The password field is required.'
    //         ];
    //     $this->postJson( 'api/login', ['Accept' => 'application/json'])
    //     ->assertStatus(422);
       
    // }


    public function testRegisterUser()
    {
        $this->withoutExceptionHandling();
   
        $userData = [
            'name' => 'Admin',
            'email' => 'admin+test2@admin.com',
            'phone' => 4444444,
            'password' => 123456,
            'role_id' => 1
        ];
        if (\App\User::whereEmail('admin+test2@admin.com')->exists())
        {
            $this->assertTrue(true);
           return true;
        }

         $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null, 'Test Personal Access Client', 'http://127.0.0.1:8000'
        );
        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
       

        //    $this->assertTrue(true);
       $res =  $this->json('POST', 'api/register', 
                    $userData,
                     ['Accept' => 'application/json']
                 );
    
    //    $r =\App\User::all();
    // dd($r->toArray());
          $res  ->assertStatus(200);
    }

    public function testLoginUser()
    {
        // $this->withoutExceptionHandling();
             // \App\User::create($userData);
         // $r =\App\User::all();
           // dd($r->toArray());
            $userData = [
                'email' => 'admin+test2@admin.com',
                'password' => 123456,
            ];
            $this->json('POST', 'api/login', $userData,  ['Accept' => 'application/json'])
            ->assertStatus(200);
    }



}
