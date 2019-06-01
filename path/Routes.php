<?php


use Path\App\Http\MiddleWares\ValidatePassword;
use Path\Core\Http\Request;
use Path\Core\Http\Response;
use Path\Core\Http\Router;

$router = new Router();
$router->setBuildPath("/");

// Catches any error,(for example Invalid parameter from user(browser))
$router->exceptionCatch(function (Request $request, Response $response, array $error) {
    // $error array contains error message and path where the error occurred
    return $response->json(["error" => $error['msg']]);
});

$routes = [
    "/",
    "/blog",
    "/manage/list/posts",
    "/manage/draft/post",
    "/manage/delete/@post_id",
    "/manage/update/@post_id",
    "/read/@blog_id"
];

$router->any([
    "path"  => $routes,
],function (Request $request,Response $response){
    return $response->html("/dist/index.html");
});

// /api/1/blog/fetch/all

$router->group("/api/@version/", function (Router $router) {//path can use Regex too
    // A route group

    $router->group("/blog", function (Router $router){

        $router->post([
            "path" => "store",
            "middleware" => ValidatePassword::class
        ],"Blogs->store");

        $router->post([
            "path" => "update/@blog_id",
            "middleware" => ValidatePassword::class
        ],"Blogs->update");

        $router->post([
            "path" => "delete/@blog_id",
            "middleware" => ValidatePassword::class
        ],"Blogs->delete");

        $router->get("fetch/all","Blogs->fetchAll");
        $router->get("fetch/@blog_id","Blogs->fetchOne");

    });

});

$router->error404(function (Request $request, Response $response) {
    return $response->json(['error' => "Error 404", 'params' => $request->server->REQUEST_URI])->addHeader([
        "Access-Control-Allow-Origin" => "*"
    ]);
});
