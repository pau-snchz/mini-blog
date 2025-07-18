<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodBlogPost;

class HomeController extends Controller
{
    public function index()
    {
        $posts = FoodBlogPost::with('pictures')->get();
        return view('home', compact('posts'));
    }
}