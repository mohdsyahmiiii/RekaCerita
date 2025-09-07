@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4 fw-bold text-secondary-900 mb-3">Our Stories</h1>
            <p class="lead text-secondary-600">Explore a collection of inspiring tales and insights from our community</p>
        </div>
    </div>

    @if($posts->count() > 0)
        <!-- Blog Posts Grid -->
        <div class="row g-4 mb-5">
            @foreach($posts as $post)
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

        <!-- Enhanced Pagination -->
        <div class="d-flex justify-content-center">
            <nav aria-label="Blog posts pagination">
                {{ $posts->links('pagination::bootstrap-4') }}
            </nav>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-book-open fa-5x text-muted opacity-50"></i>
            </div>
            <h3 class="text-secondary-700 mb-3">No Stories Yet</h3>
            <p class="text-secondary-500 mb-4">Be the first to share your story with our community!</p>
            @auth
                <a href="{{ route('posts.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-pen-fancy me-2"></i>Write Your First Story
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-user-plus me-2"></i>Join Our Community
                </a>
            @endauth
        </div>
    @endif
</div>
@endsection
