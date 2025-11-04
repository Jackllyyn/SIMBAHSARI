@extends('layouts.guest')
@section('title', 'Artikel')

@section('content')
<div class="container mx-auto px-4 py-20">
    <h1 class="text-5xl font-bold text-center mb-16 text-green-700">Artikel Terbaru</h1>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($articles as $article)
            <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition">
                @if($article->image_path)
                    <img src="{{ asset('storage/' . $article->image_path) }}" 
                         alt="{{ $article->title }}" 
                         class="w-full h-48 object-cover">
                @endif

                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        {{ Str::limit($article->title, 60) }}
                    </h3>
                    <p class="text-gray-600 text-sm mb-4">
                        {{ Str::limit(strip_tags($article->content), 100) }}
                    </p>

                    <!-- PAKAI SLUG EKSPISIT = 100% AMAN -->
                    <a href="{{ route('articles.show', $article->slug) }}" 
                       class="inline-flex items-center text-green-600 font-semibold hover:text-green-700">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </article>
        @empty
            <p class="col-span-full text-center text-gray-500">Belum ada artikel.</p>
        @endforelse
    </div>

    <div class="mt-12 flex justify-center">
        {{ $articles->links() }}
    </div>
</div>
@endsection