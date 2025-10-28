<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticlePermissionTest extends TestCase
{
    //reset db before test
    use RefreshDatabase;

    //seed db before test
    protected function setUp(): void
{
    parent::setUp();
    $this->seed(\Database\Seeders\DatabaseSeeder::class);
}

    //for required test

    //VIEWER CANNOT POST - 403
    public function test_viewer_cannot_post(){
        $response = $this->withHeaders([
            'Authorization' => 'User vi'
        ])->postJson('/api/articles',[
            'title'=> 'Viewer Try to post',
            'body'=> 'Cannot create article'
        ]);

        $response->assertStatus(403);
    }

    //EDITOR CAN POST - 201
    public function test_editor_can_post(){
        $response = $this->withHeaders([
            'Authorization' => 'User ed'
        ])->postJson('/api/articles', [
            'title' => 'Editor create article',
            'body' => 'This should success'
        ]);

        $response->assertStatus(201);
    }

    //ADMIN CAN DELETE - 204
    public function test_admin_can_delete(){

        //create data
        $create = $this->withHeaders([
            'Authorization' => 'User admin'
        ])->postJson('/api/articles', [
            'title' => 'Article to delete',
            'body' => 'testing deletion'
        ]);
        $id = $create->json('id') ?? 1;

        //delete data
        $delete = $this->withHeaders([
            'Authorization' => 'User admin'
        ])->deleteJson("/api/articles/{$id}");

        $delete->assertStatus(204);
    }

    //DELETE NON-EXIST ARTICLE - 404
    public function test_delete_nonexist_article(){

        $response = $this -> withHeaders([
            'Authorization' => 'User admin'
        ])->deleteJson('api/articles/999');

        $response->assertStatus(404);
    }

}
