<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Role Types
         *
         */
        $RoleItems = [
            [
                'name'        => 'Admin',
                'slug'        => 'Admin',
                'description' => 'Admin Role',
                'level'       => 5,
            ],
            [
                'name'        => 'Professor',
                'slug'        => 'Professor',
                'description' => 'Professor Role',
                'level'       => 1,
            ],
            [
                'name'        => 'Student',
                'slug'        => 'Student',
                'description' => 'Student Role',
                'level'       => 0,
            ],
        ];

        /*
         * Add Role Items
         *
         */
        $i=0;
        foreach ($RoleItems as $RoleItem) {
            $i+=1;
            $newRoleItem = config('roles.models.role')::where('id', '=', $i )->first();

            $newRoleItem->update([
                'name'          => $RoleItem['name'],
                'slug'          => $RoleItem['slug'],
                'description'   => $RoleItem['description'],
                'level'         => $RoleItem['level'],
            ]);           
        }
    }

   
}
