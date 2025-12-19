<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('permissions')->delete();
        Permission::create([
            'slug' => 'manage_backend',
            'name' => 'Gestion du backend',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        Permission::create([
            'slug' => 'manage_users',
            'name' => 'Gestion des utilisateurs',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        
        Permission::create([
            'slug' => 'manage_all_events',
            'name' => 'Gestion de tous les événements',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        Permission::create([
            'slug' => 'manage_my_events',
            'name' => 'Gestion de mes événements',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        
        Model::reguard();
    }
}
