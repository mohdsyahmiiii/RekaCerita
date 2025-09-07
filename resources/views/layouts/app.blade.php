<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RekaCerita')</title>

    <!-- Preconnect to external domains for better performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    @vite(['resources/css/app.css'])

    <!-- Additional custom styles -->
    <style>
        .container-fluid {
            max-width: 1400px;
        }
        .table th {
            background-color: var(--secondary-50);
            color: var(--secondary-700);
            font-weight: var(--font-semibold);
        }
        .btn-group .btn {
            margin-right: 2px;
        }
        .btn-group .btn:last-child {
            margin-right: 0;
        }

        /* Bootstrap overrides */
        .container {
            max-width: 1200px;
        }

        /* Smooth page transitions */
        main {
            animation: fadeIn 0.3s ease-in-out;
        }

        /* Navigation dropdown fixes */
        .navbar {
            position: relative;
            z-index: 1030;
        }

        .navbar .dropdown {
            position: relative;
        }

        .navbar .dropdown-menu {
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            left: auto !important;
            z-index: 9999 !important;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            padding: 8px;
            margin-top: 8px;
            min-width: 220px;
            background: white;
            display: none;
        }

        .navbar .dropdown.show .dropdown-menu {
            display: block !important;
        }

        .navbar .dropdown-item {
            border-radius: 8px;
            padding: 8px 12px;
            transition: all 150ms ease-in-out;
            color: #334155;
            display: flex;
            align-items: center;
            white-space: nowrap;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .navbar .dropdown-item:hover {
            background-color: #eff6ff;
            color: #1d4ed8;
        }

        .navbar .dropdown-item.text-danger:hover {
            background-color: #fef2f2;
            color: #dc2626;
        }

        .navbar .dropdown-header {
            color: #64748b;
            font-weight: 600;
            font-size: 14px;
            padding: 8px 12px;
            margin-bottom: 0;
        }

        .navbar .dropdown-divider {
            margin: 8px 0;
            border-color: #e2e8f0;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-feather-alt me-2"></i>RekaCerita
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.posts.index') }}">Blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <h6 class="dropdown-header">
                                        <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
                                    </h6>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('posts.index') }}">
                                        <i class="fas fa-edit me-2"></i>My Posts
                                    </a>
                                </li>
                                @if(Auth::user()->isAdmin())
                                    <li>
                                        <a class="dropdown-item" href="{{ route('users.index') }}">
                                            <i class="fas fa-users me-2"></i>Manage Users
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
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
        @yield('content')
    </main>

    <footer class="footer py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-feather-alt me-2 text-primary"></i>
                        <h5 class="mb-0 text-white">RekaCerita</h5>
                    </div>
                    <p class="text-secondary mb-0">Sharing stories, inspiring minds.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex justify-content-md-end gap-3 mb-3">
                        <a href="{{ route('home') }}" class="text-secondary text-decoration-none">Home</a>
                        <a href="{{ route('public.posts.index') }}" class="text-secondary text-decoration-none">Blog</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-secondary text-decoration-none">Dashboard</a>
                        @endauth
                    </div>
                    <p class="text-secondary mb-0">&copy; {{ date('Y') }} RekaCerita. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Dropdown fix script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure dropdown works properly
            const dropdownToggle = document.querySelector('.navbar .dropdown-toggle');
            const dropdownMenu = document.querySelector('.navbar .dropdown-menu');

            if (dropdownToggle && dropdownMenu) {
                dropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const dropdown = this.closest('.dropdown');
                    dropdown.classList.toggle('show');
                    dropdownMenu.classList.toggle('show');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        const dropdown = dropdownToggle.closest('.dropdown');
                        dropdown.classList.remove('show');
                        dropdownMenu.classList.remove('show');
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
