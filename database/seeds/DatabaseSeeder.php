<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
			'password' => bcrypt('123456'),
        ]);

        DB::table('roles')->delete();
        DB::table('role_user')->delete();

        Role::create([
            'name' => 'Administrador',
            'slug' => 'admin',
            'level' => 1,
            'description' => 'Administrador',
        ]);

        $role = Role::where('slug', '=', 'admin')->first();
        $user = User::where('email', '=', 'admin@admin.com')->first();
        $user->attachRole($role);
		
		$modelArray = array('users', 'roles', 'permissions');
		$typeArray = array('index', 'create', 'store', 'show', 'edit', 'update', 'destroy');
		
		$role = Role::where('slug', '=', 'admin')->first();
		foreach ($modelArray as $models => $model) {
			foreach ($typeArray as $types => $type) {
				$permission = Permission::create([
					'name' => ucwords($type) .' '. $model,
					'slug' => $type .'.'. $model,
					'description' => '',
					'model' => ucwords(substr($model, 0, -1)),
				]);
				
				$role->attachPermission($permission);
			}
		}
    }
}
