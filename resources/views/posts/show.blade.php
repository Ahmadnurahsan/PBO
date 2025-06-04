@extends('layouts.app') {{-- Sesuaikan jika nama layout utama kamu berbeda --}}

@section('title', $post->title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm mb-4">
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}" style="max-height: 450px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h1 class="card-title fw-bolder mb-1">{{ $post->title }}</h1>
                    <div class="text-muted fst-italic mb-3">
                        <i class="fas fa-user-edit me-1"></i>Posted on {{ $post->created_at->format('F j, Y, g:i a') }} by <strong>{{ $post->user->name ?? 'Unknown Author' }}</strong>
                    </div>
                    <hr>
                    <section class="mb-4 post-content">
                        {!! nl2br(e($post->content)) !!} {{-- Gunakan e() untuk escaping & nl2br() untuk line break --}}
                    </section>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                     <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back to All Posts</a>
                        @auth
                            @if(Auth::user() && Auth::id() == $post->user_id) {{-- Tombol edit/delete hanya untuk pemilik post --}}
                                <div>
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-outline-warning"><i class="fas fa-edit me-2"></i>Edit</a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you absolutely sure you want to delete this post? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger ms-2"><i class="fas fa-trash-alt me-2"></i>Delete</button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Tambahkan sedikit style untuk konten post jika perlu */
    .post-content p {
        line-height: 1.8;
        margin-bottom: 1.25rem; /* 20px */
        font-size: 1.1rem;
    }
    .card-title.fw-bolder {
        font-size: 2.25rem;
    }
</style>
@endsection