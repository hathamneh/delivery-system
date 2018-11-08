<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = $this->createRoles();

        $templates = $this->createTemplates($roles);

        $this->rootUser($templates['admin']);

    }

    public function createRoles()
    {
        return [
            'shipments' => \App\Role::create(['name' => 'shipments', 'default' => 1])->id,
            'clients'   => \App\Role::create(['name' => 'clients', 'default' => 1])->id,
            'couriers'  => \App\Role::create(['name' => 'couriers', 'default' => 0])->id,
            'pickups'   => \App\Role::create(['name' => 'pickups', 'default' => 0])->id,
            'notes'     => \App\Role::create(['name' => 'notes', 'default' => 3])->id,
            'zones'     => \App\Role::create(['name' => 'zones', 'default' => 0])->id,
            'services'  => \App\Role::create(['name' => 'services', 'default' => 0])->id,
            'users'     => \App\Role::create(['name' => 'users', 'default' => 0])->id,
            'roles'     => \App\Role::create(['name' => 'roles', 'default' => 0])->id,
            'mailing'   => \App\Role::create(['name' => 'mailing', 'default' => 1])->id,
            'settings'  => \App\Role::create(['name' => 'settings', 'default' => 3])->id,
            'logs'      => \App\Role::create(['name' => 'logs', 'default' => 2])->id,
            'forms'     => \App\Role::create(['name' => 'forms', 'default' => 1])->id,
        ];
    }

    public function createTemplates($roles)
    {
        $out = [];
        $out['admin'] = \App\UserTemplate::create([
            'name'        => "admin",
            'description' => "Administrator",
            'default'     => false,
            'editable'    => false,
            'deletable'   => false,
        ]);
        $out['admin']->roles()->attach([
            $roles['shipments'] => ['value' => 4],
            $roles['clients']   => ['value' => 4],
            $roles['couriers']  => ['value' => 4],
            $roles['pickups']   => ['value' => 4],
            $roles['notes']     => ['value' => 4],
            $roles['zones']     => ['value' => 4],
            $roles['services']  => ['value' => 4],
            $roles['users']     => ['value' => 4],
            $roles['roles']     => ['value' => 4],
            $roles['mailing']   => ['value' => 4],
            $roles['settings']  => ['value' => 4],
            $roles['logs']      => ['value' => 4],
            $roles['forms']      => ['value' => 4],
        ]);
        $out['employee'] = \App\UserTemplate::create([
            'name'        => "employee",
            'description' => "Employee",
            'default'     => true,
            'editable'    => true,
            'deletable'   => false,
        ]);
        $out['client'] = \App\UserTemplate::create([
            'name'        => "client",
            'description' => "Client",
            'default'     => false,
            'editable'    => true,
            'deletable'   => false,
        ]);
        $out['courier'] = \App\UserTemplate::create([
            'name'        => "courier",
            'description' => "Courier",
            'default'     => false,
            'editable'    => true,
            'deletable'   => false,
        ]);
        return $out;
    }

    public function rootUser($template)
    {
        $rootUser = new \App\User;
        $rootUser->username = "root";
        $rootUser->email = "himoath@gmail.com";
        $rootUser->password = Hash::make('rootstartx');
        $rootUser->remember_token = str_random(10);
        $rootUser->template()->associate($template);
        $rootUser->save();
    }
}
