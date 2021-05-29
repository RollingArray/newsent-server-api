<?php

namespace App\Library;

/**
 * Service.
 */
final class ToneLibrary
{
    
    public function __construct()
    {
        //
    }

    /**
     * find dominant tone
     *
     * @param mixed $elements
     * @param mixed $numberOfElements
     * 
     * @return mixed
     */
    public function findDominantTone($elements, $numberOfElements) 
    { 
        // First we sort the array 
        sort($elements); 
    
        // check for even case 
        if ($numberOfElements % 2 != 0) 
        return (double)$elements[$numberOfElements / 2]; 
        
        return (double)($elements[($numberOfElements - 1) / 2] + 
                        $elements[$numberOfElements / 2]) / 2.0; 
    } 

    /**
     * format sentiment score
     *
     * @param mixed $score
     * 
     * @return mixed
     */
    public function formatSentimentScore($score) {

        $providedScore = $score;

        if( $providedScore >= 0.500000 &&  $providedScore < 0.590000 )
        {
            return -1.0;
        }
        else if( $providedScore >= 0.600000 &&  $providedScore < 0.690000 )
        {
            return -0.5;
        }
        else if( $providedScore >= 0.700000 &&  $providedScore < 0.700000 )
        {
            return 0.0;
        }
        else if( $providedScore >= 0.800000 &&  $providedScore < 0.890000 )
        {
            return 0.5;
        }
        else if( $providedScore >= 0.900000)
        {
            return 1.0;
        }
        else
        {
            return 0.0;
        }
    }

    /**
     * time stop gap series
     *
     * @return mixed
     */
    public function timeStopGapSeries()
    {
        return array(
            array(
                "start" => "00:00:00", 
                "end" => "02:00:00",
                "key" => "2:00 am"
            ), 
            array(
                "start" => "02:01:00", 
                "end" => "04:00:00",
                "key" => "4:00 am"
            ), 
            array(
                "start" => "04:01:00", 
                "end" => "06:00:00", 
                "key" => "6:00 am"
            ), 
            array(
                "start" => "06:01:00", 
                "end" => "08:00:00", 
                "key" => "8:00 am"
            ), 
            array(
                "start" => "08:01:00", 
                "end" =>  "10:00:00", 
                "key" =>  "10:00 am"
            ), 
            array(
                "start" =>  "10:01:00", 
                "end" =>  "12:00:00", 
                "key" =>  "12:00 pm"
            ), 
            array(
                "start" =>  "12:01:00", 
                "end" =>  "14:00:00", 
                "key" =>  "2:00 pm"
            ), 
            array(
                "start" =>  "14:01:00", 
                "end" =>  "16:00:00", 
                "key" =>  "4:00 pm"
            ), 
            array(
                "start" =>  "16:01:00", 
                "end" =>  "18:00:00", 
                "key" =>  "6:00 pm"
            ), 
            array(
                "start" =>  "18:01:00", 
                "end" =>  "20:00:00", 
                "key" =>  "8:00 pm"
            ), 
            array(
                "start" => "20:01:00", 
                "end" =>  "22:00:00", 
                "key" =>  "10:00 pm"
            ), 
            array(
                "start" =>  "22:01:00", 
                "end" =>  "23:59:00", 
                "key" =>  "11:59 pm"
            )
        );
    }
}