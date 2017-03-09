<?php

// Author: Andrew Jarombek
// Date: 2/27/2017
// Utility Functions for the API

// Class With Utility Functions for the API
class APIUtils 
{
	// Return the first day of this week (Sunday or Monday)
	public static function firstDayOfWeek($week_start = 'monday') 
    {
    	$monday = strtotime('last '. $week_start, strtotime('tomorrow'));
    	return date('Y-m-d', $monday);
    }

    // Return the first day of this month
    public static function firstDayOfMonth()
    {
    	return date('Y-m-01');
    }

    // Return the first day of this year
    public static function firstDayOfYear()
    {
    	$firstday = strtotime('first day of january this year');
    	return date('Y-m-d', $firstday);
    }
}