<?php

namespace App\Repository;

use App\Library\DBLibrary;
use PDO;

/**
 * Repository.
 */
final class SentimentOverTimeReaderRepository
{

    /**
     * $db library
     *
     * @var mixed
     */
    private $dbLibrary;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection, DBLibrary $dbLibrary)
    {
        $this->connection = $connection;
        $this->dbLibrary = $dbLibrary;
    }

    /**
     * sp get sot for date
     *
     * @param mixed $data
     * 
     * @return mixed
     */
    public function spGetSotForDate($data)
    {
        $query = "CALL sp_get_sot_for_date(?)";

        return $this->dbLibrary->getAllRecords($query, $data);
    }
}
