<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Inertia\Inertia;

class BlogPostController extends Controller
{
    public function index() {}

    public function show(BlogPost $blog)
    {
        return Inertia::render('LatestInfos/BlogIndexPage', ['content' => $blog->renderRichContent('content')]);
    }
}
