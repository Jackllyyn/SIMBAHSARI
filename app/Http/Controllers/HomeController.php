<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Gallery;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->take(4)->get();
        $articles = Article::latest()->take(3)->get();
        $testimonials = Testimonial::latest()->get();
        return view('home', compact('galleries', 'articles', 'testimonials'));
    }
}