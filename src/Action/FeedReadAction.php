<?php

namespace App\Action;

use App\Data\FeedReaderData;
use App\Domain\User\Service\UserReader;
use App\Service\FeedReader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class FeedReadAction
{
    
    /**
     * @var [type]
     */
    private $feedReader;

    
    
    public function __construct(FeedReader $feedReader)
    {
        $this->feedReader = $feedReader;
    }

    
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        // Collect input from the HTTP request
        //$dateTime = (string)$args['dateTime'];
        $createdAt = (string)$request->getParsedBody()['createdAt'];
        //echo $dateTime['dateTime'];

        // Invoke the Domain with inputs and retain the result
        $result = $this->feedReader->getAllFeedsPostDate($createdAt);

        // Transform the result into the JSON representation
        // $result = [
        //     'user_id' => $userData->id,
        //     'username' => $userData->username,
        //     'first_name' => $userData->firstName,
        //     'last_name' => $userData->lastName,
        //     'email' => $userData->email,
        // ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
