<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Utility;

use Eden\Utility\Timezone\Argument as TimezoneArgument;
use Eden\Utility\Timezone\Validation;

/**
 * Timezone convert-o-matic
 *
 * @vendor Eden
 * @package Utility
 * @author Christian Blanquera cblanquera@openovate.com
 */
class Timezone extends Base 
{
    const GMT = 'GMT';
    const UTC = 'UTC';

    protected $offset = null;
    protected $time = null;

    /**
     * Preset the timezone and time
     *
     * @param *string
     * @param int|string|null
     */
    public function __construct($zone, $time = null)
    {
        TimezoneArgument::i()
            ->test(1, 'string')                  //argument 1 must be a string
            ->test(1, 'location', 'utc', 'abbr') //argument 2 must be a timezone indeicator
            ->test(2, 'int', 'string', 'null');  //argument 3 must be an integer, string or null

        if(is_null($time)) {
            $time = time();
        }

        $this->offset 	= $this->calculateOffset($zone);
        $this->setTime($time);
    }

    /**
     * Convert current time set here to another time zone
     *
     * @param *string valid UTC, GMT, PHP Location or TZ Abbreviation
     * @param string|null
     * @return string|int
     */
    public function convertTo($zone, $format = null)
    {
        TimezoneArgument::i()
            ->test(1, 'string')                  //argument 1 must be a string
            ->test(1, 'location', 'utc', 'abbr') //argument 1 must be a timezone identifier
            ->test(2, 'string', 'null');         //argument 2 must be a string or null

        $time = $this->time + $this->calculateOffset($zone);

        if(!is_null($format)) {
            return date($format, $time);
        }

        return $time;
    }

    /**
     * Returns the GMT Format
     *
     * @param string
     * @return string
     */
    public function getGMT($prefix = self::GMT)
    {
        //argument must be a string
        TimezoneArgument::i()->test(1, 'string');

        list($hour, $minute, $sign) = $this->getUtcParts($this->offset);
        return $prefix.$sign.$hour.$minute;
    }

    /**
     * Returns a list of GMT formats and dates in a 24 hour period
     *
     * @param *string
     * @param int
     * @param string|null
     * @return array
     */
    public function getGMTDates($format, $interval = 30, $prefix = self::GMT)
    {
        TimezoneArgument::i()
            ->test(1, 'string')          //argument 1 must be a string
            ->test(2, 'int')             //argument 2 must be an integer
            ->test(3, 'string', 'null'); //argument 3 must be a string or null

        $offsets 	= $this->getOffsetDates($format, $interval);
        $dates 		= array();

        foreach($offsets as $offset => $date) {
            list($hour, $minute, $sign) = $this->getUtcParts($offset);
            $gmt = $prefix.$sign.$hour.$minute;
            $dates[$gmt] = $date;
        }

        return $dates;
    }

    /**
     * Returns the current offset of this timezone
     *
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Returns a list of offsets and dates in a 24 hour period
     *
     * @param *string
     * @param int
     * @return array
     */
    public function getOffsetDates($format, $interval = 30)
    {
        TimezoneArgument::i()
            ->test(1, 'string') //argument 1 must be a string
            ->test(2, 'int');   //argument 2 must be an integer

        $dates = array();
        $interval *= 60;

        for($i=-12*3600; $i <= (12*3600); $i+=$interval) {
            $time = $this->time + $i;
            $dates[$i] = date($format, $time);
        }

        return $dates;
    }

    /**
     * Returns the time or date
     *
     * @param string|null
     * @return string|int
     */
    public function getTime($format = null)
    {
        //argument 1 must be a string or null
        TimezoneArgument::i()->test(1, 'string', 'null');

        $time = $this->time + $this->offset;

        if(!is_null($format)) {
            return date($format, $time);
        }

        return $time;
    }

    /**
     * Returns the UTC Format
     *
     * @param string|null
     * @return string
     */
    public function getUTC($prefix = self::UTC)
    {
        //argument 1 must be a string
        TimezoneArgument::i()->test(1, 'string');

        list($hour, $minute, $sign) = $this->getUtcParts($this->offset);
        return $prefix.$sign.$hour.':'.$minute;
    }

    /**
     * Returns a list of UTC formats and dates in a 24 hour period
     *
     * @param *string
     * @param int
     * @param string|null
     * @return array
     */
    public function getUTCDates($format, $interval = 30, $prefix = self::UTC)
    {
        TimezoneArgument::i()
            ->test(1, 'string')          //argument 1 must be a string
            ->test(2, 'int')             //argument 2 must be an integer
            ->test(3, 'string', 'null'); //argument 3 must be a string or null

        $offsets 	= $this->getOffsetDates($format, $interval);
        $dates 		= array();

        foreach($offsets as $offset => $date) {
            list($hour, $minute, $sign) = $this->getUtcParts($offset);
            $utc = $prefix.$sign.$hour.':'.$minute;
            $dates[$utc] = $date;
        }

        return $dates;
    }

    /**
     * Sets a new time
     *
     * @param int|string
     * @return Eden\Utility\Timezone
     */
    public function setTime($time)
    {
        //argument 1 must be an integer or string
        TimezoneArgument::i()->test(1, 'int', 'string');
        if(is_string($time)) {
            $time = strtotime($time);
        }

        $this->time = $time - $this->offset;
        return $this;
    }

    /**
     * Returns timezone's validation methods
     *
     * @return Eden\Utility\Timezone\Validation
     */
    public function validation()
    {
        return Validation::i();
    }

    /**
     * returns the offset based on timezone
     *
     * @param string
     * @return string
     */
    protected function calculateOffset($zone)
    {
        if($this->validation()->isLocation($zone)) {
            return $this->getOffsetFromLocation($zone);
        }

        if($this->validation()->isUtc($zone)) {
            return $this->getOffsetFromUtc($zone);
        }

        if($this->validation()->isAbbr($zone)) {
            return $this->getOffsetFromAbbr($zone);
        }

        return 0;
    }

    /**
     * returns the offset based using the
     * timezone abbreviation
     *
     * @param string
     * @return string
     */
    protected function getOffsetFromAbbr($zone)
    {
        $zone = timezone_name_from_abbr(strtolower($zone));
        return $this->getOffsetFromLocation($zone);
    }

    /**
     * returns the offset based on location
     *
     * @param string
     * @return string
     */
    protected function getOffsetFromLocation($zone)
    {
        $zone = new \DateTimeZone($zone);
        $gmt = new \DateTimeZone(self::GMT);

        return $zone->getOffset(new \DateTime('now', $gmt));
    }

    /**
     * returns the offset based on UTC
     *
     * @param string
     * @return string
     */
    protected function getOffsetFromUtc($zone)
    {
        $zone 	= str_replace(array('GMT','UTC'), '', $zone);
        $zone 	= str_replace(':', '', $zone);

        $add 	= $zone[0] == '+';
        $zone 	= substr($zone, 1);

        switch(strlen($zone)) {
            case 1:
            case 2:
                return $zone * 3600 * ($add?1:-1);
            case 3:
                $hour 	= substr($zone, 0, 1) * 3600;
                $minute = substr($zone, 1) * 60;
                return ($hour+$minute) * ($add?1:-1);
            case 4:
                $hour 	= substr($zone, 0, 2) * 3600;
                $minute = substr($zone, 2) * 60;
                return ($hour+$minute) * ($add?1:-1);

        }

        return 0;
    }

    /**
     * returns the UTC meta based on offset
     *
     * @param int
     * @return string
     */
    private function getUtcParts($offset)
    {
        $minute = '0'.(floor(abs($offset/60)) % 60);

        return array(
            floor(abs($offset/3600)),
            substr($minute, strlen($minute)-2),
            $offset < 0 ? '-':'+');
    }
}