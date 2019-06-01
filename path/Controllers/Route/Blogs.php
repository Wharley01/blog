<?php

/*
* This is automatically generated 
* Edit to fit your need
* Powered By: Path
*/

namespace Path\App\Controllers\Route;



use Path\App\Database\Model\Blog;
use Path\Core\Http\Request;
use Path\Core\Http\Response;
use Path\Core\Router\Route\Controller;
use Path\Core\Storage\Sessions;


class Blogs extends Controller
{
    private $session;
    private $password = "<adewale96/>";
    public function __construct()
    {
        $this->session = new Sessions();
    }
    public function fetchAll(Request $request,Response $response){
//     return a response here
        $blogs = new Blog();
        $page_index = $request->fetch("page") ?? 1;
        $result = $blogs->getPage($page_index);

        return $response->json([
            "result" => $result,
            "pages" => $blogs->getPages(),
            "total_records" => $blogs->total_record,
            "total_pages" => $blogs->total_pages
        ]);
    }

    public function fetchOne(Request $request,Response $response){
//     return a response here
        $blog_id = $request->params->blog_id;
        $blogs = new Blog();
        $result = $blogs
            ->where(['id' => $blog_id])
            ->getFirst();

        return $response->json([
            "result" => (array)$result
        ]);
    }

    public function store(Request $request,Response $response){
        $blog = new Blog();

            unset($request->inputs["password"]);
            $blog->insert(
                $request->inputs
            );
            return $response->json([
                "msg" => "Post successfully stored"
            ]);

    }
    public function update(Request $request,Response $response){
        $blog_id = $request->params->blog_id;
        if(is_numeric($blog_id)){

            unset($request->inputs["password"]);
            (new Blog())
                ->where(['id' => $blog_id])
                ->update($request->inputs);

            return $response->json([
                "msg" => "Post successfully stored"
            ]);
        }
        return $response->json([
            "msg" => "Invalid blog_id"
        ],401);
    }

    public function delete(Request $request,Response $response){

        (new Blog)
            ->where([
            "id" => $request->params->blog_id
            ])
            ->delete();

        return $response->json([
           "post successfully deleted"
        ]);
    }
    }