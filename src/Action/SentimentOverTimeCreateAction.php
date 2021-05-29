<?php

namespace App\Action;

use App\Service\FeedCreator;
use App\Service\SentimentOverTimeCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SentimentOverTimeCreateAction
{
    private $sentimentOverTimeCreator;

    /**
     * __construct
     *
     * @param FeedCreator $feedCreator
     */
    public function __construct(SentimentOverTimeCreator $sentimentOverTimeCreator)

    {
        $this->sentimentOverTimeCreator = $sentimentOverTimeCreator;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $result = $this->sentimentOverTimeCreator->generateSentimentOverTime();
        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}