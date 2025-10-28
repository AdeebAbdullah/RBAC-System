<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        //create role
        $adminRole = Role::create(['name'=> 'ADMIN']);
        $editorRole = Role::create(['name' => 'EDITOR']);
        $viewerRole = Role::create(['name' => 'VIEWER']);

        //permissions
        $create = Permission::create(['name' => 'create:article']);
        $delete = Permission::create(['name' => 'delete:article']);
        $read = Permission::create(['name'=> 'read:article']);

        //assign
        $adminRole->permissions()->attach([$create->id, $delete->id, $read->id]);
        $editorRole->permissions()->attach([$create->id, $read->id, $delete->id]);
        $viewerRole->permissions()->attach([$read->id]);

        //users
        $admin = User::create([
            'username' => 'admin',
            'role_id' => $adminRole->id,
        ]);

        $editor = User::create([
            'username' => 'ed',
            'role_id' => $editorRole->id,
        ]);

        $viewer = User::create([
            'username' => 'vi',
            'role_id' => $viewerRole->id,
        ]);

        //articles with its author
        Article::create([
            'title' => 'Admin Article',
            'body' => 'This is an article by admin.',
            'author_id' => $admin->id,
        ]);

        Article::create([
            'title' => 'Editor Article',
            'body' => 'This is an article by editor.',
            'author_id' => $editor->id,
        ]);

    }
}
