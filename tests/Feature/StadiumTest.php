<?php

namespace Tests\Feature;

use App\Models\Stadium;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StadiumTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index_displays_stadiums_with_pagination()
    {
        Stadium::factory()->count(10)->create();
        $user = User::first();
        $response = $this->actingAs($user)->getJson("api/stadium");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'current_page',
            'data',
            'links'
        ]);
    }

    public function test_store_creates_a_new_stadium()
    {
        Storage::fake('public');
        $user = User::find(2);

        $data = [
            'name' => 'New Stadium',
            'location' => 'Test City',
            'price' => 50000,
            "description" => "norm",
            "images" => [
                UploadedFile::fake()->image('stadium.jpg', 600, 600),
                UploadedFile::fake()->image('stadium1.jpg', 600, 600)
            ],
        ];


        Gate::define('create', Stadium::class);

        $response = $this->actingAs($user)->postJson("/api/stadium", $data);

        $response->assertStatus(201)->assertJson(['success' => true]);

        $this->assertDatabaseHas('stadium', ['name' => 'New Stadium']);
    }

    public function test_show_displays_a_stadium()
    {
        $stadium = Stadium::factory()->create(); // Create a single stadium
        $user = User::factory()->create(); // Create a single user

        $response = $this->actingAs($user)->getJson("api/stadium/" . $stadium->id);

        $response->assertStatus(200)
            ->assertJson([
                "name" => $stadium->name
            ]);
    }


    public function test_update_a_stadium()
    {
        $stadium = Stadium::factory()->create();
        $user = User::find(2);

        $data = ['name' => 'Updated Name'];

        Gate::define('update', Stadium::class);

        $response = $this->actingAs($user)->putJson("api/stadium/" . $stadium->id, $data);

        $response->assertStatus(200)->assertJson(['message' => 'success']);

        $this->assertDatabaseHas('stadium', ['name' => 'Updated Name']);
    }

    public function test_destroy_deletes_a_stadium()
    {
        $stadium = Stadium::factory()->create();
        $user = User::find(2);

        Gate::define('delete', fn() => true);

        $response = $this->actingAs($user)->deleteJson("api/stadium/" . $stadium->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('stadium', ['id' => $stadium->id]);
    }

    public function test_get_stadium_reviews()
    {
        return false;
    }
}
