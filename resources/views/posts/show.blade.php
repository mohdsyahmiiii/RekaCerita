@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">View Post</h1>
                <div>
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-2"></i>Edit Post
                    </a>
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Posts
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ $post->title }}</h5>
                        </div>
                        <div class="card-body">
                            @if($post->excerpt)
                                <div class="alert alert-info">
                                    <strong>Excerpt:</strong> {{ $post->excerpt }}
                                </div>
                            @endif

                            <div class="post-content">
                                {!! nl2br(e($post->content)) !!}
                            </div>
                        </div>
                    </div>

                    @if($post->media->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Media Files</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($post->media as $media)
                                        <div class="col-md-4 mb-3">
                                            @if($media->mime_type && str_starts_with($media->mime_type, 'image/'))
                                                <img src="{{ $media->getUrl() }}" alt="{{ $media->name }}" 
                                                     class="img-fluid rounded" style="max-height: 200px;">
                                            @else
                                                <div class="text-center p-3 border rounded">
                                                    <i class="fas fa-file fa-2x text-muted mb-2"></i>
                                                    <p class="mb-0 small">{{ $media->name }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="card-title mb-0">Public Visibility Status</h6>
                        </div>
                        <div class="card-body">
                            @php
                                $isPublished = $post->status === 'published';
                                $isPastDate = $post->published_at && $post->published_at->isPast();
                                $isPubliclyVisible = $isPublished && $isPastDate;
                            @endphp

                            <div class="mb-2 d-flex justify-content-between">
                                <span>Status is 'Published':</span>
                                @if($isPublished)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-danger">No</span>
                                @endif
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span>Publish Date is in the Past:</span>
                                @if($isPastDate)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-danger">No</span>
                                @endif
                            </div>

                            <hr>

                            <div class="text-center">
                                @if($isPubliclyVisible)
                                    <h5 class="text-success"><i class="fas fa-check-circle me-2"></i>Visible to Public</h5>
                                @else
                                    <h5 class="text-danger"><i class="fas fa-times-circle me-2"></i>Not Visible to Public</h5>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Post Details</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>ID:</strong></td>
                                    <td>{{ $post->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Slug:</strong></td>
                                    <td><code>{{ $post->slug }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($post->status === 'published')
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-warning">Draft</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Author:</strong></td>
                                    <td>{{ $post->user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Published:</strong></td>
                                    <td>
                                        @if($post->published_at)
                                            {{ $post->published_at->format('M d, Y \a\t g:i A') }}
                                        @else
                                            <span class="text-muted">Not published</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $post->created_at->format('M d, Y \a\t g:i A') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Updated:</strong></td>
                                    <td>{{ $post->updated_at->format('M d, Y \a\t g:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Edit Post
                                </a>
                                
                                @if($post->status === 'draft')
                                    <form action="{{ route('posts.update', $post) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="published">
                                        <input type="hidden" name="published_at" value="{{ now()->format('Y-m-d\TH:i') }}">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-publish me-2"></i>Publish Now
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('posts.destroy', $post) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this post? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fas fa-trash me-2"></i>Delete Post
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.post-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.post-content p {
    margin-bottom: 1rem;
}
</style>
@endsection
