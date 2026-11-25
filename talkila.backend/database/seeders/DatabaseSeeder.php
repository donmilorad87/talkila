<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            VATSeeder::class,
            CountriesTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            FinanceCurrenciesTableSeeder::class,
            DisposalDomainsTableSeeder::class,
            LanguagesSeeder::class,
            PolishLanguageSeeder::class,
            TalkCategoriesTableSeeder::class,
            PolishCategoriesSeeder::class,
            TalkSubCategoriesTableSeeder::class,
            PolishSubcategoriesSeeder::class,
            CallsCancellationReasonsTableSeeder::class,
            PolishCancellationReasonsSeeder::class,
            BillingAddressesTableSeeder::class,
            StaticForbiddenNamesTableSeeder::class,
            StaticPagesTableSeeder::class,
            StaticProfessionsTableSeeder::class,
            RoleAffiliateTableSeeder::class,
            ReportReasonsTableSeeder::class,
            TalkSubCategoriesOther::class,
            PageSeeder::class,
            CountriesVATSeeder::class,
            PartnerSeeder::class,
        ]);
    }
}
