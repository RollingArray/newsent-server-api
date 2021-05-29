<?php

namespace App\Service;

use App\Library\ToneLibrary;
use App\Repository\SentimentOverTimeCreatorRepository;

/**
 * Service.
 */
final class SentimentOverTimeCreator
{
    private $sentimentOverTimeCreatorRepository;

    private $toneLibrary;

    public function __construct(SentimentOverTimeCreatorRepository $sentimentOverTimeCreatorRepository, ToneLibrary $toneLibrary )
    {
        $this->sentimentOverTimeCreatorRepository = $sentimentOverTimeCreatorRepository;
        $this->toneLibrary = $toneLibrary;
    }

    /**
     * generates sentiment over time
     *
     * @return mixed
     */
    public function generateSentimentOverTime()
    {
        $rows = $this->sentimentOverTimeCreatorRepository->getSpAllUniqueDates();
        $tempRows = [];
        $timeStopGapSeries = $this->toneLibrary->timeStopGapSeries();

        foreach ($rows as $eachData) {
            foreach ($timeStopGapSeries as $eachTimeStopGap) {
                $data = [
                    $eachData['dateIst'],
                    $eachTimeStopGap['start'],
                    $eachTimeStopGap['end'],
                ];

                // save dominant tone for each stop gap for a day 
                $sentimentOverTime = [
                    $eachData['dateIst'],
                    $eachTimeStopGap['key'],
                    $this->curatePotentialTimeForEachStopGapDate($data)
                ];
                $this->sentimentOverTimeCreatorRepository->spInsertNewSot($sentimentOverTime);
            }
            $tempRows[] = $eachData;
        }
        return true;
    }

    /**
     * curate potential time for each stop gap date
     *
     * @param mixed $data
     * 
     * @return mixed
     */
    private function curatePotentialTimeForEachStopGapDate($data){
        $rows = $this->sentimentOverTimeCreatorRepository->spGetTonesInBetweenDateTime($data);
        $tempRows = [];
        foreach ($rows as $eachData) {
            $tempRows[] = $this->toneLibrary->formatSentimentScore((float)$eachData['tone']);
        }
        $numberOfElements = sizeof($tempRows);
        if($numberOfElements){
            $findDominantTone = $this->toneLibrary->findDominantTone($tempRows, sizeof($tempRows));
        }
        else{
            $findDominantTone = 0.0; // nutra tone
        }
        return $findDominantTone;
    }
    
    

    /**
     * Read a user by the given user id.
     *
     * @param int $userId The user id
     *
     * @throws ValidationException
     *
     * @return UserReaderData The user data
     */
    public function getAllFeedsPostDate(string $createdAt)
    {
        // Validation
        // if (empty($userId)) {
        //     throw new ValidationException('User ID required');
        // }

        return $this->feedReaderRepository->getAllFeedsPostDate($createdAt);
    }
}