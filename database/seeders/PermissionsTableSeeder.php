<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'session.view'],
            ['name' => 'session.create'],
            ['name' => 'session.update'],
            ['name' => 'session.delete'],

            ['name' => 'campus.view'],
            ['name' => 'campus.create'],
            ['name' => 'campus.update'],
            ['name' => 'campus.delete'],

            ['name' => 'discount.view'],
            ['name' => 'discount.create'],
            ['name' => 'discount.update'],
            ['name' => 'discount.delete'],
         
            

        ];

        // $insert_data = [];
        // $time_stamp = \Carbon::now()->toDateTimeString();
        // foreach ($data as $d) {
        //     $d['guard_name'] = 'web';
        //     $d['created_at'] = $time_stamp;
        //     $insert_data[] = $d;
        // }
        // Permission::insert($insert_data);

           //create Admin role and assign to user
        //    $user_id=1;
        //    $business_id=1;
        //    $user = User::find($user_id);
        //    $role = Role::create([ 'name' => 'Admin#' . $business_id,
        //    'system_settings_id' => 1,
        //    'guard_name' => 'web', 'is_default' => 1
        //      ]);
        // $user->assignRole($role->name);
    }
}
