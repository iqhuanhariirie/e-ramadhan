<?php

use Carbon\Carbon;

/**
 * Get array of date list.
 *
 * @return array
 */
function get_dates()
{
    $dates = [];
    foreach (range(1, 31) as $date) {
        $date = str_pad($date, 2, 0, STR_PAD_LEFT);
        $dates[$date] = $date;
    }

    return $dates;
}

/**
 * Get array of month list.
 *
 * @return array
 */
function get_months()
{
    return [
        '01' => __('time.months.01'),
        '02' => __('time.months.02'),
        '03' => __('time.months.03'),
        '04' => __('time.months.04'),
        '05' => __('time.months.05'),
        '06' => __('time.months.06'),
        '07' => __('time.months.07'),
        '08' => __('time.months.08'),
        '09' => __('time.months.09'),
        '10' => __('time.months.10'),
        '11' => __('time.months.11'),
        '12' => __('time.months.12'),
    ];
}

/**
 * Get array of year list starting from 2018.
 *
 * @return array
 */
function get_years()
{
    $yearRange = range(2020, date('Y'));
    foreach ($yearRange as $year) {
        $years[$year] = $year;
    }

    return $years;
}

/**
 * Get two digits of month.
 *
 * @param  int|string  $number
 * @return string
 */
function month_number($number)
{
    return str_pad($number, 2, '0', STR_PAD_LEFT);
}

/**
 * Get month name from given month number.
 *
 * @param  int|string  $monthNumber
 * @return string
 */
function month_id($monthNumber)
{
    if (is_null($monthNumber)) {
        return $monthNumber;
    }

    $months = get_months();
    $monthNumber = month_number($monthNumber);

    return $months[$monthNumber];
}

function get_date_range_per_week(string $startDate, string $endDate, string $startDay = 'monday'): array
{
    $periode = new \DatePeriod(
        $startDate = Carbon::parse($startDate),
        new \DateInterval('P1D'),
        Carbon::parse($endDate)->endOfMonth()
    );

    $dateRanges = [];
    $dateKey = $startDate->format('dmY');
    $dateRanges[$dateKey] = [];
    foreach ($periode as $date) {
        if (strtolower($date->format('l')) == $startDay) {
            $dateKey = $date->format('dmY');
        }
        $dateRanges[$dateKey][] = $date->format('Y-m-d');
    }

    return array_values(array_filter($dateRanges));
}
