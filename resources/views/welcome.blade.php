@extends('layouts.app')

@section('title', 'Welcome to RekaCerita')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center" style="min-height: 75vh;">
            <div class="col-lg-6">
                <div class="hero-content fade-in">
                    <h1 class="hero-title">
                        Welcome to <span class="text-warning">RekaCerita</span>
                    </h1>
                    <p class="hero-subtitle">
                        Discover amazing stories, share your thoughts, and connect with fellow readers and writers.
                        Your platform for creative expression and meaningful conversations.
                    </p>

                    <div class="d-flex flex-column flex-sm-row gap-3 mb-5">
                        <a href="{{ route('public.posts.index') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-book-open me-2"></i>Explore Stories
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Join Community
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row g-4 slide-up">
                    <div class="col-sm-6">
                        <div class="text-center p-4 bg-white bg-opacity-10 rounded-3" style="backdrop-filter: blur(10px);">
                            <i class="fas fa-book-open fa-3x mb-3 text-warning"></i>
                            <h5 class="text-white mb-2">Read Stories</h5>
                            <p class="text-white-50 mb-0">Explore diverse content from talented writers</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-center p-4 bg-white bg-opacity-10 rounded-3" style="backdrop-filter: blur(10px);">
                            <i class="fas fa-pen-fancy fa-3x mb-3 text-warning"></i>
                            <h5 class="text-white mb-2">Write & Share</h5>
                            <p class="text-white-50 mb-0">Express your creativity and share your voice</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-center p-4 bg-white bg-opacity-10 rounded-3" style="backdrop-filter: blur(10px);">
                            <i class="fas fa-users fa-3x mb-3 text-warning"></i>
                            <h5 class="text-white mb-2">Connect</h5>
                            <p class="text-white-50 mb-0">Join our vibrant community of storytellers</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-center p-4 bg-white bg-opacity-10 rounded-3" style="backdrop-filter: blur(10px);">
                            <i class="fas fa-heart fa-3x mb-3 text-warning"></i>
                            <h5 class="text-white mb-2">Inspire</h5>
                            <p class="text-white-50 mb-0">Share stories that touch hearts and minds</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">

@if($posts->count() > 0)
    <!-- Latest Posts Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-5 fw-bold text-secondary-900 mb-3">Latest Stories</h2>
                    <p class="lead text-secondary-600">Discover the most recent tales from our community</p>
                </div>
            </div>

            <div class="row g-4">
                @foreach($posts->take(3) as $post)
                    <div class="col-lg-4 col-md-6">
                        <article class="blog-card">
                            <div class="blog-card-image">
                                @if($post->getFirstMediaUrl('posts'))
                                    <img src="{{ $post->getFirstMediaUrl('posts') }}" alt="{{ $post->title }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="blog-card-content">
                                <h3 class="blog-card-title">{{ $post->title }}</h3>
                                <p class="blog-card-excerpt">
                                    {{ Str::limit($post->excerpt ?: $post->content, 120) }}
                                </p>

                                <div class="blog-card-meta">
                                    <div class="blog-card-author">
                                        <i class="fas fa-user"></i>
                                        <span>{{ $post->user->name }}</span>
                                    </div>
                                    <div class="blog-card-date">
                                        <i class="fas fa-calendar"></i>
                                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('public.posts.show', $post->slug) }}" class="btn btn-primary w-100">
                                    <i class="fas fa-book-open me-2"></i>Read Story
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('public.posts.index') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-th-large me-2"></i>Explore All Stories
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>
@endif
@endsection
