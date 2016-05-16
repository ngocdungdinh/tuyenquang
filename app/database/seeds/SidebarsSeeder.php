<?php

class SidebarsSeeder extends Seeder {

	public function run()
	{
		// Delete all the sidebars
		DB::table('sidebars')->truncate();
		$user_id = DB::table('users')->orderBy('id', 'asc')->first()->id;
		
		$dateTime = new DateTime('now');
		$dateTime = $dateTime->format('Y-m-d H:i:s');

		$sidebars = array(
			array(
				'name' => 'Mặc định',
				'code' => 'mac-dinh',
				'position' => 'default',
				'can_delete' => 0,
				'user_id' => $user_id,
				'status' => 'on',
                'created_at' => $dateTime,
                'updated_at' => $dateTime
			),
			array(
				'name' => 'Trên cùng',
				'code' => 'tren-cung',
				'position' => 'top',
				'can_delete' => 1,
				'user_id' => $user_id,
				'status' => 'off',
                'created_at' => $dateTime,
                'updated_at' => $dateTime
			),
			array(
				'name' => 'Dưới cùng',
				'code' => 'duoi-cung',
				'position' => 'bottom',
				'can_delete' => 1,
				'user_id' => $user_id,
				'status' => 'off',
                'created_at' => $dateTime,
                'updated_at' => $dateTime
			),
			array(
				'name' => 'Bên phải',
				'code' => 'ben-phai',
				'position' => 'right',
				'can_delete' => 1,
				'user_id' => $user_id,
				'status' => 'off',
                'created_at' => $dateTime,
                'updated_at' => $dateTime
			),
			array(
				'name' => 'Bên trái',
				'code' => 'ben-trai',
				'position' => 'left',
				'can_delete' => 1,
				'user_id' => $user_id,
				'status' => 'off',
                'created_at' => $dateTime,
                'updated_at' => $dateTime
			),
			array(
				'name' => 'Chính giữa',
				'code' => 'chinh-giua',
				'position' => 'center',
				'can_delete' => 1,
				'user_id' => $user_id,
				'status' => 'off',
                'created_at' => $dateTime,
                'updated_at' => $dateTime
			)
		);
		// Insert the sidebars
		DB::table('sidebars')->insert($sidebars);
	}

}
