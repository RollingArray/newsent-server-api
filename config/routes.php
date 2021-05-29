<?php

use App\Action\PreflightAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;


return function (App $app) {


	$app->get('/', \App\Action\HomeAction::class);
	$app->post('/users', \App\Action\UserCreateAction::class);
	$app->get('/feed', \App\Action\FeedCreateAction::class);
	$app->post('/user-paginated-feeds', \App\Action\FeedReadAction::class);
	$app->get('/generate/sentiment-over-time', \App\Action\SentimentOverTimeCreateAction::class);
	$app->get('/sentiments-over-time/sentiments/{date}', \App\Action\SentimentOverTimeReadAction::class);

	// Allow preflight requests for /user-paginated-feeds
	$app->options('/user-paginated-feeds', PreflightAction::class);

	// Allow preflight requests for /sentiments-over-time/sentiments/{date}
	$app->options('/sentiments-over-time/sentiments/{date}', PreflightAction::class);


	// // Allow preflight requests
	// // Due to the behaviour of browsers when sending a request,
	// // you must add the OPTIONS method. Read about preflight.
	// // $app->options('/feeds-two', function (Request $request, Response $response): Response {
	// //     // Do nothing here. Just return the response.
	// //     return $response;
	// // });

	// $app->options('/sentiments-over-time/sentiments/{date}', function (Request $request, Response $response): Response {
	// 	// Do nothing here. Just return the response.
	// 	return $response;
	// });
};
