<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\group;
use App\Models\Tag;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $admin = User::create([
        'name'=>'admin',
        'email'=>'admin@hotmail.com',
        'password'=>bcrypt('12345678')
       ]);

       Role::create([
           'name'=>'admin'
       ]);
       Role::create([
           'name'=>'edit-reports'
       ]);
       Role::create([
           'name'=>'create-reports'
       ]);
       Role::create([
           'name'=>'view-reports'
       ]);
       Role::create([
           'name'=>'delete-reports'
       ]);
    
       $adminRole = Role::where('name', 'admin')->pluck('id');

       $admin->roles()->attach($adminRole);

       Group::create([
        'name'=>'KSA'
       ]);
       Group::create([
        'name'=>'US'
       ]);
       Group::create([
        'name'=>'UAE'
       ]);

       Tag::create([
        'name'=>'technology'
       ]);
       Tag::create([
        'name'=>'sports'
       ]);
       Tag::create([
        'name'=>'medical'
       ]);
    }
}
