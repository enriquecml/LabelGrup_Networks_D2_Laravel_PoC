<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_post(): void
    {
        $response = $this->postJson('/api/products', ['name' => 'Pera']);
        $response->assertStatus(201);
        $response = $this->postJson('/api/products', ['name' => 'Naranja']);
        $response->assertStatus(201);
    }

    public function test_get(): void
    {
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
                $json->has('images.0',fn (AssertableJson $json) =>
                    $json->where('file_name','tomate1.jpg')->etc()
                )
                ->has('images.1',fn (AssertableJson $json) =>
                    $json->where('file_name','tomate2.jpg')->etc()
                )
                ->etc()
            )->etc()

        );


    }
}
