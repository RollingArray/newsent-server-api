<?php

namespace App\Action;

use App\Service\FeedCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FeedCreateAction
{
    private $feedCreator;

    
    
    /**
     * __construct
     *
     * @param FeedCreator $feedCreator
     */
    public function __construct(FeedCreator $feedCreator)

    {
        $this->feedCreator = $feedCreator;
    }

        
    
    /**
     * __invoke
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * 
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        // Collect input from the HTTP request
        //var_dump((array)$request);
        //$data = (array)$request->getParsedBody();
        //var_dump($data);

        // Invoke the Domain with inputs and retain the result
        $userId = $this->feedCreator->createFeed();

        // Transform the result into the JSON representation
        $result = [
            'success' => true
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}