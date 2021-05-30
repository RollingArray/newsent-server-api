<?php

namespace App\Repository;

use App\Library\DBLibrary;
use PDO;

/**
 * Repository.
 */
final class SentimentOverTimeCreatorRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

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
     * sp insert new sot
     *
     * @param mixed $data
     * 
     * @return mixed
     */
    public function spInsertNewSot($data)
    {
		$query = "CALL sp_insert_new_sot(?,?,?)";

        return $this->dbLibrary->executeStatement($query, $data);
    }

    /**
     * get all unique dates
     *
     * @return mixed
     */
    public function getSpAllUniqueDates()
    {
        $data = [];

        $query = "CALL sp_get_unique_date()";

        return $this->dbLibrary->getAllRecords($query, $data);
    }

	/**
	 * sp get tones in between date time
	 *
	 * @param mixed $data
	 * 
	 * @return mixed
	 */
	public function spGetTonesInBetweenDateTime($data)
    {
        $query = "CALL sp_get_tones_in_between_date_time(?,?,?)";

        return $this->dbLibrary->getAllRecords($query, $data);
    }

	
}
