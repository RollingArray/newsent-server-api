<?php


/**
 * © Rolling Array https://rollingarray.co.in/
 *
 *
 * @summary Feed creator repository
 * @author code@rollingarray.co.in
 *
 * Created at     : 2021-05-29 14:02:24 
 * Last modified  : 2021-05-29 14:04:37
 */

namespace App\Repository;

use App\Library\DBLibrary;
use PDO;

/**
 * Repository.
 */
final class FeedCreatorRepository
{

    /**
     * $db library
     *
     * @var mixed
     */
    private $dbLibrary;

   
    /**
     * constructor
     *
     * @param PDO $connection
     * @param DBLibrary $dbLibrary
     */
    public function __construct(PDO $connection, DBLibrary $dbLibrary)
    {
        $this->connection = $connection;
        $this->dbLibrary = $dbLibrary;
    }

    
    /**
     * insert new feed
     *
     * @param array $feed
     * 
     * @return mixed
     */
    public function insertFeed(array $feed)
    {
        $data = [
            $feed['guid'],
            $feed['title'],
            array_key_exists('description', $feed) ? $feed['description'] : "",
            array_key_exists('image', $feed) ? $feed['image'] : "default",
            $feed['link'],
            $feed['originalPubDate'],
            $feed['dateIst'],
            $feed['timeIst'],
            $feed['tone'],
            $feed['source'],
            array_key_exists('twitterHandle', $feed) ? $feed['twitterHandle'] : "",
            array_key_exists('keywords',$feed) ? $feed['keywords'] : "" 
        ];

        $query = "CALL sp_insert_new_feed(?,?,?,?,?,?,?,?,?,?,?,?)";

        $this->dbLibrary->executeStatement($query, $data);
    }

    /**
     * if feed exist
     *
     * @param string $guid
     * 
     * @return mixed
     */
    public function ifFeedExist(string $guid)
    {
        $data = [
            $guid
        ];

        $query = "CALL sp_feed_exist(?)";

        return $this->dbLibrary->ifRecordExist($query, $data);
    }
}