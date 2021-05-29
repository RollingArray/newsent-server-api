<?php

/**
 * © Rolling Array https://rollingarray.co.in/
 *
 *
 * @summary Feed reader repository
 * @author code@rollingarray.co.in
 *
 * Created at     : 2021-05-29 14:02:24 
 * Last modified  : 2021-05-29 14:02:51
 */

namespace App\Repository;

use App\Library\DBLibrary;
use App\Library\ResponseGeneratorLib;
use DomainException;
use PDO;

/**
 * Repository.
 */
class FeedReaderRepository
{
   
    /**
     * $db library
     *
     * @var mixed
     */
    private $dbLibrary;


    /**
     * $response generator lib
     *
     * @var mixed
     */
    private $responseGeneratorLib;

    /**
     * constructor
     *
     * @param PDO $connection
     * @param DBLibrary $dbLibrary
     * @param ResponseGeneratorLib $responseGeneratorLib
     */
    public function __construct(PDO $connection, DBLibrary $dbLibrary, ResponseGeneratorLib $responseGeneratorLib)
    {
        $this->connection = $connection;
        $this->dbLibrary = $dbLibrary;
        $this->responseGeneratorLib = $responseGeneratorLib;
    }

    /**
     * Get user by the given user id.
     *
     * @param int $userId The user id
     *
     * @throws DomainException
     *
     * @return UserReaderData The user data
     */

    public function getAllFeedsPostDate(string $dateTime)
    {
        $rows = $this->spGetAllFeedsPostDate($dateTime);
        $tempRows = array();

        foreach ($rows as $eachData) {
            $tempRows[] = $this->responseGeneratorLib->generateKeyValueStructure($eachData);
        }

        return $this->responseGeneratorLib->generateServiceReturnDataStructure($tempRows);
    }


    /**
     * sp get all feeds post date
     *
     * @param string $createdAt
     * 
     * @return mixed
     */
    private function spGetAllFeedsPostDate (string $createdAt){

        $data = [
            $createdAt
        ];
        $query = "CALL sp_get_all_feeds_post_date(?)";
        return $this->dbLibrary->getAllRecords($query, $data);
    }
}
