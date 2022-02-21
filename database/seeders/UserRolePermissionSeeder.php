<?php
namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // Permissions
            ['group' => 'Permissions', 'name' => 'create-permissions', 'display_name' => 'Create Permissions', 'guard_name' => 'web'],
            ['group' => 'Permissions', 'name' => 'edit-permissions', 'display_name' => 'Edit Permissions', 'guard_name' => 'web'],
            ['group' => 'Permissions', 'name' => 'list-permissions', 'display_name' => 'List Permissions', 'guard_name' => 'web'],
            ['group' => 'Permissions', 'name' => 'delete-permissions', 'display_name' => 'Delete Permissions', 'guard_name' => 'web'],
            // Languages
            ['group' => 'Languages', 'name' => 'create-languages', 'display_name' => 'Create Languages', 'guard_name' => 'web'],
            ['group' => 'Languages', 'name' => 'edit-languages', 'display_name' => 'Edit Languages', 'guard_name' => 'web'],
            ['group' => 'Languages', 'name' => 'list-languages', 'display_name' => 'List Languages', 'guard_name' => 'web'],
            ['group' => 'Languages', 'name' => 'delete-languages', 'display_name' => 'Delete Languages', 'guard_name' => 'web'],
            // models
            ['group' => 'models', 'name' => 'create-models', 'display_name' => 'Create models', 'guard_name' => 'web'],
            ['group' => 'models', 'name' => 'edit-models', 'display_name' => 'Edit models', 'guard_name' => 'web'],
            ['group' => 'models', 'name' => 'list-models', 'display_name' => 'List models', 'guard_name' => 'web'],
            ['group' => 'models', 'name' => 'delete-models', 'display_name' => 'Delete models', 'guard_name' => 'web'],
            // modelstatus
            ['group' => 'modelstatus', 'name' => 'create-modelstatus', 'display_name' => 'Create model status', 'guard_name' => 'web'],
            ['group' => 'modelstatus', 'name' => 'edit-modelstatus', 'display_name' => 'Edit model status', 'guard_name' => 'web'],
            ['group' => 'modelstatus', 'name' => 'list-modelstatus', 'display_name' => 'List model status', 'guard_name' => 'web'],
            ['group' => 'modelstatus', 'name' => 'delete-modelstatus', 'display_name' => 'Delete model status', 'guard_name' => 'web'],
            // modelfeatures
            ['group' => 'modelfeatures', 'name' => 'create-modelfeatures', 'display_name' => 'Create model Feature', 'guard_name' => 'web'],
            ['group' => 'modelfeatures', 'name' => 'edit-modelfeatures', 'display_name' => 'Edit model Feature', 'guard_name' => 'web'],
            ['group' => 'modelfeatures', 'name' => 'list-modelfeatures', 'display_name' => 'List model Feature', 'guard_name' => 'web'],
            ['group' => 'modelfeatures', 'name' => 'delete-modelfeatures', 'display_name' => 'Delete model Feature', 'guard_name' => 'web'],

            // Roles
            ['group' => 'Roles', 'name' => 'create-roles', 'display_name' => 'Create', 'guard_name' => 'web'],
            ['group' => 'Roles', 'name' => 'edit-roles', 'display_name' => 'Edit', 'guard_name' => 'web'],
            ['group' => 'Roles', 'name' => 'list-roles', 'display_name' => 'List', 'guard_name' => 'web'],
            ['group' => 'Roles', 'name' => 'delete-roles', 'display_name' => 'Delete', 'guard_name' => 'web'],
            // Users
            ['group' => 'Users', 'name' => 'create-users', 'display_name' => 'Create User', 'guard_name' => 'web'],
            ['group' => 'Users', 'name' => 'list-users', 'display_name' => 'List Users', 'guard_name' => 'web'],
            ['group' => 'Users', 'name' => 'edit-users', 'display_name' => 'Edit Users', 'guard_name' => 'web'],
            ['group' => 'Users', 'name' => 'delete-users', 'display_name' => 'Delete Users', 'guard_name' => 'web'],
            // packages
            ['group' => 'packages', 'name' => 'create-packages', 'display_name' => 'Create packages', 'guard_name' => 'web'],
            ['group' => 'packages', 'name' => 'edit-packages', 'display_name' => 'Edit packages', 'guard_name' => 'web'],
            ['group' => 'packages', 'name' => 'list-packages', 'display_name' => 'List packages', 'guard_name' => 'web'],
            ['group' => 'packages', 'name' => 'delete-packages', 'display_name' => 'Delete packages', 'guard_name' => 'web'],
            ['group' => 'packages', 'name' => 'assignuser-packages', 'display_name' => 'assign user', 'guard_name' => 'web'],
            ['group' => 'packages', 'name' => 'items-packages', 'display_name' => 'Add Items', 'guard_name' => 'web'],
            // features
            ['group' => 'features', 'name' => 'create-features', 'display_name' => 'Create features', 'guard_name' => 'web'],
            ['group' => 'features', 'name' => 'edit-features', 'display_name' => 'Edit features', 'guard_name' => 'web'],
            ['group' => 'features', 'name' => 'list-features', 'display_name' => 'List features', 'guard_name' => 'web'],
            ['group' => 'features', 'name' => 'delete-features', 'display_name' => 'Delete features', 'guard_name' => 'web'],
            // Settings
            ['group' => 'Settings', 'name' => 'list-settings', 'display_name' => 'List Settings', 'guard_name' => 'web'],
            ['group' => 'Settings', 'name' => 'create-settings', 'display_name' => 'Create Settings', 'guard_name' => 'web'],
            ['group' => 'Settings', 'name' => 'edit-settings', 'display_name' => 'Edit Settings', 'guard_name' => 'web'],
            ['group' => 'Settings', 'name' => 'delete-settings', 'display_name' => 'Delete Settings', 'guard_name' => 'web'],
            // Customers
            ['group' => 'Customers', 'name' => 'list-mypackages', 'display_name' => 'list my packages', 'guard_name' => 'web'],
            ['group' => 'Customers', 'name' => 'edit-mypackages', 'display_name' => 'edit my packages', 'guard_name' => 'web'],
            ['group' => 'Customers', 'name' => 'delete-mypackages', 'display_name' => 'delete my packages', 'guard_name' => 'web'],
            ['group' => 'Customers', 'name' => 'create-mypackages', 'display_name' => 'create my packages', 'guard_name' => 'web'],
            // CustomerUsers
            ['group' => 'CustomerUsers', 'name' => 'list-CustomerUsers', 'display_name' => 'List Customer Users', 'guard_name' => 'web'],
            ['group' => 'CustomerUsers', 'name' => 'edit-CustomerUsers', 'display_name' => 'edit Customer Users', 'guard_name' => 'web'],
            ['group' => 'CustomerUsers', 'name' => 'create-CustomerUsers', 'display_name' => 'create Customer Users', 'guard_name' => 'web'],
            ['group' => 'CustomerUsers', 'name' => 'delete-CustomerUsers', 'display_name' => 'List Customer Users', 'guard_name' => 'web'],
            ['group' => 'CustomerUsers', 'name' => 'assign-CustomerUsers', 'display_name' => 'Assign Customer Users', 'guard_name' => 'web'],


            // CustomerUsers
            ['group' => 'CustomerBranches', 'name' => 'list-CustomerBranches', 'display_name' => 'List Customer Branches', 'guard_name' => 'web'],
            ['group' => 'CustomerBranches', 'name' => 'edit-CustomerBranches', 'display_name' => 'edit Customer Branches', 'guard_name' => 'web'],
            ['group' => 'CustomerBranches', 'name' => 'create-CustomerBranches', 'display_name' => 'create Customer Branches', 'guard_name' => 'web'],
            ['group' => 'CustomerBranches', 'name' => 'delete-CustomerBranches', 'display_name' => 'List Customer Branches', 'guard_name' => 'web'],
            // branchmodels
            ['group' => 'branchmodels', 'name' => 'list-branchmodels', 'display_name' => 'List Branch Models', 'guard_name' => 'web'],
            ['group' => 'branchmodels', 'name' => 'edit-branchmodels', 'display_name' => 'edit Branch Models', 'guard_name' => 'web'],
            ['group' => 'branchmodels', 'name' => 'create-branchmodels', 'display_name' => 'create Branch Models', 'guard_name' => 'web'],
            ['group' => 'branchmodels', 'name' => 'delete-branchmodels', 'display_name' => 'List Branch Models', 'guard_name' => 'web'],


            /*
            'blank' => [
                ['group' => '', 'name' => '', 'display_name' => '', 'guard_name' => 'web'],
                ['group' => '', 'name' => '', 'display_name' => '', 'guard_name' => 'web'],
                ['group' => '', 'name' => '', 'display_name' => '', 'guard_name' => 'web'],
                ['group' => '', 'name' => '', 'display_name' => '', 'guard_name' => 'web'],
            ],
            */

        ];

        DB::table('model_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('role_has_permissions')->delete();
        DB::table('permissions')->delete();
        DB::table('roles')->delete();
        DB::table('users')->delete();

        // default admin users
        $rootUser = User::create([
            'name' => 'ROOT',
            'email' => 'root@general.com',
            'password' => '12345678',
            'type' => 'admin'
        ]);
        $adminUser = User::create([
            'name' => 'Administrator',
            'parent_id' => $rootUser->id,
            'email' => 'admin@general.com',
            'password' => '12345678',
            'type' => 'admin'
        ]);

        $customerUser = User::create([
            'name' => 'Petromin',
            'parent_id' => null,
            'email' => 'petro@general.com',
            'password' => '123465',
            'type' => 'customer'
        ]);

        // default roles
        $rootRole = Role::create([
            'name' => 'admin.Root',
            'display_name' => 'Root',
            'guard_name' => 'web'
        ]);

        $adminRole = Role::create([
            'name' => 'admin.Admin',
            'display_name' => 'Admin',
            'guard_name' => 'web'
        ]);

        $customerRole = Role::create([
            'name' => 'customer',
            'display_name' => 'customer',
            'guard_name' => 'web'
        ]);

        $rootUser->assignRole($rootRole);
        $adminUser->assignRole($adminRole);
        $customerUser->assignRole($customerRole);

        // add default permissions
        Permission::insert($permissions);

        $customerRole->syncPermissions(Permission::whereIn('group', ['Customers', 'CustomerUsers', 'CustomerBranches', 'branchmodels'])->get());
        $rootRole->syncPermissions(Permission::where('group', '!=', 'Customers')->get());
        $adminRole->syncPermissions(Permission::where('group', '!=', 'Permissions')->get());
        $adminRole->syncPermissions(Permission::where('group', '!=', 'Permissions')->get());

        // add default languages
        $language = new \App\Language;
        $language->name = 'EN';
        $language->code = 'EN';
        $language->direction = 'LTR';
        $language->flag = 'EN';
        $language->user_id = $adminUser->id;

        $language->save();

        $language = new \App\Language;
        $language->name = 'AR';
        $language->code = 'AR';
        $language->direction = 'RTL';
        $language->flag = 'AR';
        $language->user_id = $adminUser->id;

        $language->save();

    }
}
