<?php


namespace App\Library;

use PDO;

/**
 * database library for common operation
 */
final class DBLibrary
{
	/**
	 * $connection
	 *
	 * @var mixed
	 */
	private $connection;


	/**
	 * construct
	 *
	 * @param PDO $connection
	 */
	public function __construct(PDO $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * get all records
	 *
	 * @param mixed $query
	 * @param mixed $data
	 * 
	 * @return mixed
	 */
	public function getAllRecords($query, $data)
	{
		$queryResponse = $this->connection->prepare($query);
		$rowsEffected = $queryResponse->execute($data);
		if (!$rowsEffected) {
			echo 'PDO::errorInfo():';
			echo '<br />';
			echo 'error SQL: ' . $query;
			die();
		}
		$queryResponse->setFetchMode(\PDO::FETCH_ASSOC);
		$responseData = $queryResponse->fetchAll();

		return $responseData;
	}

	/**
	 * if record exist
	 *
	 * @param mixed $query
	 * @param mixed $data
	 * 
	 * @return mixed
	 */
	public function ifRecordExist($query, $data)
	{
		$dataAvailable = false;
		$queryResponse = $this->connection->prepare($query);
		$rowsEffected = $queryResponse->execute($data);
		if (!$rowsEffected) {
			echo 'PDO::errorInfo():';
			echo '<br />';
			echo 'error SQL: ' . $query;
			die();
		}
		$queryResponse->setFetchMode(\PDO::FETCH_ASSOC);
		$responseData = $queryResponse->fetchAll();

		if (count($responseData) > 0) {
			$dataAvailable = true;
		} else {
			$dataAvailable = false;
		}

		return $dataAvailable;
	}


	/**
	 * execute statement
	 *
	 * @param string $query
	 * @param array $data
	 * 
	 * @return mixed
	 */
	public function executeStatement(string $query, array $data)
	{
		$queryResponse = $this->connection->prepare($query);
		$queryResponse->execute($data);

		if (!$queryResponse) {
			echo 'PDO::errorInfo():';
			echo '<br />';
			echo 'error SQL: ' . $query;
			die();
		}

		return $queryResponse;
	}
}
