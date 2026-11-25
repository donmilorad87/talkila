<?php

namespace App\Http\Controllers\Admin;

use App\Entity\CallTypes;
use App\Models\Booking;
use App\Models\User;
use App\ModelsApi\Availability;
use App\ModelsApi\Language;
use App\ModelsApi\StaticProfession;
use App\ModelsApi\Talk;

class HomeController
{
    private function applyFilterByConfigValue($talks, $filterIndex, $filterItems, $teacherAvailability = false) {
        $configField = config('variables.filter.'.$filterIndex.'.field');
        $configValues = config('variables.filter.'.$filterIndex.'.values');

        $talks->where(function ($query) use ($configField, $configValues, $filterItems, $teacherAvailability) {
            foreach ($filterItems as $itemIndex => $filterItem) {
                $configValue = $configValues[$itemIndex];

                if($filterItem) {
                    $query->orWhere(function ($query2) use ($configValue, $configField) {
                        foreach ($configValue as $item) {
                            $query2->orWhere($configField, $item['operator'], $item['value']);
                        }
                    });
                }
            }

            if (!empty($teacherAvailability)) {
                $query->orWhereIn('teacher_user_id', $teacherAvailability);
            }
        });
    }

    private function applyFilterByAvailability($talks, $filterIndex, $filterItems, $loggedUser) {
        $teacherAvailability = \App\Models\Availability::query()
            ->select('user_id')
            ->where('state', Availability::STATE['valid'])
            ->where('user_id', '!=', $loggedUser);

        $this->applyFilterByConfigValue($teacherAvailability, $filterIndex, $filterItems);

        $this->applyFilterByConfigValue($talks, $filterIndex, $filterItems, $teacherAvailability);
    }

    private function applyFilterByDynamicValue($talks, $filterIndex, $filterItems) {
        $configField = config('variables.filter.'.$filterIndex.'.field');

        $talks->where(function ($query) use ($configField, $filterItems) {
            if(is_array($filterItems)) {
                foreach ($filterItems as $filterValue) {
                    $query->orWhere($configField, $filterValue);
                }
            } else {
                $query->where($configField, $filterItems);
            }
        });
    }

    public function index()
    {
        $loggedUser = 10;

        $user           = \App\ModelsApi\User::query()->select('id', 'name as teacher_name', 'username as teacher_username')
            ->selectRaw("CASE WHEN id = $loggedUser THEN profile_picture_tmp ELSE profile_picture END AS teacher_profile_picture");

        $languages      = Language::query()->select('id', StaticProfession::DATABASE_LANGUAGE['en'] .' as language_value');



        $talks          = Talk::query()->select('talks.id', 'languages.language_value', 'start_time_call', 'end_time_call', 'headline', 'talk_type', 'call_type', 'duration', 'weekday', 'max_participiants', 'anonym_call', 'price', 'teacher_name', 'teacher_username', 'teacher_profile_picture')
            ->selectRaw('
                    reviews as total_reviews,
                    CASE WHEN reviews > 0 THEN ROUND(ratings::NUMERIC / reviews::NUMERIC, 1) ELSE 0 END AS ratings
                ')
            ->where('teacher_user_id', '!=', $loggedUser)
            ->where('state', Talk::STATE['valid'])
            /* Talk Type Change */
            // ->where('talk_type', Talk::TALK_TYPE['face_to_face'])
            ->where('call_type', CallTypes::ONE_TO_ONE)
            ->leftJoinSub($user, 'users', function ($join) {
                $join->on('users.id', '=', 'talks.teacher_user_id');
            })
            ->leftJoinSub($languages, 'languages', function ($join) {
                $join->on('languages.id', '=', 'talks.languages_id');
            });

//        // Filter condition for type
//        if(!empty($filter['type'])) {
//            if ($filter['type']['private'] && !$filter['type']['group']) {
//                $talks->where('talk_type', Talk::TALK_TYPE['face_to_face']);
//
//            } elseif (!$filter['type']['private'] && $filter['type']['group']) {
//                $talks->where('talk_type', Talk::TALK_TYPE['group']);
//
//            } elseif ($filter['type']['private'] && $filter['type']['group']) {
//                $talks->where(function ($query) {
//                    $query->where('talk_type', Talk::TALK_TYPE['face_to_face']);
//                    $query->orWhere('talk_type', Talk::TALK_TYPE['group']);
//                });
//
//            }
//        }
//
//        // Filter condition for price range
//        if(!empty($filter['priceRange'])) {
//            if ($filter['priceRange']['1_10'] || $filter['priceRange']['10_50'] || $filter['priceRange']['over50'] || $filter['priceRange']['over100']) {
//                $talks->where(function ($query) use ($filter) {
//                    if ($filter['priceRange']['1_10']) {
//                        $query->orWhere(function ($query2) {
//                            $query2->where('talks.price', '>=', 1);
//                            $query2->where('talks.price', '<=', 10);
//                        });
//                    }
//
//                    if ($filter['priceRange']['10_50']) {
//                        $query->orWhere(function ($query2) {
//                            $query2->where('talks.price', '>=', 10);
//                            $query2->where('talks.price', '<=', 50);
//                        });
//                    }
//
//                    if ($filter['priceRange']['over50']) {
//                        $query->orWhere(function ($query2) {
//                            $query2->where('talks.price', '>=', 50);
//                        });
//                    }
//
//                    if ($filter['priceRange']['over100']) {
//                        $query->orWhere(function ($query2) {
//                            $query2->where('talks.price', '>=', 100);
//                        });
//                    }
//                });
//            }
//        }
//
//        // Filter condition for order by
//        if(!empty($filter['order_by'])) {
//            $param = $filter['order_by'];
//            if($param == 'rating') {
//                $param = 'ratings';
//            }
//            if($filter['order_by_type'] == 'DESC') {
//                $talks->orderByDesc($param);
//            } else {
//                $talks->orderBy($param);
//            }
//        }
//
//        // Filter condition for duration
//        if(!empty($filter['duration'])) {
//            $talks->where(function ($query) use ($filter) {
//                foreach ($filter['duration'] as $key => $duration) {
//                    $query->orWhere('duration', $duration);
//                }
//            });
//        }
//
//        // Filter condition for availability
//        if(!empty($filter['availability'])) {
//            if ($filter['availability']['monday'] ||
//                $filter['availability']['tuesday'] ||
//                $filter['availability']['wednesday'] ||
//                $filter['availability']['thursday'] ||
//                $filter['availability']['friday'] ||
//                $filter['availability']['saturday'] ||
//                $filter['availability']['sunday']
//            ) {
//
//                $teacherAvailability = \App\Models\Availability::query()
//                    ->where('state', Availability::STATE['valid'])
//                    ->where('user_id', '!=', $loggedUser)
//                    ->where(function ($query) use ($filter) {
//                        if ($filter['availability']['monday']) {
//                            $query->orWhere(function ($query) {
//                                $query->where('weekday', 1);
//                            });
//                        }
//                        if ($filter['availability']['tuesday']) {
//                            $query->orWhere(function ($query) {
//                                $query->where('weekday', 2);
//                            });
//                        }
//                        if ($filter['availability']['wednesday']) {
//                            $query->orWhere(function ($query) {
//                                $query->where('weekday', 3);
//                            });
//                        }
//                        if ($filter['availability']['thursday']) {
//                            $query->orWhere(function ($query) {
//                                $query->where('weekday', 4);
//                            });
//                        }
//                        if ($filter['availability']['friday']) {
//                            $query->orWhere(function ($query) {
//                                $query->where('weekday', 5);
//                            });
//                        }
//                        if ($filter['availability']['saturday']) {
//                            $query->orWhere(function ($query) {
//                                $query->where('weekday', 6);
//                            });
//                        }
//                        if ($filter['availability']['sunday']) {
//                            $query->orWhere(function ($query) {
//                                $query->where('weekday', 7);
//                            });
//                        }
//                    })
//                    ->get()
//                    ->pluck('user_id')
//                    ->toArray();
//
//                $talks->where(function ($query) use ($filter, $teacherAvailability) {
//                    if ($filter['availability']['monday']) {
//                        $query->orWhere(function ($query) {
//                            $query->where('weekday', 1);
//                        });
//                    }
//                    if ($filter['availability']['tuesday']) {
//                        $query->orWhere(function ($query) {
//                            $query->where('weekday', 2);
//                        });
//                    }
//                    if ($filter['availability']['wednesday']) {
//                        $query->orWhere(function ($query) {
//                            $query->where('weekday', 3);
//                        });
//                    }
//                    if ($filter['availability']['thursday']) {
//                        $query->orWhere(function ($query) {
//                            $query->where('weekday', 4);
//                        });
//                    }
//                    if ($filter['availability']['friday']) {
//                        $query->orWhere(function ($query) {
//                            $query->where('weekday', 5);
//                        });
//                    }
//                    if ($filter['availability']['saturday']) {
//                        $query->orWhere(function ($query) {
//                            $query->where('weekday', 6);
//                        });
//                    }
//                    if ($filter['availability']['sunday']) {
//                        $query->orWhere(function ($query) {
//                            $query->where('weekday', 7);
//                        });
//                    }
//
//                    if (!empty($teacherAvailability)) {
//                        $query->whereIn('teacher_user_id', $teacherAvailability);
//                    }
//
//                });
//            }
//        }
//
//        // Filter condition for anon talks
//        if ($filter['anonTalks'] == false) {
//            $talks->where('anonym_call', Talk::ANONYM_CALL['not_allowed']);
//        } elseif ($filter['anonTalks'] === true) {
//            $talks->where('anonym_call', Talk::ANONYM_CALL['allowed']);
//        } else {
//        }
//
//        // Filter condition for length
//        if(!empty($filter['talks'])) {
//            if (!empty($filter['talks']['length'])) {
//                $talks->whereIn('call_type', $filter['talks']['length']);
//            }
//
//            // Filter condition for availability
//            if ($filter['talks']['video'] || $filter['talks']['voice']) {
//                $talks->where(function ($query) use ($filter) {
//                    if ($filter['talks']['voice']) {
//                        $query->orWhere(function ($query) {
//                            $query->where('call_type', Talk::CALL_TYPE['voice_call']);
//                        });
//                    }
//                    if ($filter['talks']['video']) {
//                        $query->orWhere(function ($query) {
//                            $query->where('call_type', Talk::CALL_TYPE['video_call']);
//                        });
//                    }
//                });
//            }
//        }
//
//        // Filter condition for languages
//        if (!empty($filter['language_id'])) {
//            $talks->where('languages_id', $filter['language_id']);
//        }


        $time  = time();

        $monthRequested = date('Y-m', $time);

        $months     = [
            1  => 'Jan',
            2  => 'Feb',
            3  => 'Mar',
            4  => 'Apr',
            5  => 'May',
            6  => 'Jun',
            7  => 'Jul',
            8  => 'Aug',
            9  => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
        ];

        $last12Months = date('Y-m', strtotime("-11 months", $time));

        $monthCondition     = [];
        $aMonthsForChart    = [];
        $aMonthsBookedTalks  = [];
        $aMonthsRevenue     = [];

        while(strtotime($last12Months) <= strtotime($monthRequested)) {
            $aMonthsForChart[] = date('M', strtotime($last12Months));

            $monthsByName[date('M', strtotime($last12Months))] = null;
            $aMonthsBookedTalks[date('Y-m', strtotime($last12Months))] = 0;
            $aMonthsRevenue[date('Y-m', strtotime($last12Months))] = 0;

            $monthCondition[] = date('Y-m', strtotime($last12Months));

            $last12Months = date('Y-m', strtotime("+1 months", strtotime($last12Months)));
        }


        $nTotalCustomersThisMonth   = User::query()->whereMonth('created_at', date('m'))
                                                   ->whereYear('created_at', date('Y'))
                                                   ->count();

        $oBookingThisMonth          = Booking::query()->selectRaw('SUM(price) AS total_all, count(*) as "totalBookingsCount"')
                                                      ->whereMonth('start_call', date('m'))
                                                      ->whereYear('start_call', date('Y'))
                                                      ->where('state', 1)
                                                      ->first();

        $oNextTalkBookings        = Booking::query()->whereDate('start_call', '>', '2020-07-29')
                                                      ->where('state', 1)
                                                      ->get();

        $oBooking = Booking::query()->selectRaw("TO_CHAR(start_call,'YYYY-MM') as date_period, count(*) as count, SUM(price) AS total_price")
                                    ->whereRaw("TO_CHAR(start_call,'YYYY-MM') IN ('".implode('\',\'',$monthCondition)."')")
                                    ->groupByRaw("TO_CHAR(start_call,'YYYY-MM')")
                                    ->where('state', 1)
                                    ->get();
        foreach($oBooking as $booking) {
            if(array_key_exists($booking->date_period, $aMonthsBookedTalks)) {
                $aMonthsBookedTalks[$booking->date_period] = $booking->count;
                $aMonthsRevenue[$booking->date_period] = $booking->total_price;
            }
        }


        $series = [
            [
                'name' => 'Database Booked Talks',
                'data' => array_values($aMonthsBookedTalks),
            ],
            [
                'name' => 'Commission',
                'data' => array_values([76, 85, 101, 98, 87, 105, 91, 114, 94, 100, 110, 96]),
            ],
            [
                'name' => 'Revenue',
                'data' => array_values($aMonthsRevenue)
            ]
        ];

        $users = User::selectRaw("count(case when deleted_at is null then 1 end) as active")
        ->selectRaw("count(case when verified = '1' then 1 end) as verified")
        ->selectRaw("count(case when verified = '1' then 1 end) as supplier")
        ->selectRaw("count(case when visibility = '1' then 1 end) as private")
        ->first();

        foreach($oBooking as $booking) {
            $aBookedTalks[$months[date('n', strtotime($booking->start_call))]] = $booking->price > 0 ? round($booking->price) : null;
        }

        return view('home', compact('nTotalCustomersThisMonth', 'oNextTalkBookings', 'oBookingThisMonth', 'aMonthsForChart', 'series', 'users'));
    }
}
