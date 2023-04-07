<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_post(): void
    {
        Sanctum::actingAs(
            User::find(1)
        );

        $response = $this->postJson('/api/products', ['name' => 'Pera']);
        $response->assertStatus(201);
        $response = $this->postJson('/api/products', ['name' => 'Naranja']);
        $response->assertStatus(201);
    }

        /**
     * A basic feature test example.
     */
    public function test_post_with_categories(): void
    {
        Sanctum::actingAs(
            User::find(1)
        );

        $response = $this->postJson('/api/products', [
            'name' => 'Lima',
            'categories'=>[
                [
                    'category_id'=>1,
                    'main'=>true
                ],
                [
                    'category_id'=>3,
                    'main'=>false
                ],
            ]
        ]);
        $response->assertStatus(201);

    }

    public function test_get(): void
    {
        Sanctum::actingAs(
            User::find(1)
        );
        $response = $this->getJson('/api/products');
        $response->assertJson(fn(AssertableJson $json)=>$json->has('data')->etc());
        $response->assertJson(
            fn(AssertableJson $json)=>
            $json->has('data.0',fn (AssertableJson $json) =>
            $json->where('name','Pera')->etc())->etc()
        );
    }

    public function test_post_with_images(): void
    {
        Sanctum::actingAs(
            User::find(1)
        );
        $response = $this->postJson('/api/products', [
            'name' => 'Tomate',
            'images'=> [
                UploadedFile::fake()->image('tomate1.jpg')->size(100),
                UploadedFile::fake()->image('tomate2.jpg')->size(200)
            ],
        ]);

        $response = $this->getJson('/api/products?filter[name]=Tomate&include=media');
        $response->assertJson(fn(AssertableJson $json)=>$json->has('data')->etc());
        $response->assertJson(fn(AssertableJson $json)=>
            $json->has('data.0',fn (AssertableJson $json) =>
                $json->has('media.0',fn (AssertableJson $json) =>
                    $json->where('file_name','tomate1.jpg')->etc()
                )
                ->has('media.1',fn (AssertableJson $json) =>
                    $json->where('file_name','tomate2.jpg')->etc()
                )
                ->etc()
            )->etc()

        );


    }

    public function test_get_one(): void
    {
        Sanctum::actingAs(
            User::find(1)
        );
        $response = $this->getJson('/api/products/1?fields[products]=id,name');

        $response->assertJson(fn(AssertableJson $json)=>
            $json->has('data',fn (AssertableJson $json) =>
                $json->where('id',1)->has('name')
            )
        );
    }

    public function test_update(): void
    {
        Sanctum::actingAs(
            User::find(1)
        );
        $response = $this->putJson('/api/products/1', [
            'name' => 'Kiwi',
            'images'=> [
                UploadedFile::fake()->image('kiwi1.jpg')->size(300),
            ],
            'categories'=>[
                [
                    'category_id'=>3,
                    'main'=>true
                ],
            ]
        ]);

        $response = $this->getJson('/api/products?filter[name]=Kiwi&include=media');
        $response->assertJson(fn(AssertableJson $json)=>$json->has('data')->etc());
        $response->assertJson(fn(AssertableJson $json)=>
            $json->has('data.0',fn (AssertableJson $json) =>
                $json->has('media.0',fn (AssertableJson $json) =>
                    $json->where('file_name','kiwi1.jpg')->etc()
                )
                ->etc()
            )->etc()

        );
    }

    public function test_delete(): void
    {
        Sanctum::actingAs(
            User::find(1)
        );
        $response = $this->deleteJson('/api/products/1', [
        ]);

        $response->assertStatus(200);
    }

}
