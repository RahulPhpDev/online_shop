<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Tests\TestCase;
// vendor/bin/phpunit --filter show_banner_record BannerTest tests/Feature/BannerTest.php
class BannerTest extends TestCase
{
    use RefreshDatabase;
    // public function setUp():void
    // {
    //     parent::setUp();
    //     $this->withoutExceptionHandling();
    //     // dd( User::query()->whereEmail('admin+test2@admin.com')->first());
    //       Passport::actingAs(
    //          User::query()->whereEmail('admin+test2@admin.com')->first()
    //     );
    // }

    /**
    * @test
    */
//    public function required_field_for_add_banner()
//    {
//
//        $data = [
//         'title'  =>  'The title field is required.',
//          'slug' =>  'The slug field is required.',
//          'description' =>  'The description field is required.'
//        ];
//        $response = $this->postJson('api/admin/banner', [],    ['Accept' => 'application/json']);
//        $response->assertJsonValidationErrors($data);
//
//    }

    /**
    * @test
    */
    public function add_banner_record()
    {
        $bannerRecord = [
          'title' => 'Test',
            'description' => 'Test Description is here'
        ];
       $finalRecord =  array_merge( $bannerRecord, [
            'slug' => Str::slug(Str::limit($bannerRecord['title'], 20, '')),
           'src' => 'das'
        ]);
        $response =$this->json(
                'post',
                '/api/admin/banner',
                    $finalRecord,
                 ['Accept' => 'application/json']
                 );
        $response->assertStatus(201);
    }


    /**
    * @test
    */
    public function show_banner_record()
    {
        $response = $this->get('/api/admin/banner');
            $response->assertStatus(200);
    }
}
