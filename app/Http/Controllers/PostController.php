<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Tambahkan ini jika ingin menggunakan Str::slug atau sejenisnya

class PostController extends Controller
{
    public function __construct()
    {
        // Hanya user yang terautentikasi yang bisa membuat, edit, update, delete post
        // index dan show bisa dilihat publik
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(9); // Saya ubah ke 9 agar pas 3 kolom
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            // 'slug' => Str::slug($request->title) . '-' . uniqid(), // Contoh jika ingin slug unik
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        // $post sudah otomatis di-resolve oleh Laravel (Route Model Binding)
        // Jika ingin memuat komentar atau relasi lain di sini: $post->load('comments.user');
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // Otorisasi: Pastikan pengguna yang login adalah pemilik post
        // Untuk implementasi yang lebih baik, gunakan Laravel Policies: https://laravel.com/docs/authorization#creating-policies
        if (Auth::id() !== $post->user_id) {
            // Atau jika ada peran admin, tambahkan pengecekan: && !Auth::user()->isAdmin()
            return redirect()->route('posts.index')->with('error', 'You are not authorized to edit this post.');
            // atau abort(403, 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // Otorisasi: Pastikan pengguna yang login adalah pemilik post
        if (Auth::id() !== $post->user_id) {
            // Atau jika ada peran admin, tambahkan pengecekan: && !Auth::user()->isAdmin()
            return redirect()->route('posts.index')->with('error', 'You are not authorized to update this post.');
            // atau abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
        ]);

        $imagePath = $post->image; // Defaultnya pakai gambar lama

        if ($request->hasFile('image')) {
            // Jika ada gambar baru diupload:
            // 1. Hapus gambar lama (jika ada)
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            // 2. Simpan gambar baru
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            // 'slug' => Str::slug($request->title) . '-' . uniqid(), // Update slug juga jika judul berubah
        ]);

        return redirect()->route('posts.show', $post->id)->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        // Otorisasi: Pastikan pengguna yang login adalah pemilik post
        if (Auth::id() !== $post->user_id) {
            // Atau jika ada peran admin, tambahkan pengecekan: && !Auth::user()->isAdmin()
            return redirect()->route('posts.index')->with('error', 'You are not authorized to delete this post.');
            // atau abort(403, 'Unauthorized action.');
        }

        // Hapus gambar jika ada
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
}