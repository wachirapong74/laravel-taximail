<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Role;
use App\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::beginTransaction();

    	try {
    		
	        $admin = new Role();
	        $admin->name         = 'admin';
	        $admin->display_name = 'User Administrator'; // optional
	        $admin->description  = 'User is allowed to manage and edit other users'; // optional
	        $admin->save();

	        $user = new User;
	        $user->name = 'administrator';
	        $user->username = 'root';
	        $user->email = 'root@i3gateway.com';
	        $user->password = bcrypt('1q2w3e4r');
	        $user->save();

	        $user->attachRole($admin);

	    	DB::commit();

	    } catch (\Exception $e) {
	        DB::rollback();
	        // something went wrong
            echo $e->getMessage();
	    }
    }
}
