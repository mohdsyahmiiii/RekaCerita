@extends('layouts.app')

@section('title', 'Edit Post: ' . $post->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Edit Post: {{ $post->title }}</h1>
                <div>
                    <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary me-2">
                        <i class="fas fa-eye me-2"></i>View Post
                    </a>
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Posts
                    </a>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $post->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('content') is-invalid @enderror" 
                                              id="content" name="content" rows="12" required>{{ old('content', $post->content) }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="excerpt" class="form-label">Excerpt</label>
                                    <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                              id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>
                                    <div class="form-text">A brief summary of the post (optional)</div>
                                    @error('excerpt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="published_at" class="form-label">Publish Date</label>
                                    <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                                           id="published_at" name="published_at" 
                                           value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                                    <div class="form-text">Date field is for reference only. Posts with "Published" status will appear immediately.</div>
                                    @error('published_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="media" class="form-label">Add Media Files</label>
                                    <input type="file" class="form-control @error('media.*') is-invalid @enderror" 
                                           id="media" name="media[]" multiple accept="image/*,video/*">
                                    <div class="form-text">You can select multiple files</div>
                                    @error('media.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Post
                                    </button>
                                    <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            @if($post->media->count() > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Current Media Files</h5>
                    </div>
                    <div class="card-body">
                        @foreach($post->media as $media)
                            <div class="d-flex align-items-center mb-2">
                                @if($media->mime_type && str_starts_with($media->mime_type, 'image/'))
                                    <img src="{{ $media->getUrl() }}" alt="{{ $media->name }}" 
                                         class="me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <i class="fas fa-file me-2 text-muted"></i>
                                @endif
                                <span class="flex-grow-1 small">{{ $media->name }}</span>
                                <form action="{{ route('posts.media.destroy', ['post' => $post, 'media' => $media]) }}" 
                                      method="POST" class="d-inline" 
                                      onsubmit="return confirm('Remove this media file?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-generate excerpt from content if excerpt is empty
    document.getElementById('content').addEventListener('input', function() {
        const excerptField = document.getElementById('excerpt');
        if (!excerptField.value.trim()) {
            const content = this.value;
            const excerpt = content.substring(0, 150).trim();
            if (excerpt.length === 150) {
                excerptField.value = excerpt + '...';
            } else {
                excerptField.value = excerpt;
            }
        }
    });

    // Set default publish date to current time if status is published and no date set
    document.getElementById('status').addEventListener('change', function() {
        const publishDateField = document.getElementById('published_at');
        if (this.value === 'published' && !publishDateField.value) {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            publishDateField.value = `${year}-${month}-${day}T${hours}:${minutes}`;
        }
    });
</script>
@endpush
@endsection
