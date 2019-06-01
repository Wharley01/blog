<?php
/*
* This is automatically generated 
* Edit to fit your need
* Powered By: Path
*/

namespace Path\App\Database\Model;


use Path\Core\Database\Model;

class Blog extends Model
{
    protected $table_name               = "blog_posts";
    protected $non_writable_cols        = ["id"];
    protected $writable_cols            = ["title","body","author"];
    protected $record_per_page          = 2;

    public function __construct()
    {
        parent::__construct();
    }
}