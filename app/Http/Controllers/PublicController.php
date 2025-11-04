<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Gallery;
use App\Models\Testimonial;
use App\Models\Nasabah;
use App\Models\PenjualanSampah;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $galleries = Gallery::latest()->take(6)->get();
        $articles = Article::latest()->take(3)->get();
        $testimonials = Testimonial::latest()->get();

        $ton = number_format(PenjualanSampah::sum('berat') / 1000, 1);

        return view('public.home', compact('galleries', 'articles', 'testimonials', 'ton'));
    }

    public function articles()
    {
        $articles = Article::latest()->paginate(9);
        return view('public.articles.index', compact('articles'));
    }

    public function articleShow(Article $article)
    {
        $article->increment('views');
        $related = Article::where('id', '!=', $article->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('public.articles.show', compact('article', 'related'));
    }

    public function about()
    {
        $stats = [
            'nasabah' => Nasabah::count(),
            'ton' => number_format(PenjualanSampah::sum('berat') / 1000, 1),
            'pohon' => (int)(PenjualanSampah::sum('berat') / 1000 * 10),
            'penghargaan' => 12
        ];

        return view('public.about', compact('stats'));
    }

    public function galeri()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('public.galeri.index', compact('galleries'));
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'content' => 'required|string|min:10',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Testimonial::create($request->only(['name', 'occupation', 'content', 'rating']));

        return response()->json([
            'message' => 'Terima kasih! Testimoni Anda telah dikirim.',
        ], 200);
    }
}