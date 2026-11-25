<?php

use App\Models\StaticProfession;
use Illuminate\Support\Carbon;

const shortWeek          = 'l';
const day                = 'd';
const hourMinuteWithAMPM = 'g:i A';
const weekMonthDay       = 'l, F jS';

function getLocalTimeZone()
{
    return isset($_COOKIE['timezone']) ? $_COOKIE['timezone'] : '';
}

function getLocalTimeZoneName()
{
    $timezone = request()->user()->timezone ?: null;
    $date     = \Carbon\Carbon::now();
    $date->utcOffset($timezone);
    return $date->tzName;
}

function changeDateFormat($format, $date)
{
    $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date);
    return \Carbon\Carbon::parse($date)->format($format);
}

function getTimeZonedDate($format, $date)
{
    /* $timeZoneOffset = getLocalTimeZone();

     if ($timeZoneOffset > 0) {
        $timeCorrection = '+' . $timeZoneOffset . " minutes";
    } else {
        $timeCorrection = '-' . (int)($timeZoneOffset) . " minutes";
    } */
    $timeCorrection = "+0 minutes";

    return date(
        $format,
        strtotime(
            $timeCorrection,
            strtotime($date)
        )
    );
}

function getTimeZonedDate2($format, $date)
{
    $timeZoneOffset = getLocalTimeZone();

    if ($timeZoneOffset > 0) {
        $timeCorrection = '+' . $timeZoneOffset . " minutes";
    } else {
        $timeCorrection = '-' . (int)($timeZoneOffset) . " minutes";
    }
    $timeCorrection = "+0 minutes";

    return date(
        $format,
        strtotime(
            $timeCorrection,
            strtotime($date)
        )
    );
}

function floatFormater($number,$numberOfDecimals){
    if (session('language') == 'en') {
        return number_format((float)$number, $numberOfDecimals, '.', ',');
    }

    return (float)$number == 0 ? 0 : number_format((float)$number, $numberOfDecimals, ',', '.');
}

function priceFormater($number, $noEuroSign = false)
{
    $euroChar = ' €';

    if ($noEuroSign) {
        $euroChar = '';
    }

    if (session('language') == 'en') {
        return number_format((float)$number, 2, '.', ',') . $euroChar;
    }

    return number_format((float)$number, 2, ',', '.') . $euroChar;
}

function changeDateStringFormat($inputFormat, $outputformat, $date)
{
    $dateTime = datetime::createfromformat($inputFormat, $date);
    return $dateTime->format($outputformat);
}

function changeDateFormatLocale($format, $date, $year = null)
{
    $formatter = new IntlDateFormatter(session('language'), IntlDateFormatter::FULL, IntlDateFormatter::FULL);

    $d = DateTime::createFromFormat($format, $date);

    $pieces = explode(" ", $formatter->format($d));

    if (session('language') == 'en') {
        $num    = substr($pieces[2], 0, -1);
        $nf     = new NumberFormatter(session('language'), NumberFormatter::ORDINAL);
        $number = $nf->format($num);
    } else {
        $number = $pieces[2];
    }

    if ($year) {
        $year = ', ' . $pieces[3];
    }
    return ucfirst($pieces[0]) . ' ' . $pieces[1] . ' ' . $number . $year;
}

function changeDateFormatLocaleDay($format, $date)
{
    $formatter = new IntlDateFormatter(session('language'), IntlDateFormatter::FULL, IntlDateFormatter::FULL);

    $d = DateTime::createFromFormat($format, $date);

    $pieces = explode(" ", $formatter->format($d));

    if (session('language') == 'en') {
        $num    = substr($pieces[2], 0, -1);
        $nf     = new NumberFormatter(session('language'), NumberFormatter::ORDINAL);
        $number = $nf->format($num);
    } else {
        $number = $pieces[2];
    }

    return ucfirst($pieces[0]);
}

function getTimeDifferentMinuteFormat($start, $end)
{
    $startTime = \Carbon\Carbon::parse($start);
    $endTime   = \Carbon\Carbon::parse($end);

    $totalDuration = $endTime->diffInMinutes($startTime);

    return $totalDuration;
}

if (! function_exists('convertToUserTimezone')) {
    /**
     * Converts date to another timezone.
     *
     * @param  string       $date    Initial date.
     * @param  string|null  $format  Date format.
     *
     * @return Carbon|string Converted date.
     */
    function convertToUserTimezone(string $date, ?string $format = null)
    {
        $converted_data = Carbon::parse($date)->addMinutes((int) (request()->user() ? request()->user()->timezone : 0));

        if ($format) {
            return $converted_data->format($format);
        }

        return $converted_data;
    }
}

if (! function_exists('getTimezoneAbbreviation')) {
    /**
     * Return Timezone Abbreviation depending on the users' timezone offset.
     *
     * @return false|string|null
     */
    function getTimezoneAbbreviation()
    {
        $timezone = request()->header('Time-Zone-Offset-UTC') ?: (request()->user() ? request()->user()->timezone : 0);
        $hours    = $timezone / 60;
        $minutes  = str_pad($timezone % 60, 2, 0);
        $seconds  = $hours * 60 * 60 + $minutes * 60;

        return timezone_name_from_abbr('', $seconds, 1) ?: null;
    }
}

if (! function_exists('isMobileApp')) {
    /**
     * Determine if the request came from Mobile Application.
     *
     * @return bool
     */
    function isMobileApp(): bool
    {
        return request()->header('Is-Mobile-App', false);
    }
}

if (! function_exists('userLanguage')) {
    /**
     *  Return user language preference.
     *
     * @return string
     */
    function userLanguage()
    {
        return StaticProfession::DATABASE_LANGUAGE[request()->header('Application-Language', request()->user() ? request()->user()->last_language : 'en')];
    }
}
