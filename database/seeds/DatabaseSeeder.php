<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            'DataBizpars',
            'DatabaseRoles',
            'DatabaseUsers',
            'DatabaseCategories',
            'DatabaseArticles',
            'DatabaseBenefits',
            'DatabaseFeedbacks',
            'DatabasePermission',
            'DatabaseRolePermission',
        ]);
    }
}
