@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stat-card {
        background: linear-gradient(135deg, var(--primary-500) 0%, var(--primary-600) 100%);
        border: none;
        border-radius: var(--radius-2xl);
        color: white;
        transition: all var(--transition-normal);
        overflow: hidden;
        position: relative;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(30px, -30px);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    .stat-card.success {
        background: linear-gradient(135deg, var(--success-500) 0%, var(--success-600) 100%);
    }

    .stat-card.warning {
        background: linear-gradient(135deg, var(--warning-500) 0%, var(--warning-600) 100%);
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--secondary-50) 0%, var(--primary-50) 100%);
        border-radius: var(--radius-2xl);
        border: 1px solid var(--primary-200);
    }

    .quick-action-card {
        border: 1px solid var(--secondary-200);
        border-radius: var(--radius-xl);
        transition: all var(--transition-normal);
    }

    .quick-action-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .recent-post-item {
        border: 1px solid var(--secondary-200);
        border-radius: var(--radius-lg);
        transition: all var(--transition-fast);
        margin-bottom: var(--space-3);
    }

    .recent-post-item:hover {
        box-shadow: var(--shadow-md);
        border-color: var(--primary-300);
    }
</style>
@endpush

@section('content')
<div class="container">
    <!-- Dashboard Header -->
    <div class="dashboard-header p-4 mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold text-secondary-900 mb-2">
                    Welcome back, {{ Auth::user()->name }}!
                </h1>
                <p class="lead text-secondary-600 mb-0">
                    Here's what's happening with your stories today.
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="d-flex justify-content-md-end gap-2">
                    <a href="{{ route('posts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>New Story
                    </a>
                    <a href="{{ route('public.posts.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-2"></i>View Blog
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-2">Total Stories</h6>
                            <h2 class="mb-0 fw-bold">{{ Auth::user()->posts()->count() }}</h2>
                            <small class="text-white-75">
                                <i class="fas fa-chart-line me-1"></i>All time
                            </small>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-book fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card success card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-2">Published</h6>
                            <h2 class="mb-0 fw-bold">{{ Auth::user()->posts()->where('status', 'published')->count() }}</h2>
                            <small class="text-white-75">
                                <i class="fas fa-globe me-1"></i>Live stories
                            </small>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-check-circle fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card warning card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-2">Drafts</h6>
                            <h2 class="mb-0 fw-bold">{{ Auth::user()->posts()->where('status', 'draft')->count() }}</h2>
                            <small class="text-white-75">
                                <i class="fas fa-edit me-1"></i>In progress
                            </small>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-file-alt fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="quick-action-card card h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title text-secondary-800 mb-0">
                        <i class="fas fa-bolt text-primary me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('posts.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-pen-fancy me-2"></i>Write New Story
                        </a>
                        <a href="{{ route('posts.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>Manage Stories
                        </a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-users me-2"></i>Manage Users
                            </a>
                        @endif
                        <a href="{{ route('public.posts.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-eye me-2"></i>View Public Blog
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-secondary-800 mb-0">
                            <i class="fas fa-clock text-primary me-2"></i>Recent Stories
                        </h5>
                        <a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-primary">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(Auth::user()->posts()->count() > 0)
                        <div class="space-y-3">
                            @foreach(Auth::user()->posts()->latest()->take(5)->get() as $post)
                                <div class="recent-post-item p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-2 text-secondary-900">
                                                <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-secondary-900">
                                                    {{ $post->title }}
                                                </a>
                                            </h6>
                                            <p class="text-secondary-600 mb-2 small">
                                                {{ Str::limit($post->excerpt ?: $post->content, 80) }}
                                            </p>
                                            <div class="d-flex align-items-center gap-3 text-sm text-secondary-500">
                                                <span>
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ $post->created_at->diffForHumans() }}
                                                </span>
                                                <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }}-100 text-{{ $post->status === 'published' ? 'success' : 'warning' }}-700">
                                                    <i class="fas fa-{{ $post->status === 'published' ? 'check' : 'edit' }} me-1"></i>
                                                    {{ ucfirst($post->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('posts.show', $post->id) }}">
                                                        <i class="fas fa-eye me-2"></i>View
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="{{ route('posts.edit', $post->id) }}">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </a></li>
                                                    @if($post->status === 'published')
                                                        <li><a class="dropdown-item" href="{{ route('public.posts.show', $post->slug) }}" target="_blank">
                                                            <i class="fas fa-external-link-alt me-2"></i>View Public
                                                        </a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-pen-fancy fa-4x text-muted opacity-50"></i>
                            </div>
                            <h5 class="text-secondary-700 mb-2">No stories yet</h5>
                            <p class="text-secondary-500 mb-4">Start your writing journey by creating your first story!</p>
                            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Create Your First Story
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
