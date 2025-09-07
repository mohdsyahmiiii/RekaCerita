@extends('layouts.app')

@section('title', 'User Details: ' . $user->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">User Details</h1>
                <div>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-2"></i>Edit User
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Users
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
                            <h5 class="card-title mb-0">{{ $user->name }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Basic Information</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>ID:</strong></td>
                                            <td>{{ $user->id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Role:</strong></td>
                                            <td>
                                                @if($user->role === 'admin')
                                                    <span class="badge bg-danger">Admin</span>
                                                @else
                                                    <span class="badge bg-secondary">User</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Account Status</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @if($user->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-warning">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email Verified:</strong></td>
                                            <td>
                                                @if($user->email_verified_at)
                                                    <span class="badge bg-success">Verified</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Joined:</strong></td>
                                            <td>{{ $user->created_at->format('M d, Y \a\t g:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Updated:</strong></td>
                                            <td>{{ $user->updated_at->format('M d, Y \a\t g:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($user->posts->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">User's Posts ({{ $user->posts->count() }})</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Published</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user->posts->take(5) as $post)
                                                <tr>
                                                    <td>
                                                        <strong>{{ Str::limit($post->title, 40) }}</strong>
                                                    </td>
                                                    <td>
                                                        @if($post->status === 'published')
                                                            <span class="badge bg-success">Published</span>
                                                        @else
                                                            <span class="badge bg-warning">Draft</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($post->published_at)
                                                            {{ $post->published_at->format('M d, Y') }}
                                                        @else
                                                            <span class="text-muted">Not set</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $post->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($user->posts->count() > 5)
                                    <div class="text-center mt-3">
                                        <small class="text-muted">Showing first 5 posts. Total: {{ $user->posts->count() }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-newspaper fa-2x text-muted mb-3"></i>
                                <h6 class="text-muted">No Posts Yet</h6>
                                <p class="text-muted mb-0">This user hasn't created any posts yet.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Edit User
                                </a>
                                
                                @if($user->id !== auth()->id())
                                    @if($user->is_active)
                                        <form action="{{ route('users.update', $user) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="is_active" value="0">
                                            <button type="submit" class="btn btn-warning w-100">
                                                <i class="fas fa-user-slash me-2"></i>Deactivate User
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('users.update', $user) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="is_active" value="1">
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="fas fa-user-check me-2"></i>Activate User
                                            </button>
                                        </form>
                                    @endif

                                    @if(!$user->email_verified_at)
                                        <form action="{{ route('users.update', $user) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="email_verified_at" value="{{ now() }}">
                                            <button type="submit" class="btn btn-info w-100">
                                                <i class="fas fa-check-circle me-2"></i>Mark Email Verified
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('users.destroy', $user) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="fas fa-trash me-2"></i>Delete User
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-info">
                                        <small><i class="fas fa-info-circle me-1"></i>You cannot modify your own account from this view.</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Account Statistics</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h4 class="text-primary mb-1">{{ $user->posts->count() }}</h4>
                                        <small class="text-muted">Posts</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-success mb-1">{{ $user->posts->where('status', 'published')->count() }}</h4>
                                    <small class="text-muted">Published</small>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <small class="text-muted">
                                    Member since {{ $user->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
