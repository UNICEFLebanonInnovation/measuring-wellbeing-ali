<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	/*Creating roles S*/
        $adminRole = DB::table('roles')->where('name','admin')->first();
        if(empty($adminRole)){
        	DB::table('roles')->insert([
        		'name' => "admin",
        		'gaurd_name' => "admin"
        	]);
        }

        $partnerRole = DB::table('roles')->where('name','partner')->first();
        if(empty($partnerRole)){
        	DB::table('roles')->insert([
        		'name' => "partner",
        		'gaurd_name' => "admin"
        	]);
        }

        $collectorRole = DB::table('roles')->where('name','collector')->first();
        if(empty($collectorRole)){
        	DB::table('roles')->insert([
        		'name' => "collector",
        		'gaurd_name' => "admin"
        	]);
        }
    	/*Creating roles E*/

    	/*Create admin user S*/
    	$userObj = User::where('email','vipul@cosmonautgroup.com')->first();
    	if(empty($userObj)){
    		$userObj = User::insert([
    			'firstname' => "Admin",
    			'lastname' => "Account",
    			'email' => 'vipul@cosmonautgroup.com',
    			'password' => Hash::make("Admin@123"),
    			'email_verified_at' => date(),
    			'is_active' => 1
    		]);
    		$adminRole = DB::table('roles')->where('name','admin')->first();
    		DB::table('model_has_roles')->insert([
    			'role_id' => $adminRole->id,
    			'model_type' => "App\User",
    			'model_id' => $userObj->id
    		]);
    	}
    	$this->command->info('Admin Details => Email: '.$userObj->email." Password: Admin@123");
    	/*Create admin user E*/
    }
}
