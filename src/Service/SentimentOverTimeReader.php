<?php

namespace App\Service;

use App\Library\ToneLibrary;
use App\Repository\SentimentOverTimeReaderRepository;

/**
 * Service.
 */
final class SentimentOverTimeReader
{
    /**
     * sentiment over time reader repository
     *
     * @var mixed
     */
    private $sentimentOverTimeReaderRepository;

    private $toneLibrary;

    /**
     * __construct
     *
     * @param SentimentOverTimeReaderRepository $sentimentOverTimeReaderRepository
     */
    public function __construct(SentimentOverTimeReaderRepository $sentimentOverTimeReaderRepository, ToneLibrary $toneLibrary)
    {
        $this->sentimentOverTimeReaderRepository = $sentimentOverTimeReaderRepository;

        $this->toneLibrary = $toneLibrary;
    }

    /**
     * generates sentiment over time
     *
     * @return mixed
     */
    public function generateSentimentOverTime($data)
    {
        return array(
            "timeSeries" => $this->getStopGap(),
            "scoreSeries" => $this->getToneForEachStopGap($data)
        );
    }

    /**
     * get stop gap
     *
     * @return mixed
     */
    private function getStopGap()
    {
        $timeSeries = [];
        $timeStopGapSeries = $this->toneLibrary->timeStopGapSeries();
        foreach ($timeStopGapSeries as $eachTimeStopGap) {
            $timeSeries[] = $eachTimeStopGap['key'];
        }

        return $timeSeries;
    }

    /**
     * get tone for each stop gap
     *
     * @param mixed $rows
     * 
     * @return mixed
     */
    private function getToneForEachStopGap($data)
    {
        $rows = $this->sentimentOverTimeReaderRepository->spGetSotForDate($data);
        $scoreSeries = [];
        $timeStopGapSeries = $this->toneLibrary->timeStopGapSeries();
        foreach ($rows as $eachData) {
            foreach ($timeStopGapSeries as $eachTimeStopGap) {
                if($eachData['time'] === $eachTimeStopGap['key']){
                    $scoreSeries[] = $eachData['tone'];
                }
            }
        }

        return $scoreSeries;
    }
}