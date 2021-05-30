<?php

namespace App\Service;

use Psr\Container\ContainerInterface;
use App\Repository\FeedCreatorRepository;
use App\Exception\ValidationException;
use App\Library\DateLibrary;
use App\Library\MetaLibrary;
use App\Library\UrlLibrary;
use DOMDocument, DateTime, DateTimeZone;

/**
 * Service.
 */
final class FeedCreator
{
    
    /**
     * $feedCreatorRepository
     *
     * @var mixed
     */
    private $feedCreatorRepository;

    private $metaLibrary;

    private $urlLibrary;

    private $settings;


    /**
     * $dateLibrary
     *
     * @var DateLibrary
     */
    private $dateLibrary;

    
    public function __construct(
        FeedCreatorRepository $feedCreatorRepository, 
        MetaLibrary $metaLibrary, 
        UrlLibrary $urlLibrary, 
        DateLibrary $dateLibrary,
        ContainerInterface $container
    )
    {
        $this->feedCreatorRepository = $feedCreatorRepository;
        $this->metaLibrary = $metaLibrary;
        $this->urlLibrary = $urlLibrary;
        $this->dateLibrary = $dateLibrary;
        $this->settings = $container->get('settings');
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function createFeed()
    {
        $rssFeed = $this->getRssFeed();
        $originalFeeds = $this->buildOriginalFeedFromRss($rssFeed);

        // if feeds available to analyse
        if($originalFeeds){
            $feedsToAnalyse = $this->feedsToAnalyse($originalFeeds);
            $utterancesTone = json_decode($this->urlLibrary->postCurl(
                $this->settings['toneAnalyzer']['api'], 
                $this->settings['toneAnalyzer']['key'], 
                $this->headers(), 
                $feedsToAnalyse
            ));

            $feedsWithTones = $this->compareAndBuildSentimentForFeed($originalFeeds, $utterancesTone->utterances_tone);

            $this->insertEachFeed($feedsWithTones);
        }
    }

    private function insertEachFeed($feedsWithTones){
        foreach ($feedsWithTones as $eachFeed) {
            $this->feedCreatorRepository->insertFeed($eachFeed);
        }
    }

    /**
     * buildOriginalFeedFromRss
     *
     * @param mixed $rssFeed
     * 
     * @return mixed
     */
    private function buildOriginalFeedFromRss($rssFeed){
        $originalFeeds = array();
        //$count = 0;
        foreach ($rssFeed->channel->item as $feedItem) {
            $extractedMeta = array();
            $guid = "{$feedItem->guid}";
            $source = "{$feedItem->source}";
            $pubDate = "{$feedItem->pubDate}";
            $dateInIST = $this->dateLibrary->convectGMTDateToISTDate("{$pubDate}");
            $timeInIST = $this->dateLibrary->convectGMTDateToISTTime("{$pubDate}");
            
            // check if the feed already exist in db
            if(!$this->feedCreatorRepository->ifFeedExist($guid)){
                
                // feed does not exist, process feed
                $extractedMeta = $this->metaLibrary->extractMeta($feedItem->link);
                $extractedMeta['title'] = "{$feedItem->title}";
                $extractedMeta['link'] = "{$feedItem->link}";
                $extractedMeta['guid'] = "{$guid}";
                $extractedMeta['source'] = "{$source}";
                $extractedMeta['originalPubDate'] = "{$pubDate}";
                $extractedMeta['dateIst'] = "{$dateInIST}";
                $extractedMeta['timeIst'] = "{$timeInIST}";
                $originalFeeds[] = $extractedMeta;

                // $count++;
                // if($count == 2){
                //     break;
                // }
            }
            else{
                //
            }
            
        }

        return $originalFeeds;
    }

    private function getRssFeed(){
        $feedUrl = $this->settings['feed']['url'];
        return simplexml_load_file($feedUrl);
    }

    private function headers(){
        return array(
            'Content-Type:application/json',
        );
    }

    private function compareAndBuildSentimentForFeed($originalFeeds, $utterancesTone){
        $feeds = array();
        foreach ($originalFeeds as $feed) {
            $feedWithTones = array();
            $feedWithTones = $feed;
            foreach ($utterancesTone as $utterance) {
                if(array_key_exists('description', $feed)){
                    if($feed['description'] === $utterance->utterance_text){
                        $tone = '';
                        if($utterance->tones){
                            $tone = $utterance->tones[0]->score;
                        }
                        else{
                            $tone = '0.700000';
                        }
                        $feedWithTones['tone'] = $tone;
                        $feeds[] = $feedWithTones;
                    }
                }
            }
        }

        return $feeds;
    }

    private function feedsToAnalyse($feeds){
        $feedsToAnalyse = array();
        foreach ($feeds as $feed) {
            $extractedText = array();
            $trimmed = "";
            if(array_key_exists('description', $feed)){
                $trimmed = str_replace("\\n", "", $feed["description"]);
            }
            $extractedText['text'] = $trimmed;
            $feedsToAnalyse[] = $extractedText;
        }

        return array(
            "utterances" => $feedsToAnalyse
        );
    }
}