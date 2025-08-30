<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

class BlogPostController extends Controller
{
    public function index() {}

    public function show(BlogPost $blog)
    {
        return $blog->renderRichContent('content');
    }
}
