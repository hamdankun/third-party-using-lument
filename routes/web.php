<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
use GuzzleHttp\Client;
use Illuminate\Http\Request;

/**
 * Config Guzzle Http
 * @var Client
 */
$thirdParty = new Client([
    'base_uri' => 'https://jsonplaceholder.typicode.com'
]);


/**
 * Root Router
 */
$router->get('/', function() use ($router) {
    return $router->app->version();
});


/**
 * API Under prefix /posts
 */
$router->group(['prefix' => 'posts'], function($router) use($thirdParty) {

    /**
     * API Get Request
     */
    $router->get('/', function() use($thirdParty) {
        $posts = $thirdParty->get('/posts');
        return response()->json([
            'status' => $posts->getStatusCode(),
            'body' => parseJson($posts
                ->getBody()
                ->getContents())
        ], $posts->getStatusCode());
    });

    /**
     * API GET With Parameters Request
     */
    $router->get('/{id}', function($id) use($thirdParty) {
        $posts = $thirdParty->get('/posts/' . $id);
        return response()->json([
            'status' => $posts->getStatusCode(),
            'body' => parseJson($posts
                ->getBody()
                ->getContents())
        ], $posts->getStatusCode());
    });

    /**
     * API POST Request
     */
    $router->post('/', function(Request $request) use($thirdParty) {
        $posts = $thirdParty->post('/posts', [
            'form_params' => [
                'userId' =>  $request->input('userId'),
                'title' => $request->input('title'),
                'body' => $request->input('body')
            ]
        ]);
        return response()->json([
            'status' => $posts->getStatusCode(),
            'body' => parseJson($posts
                ->getBody()
                ->getContents())
        ], $posts->getStatusCode());
    });

    /**
     * API PUT Request
     */
    $router->put('/{id}', function(Request $request, $id) use($thirdParty) {
        $posts = $thirdParty->put('/posts/' . $id, [
            'form_params' => [
                'userId' =>  $request->input('userId'),
                'title' => $request->input('title'),
                'body' => $request->input('body')
            ]
        ]);
        return response()->json([
            'status' => $posts->getStatusCode(),
            'body' => parseJson($posts
                ->getBody()
                ->getContents())
        ], $posts->getStatusCode());
    });

    /**
     * API DELETE Request
     */
    $router->delete('/{id}', function(Request $request, $id) use($thirdParty) {
        $posts = $thirdParty->delete('/posts/' . $id);
        return response()->json([
            'status' => $posts->getStatusCode(),
            'body' => parseJson($posts
                ->getBody()
                ->getContents())
        ], $posts->getStatusCode());
    });
});

/**
 * API GET Cities
 */
$router->get('/api-jakarta/city', function() {
    $http = new Client();
    $response = $http->get('http://api.jakarta.go.id/v1/kota', [
        'headers' => [
            'Authorization' => '8W6xezkIc+XfYRCbr+KoAUJ9Q0XDgOKN6IJ2qfhL186QZePtndeOVm5Vx2UE5IeF'
        ]
    ]);
    return response()->json([
        'status' => $response->getStatusCode(),
        'body' => parseJson($response->getBody()->getContents())
    ], $response->getStatusCode());
});

/**
 * Helper for parse json string to array
 * @param  string $jsonData
 * @return array
 */
function parseJson($jsonData) {
    return json_decode($jsonData, true);
}
