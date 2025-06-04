<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyBlog')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Custom Minimalist Styling --}}
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9fafb;
            color: #333;
        }

        .navbar {
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.2rem;
        }

        .nav-link {
            font-size: 0.95rem;
            padding: 0.5rem 0.75rem;
        }

        .container {
            max-width: 900px;
        }

        .alert {
            font-size: 0.95rem;
            border-radius: 0.5rem;
        }

        footer {
            font-size: 0.85rem;
            background-color: #f1f3f5;
        }

        .btn {
            border-radius: 0.5rem;
        }
    </style>

    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand text-dark" href="{{ route('home') }}">
                <i class="fas fa-feather-alt me-2"></i>MyBlog
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('posts.index') || request()->routeIs('home') ? 'active text-primary' : '' }}" href="{{ route('posts.index') }}">Home</a>
                    </li>

                    @guest
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active text-primary' : '' }}" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('register') ? 'active text-primary' : '' }}" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('posts.create') }}">
                                <i class="fas fa-plus me-1"></i>New Post
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="text-center py-4 mt-5 border-top">
        <p class="text-muted mb-0">&copy; {{ date('Y') }} MyBlog — Maaf Ngasal Bapak Yang penting A 😅🙏 </p>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
