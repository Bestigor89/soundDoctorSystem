<?php

use Carbon\Carbon;

/**
 * @return string
 */
function base_timezone()
{
    return config('app.base_timezone');
}

/**
 * @return string
 */
function app_timezone()
{
    return config('app.timezone');
}

/**
 * @param $value
 * @return Carbon
 */
function system_datetime_to_display($value)
{
    if (!$value) {
        return null;
    }

    if ($value instanceof DateTime) {
        return Carbon::instance($value)->setTimezone(base_timezone());
    }

    if (is_numeric($value)) {
        return Carbon::createFromTimestamp($value)->setTimezone(base_timezone());
    }

    return Carbon::parse($value, app_timezone())
        ->setTimezone(base_timezone());
}

/**
 * @param string|Carbon|DateTime|null $date
 * @return Carbon|null
 */
function display_date_to_system($date)
{
    if (!$date) {
        return null;
    }

    $appTimezone = config('app.timezone');
    $baseTimezone = config('app.base_timezone');

    if ($date instanceof DateTime) {
        return Carbon::instance($date)->setTimezone($appTimezone);
    }

    if (is_numeric($date)) {
        return Carbon::createFromTimestamp($date)->setTimezone($appTimezone);
    }

    return Carbon::parse($date, $baseTimezone)
        ->setTimezone($appTimezone);
}

/**
 * @return \Illuminate\Support\Carbon
 */
function now_in_base_time_zone()
{
    return now(config('app.base_timezone'));
}
