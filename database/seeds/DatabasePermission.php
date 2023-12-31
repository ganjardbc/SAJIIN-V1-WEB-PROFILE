<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabasePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'permission_id' => 'PR-000000001',
                'name' => 'dashboard',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '2',
                'permission_id' => 'PR-000000002',
                'name' => 'bizpars',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '3',
                'permission_id' => 'PR-000000003',
                'name' => 'themes',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '4',
                'permission_id' => 'PR-000000004',
                'name' => 'songs',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '5',
                'permission_id' => 'PR-000000005',
                'name' => 'invitations',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '6',
                'permission_id' => 'PR-000000006',
                'name' => 'events',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '7',
                'permission_id' => 'PR-000000007',
                'name' => 'categories',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '8',
                'permission_id' => 'PR-000000008',
                'name' => 'brides',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '9',
                'permission_id' => 'PR-000000009',
                'name' => 'parents',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '10',
                'permission_id' => 'PR-000000010',
                'name' => 'guests',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '11',
                'permission_id' => 'PR-000000011',
                'name' => 'galleries',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '12',
                'permission_id' => 'PR-000000012',
                'name' => 'articles',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '13',
                'permission_id' => 'PR-000000013',
                'name' => 'benefits',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '14',
                'permission_id' => 'PR-000000014',
                'name' => 'feedbacks',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '15',
                'permission_id' => 'PR-000000015',
                'name' => 'permissions',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '16',
                'permission_id' => 'PR-000000016',
                'name' => 'roles',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ],
            [
                'id' => '17',
                'permission_id' => 'PR-000000017',
                'name' => 'users',
                'description' => 'Lorem ipsum dolor ismet.',
                'status' => 'active',
                "created_at" => '2020-06-28 19:08:45',
                "updated_at" => '2020-06-28 19:08:45'
            ]
        ];

        DB::table('permissions')->insert($data);
    }
}
