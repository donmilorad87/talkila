<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => '1',
                'title' => 'user_management_access',
            ],
            [
                'id'    => '2',
                'title' => 'permission_create',
            ],
            [
                'id'    => '3',
                'title' => 'permission_edit',
            ],
            [
                'id'    => '4',
                'title' => 'permission_show',
            ],
            [
                'id'    => '5',
                'title' => 'permission_delete',
            ],
            [
                'id'    => '6',
                'title' => 'permission_access',
            ],
            [
                'id'    => '7',
                'title' => 'role_create',
            ],
            [
                'id'    => '8',
                'title' => 'role_edit',
            ],
            [
                'id'    => '9',
                'title' => 'role_show',
            ],
            [
                'id'    => '10',
                'title' => 'role_delete',
            ],
            [
                'id'    => '11',
                'title' => 'role_access',
            ],
            [
                'id'    => '12',
                'title' => 'user_create',
            ],
            [
                'id'    => '13',
                'title' => 'user_edit',
            ],
            [
                'id'    => '14',
                'title' => 'user_show',
            ],
            [
                'id'    => '15',
                'title' => 'user_delete',
            ],
            [
                'id'    => '16',
                'title' => 'user_access',
            ],
            [
                'id'    => '17',
                'title' => 'user_blocked_create',
            ],
            [
                'id'    => '18',
                'title' => 'user_blocked_edit',
            ],
            [
                'id'    => '19',
                'title' => 'user_blocked_show',
            ],
            [
                'id'    => '20',
                'title' => 'user_blocked_delete',
            ],
            [
                'id'    => '21',
                'title' => 'user_blocked_access',
            ],
            [
                'id'    => '22',
                'title' => 'audit_log_show',
            ],
            [
                'id'    => '23',
                'title' => 'audit_log_access',
            ],
            [
                'id'    => '24',
                'title' => 'user_followed_create',
            ],
            [
                'id'    => '25',
                'title' => 'user_followed_edit',
            ],
            [
                'id'    => '26',
                'title' => 'user_followed_show',
            ],
            [
                'id'    => '27',
                'title' => 'user_followed_delete',
            ],
            [
                'id'    => '28',
                'title' => 'user_followed_access',
            ],
            [
                'id'    => '29',
                'title' => 'user_dont_show_again_create',
            ],
            [
                'id'    => '30',
                'title' => 'user_dont_show_again_edit',
            ],
            [
                'id'    => '31',
                'title' => 'user_dont_show_again_show',
            ],
            [
                'id'    => '32',
                'title' => 'user_dont_show_again_delete',
            ],
            [
                'id'    => '33',
                'title' => 'user_dont_show_again_access',
            ],
            [
                'id'    => '34',
                'title' => 'system_login_create',
            ],
            [
                'id'    => '35',
                'title' => 'system_login_edit',
            ],
            [
                'id'    => '36',
                'title' => 'system_login_show',
            ],
            [
                'id'    => '37',
                'title' => 'system_login_delete',
            ],
            [
                'id'    => '38',
                'title' => 'system_login_access',
            ],
            [
                'id'    => '39',
                'title' => 'static_profession_create',
            ],
            [
                'id'    => '40',
                'title' => 'static_profession_edit',
            ],
            [
                'id'    => '41',
                'title' => 'static_profession_show',
            ],
            [
                'id'    => '42',
                'title' => 'static_profession_delete',
            ],
            [
                'id'    => '43',
                'title' => 'static_profession_access',
            ],
            [
                'id'    => '44',
                'title' => 'static_review_create',
            ],
            [
                'id'    => '45',
                'title' => 'static_review_edit',
            ],
            [
                'id'    => '46',
                'title' => 'static_review_show',
            ],
            [
                'id'    => '47',
                'title' => 'static_review_delete',
            ],
            [
                'id'    => '48',
                'title' => 'static_review_access',
            ],
            [
                'id'    => '49',
                'title' => 'static_forbidden_name_create',
            ],
            [
                'id'    => '50',
                'title' => 'static_forbidden_name_edit',
            ],
            [
                'id'    => '51',
                'title' => 'static_forbidden_name_show',
            ],
            [
                'id'    => '52',
                'title' => 'static_forbidden_name_delete',
            ],
            [
                'id'    => '53',
                'title' => 'static_forbidden_name_access',
            ],
            [
                'id'    => '54',
                'title' => 'static_commission_create',
            ],
            [
                'id'    => '55',
                'title' => 'static_commission_edit',
            ],
            [
                'id'    => '56',
                'title' => 'static_commission_show',
            ],
            [
                'id'    => '57',
                'title' => 'static_commission_delete',
            ],
            [
                'id'    => '58',
                'title' => 'static_commission_access',
            ],
            [
                'id'    => '59',
                'title' => 'static_blocked_user_create',
            ],
            [
                'id'    => '60',
                'title' => 'static_blocked_user_edit',
            ],
            [
                'id'    => '61',
                'title' => 'static_blocked_user_show',
            ],
            [
                'id'    => '62',
                'title' => 'static_blocked_user_delete',
            ],
            [
                'id'    => '63',
                'title' => 'static_blocked_user_access',
            ],
            [
                'id'    => '64',
                'title' => 'search_create',
            ],
            [
                'id'    => '65',
                'title' => 'search_edit',
            ],
            [
                'id'    => '66',
                'title' => 'search_show',
            ],
            [
                'id'    => '67',
                'title' => 'search_delete',
            ],
            [
                'id'    => '68',
                'title' => 'search_access',
            ],
            [
                'id'    => '69',
                'title' => 'profil_payout_method_create',
            ],
            [
                'id'    => '70',
                'title' => 'profil_payout_method_edit',
            ],
            [
                'id'    => '71',
                'title' => 'profil_payout_method_show',
            ],
            [
                'id'    => '72',
                'title' => 'profil_payout_method_delete',
            ],
            [
                'id'    => '73',
                'title' => 'profil_payout_method_access',
            ],
            [
                'id'    => '74',
                'title' => 'profil_cv_create',
            ],
            [
                'id'    => '75',
                'title' => 'profil_cv_edit',
            ],
            [
                'id'    => '76',
                'title' => 'profil_cv_show',
            ],
            [
                'id'    => '77',
                'title' => 'profil_cv_delete',
            ],
            [
                'id'    => '78',
                'title' => 'profil_cv_access',
            ],
            [
                'id'    => '79',
                'title' => 'language_create',
            ],
            [
                'id'    => '80',
                'title' => 'language_edit',
            ],
            [
                'id'    => '81',
                'title' => 'language_show',
            ],
            [
                'id'    => '82',
                'title' => 'language_delete',
            ],
            [
                'id'    => '83',
                'title' => 'language_access',
            ],
            [
                'id'    => '84',
                'title' => 'country_create',
            ],
            [
                'id'    => '85',
                'title' => 'country_edit',
            ],
            [
                'id'    => '86',
                'title' => 'country_show',
            ],
            [
                'id'    => '87',
                'title' => 'country_delete',
            ],
            [
                'id'    => '88',
                'title' => 'country_access',
            ],
            [
                'id'    => '89',
                'title' => 'languages_profil_create',
            ],
            [
                'id'    => '90',
                'title' => 'languages_profil_edit',
            ],
            [
                'id'    => '91',
                'title' => 'languages_profil_show',
            ],
            [
                'id'    => '92',
                'title' => 'languages_profil_delete',
            ],
            [
                'id'    => '93',
                'title' => 'languages_profil_access',
            ],
            [
                'id'    => '94',
                'title' => 'autocomplete_tag_create',
            ],
            [
                'id'    => '95',
                'title' => 'autocomplete_tag_edit',
            ],
            [
                'id'    => '96',
                'title' => 'autocomplete_tag_show',
            ],
            [
                'id'    => '97',
                'title' => 'autocomplete_tag_delete',
            ],
            [
                'id'    => '98',
                'title' => 'autocomplete_tag_access',
            ],
            [
                'id'    => '99',
                'title' => 'payout_create',
            ],
            [
                'id'    => '100',
                'title' => 'payout_edit',
            ],
            [
                'id'    => '101',
                'title' => 'payout_show',
            ],
            [
                'id'    => '102',
                'title' => 'payout_delete',
            ],
            [
                'id'    => '103',
                'title' => 'payout_access',
            ],
            [
                'id'    => '104',
                'title' => 'payout_currency_create',
            ],
            [
                'id'    => '105',
                'title' => 'payout_currency_edit',
            ],
            [
                'id'    => '106',
                'title' => 'payout_currency_show',
            ],
            [
                'id'    => '107',
                'title' => 'payout_currency_delete',
            ],
            [
                'id'    => '108',
                'title' => 'payout_currency_access',
            ],
            [
                'id'    => '109',
                'title' => 'email_history_create',
            ],
            [
                'id'    => '110',
                'title' => 'email_history_edit',
            ],
            [
                'id'    => '111',
                'title' => 'email_history_show',
            ],
            [
                'id'    => '112',
                'title' => 'email_history_delete',
            ],
            [
                'id'    => '113',
                'title' => 'email_history_access',
            ],
            [
                'id'    => '114',
                'title' => 'disposal_domain_create',
            ],
            [
                'id'    => '115',
                'title' => 'disposal_domain_edit',
            ],
            [
                'id'    => '116',
                'title' => 'disposal_domain_show',
            ],
            [
                'id'    => '117',
                'title' => 'disposal_domain_delete',
            ],
            [
                'id'    => '118',
                'title' => 'disposal_domain_access',
            ],
            [
                'id'    => '119',
                'title' => 'availability_create',
            ],
            [
                'id'    => '120',
                'title' => 'availability_edit',
            ],
            [
                'id'    => '121',
                'title' => 'availability_show',
            ],
            [
                'id'    => '122',
                'title' => 'availability_delete',
            ],
            [
                'id'    => '123',
                'title' => 'availability_access',
            ],
            [
                'id'    => '124',
                'title' => 'billing_address_create',
            ],
            [
                'id'    => '125',
                'title' => 'billing_address_edit',
            ],
            [
                'id'    => '126',
                'title' => 'billing_address_show',
            ],
            [
                'id'    => '127',
                'title' => 'billing_address_delete',
            ],
            [
                'id'    => '128',
                'title' => 'billing_address_access',
            ],
            [
                'id'    => '129',
                'title' => 'booking_create',
            ],
            [
                'id'    => '130',
                'title' => 'booking_edit',
            ],
            [
                'id'    => '131',
                'title' => 'booking_show',
            ],
            [
                'id'    => '132',
                'title' => 'booking_delete',
            ],
            [
                'id'    => '133',
                'title' => 'booking_access',
            ],
            [
                'id'    => '134',
                'title' => 'calls_cancellation_reason_create',
            ],
            [
                'id'    => '135',
                'title' => 'calls_cancellation_reason_edit',
            ],
            [
                'id'    => '136',
                'title' => 'calls_cancellation_reason_show',
            ],
            [
                'id'    => '137',
                'title' => 'calls_cancellation_reason_delete',
            ],
            [
                'id'    => '138',
                'title' => 'calls_cancellation_reason_access',
            ],
            [
                'id'    => '139',
                'title' => 'bookings_payout_create',
            ],
            [
                'id'    => '140',
                'title' => 'bookings_payout_edit',
            ],
            [
                'id'    => '141',
                'title' => 'bookings_payout_show',
            ],
            [
                'id'    => '142',
                'title' => 'bookings_payout_delete',
            ],
            [
                'id'    => '143',
                'title' => 'bookings_payout_access',
            ],
            [
                'id'    => '144',
                'title' => 'talk_create',
            ],
            [
                'id'    => '145',
                'title' => 'talk_edit',
            ],
            [
                'id'    => '146',
                'title' => 'talk_show',
            ],
            [
                'id'    => '147',
                'title' => 'talk_delete',
            ],
            [
                'id'    => '148',
                'title' => 'talk_access',
            ],
            [
                'id'    => '149',
                'title' => 'talks_booking_create',
            ],
            [
                'id'    => '150',
                'title' => 'talks_booking_edit',
            ],
            [
                'id'    => '151',
                'title' => 'talks_booking_show',
            ],
            [
                'id'    => '152',
                'title' => 'talks_booking_delete',
            ],
            [
                'id'    => '153',
                'title' => 'talks_booking_access',
            ],
            [
                'id'    => '154',
                'title' => 'feedback_create',
            ],
            [
                'id'    => '155',
                'title' => 'feedback_edit',
            ],
            [
                'id'    => '156',
                'title' => 'feedback_show',
            ],
            [
                'id'    => '157',
                'title' => 'feedback_delete',
            ],
            [
                'id'    => '158',
                'title' => 'feedback_access',
            ],
            [
                'id'    => '159',
                'title' => 'user_report_type_create',
            ],
            [
                'id'    => '160',
                'title' => 'user_report_type_edit',
            ],
            [
                'id'    => '161',
                'title' => 'user_report_type_show',
            ],
            [
                'id'    => '162',
                'title' => 'user_report_type_delete',
            ],
            [
                'id'    => '163',
                'title' => 'user_report_type_access',
            ],
            [
                'id'    => '164',
                'title' => 'user_reported_create',
            ],
            [
                'id'    => '165',
                'title' => 'user_reported_edit',
            ],
            [
                'id'    => '166',
                'title' => 'user_reported_show',
            ],
            [
                'id'    => '167',
                'title' => 'user_reported_delete',
            ],
            [
                'id'    => '168',
                'title' => 'user_reported_access',
            ],
            [
                'id'    => '169',
                'title' => 'static_metric_create',
            ],
            [
                'id'    => '170',
                'title' => 'static_metric_edit',
            ],
            [
                'id'    => '171',
                'title' => 'static_metric_show',
            ],
            [
                'id'    => '172',
                'title' => 'static_metric_delete',
            ],
            [
                'id'    => '173',
                'title' => 'static_metric_access',
            ],
            [
                'id'    => '174',
                'title' => 'user_visited_create',
            ],
            [
                'id'    => '175',
                'title' => 'user_visited_edit',
            ],
            [
                'id'    => '176',
                'title' => 'user_visited_show',
            ],
            [
                'id'    => '177',
                'title' => 'user_visited_delete',
            ],
            [
                'id'    => '178',
                'title' => 'user_visited_access',
            ],
            [
                'id'    => '179',
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => '180',
                'title' => 'disposal_email_edit',
            ],
            [
                'id'    => '181',
                'title' => 'disposal_email_create',
            ],
            [
                'id'    => '182',
                'title' => 'disposal_email_delete',
            ],
            [
                'id'    => '183',
                'title' => 'disposal_email_access',
            ],
            [
                'id'    => '184',
                'title' => 'page_edit',
            ],
            [
                'id'    => '185',
                'title' => 'page_create',
            ],
            [
                'id'    => '186',
                'title' => 'page_delete',
            ],
            [
                'id'    => '187',
                'title' => 'page_access',
            ],
            [
                'id'    => '188',
                'title' => 'cms_access',
            ],
            [
                'id'    => '189',
                'title' => 'cms_create',
            ],
            [
                'id'    => '190',
                'title' => 'cms_edit',
            ],
            [
                'id'    => '191',
                'title' => 'cms_show',
            ],
            [
                'id'    => '192',
                'title' => 'cms_delete',
            ],
            [
                'id'    => '193',
                'title' => 'talk_categories_access',
            ],
            [
                'id'    => '194',
                'title' => 'talk_categories_show',
            ],
            [
                'id'    => '195',
                'title' => 'talk_categories_edit',
            ],
            [
                'id'    => '196',
                'title' => 'talk_categories_delete',
            ],
            [
                'id'    => '197',
                'title' => 'talk_categories_create',
            ],
            [
                'id'    => '198',
                'title' => 'talk_subcategories_access',
            ],
            [
                'id'    => '199',
                'title' => 'talk_subcategories_show',
            ],
            [
                'id'    => '200',
                'title' => 'talk_subcategories_edit',
            ],
            [
                'id'    => '201',
                'title' => 'talk_subcategories_delete',
            ],
            [
                'id'    => '202',
                'title' => 'talk_subcategories_create',
            ],
            [
                'id'    => '203',
                'title' => 'suggestions_home_screen_access',
            ],
            [
                'id'    => '204',
                'title' => 'suggestions_home_screen_show',
            ],
            [
                'id'    => '205',
                'title' => 'suggestions_home_screen_edit',
            ],
            [
                'id'    => '206',
                'title' => 'suggestions_home_screen_delete',
            ],
            [
                'id'    => '207',
                'title' => 'suggestions_home_screen_create',
            ],
            [
                'id'    => '208',
                'title' => 'user_bookmarked_talks_access',
            ],
            [
                'id'    => '209',
                'title' => 'user_bookmarked_talks_show',
            ],
            [
                'id'    => '210',
                'title' => 'user_bookmarked_talks_edit',
            ],
            [
                'id'    => '211',
                'title' => 'user_bookmarked_talks_delete',
            ],
            [
                'id'    => '212',
                'title' => 'user_bookmarked_talks_create',
            ],
            [
                'id'    => '213',
                'title' => 'page_verifications_access',
            ],
            [
                'id'    => '214',
                'title' => 'notifications_access',
            ],
            [
                'id'    => '215',
                'title' => 'notifications_show',
            ],
            [
                'id'    => '216',
                'title' => 'notifications_edit',
            ],
            [
                'id'    => '217',
                'title' => 'notifications_delete',
            ],
            [
                'id'    => '218',
                'title' => 'notifications_create',
            ],
            [
                'id'    => '219',
                'title' => 'user_bookmarked_talks_access',
            ],
            [
                'id'    => '220',
                'title' => 'user_bookmarked_talks_show',
            ],
            [
                'id'    => '221',
                'title' => 'user_bookmarked_talks_delete',
            ],
            [
                'id'    => '222',
                'title' => 'user_bookmarked_talks_edit',
            ],
            [
                'id'    => '223',
                'title' => 'user_bookmarked_talks_create',
            ],
            [
                'id'    => '224',
                'title' => 'socket_room_access',
            ],
            [
                'id'    => '225',
                'title' => 'vat_access',
            ],
            [
                'id'    => '226',
                'title' => 'vat_create',
            ],
            [
                'id'    => '227',
                'title' => 'vat_show',
            ],
            [
                'id'    => '228',
                'title' => 'vat_edit',
            ],
            [
                'id'    => '229',
                'title' => 'vat_delete',
            ],
        ];

        Permission::insert($permissions);
    }
}
