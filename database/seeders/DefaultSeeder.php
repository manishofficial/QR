<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newPlan = new Plan();
        $newPlan->title = 'default';
        $newPlan->recurring_type = 'onetime';
        $newPlan->status = 'inactive';
        $newPlan->save();

        $adminData = get_admin_permission();

        $restaurantData = get_restaurant_permissions();

        $customerData = get_customer_permissions();

        $roleName = 'admin';
        $adminRole = Role::findOrCreate($roleName);
        $user = User::where('type', 'admin')->first();

        if ($user) {

            $roleName = 'restaurant_owner';
            $role = Role::findOrCreate($roleName);
            foreach ($restaurantData as $d) {
                $permission = Permission::findOrCreate($d);
                $role->givePermissionTo($permission);
            }


            $roleName = 'customer';
            $role = Role::findOrCreate($roleName);
            foreach ($customerData as $d) {
                $permission = Permission::findOrCreate($d);
                $role->givePermissionTo($permission);
            }
            $roleName = 'admin';
            foreach ($adminData as $d) {
                $permission = Permission::findOrCreate($d);
                $adminRole->givePermissionTo($permission);
            }

            $user->assignRole($roleName);
        }

        $data = [
            [
                'name' => 'payment_gateway',
                'value' => '{"paypal_client_id":"","paypal_secret_key":"","stripe_publish_key":"","stripe_secret_key":""}'
            ],
            [
                'name' => 'site_setting',
                'value' => '{"name":"PicoQR","favicon":"","logo":""}'
            ],
            [
                'name' => 'email_setting',
                'value' => '{"host":"","username":"demo@picotech.app","email_from":"demo@picotech.app","name":"Picotech Demo","password":"88888","port":"985","encryption_type":"ssl"}'
            ],
        ];

        Setting::insert($data);
    }
}
