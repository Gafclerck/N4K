<?php

namespace Utils;

class DateTimeUtils
{
    public static function formatDate(\DateTime $date, string $format = "d/m/Y H:i:s"): string
    {
        return $date->format($format);
    }

    public static function parseDate(string $dateString, string $format = "Y-m-d H:i:s"): \DateTime
    {
        return \DateTime::createFromFormat($format, $dateString);
    }
}