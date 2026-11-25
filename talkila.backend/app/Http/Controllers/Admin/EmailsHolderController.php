<?php

namespace App\Http\Controllers\Admin;

use App\Models\EmailHistoriesLog;
use App\Http\Controllers\Controller;

use SendGrid\Mail\From;
use SendGrid\Mail\Mail;
use SendGrid\Mail\TemplateId;
use SendGrid\Mail\To;


class EmailsHolderController extends Controller
{

    public static function accountActivation($language, $send_email, $username, $username_url, $activation_link, $created, $created_at)
    {
        try {
            $from = new From("mail@talkila.com", $username);

            $tos = [
                new To(
                    $send_email,
                    $username,
                    [
                        'subject' => 'Account activation',
//                        'language'          => $language,
                        'username' => $username,
//                        'username_url'      => $username_url,
                        'activation_link' => $activation_link,
//                        'created'           => $created,
                        'created_at' => $created_at,
                    ]
                )
            ];

            $email = new \SendGrid\Mail\Mail(
                $from,
                $tos
            );

            $email->setSubject('Account activation');
            $email->setTemplateId(
                new TemplateId("d-b29957cbf0f0489ebf2bb5c5e82c2e94")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog = new EmailHistoriesLog();
                $emailHistoriesLog->from_user = "mail@talkila.com";
                $emailHistoriesLog->to_user = $send_email;
                $emailHistoriesLog->subject = 'Account activation';
                $emailHistoriesLog->message = 'Account activation';
                $emailHistoriesLog->template_id = "d-b29957cbf0f0489ebf2bb5c5e82c2e94";
                $emailHistoriesLog->save();
            }

        } catch (\Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }

    public static function accountBlocked($language, $send_email, $username, $username_url, $account_blocked_reason, $updated)
    {
        try {
            $from = new From("mail@talkila.com", "Example User");
            $tos = [
                new To(
                    $send_email,
                    [
                        'subject' => 'Account blocked',
                        'language' => $language,
                        'username' => $username,
                        'username_url' => $username_url,
                        'account_blocked_reason' => $account_blocked_reason,
                        'updated' => $updated
                    ]
                )
            ];
            $email = new Mail(
                $from,
                $tos
            );

            $email->setSubject('Account blocked');
            $email->setTemplateId(
                new TemplateId("d-372218f03bbd4774942bc287c176b7e5")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog = new EmailHistoriesLog();
                $emailHistoriesLog->from_user = "mail@talkila.com";
                $emailHistoriesLog->to_user = $send_email;
                $emailHistoriesLog->subject = 'Account blocked';
                $emailHistoriesLog->message = 'Account blocked';
                $emailHistoriesLog->template_id = "d-372218f03bbd4774942bc287c176b7e5";
                $emailHistoriesLog->save();
            }

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }

    public static function bookingCancellationClient($language, $email_client, $username_client, $username_mentor, $username_mentor_url, $talk_name, $booking_time, $talk_duration, $price, $price_currency, $talk_type, $anonym_call, $updated)
    {
        try {
            $from = new From("mail@talkila.com", "Example User");
            $tos = [
                new To(
                    $email_client,
                    [
                        'subject' => 'Booking cancellation client',
                        'language' => $language,
                        'username_mentor' => $username_mentor,
                        'username_mentor_url' => $username_mentor_url,
                        'username_client' => $username_client,
                        'talk_name' => $talk_name,
                        'booking_time' => $booking_time,
                        'talk_duration' => $talk_duration,
                        'price' => $price,
                        'price_currency' => $price_currency,
                        'talk_type' => $talk_type,
                        'anonym_call' => $anonym_call,
                        'updated' => $updated,
                    ]
                )
            ];
            $email = new Mail(
                $from,
                $tos
            );

            $email->setSubject('Booking cancellation client');
            $email->setTemplateId(
                new TemplateId("d-8547f92c902e47f6b30450d50acd5af3")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog = new EmailHistoriesLog();
                $emailHistoriesLog->from_user = "mail@talkila.com";
                $emailHistoriesLog->to_user = $email_client;
                $emailHistoriesLog->subject = 'Booking cancellation client';
                $emailHistoriesLog->message = 'Booking cancellation client';
                $emailHistoriesLog->template_id = "d-8547f92c902e47f6b30450d50acd5af3";
                $emailHistoriesLog->save();
            }

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }

    public static function bookingCancellationMentor($language, $email_mentor, $username_client, $username_mentor, $username_mentor_url, $talk_name, $booking_time, $talk_duration, $price, $price_currency, $talk_type, $anonym_call, $updated)
    {
        try {
            $from = new From("mail@talkila.com", "Example User");
            $tos = [
                new To(
                    $email_mentor,
                    [
                        'subject' => 'Booking cancellation mentor',
                        'language' => $language,
                        'username_mentor' => $username_mentor,
                        'username_mentor_url' => $username_mentor_url,
                        'username_client' => $username_client,
                        'talk_name' => $talk_name,
                        'booking_time' => $booking_time,
                        'talk_duration' => $talk_duration,
                        'price' => $price,
                        'price_currency' => $price_currency,
                        'talk_type' => $talk_type,
                        'anonym_call' => $anonym_call,
                        'updated' => $updated,
                    ]
                )
            ];
            $email = new Mail(
                $from,
                $tos
            );

            $email->setSubject('Booking cancellation mentor');
            $email->setTemplateId(
                new TemplateId("d-732cbb36815c4fafaa0b358c96441505")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog = new EmailHistoriesLog();
                $emailHistoriesLog->from_user = "mail@talkila.com";
                $emailHistoriesLog->to_user = $email_mentor;
                $emailHistoriesLog->subject = 'Booking cancellation mentor';
                $emailHistoriesLog->message = 'Booking cancellation mentor';
                $emailHistoriesLog->template_id = "d-732cbb36815c4fafaa0b358c96441505";
                $emailHistoriesLog->save();
            }

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }

    public static function bookingConfirmation($email_student, $email_mentor, $username_mentor, $username_mentor_url, $username_client, $talk_name, $booking_time, $talk_duration, $price, $price_currency, $talk_type, $anonym_call, $updated)
    {
        try {
            $from = new From("mail@talkila.com", "Example User");
            $tos = [
                new To(
                    $email_mentor,
                    [
                        'subject' => 'Booking confirmation',
                        'email_student' => $email_student,
                        'username_mentor' => $username_mentor,
                        'username_mentor_url' => $username_mentor_url,
                        'username_client' => $username_client,
                        'talk_name' => $talk_name,
                        'booking_time' => $booking_time,
                        'talk_duration' => $talk_duration,
                        'price' => $price,
                        'price_currency' => $price_currency,
                        'talk_type' => $talk_type,
                        'anonym_call' => $anonym_call,
                        'updated' => $updated,
                    ]
                )
            ];
            $email = new Mail(
                $from,
                $tos
            );

            $email->setSubject('Booking confirmation');
            $email->setTemplateId(
                new TemplateId("d-2412ad43403a400da2a1f0855280da23")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog = new EmailHistoriesLog();
                $emailHistoriesLog->from_user = "mail@talkila.com";
                $emailHistoriesLog->to_user = $email_student;
                $emailHistoriesLog->subject = 'Booking confirmation';
                $emailHistoriesLog->message = 'Booking confirmation';
                $emailHistoriesLog->template_id = "d-2412ad43403a400da2a1f0855280da23";
                $emailHistoriesLog->save();
            }

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }

    public static function bookingConfirmationClient($language, $email_client, $username_client, $username_mentor, $username_mentor_url, $talk_name, $booking_time, $talk_duration, $price, $price_currency, $talk_type, $anonym_call, $updated)
    {
        try {
            $from = new From("mail@talkila.com", "Example User");
            $tos = [
                new To(
                    $email_client,
                    [
                        'subject'               => 'Booking confirmation',
                        'language'              => $language,
                        'username_mentor'       => $username_mentor,
                        'username_mentor_url'   => $username_mentor_url,
                        'username_client'       => $username_client,
                        'talk_name'           => $talk_name,
                        'booking_time'          => $booking_time,
                        'talk_duration'       => $talk_duration,
                        'price'                 => $price,
                        'price_currency'        => $price_currency,
                        'talk_type'           => $talk_type,
                        'anonym_call'           => $anonym_call,
                        'updated'               => $updated,
                    ]
                )
            ];
            $email = new Mail(
                $from,
                $tos
            );

            $email->setSubject('Booking confirmation');
            $email->setTemplateId(
                new TemplateId("d-b2e766be04304a14aae5e292a5dc2280")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog = new EmailHistoriesLog();
                $emailHistoriesLog->from_user = "mail@talkila.com";
                $emailHistoriesLog->to_user = $email_client;
                $emailHistoriesLog->subject = 'Booking confirmation';
                $emailHistoriesLog->message = 'Booking confirmation';
                $emailHistoriesLog->template_id = "d-b2e766be04304a14aae5e292a5dc2280";
                $emailHistoriesLog->save();
            }

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

    public static function bookingUpdateMentor($language, $email_client, $username_mentor, $username_mentor_url, $talk_name, $booking_time_old,
                                               $booking_time_new, $talk_duration_old, $talk_duration_new, $price_old, $price_new, $price_currency,
                                               $talk_type_old, $talk_type_new, $anonym_call_old, $anonym_call_new, $updated)
    {
        try {
            $from = new From("mail@talkila.com", "Example User");
            $tos = [
                new To(
                    $email_client,
                    [
                        'subject'               => 'Booking update mentor',
                        'language'              => $language,
                        'username_mentor'       => $username_mentor,
                        'username_mentor_url'   => $username_mentor_url,
                        'talk_name'           => $talk_name,
                        'booking_time_old'      => $booking_time_old,
                        'booking_time_new'      => $booking_time_new,
                        'talk_duration_old'   => $talk_duration_old,
                        'talk_duration_new'   => $talk_duration_new,
                        'price_old'             => $price_old,
                        'price_new'             => $price_new,
                        'price_currency'        => $price_currency,
                        'talk_type_old'       => $talk_type_old,
                        'talk_type_new'       => $talk_type_new,
                        'anonym_call_old'       => $anonym_call_old,
                        'anonym_call_new'       => $anonym_call_new,
                        'updated'               => $updated,
                    ]
                )
            ];
            $email = new Mail(
                $from,
                $tos
            );

            $email->setSubject('Booking update mentor');
            $email->setTemplateId(
                new TemplateId("d-8547f92c902e47f6b30450d50acd5af3")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog              = new EmailHistoriesLog();
                $emailHistoriesLog->from_user   = "mail@talkila.com";
                $emailHistoriesLog->to_user     = $email_client;
                $emailHistoriesLog->subject     = 'Booking update mentor';
                $emailHistoriesLog->message     = 'Booking update mentor';
                $emailHistoriesLog->template_id = "d-8547f92c902e47f6b30450d50acd5af3";
                $emailHistoriesLog->save();
            }

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

    public static function feedbackDeleted($language, $email_client, $reason)
    {
        try {
            $from = new From("mail@talkila.com", "Example User");
            $tos = [
                new To(
                    $email_client,
                    [
                        'subject'   => 'Meeting missed',
                        'language'  => $language,
                        'reason'    => $reason,
                    ]
                )
            ];
            $email = new Mail(
                $from,
                $tos
            );

            $email->setSubject('Meeting missed');
            $email->setTemplateId(
                new TemplateId("d-f4f0e9853c234c83950320a906bbadb1")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog              = new EmailHistoriesLog();
                $emailHistoriesLog->from_user   = "mail@talkila.com";
                $emailHistoriesLog->to_user     = $email_client;
                $emailHistoriesLog->subject     = 'Meeting missed client';
                $emailHistoriesLog->message     = 'Meeting missed';
                $emailHistoriesLog->template_id = "d-f4f0e9853c234c83950320a906bbadb1";
                $emailHistoriesLog->save();
            }

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

    public static function feedbackNew($language, $email_mentor, $username_mentor_url, $stars_content, $description, $updated)
    {
        try {
            $from = new From("mail@talkila.com", "Example User");
            $tos = [
                new To(
                    $email_mentor,
                    [
                        'subject'               => 'Booking update mentor',
                        'language'              => $language,
                        'username_mentor_url'   => $username_mentor_url,
                        'stars_content'         => $stars_content,
                        'description'           => $description,
                        'updated'               => $updated,
                    ]
                )
            ];
            $email = new Mail(
                $from,
                $tos
            );

            $email->setSubject('Booking update mentor');
            $email->setTemplateId(
                new TemplateId("d-d6b96ab50731430d92bd19a63b1addc1")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog              = new EmailHistoriesLog();
                $emailHistoriesLog->from_user   = "mail@talkila.com";
                $emailHistoriesLog->to_user     = $email_mentor;
                $emailHistoriesLog->subject     = 'Booking update mentor';
                $emailHistoriesLog->message     = 'Booking update mentor';
                $emailHistoriesLog->template_id = "d-d6b96ab50731430d92bd19a63b1addc1";
                $emailHistoriesLog->save();
            }

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

    public static function invoiceBooking($language, $username_client, $username_mentor, $username_mentor_url, $email_client, $billing_address_email,
                                          $billing_address_street, $billing_address_zipcode,
                                          $billing_address_city, $billing_address_company_name, $billing_address_vat_number, $billing_address_country,
                                          $billing_address_tel_number, $billing_number, $talk_name, $booking_time, $talk_duration, $price, $price_currency,
                                          $talk_type, $anonym_call, $updated)
    {
        try {
            $from = new From("mail@talkila.com", "Example User");
            $tos = [
                new To(
                    $email_client,
                    [
                        'subject'                       => 'Invoice booking',
                        'language'                      => $language,
                        'username_client'               => $username_client,
                        'username_mentor'               => $username_mentor,
                        'username_mentor_url'           => $username_mentor_url,
                        'billing_address_email'         => $billing_address_email,
                        'billing_address_street'        => $billing_address_street,
                        'billing_address_zipcode'       => $billing_address_zipcode,
                        'billing_address_city'          => $billing_address_city,
                        'billing_address_company_name'  => $billing_address_company_name,
                        'billing_address_vat_number'    => $billing_address_vat_number,
                        'billing_address_country'       => $billing_address_country,
                        'billing_address_tel_number'    => $billing_address_tel_number,
                        'billing_number'                => $billing_number,
                        'talk_name'                   => $talk_name,
                        'booking_time'                  => $booking_time,
                        'talk_duration'               => $talk_duration,
                        'price'                         => $price,
                        'price_currency'                => $price_currency,
                        'talk_type'                   => $talk_type,
                        'anonym_call'                   => $anonym_call,
                        'updated'                       => $updated,
                    ]
                )
            ];
            $email = new Mail(
                $from,
                $tos
            );

            $email->setSubject('Invoice booking');
            $email->setTemplateId(
                new TemplateId("d-e854fdba460b4c4586258b37179e4451")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog              = new EmailHistoriesLog();
                $emailHistoriesLog->from_user   = "mail@talkila.com";
                $emailHistoriesLog->to_user     = $email_client;
                $emailHistoriesLog->subject     = 'Invoice booking';
                $emailHistoriesLog->message     = 'Invoice booking';
                $emailHistoriesLog->template_id = "d-e854fdba460b4c4586258b37179e4451";
                $emailHistoriesLog->save();
            }

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

    public static function meetingMissedClient($language, $email_client, $username_mentor, $username_mentor_url, $username_client, $talk_name,
                                               $booking_time, $talk_duration, $price, $price_currency, $talk_type, $anonym_call, $date_updated)
    {
        try {
            $from = new From("mail@talkila.com", "Example User");
            $tos = [
                new To(
                    $email_client,
                    [
                        'subject'               => 'Meeting missed',
                        'language'              => $language,
                        'email_client'          => $email_client,
                        'username_mentor'       => $username_mentor,
                        'username_mentor_url'   => $username_mentor_url,
                        'username_client'       => $username_client,
                        'talk_name'           => $talk_name,
                        'booking_time'          => $booking_time,
                        'talk_duration'       => $talk_duration,
                        'price'                 => $price,
                        'price_currency'        => $price_currency,
                        'talk_type'           => $talk_type,
                        'anonym_call'           => $anonym_call,
                        'date_updated'          => $date_updated,
                    ]
                )
            ];
            $email = new Mail(
                $from,
                $tos
            );

            $email->setSubject('Meeting missed');
            $email->setTemplateId(
                new TemplateId("d-82b2a52a9ade49679a348aa250ff7574")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog              = new EmailHistoriesLog();
                $emailHistoriesLog->from_user   = "mail@talkila.com";
                $emailHistoriesLog->to_user     = $email_client;
                $emailHistoriesLog->subject     = 'Meeting missed client';
                $emailHistoriesLog->message     = 'Meeting missed';
                $emailHistoriesLog->template_id = "d-82b2a52a9ade49679a348aa250ff7574";
                $emailHistoriesLog->save();
            }

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

    public static function meetingMissedMentor($language, $email_mentor, $username_client, $username_mentor, $username_mentor_url, $talk_name,
                                               $booking_time, $talk_duration, $price, $price_currency, $talk_type, $anonym_call, $date_updated)
    {
        try {
            $from = new From("mail@talkila.com", "Example User");
            $tos = [
                new To(
                    $email_mentor,
                    [
                        'subject'               => 'Meeting missed',
                        'language'              => $language,
                        'email_mentor'          => $email_mentor,
                        'username_mentor_url'   => $username_mentor_url,
                        'username_client'       => $username_client,
                        'username_mentor'       => $username_mentor,
                        'talk_name'           => $talk_name,
                        'booking_time'          => $booking_time,
                        'talk_duration'       => $talk_duration,
                        'price'                 => $price,
                        'price_currency'        => $price_currency,
                        'talk_type'           => $talk_type,
                        'anonym_call'           => $anonym_call,
                        'date_updated'          => $date_updated,
                    ]
                )
            ];
            $email = new Mail(
                $from,
                $tos
            );

            $email->setSubject('Meeting missed');
            $email->setTemplateId(
                new TemplateId("d-7bbf32c2d6bd435d9b5e003d76b33765")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog              = new EmailHistoriesLog();
                $emailHistoriesLog->from_user   = "mail@talkila.com";
                $emailHistoriesLog->to_user     = $email_mentor;
                $emailHistoriesLog->subject     = 'Meeting missed client';
                $emailHistoriesLog->message     = 'Meeting missed';
                $emailHistoriesLog->template_id = "d-7bbf32c2d6bd435d9b5e003d76b33765";
                $emailHistoriesLog->save();
            }

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

    public static function mentorUpgrade($language, $email_mentor, $username_client, $step_profession, $step_price, $step_availability, $step_accounting, $step_money_transfer)
    {
        try {
            $from = new From("mail@talkila.com", "Example User");
            $tos = [
                new To(
                    $email_mentor,
                    [
                        'subject'               => 'Mentor upgrade',
                        'language'              => $language,
                        'email_mentor'          => $email_mentor,
                        'username_mentor'       => $username_client,
                        'step_profession'       => $step_profession,
                        'step_price'            => $step_price,
                        'step_availability'     => $step_availability,
                        'step_accounting'       => $step_accounting,
                        'step_money_transfer'   => $step_money_transfer,
                    ]
                )
            ];
            $email = new Mail(
                $from,
                $tos
            );

            $email->setSubject('Mentor upgrade');
            $email->setTemplateId(
                new TemplateId("d-fb969723029941b58f1f3f822ac8de5e")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog              = new EmailHistoriesLog();
                $emailHistoriesLog->from_user   = "mail@talkila.com";
                $emailHistoriesLog->to_user     = $email_mentor;
                $emailHistoriesLog->subject     = 'Mentor upgrade';
                $emailHistoriesLog->message     = 'Mentor upgrade';
                $emailHistoriesLog->template_id = "d-fb969723029941b58f1f3f822ac8de5e";
                $emailHistoriesLog->save();
            }

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

    public static function payoutInvoice($language, $username_mentor, $username_mentor_url, $billing_address_email,
                                         $billing_address_street, $billing_address_zipcode, $billing_address_city, $billing_address_company_name, $billing_address_tax_number,
                                         $billing_address_country , $billing_address_tel_number, $billing_number, $total_amount_earnings, $total_amount_earnings_minus_comission,
                                         $total_amount_tax , $total_amount_paid_by_paypal, $total_amount_paid_by_stripe, $booking)
    {
        try {
            $from = new From("mail@talkila.com", "Example User");
            $tos = [
                new To(
                    $billing_address_email,
                    $username_mentor,
                    [
                        'subject'                               => 'Payout invoice',
                        'language'                              => $language,
                        'username_mentor'                       => $username_mentor,
                        'username_mentor_url'                   => $username_mentor_url,
                        'billing_address_street'                => $billing_address_street,
                        'billing_address_zipcode'               => $billing_address_zipcode,
                        'billing_address_city'                  => $billing_address_city,
                        'billing_address_company_name'          => $billing_address_company_name,
                        'billing_address_tax_number'            => $billing_address_tax_number,
                        'billing_address_country'               => $billing_address_country,
                        'billing_address_tel_number'            => $billing_address_tel_number,
                        'billing_number'                        => $billing_number,
                        'total_amount_earnings'                 => $total_amount_earnings,
                        'total_amount_earnings_minus_comission' => $total_amount_earnings_minus_comission,
                        'total_amount_tax'                      => $total_amount_tax,
                        'total_amount_paid_by_paypal'           => $total_amount_paid_by_paypal,
                        'total_amount_paid_by_stripe'           => $total_amount_paid_by_stripe,
                        'booking'                               => $booking,
                    ]
                )
            ];
            $email = new Mail(
                $from,
                $tos
            );

            $email->setSubject('Payout invoice');
            $email->setTemplateId(
                new TemplateId("d-ed141983d08e45f684edc38afac76f41")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog              = new EmailHistoriesLog();
                $emailHistoriesLog->from_user   = "mail@talkila.com";
                $emailHistoriesLog->to_user     = $billing_address_email;
                $emailHistoriesLog->subject     = 'Payout invoice';
                $emailHistoriesLog->message     = 'Payout invoice';
                $emailHistoriesLog->template_id = "d-ed141983d08e45f684edc38afac76f41";
                $emailHistoriesLog->save();
            }
        } catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

    public static function promoteYourProfile($language, $username_mentor, $username_mentor_url, $email_mentor, $url_mentor)
    {
        try {
            $from = new From("mail@talkila.com", "Example User");
            $tos = [
                new To(
                    $email_mentor,
                    [
                        'subject'               => 'Meeting missed',
                        'language'              => $language,
                        'email_mentor'          => $email_mentor,
                        'username_mentor_url'   => $username_mentor_url,
                        'username_mentor'       => $username_mentor,
                        'url_mentor'            => $url_mentor,
                    ]
                )
            ];
            $email = new Mail(
                $from,
                $tos
            );

            $email->setSubject('Meeting missed');
            $email->setTemplateId(
                new TemplateId("d-7bbf32c2d6bd435d9b5e003d76b33765")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog              = new EmailHistoriesLog();
                $emailHistoriesLog->from_user   = "mail@talkila.com";
                $emailHistoriesLog->to_user     = $email_mentor;
                $emailHistoriesLog->subject     = 'Meeting missed client';
                $emailHistoriesLog->message     = 'Meeting missed';
                $emailHistoriesLog->template_id = "d-7bbf32c2d6bd435d9b5e003d76b33765";
                $emailHistoriesLog->save();
            }

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

    public static function verificationEmail($language, $send_email, $username, $username_url, $temporary_url, $updated)
    {

        try {
            $from = new From("mail@talkila.com", $username);
            $tos = [
                new To(
                    $send_email,
                    $username,
                    [
                        'subject'              => 'Account new email verification',
//                        'language'                  => $language,
                        'username'             => $username,
//                        'username_url'              => $username_url,
                        'verification_link'    => $temporary_url,
                        'updated'              => $updated
                    ]
                )
            ];
            $email = new \SendGrid\Mail\Mail(
                $from,
                $tos
            );

            $email->setSubject('Account new email verification');
            $email->setTemplateId(
                new TemplateId("d-1b222dc6c5684af591ba3ddc2d805953")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog = new EmailHistoriesLog();
                $emailHistoriesLog->from_user = "mail@talkila.com";
                $emailHistoriesLog->to_user = $send_email;
                $emailHistoriesLog->subject = 'Account new email verification';
                $emailHistoriesLog->message = 'Account new email verification';
                $emailHistoriesLog->template_id = "d-1b222dc6c5684af591ba3ddc2d805953";
                $emailHistoriesLog->save();
            }

            return true;

        } catch (\Exception $e) {

            return false;
        }
    }

    public static function appFeedbackEmail($send_email, $username, $rating, $comment, $created_at)
    {

        try {
            $from = new From("mail@talkila.com", 'System email');
            $tos = [
                new To(
                    $send_email,
                    $username,
                    [
                        'subject'       => 'New feedback created',
                        'username'      => $username,
                        'rating'        => $rating,
                        'comment'       => $comment,
                        'created_at'    => $created_at
                    ]
                )
            ];
            $email = new \SendGrid\Mail\Mail(
                $from,
                $tos
            );

            $email->setSubject('New feedback created');
            $email->setTemplateId(
                new TemplateId("d-caa88b9623fe4e47bb0c7845070284d8")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog = new EmailHistoriesLog();
                $emailHistoriesLog->from_user = "mail@talkila.com";
                $emailHistoriesLog->to_user = $send_email;
                $emailHistoriesLog->subject = 'New feedback created';
                $emailHistoriesLog->message = 'New feedback created';
                $emailHistoriesLog->template_id = "d-caa88b9623fe4e47bb0c7845070284d8";
                $emailHistoriesLog->save();
            }

            return true;

        } catch (\Exception $e) {

            return false;
        }
    }

    public static function welcomeEmail($language, $username_client, $username_client_url, $email_client)
    {
        try {
            $from = new From("mail@talkila.com", "Example User");
            $tos = [
                new To(
                    $email_client,
                    [
                        'subject'               => 'Welcome email',
                        'language'              => $language,
                        'username_client'       => $username_client,
                        'username_client_url'   => $username_client_url,
                    ]
                )
            ];
            $email = new Mail(
                $from,
                $tos
            );

            $email->setSubject('Welcome email');
            $email->setTemplateId(
                new TemplateId("d-9e55e39bff324e96a0554bb81e6a830b")
            );

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog              = new EmailHistoriesLog();
                $emailHistoriesLog->from_user   = "mail@talkila.com";
                $emailHistoriesLog->to_user     = $email_client;
                $emailHistoriesLog->subject     = 'Welcome email';
                $emailHistoriesLog->message     = 'Welcome email';
                $emailHistoriesLog->template_id = "d-9e55e39bff324e96a0554bb81e6a830b";
                $emailHistoriesLog->save();
            }

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }



}
