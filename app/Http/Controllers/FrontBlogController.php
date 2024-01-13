<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class FrontBlogController extends Controller
{
    public function getBlogs()
    {
        $blogs = Blog::latest()->get();
        return response()->json(['success'=>true,'data'=>$blogs]);

    }
}
