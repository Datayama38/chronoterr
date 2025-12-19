<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('roles')->delete();
        Role::create([
            'slug' => 'admin',
            'name' => 'Administrateur',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ])->permissions()->sync([1,2,3,4]);
        Role::create([
            'slug' => 'contributor',
            'name' => 'Contributeur',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ])->permissions()->sync([4]); 
        Role::create([
            'slug' => 'editor',
            'name' => 'Éditeur',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ])->permissions()->sync([3,4]);        
        Model::reguard();
    }
}
