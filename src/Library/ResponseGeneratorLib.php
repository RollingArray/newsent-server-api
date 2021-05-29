<?php

namespace App\Library;

/**
 * Repository.
 */
class ResponseGeneratorLib
{

    /**
     * construct
     *
     */
    public function __construct()
    {
        //
    }

    
    /**
     * generate key value structure
     *
     * @param mixed $data
     * 
     * @return mixed
     */
    public function generateKeyValueStructure($data)
    {
        $tempRows = array();
        foreach ($data as $key => $value) {
            //$keyName = $this->extractKeyName($key);
            $tempRows[$key] = $value;
        }

        return $tempRows;
    }

    
    /**
     * generate service return data structure
     *
     * @param mixed $passedData
     * 
     * @return mixed
     */
    public function generateServiceReturnDataStructure($passedData)
    {
        $responseData = array();

        //echo "$passedData".json_encode($passedData);

        if ($passedData) {
            $responseData['success'] = true;
            $responseData['data'] = $passedData;
        } else {
            $responseData['success'] = false;
        }


        return $responseData;
    }
}
