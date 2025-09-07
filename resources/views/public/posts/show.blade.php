@extends('layouts.app')

@section('title', $post->title)

@push('styles')
<style>
    .blog-post-content {
        font-family: var(--font-family-serif);
        font-size: var(--text-lg);
        line-height: var(--leading-relaxed);
        color: var(--secondary-800);
    }

    .blog-post-content p {
        margin-bottom: var(--space-6);
    }

    .blog-post-meta {
        background: linear-gradient(135deg, var(--secondary-50) 0%, var(--primary-50) 100%);
        border-left: 4px solid var(--primary-500);
    }

    .image-gallery img {
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        transition: transform var(--transition-normal);
    }

    .image-gallery img:hover {
        transform: scale(1.02);
    }

    .breadcrumb-item a {
        color: var(--primary-600);
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        color: var(--primary-700);
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Breadcrumb Navigation -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('public.posts.index') }}">
                            <i class="fas fa-book-open me-1"></i>Stories
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ Str::limit($post->title, 50) }}
                    </li>
                </ol>
            </nav>

            <!-- Article Header -->
            <article class="blog-post">
                <header class="mb-5">
                    <h1 class="display-4 fw-bold text-secondary-900 mb-4">{{ $post->title }}</h1>

                    <!-- Post Meta Information -->
                    <div class="blog-post-meta p-4 rounded-3 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex flex-wrap gap-3 text-secondary-600">
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-user me-2 text-primary-500"></i>
                                        <strong>{{ $post->user->name }}</strong>
                                    </span>
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-calendar me-2 text-primary-500"></i>
                                        {{ $post->published_at->format('F d, Y') }}
                                    </span>
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-clock me-2 text-primary-500"></i>
                                        {{ $post->published_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <span class="badge bg-primary-100 text-primary-700 px-3 py-2">
                                    <i class="fas fa-book-reader me-1"></i>
                                    {{ str_word_count(strip_tags($post->content)) }} words
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($post->excerpt)
                        <div class="lead text-secondary-600 p-4 bg-secondary-50 rounded-3 border-start border-4 border-primary-400">
                            {{ $post->excerpt }}
                        </div>
                    @endif
                </header>

                <!-- Image Gallery -->
                @if($post->getMedia('posts')->count() > 0)
                    <div class="image-gallery mb-5">
                        @if($post->getMedia('posts')->count() == 1)
                            <div class="text-center">
                                <img src="{{ $post->getFirstMedia('posts')->getUrl() }}"
                                     class="img-fluid"
                                     alt="{{ $post->title }}"
                                     style="max-height: 500px; width: auto;">
                            </div>
                        @else
                            <div class="row g-3">
                                @foreach($post->getMedia('posts') as $media)
                                    <div class="col-md-6">
                                        <img src="{{ $media->getUrl() }}"
                                             class="img-fluid w-100"
                                             alt="{{ $post->title }}"
                                             style="height: 300px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Article Content -->
                <div class="blog-post-content">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </article>

            <!-- Article Footer -->
            <footer class="mt-5 pt-4 border-top">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <a href="{{ route('public.posts.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Stories
                        </a>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <div class="d-flex justify-content-md-end gap-2">
                            <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                                <i class="fas fa-print me-1"></i>Print
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" onclick="navigator.share ? navigator.share({title: '{{ $post->title }}', url: window.location.href}) : alert('Sharing not supported')">
                                <i class="fas fa-share me-1"></i>Share
                            </button>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>
@endsection
