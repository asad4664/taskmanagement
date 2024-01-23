<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

// Models
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userData = [
            'name' => 'Laraib Hassan',
            'employee_id' => '547-2017-6522',
            'email' => 'laraib.hassan@psca.gop.pk',
            'password' => \Hash::make('Hello123$'),
            'designation' => 'PCO',
        ];

        // Insert the user into the database
        $user = User::create($userData);

        // Give permission to the user
        $user->givePermissionTo('create_users');
        $user->givePermissionTo('edit_users');
        $user->givePermissionTo('delete_users');
        $user->givePermissionTo('create_project');
        $user->givePermissionTo('edit_project');
        $user->givePermissionTo('delete_project');
        $user->givePermissionTo('view_project');
        $user->givePermissionTo('create_task');
        $user->givePermissionTo('edit_task');
        $user->givePermissionTo('delete_task');
        $user->givePermissionTo('view_task');
        $user->givePermissionTo('create_subtask');
        $user->givePermissionTo('edit_subtask');
        $user->givePermissionTo('view_subtask');
        $user->givePermissionTo('create_activity');
        $user->givePermissionTo('edit_activity');
        $user->givePermissionTo('delete_activity');
        $user->givePermissionTo('view_activity');
        $user->givePermissionTo('view_alldashboardstats');
        $user->givePermissionTo('view_userdashboard');
        $user->givePermissionTo('view_alltasks');
        $user->givePermissionTo('view_allactivities');
        $user->givePermissionTo('manage_permission');
        $user->givePermissionTo('view_users');

        $userData = [
            'name' => 'Ahsan Younas',
            'employee_id' => '547-2023-0001',
            'email' => 'ahsan.younas@psca.gop.pk',
            'password' => \Hash::make('123456'),
            'designation' => 'MD',
        ];

        // Insert the user into the database
        $user = User::create($userData);

        // Give permission to the user
        $user->givePermissionTo('create_users');
        $user->givePermissionTo('edit_users');
        $user->givePermissionTo('delete_users');
        $user->givePermissionTo('create_project');
        $user->givePermissionTo('edit_project');
        $user->givePermissionTo('delete_project');
        $user->givePermissionTo('view_project');
        $user->givePermissionTo('create_task');
        $user->givePermissionTo('edit_task');
        $user->givePermissionTo('delete_task');
        $user->givePermissionTo('view_task');
        $user->givePermissionTo('create_subtask');
        $user->givePermissionTo('edit_subtask');
        $user->givePermissionTo('view_subtask');
        $user->givePermissionTo('create_activity');
        $user->givePermissionTo('edit_activity');
        $user->givePermissionTo('delete_activity');
        $user->givePermissionTo('view_activity');
        $user->givePermissionTo('view_alldashboardstats');
        $user->givePermissionTo('view_userdashboard');
        $user->givePermissionTo('view_alltasks');
        $user->givePermissionTo('view_allactivities');
        $user->givePermissionTo('manage_permission');
        $user->givePermissionTo('view_users');

        $userData = [
            'name' => 'Asif',
            'employee_id' => '547-2018-6532',
            'email' => 'asif.ayub@psca.gop.pk',
            'password' => \Hash::make('123456'),
            'designation' => 'PTO',
        ];
        $user = User::create($userData);

        $userData = [
            'name' => 'Adeel',
            'employee_id' => '547-2023-5226',
            'email' => 'adeel.mehmood@psca.gop.pk',
            'password' => \Hash::make('123456'),
            'designation' => 'DEO',
        ];
        $user = User::create($userData);

        $userData = [
            'name' => 'Safeer',
            'employee_id' => '547-2023-5293',
            'email' => 'safeer.abbas@psca.gop.pk',
            'password' => \Hash::make('123456'),
            'designation' => 'DEO',
        ];
        $user = User::create($userData);
         // Give permission to the user
         $user->givePermissionTo('create_users');
         $user->givePermissionTo('edit_users');
         $user->givePermissionTo('create_project');
         $user->givePermissionTo('edit_project');
         $user->givePermissionTo('delete_project');
         $user->givePermissionTo('view_project');
         $user->givePermissionTo('create_task');
         $user->givePermissionTo('edit_task');
         $user->givePermissionTo('delete_task');
         $user->givePermissionTo('view_task');
         $user->givePermissionTo('create_subtask');
         $user->givePermissionTo('edit_subtask');
         $user->givePermissionTo('view_subtask');
         $user->givePermissionTo('create_activity');
         $user->givePermissionTo('edit_activity');
         $user->givePermissionTo('delete_activity');
         $user->givePermissionTo('view_activity');
         $user->givePermissionTo('view_alldashboardstats');
         $user->givePermissionTo('view_userdashboard');
         $user->givePermissionTo('view_alltasks');
         $user->givePermissionTo('view_allactivities');
         $user->givePermissionTo('view_users');

        $userData = [
            'name' => 'Riffat Bokhari',
            'employee_id' => '547-2023-0002',
            'email' => 'riffat.bokhari@psca.gop.pk',
            'password' => \Hash::make('123456'),
            'designation' => 'SSP',
        ];
        $user = User::create($userData);
        // Give permission to the user
        $user->givePermissionTo('create_users');
        $user->givePermissionTo('edit_users');
        $user->givePermissionTo('create_project');
        $user->givePermissionTo('edit_project');
        $user->givePermissionTo('delete_project');
        $user->givePermissionTo('view_project');
        $user->givePermissionTo('create_task');
        $user->givePermissionTo('edit_task');
        $user->givePermissionTo('delete_task');
        $user->givePermissionTo('view_task');
        $user->givePermissionTo('create_subtask');
        $user->givePermissionTo('edit_subtask');
        $user->givePermissionTo('view_subtask');
        $user->givePermissionTo('create_activity');
        $user->givePermissionTo('edit_activity');
        $user->givePermissionTo('delete_activity');
        $user->givePermissionTo('view_activity');
        $user->givePermissionTo('view_alldashboardstats');
        $user->givePermissionTo('view_userdashboard');
        $user->givePermissionTo('view_alltasks');
        $user->givePermissionTo('view_allactivities');
        $user->givePermissionTo('view_users');



    }
}
