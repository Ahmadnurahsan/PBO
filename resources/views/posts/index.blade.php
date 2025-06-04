@extends('layouts.app') {{-- Sesuaikan jika nama layout utama kamu berbeda --}}

@section('title', 'All Posts')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>All Blog Posts</h1>
        @auth {{-- Tombol create post hanya muncul jika user sudah login --}}
            <a href="{{ route('posts.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle me-1"></i>Create New Post</a>
        @endauth
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @forelse ($posts as $post)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if ($post->image)
                        <a href="{{ route('posts.show', $post->id) }}">
                            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                        </a>
                    @else
                        <a href="{{ route('posts.show', $post->id) }}">
                            <img src="https://via.placeholder.com/400x200.png?text=No+Image" class="card-img-top" alt="No image available" style="height: 200px; object-fit: cover;">
                        </a>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">
                            <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">{{ $post->title }}</a>
                        </h5>
                        <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                        <p class="card-text">
                            <small class="text-muted">
                                By: {{ $post->user->name ?? 'Unknown Author' }}
                                <br>
                                {{ $post->created_at->format('M d, Y') }}
                            </small>
                        </p>
                        {{-- Tombol Aksi diletakkan di sini --}}
                        <div class="mt-auto pt-2 border-top"> 
                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye me-1"></i>View</a>
                            @auth
                                @if(Auth::user() && Auth::id() == $post->user_id) {{-- Pastikan user login & adalah pemilik post --}}
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-warning ms-1"><i class="fas fa-edit me-1"></i>Edit</a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you absolutely sure you want to delete this post? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger ms-1"><i class="fas fa-trash-alt me-1"></i>Delete</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <div class="alert alert-info text-center">
                    <p class="mb-0">No posts yet.</p>
                    @auth
                        <p class="mb-0">Be the first to <a href="{{ route('posts.create') }}">create one</a>!</p>
                    @else
                        <p class="mb-0"><a href="{{ route('login') }}">Login</a> to create a post.</p>
                    @endauth
                </div>
            </div>
        @endforelse
    </div>

    @if ($posts->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }} {{-- Untuk Paginasi Bootstrap --}}
    </div>
    @endif
</div>
@endsection