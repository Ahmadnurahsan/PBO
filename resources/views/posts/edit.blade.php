@extends('layouts.app')

@section('title', 'Edit Post: ' . $post->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Post</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- Penting untuk method update --}}

                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold">Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="8" required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label fw-bold">Featured Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" onchange="previewImage()">
                        <div class="form-text mb-2">Leave blank to keep the current image. Max file size: 2MB.</div>
                        @error('image')
                            <div class="invalid-feedback d-block"> {{-- d-block agar tampil walau input tidak invalid --}}
                                {{ $message }}
                            </div>
                        @enderror

                        <p class="mt-3 fw-bold">Current Image:</p>
                        @if ($post->image)
                            <img id="current-image" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid rounded mb-2" style="max-height: 200px;">
                        @else
                            <p id="current-image" class="text-muted">No current image.</p>
                        @endif
                        
                        <p class="mt-2 fw-bold">New Image Preview (if chosen):</p>
                        <img id="image-preview" src="#" alt="New Image Preview" class="img-fluid mt-1 rounded" style="display:none; max-height: 300px;"/>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-outline-secondary me-md-2"><i class="fas fa-times me-1"></i>Cancel</a>
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save me-2"></i>Update Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('#image-preview');
        const currentImage = document.querySelector('#current-image');

        if (image.files && image.files[0]) {
            imgPreview.style.display = 'block';
            if(currentImage) { // Sembunyikan gambar lama jika ada preview baru
                // currentImage.style.display = 'none'; // Atau biarkan saja untuk perbandingan
            }
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        } else {
            imgPreview.style.display = 'none';
             if(currentImage) {
                // currentImage.style.display = 'block';
            }
        }
    }
</script>
@endpush