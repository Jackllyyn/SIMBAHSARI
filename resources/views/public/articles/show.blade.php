@extends('layouts.guest')
@section('title', $article->title)

@section('content')
<div class="container mx-auto px-4 py-20 max-w-4xl">
    <article class="bg-white rounded-2xl shadow-xl p-8">
        <h1 class="text-4xl font-bold text-green-700 mb-6">{{ $article->title }}</h1>
        
        <!-- GAMBAR DIPERBESAR & RESPONSIF -->
        @if($article->image_path)
            <div class="relative w-full h-64 sm:h-80 md:h-96 lg:h-[500px] rounded-xl overflow-hidden mb-8 shadow-lg">
                <img src="{{ asset('storage/' . $article->image_path) }}" 
                     alt="{{ $article->title }}" 
                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
            </div>
        @endif

        <div class="prose max-w-none text-gray-700">
            {!! $article->content !!}
        </div>

        <div class="mt-8 text-sm text-gray-500">
            Dilihat: {{ $article->views }} kali
        </div>
    </article>

    <!-- ARTIKEL TERKAIT -->
    <div class="mt-12">
        <h3 class="text-2xl font-bold mb-6">Artikel Terkait</h3>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($related as $rel)
                <a href="{{ route('articles.show', $rel->slug) }}" 
                   class="block bg-white p-4 rounded-lg shadow hover:shadow-md transition">
                    <h4 class="font-semibold text-green-700">{{ $rel->title }}</h4>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection