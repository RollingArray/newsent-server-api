<?php

namespace App\Action;

use App\Service\FeedCreator;
use App\Service\SentimentOverTimeReader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SentimentOverTimeReadAction
{
    private $sentimentOverTimeReader;

    /**
     * __construct
     *
     * @param FeedCreator $feedCreator
     */
    public function __construct(SentimentOverTimeReader $sentimentOverTimeReader)

    {
        $this->sentimentOverTimeReader = $sentimentOverTimeReader;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface {
        $date = (string)$args['date'];
        $data =  array(
            $date
        );
        $result = $this->sentimentOverTimeReader->generateSentimentOverTime($data);
        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}