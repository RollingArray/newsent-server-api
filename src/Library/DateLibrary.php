<?php

namespace App\Library;
use DateTime, DateTimeZone;

/**
 * Service.
 */
final class DateLibrary
{
    
    public function __construct()
    {
        //
    }

    public function convectGMTDateToISTDate($date)
    {
        $date = new DateTime($date, new DateTimeZone('GMT'));
        $date->setTimezone(new DateTimeZone('Asia/Kolkata'));

       return $date->format('Y-m-d');
    }

    public function convectGMTDateToISTTime($date)
    {
        $date = new DateTime($date, new DateTimeZone('GMT'));
        $date->setTimezone(new DateTimeZone('Asia/Kolkata'));

        return $date->format('H:i:s');
    }
}