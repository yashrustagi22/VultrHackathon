<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Medical Chatbot</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Vite Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-XQIRF12pL4QH6SHKTL3RoqAp/SInBXWh2cWzBbP4M0J5RmLTG9ImvP0Yd+NS3RGp" crossorigin="anonymous">

    <!-- Custom Styles -->
    <style>
        /* Navbar styling */
        .navbar {
            background-color: #28a745; /* Green background */
            color: white;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white !important;
        }
        .navbar-nav .nav-link {
            color: white !important;
            font-size: 1rem;
        }
        /* Welcome message styling */
        .welcome-message {
            color: #f8f9fa; /* Light color */
            font-weight: bold;
            font-size: 1.1rem;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2); /* Soft shadow */
            transition: color 0.3s ease;
        }
        .welcome-message:hover {
            color: #d4edda; /* Slightly lighter green on hover */
        }
        /* Red Logout Button */
        .navbar-nav .logout-button {
            color: #ffffff !important;
            background-color: #dc3545; /* Red color */
            border: none;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .navbar-nav .logout-button:hover {
            background-color: #c82333;
        }
        /* Spacing adjustments */
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .username-spacing {
            margin-right: 0.75rem; /* Add space between welcome message and logout button */
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar .container {
                justify-content: center;
            }
            .navbar-nav.ms-auto {
                flex-direction: row;
                margin-left: auto;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <!-- Brand name as plain text -->
                <span class="navbar-brand">Medical Chatbot</span>

                <!-- Navbar links (right-aligned) -->
                <ul class="navbar-nav ms-auto">
                    @guest
                        <!-- Login and register buttons removed -->
                    @else
                        <li class="nav-item username-spacing">
                            <!-- Welcome message with username -->
                            <span class="nav-link welcome-message">Welcome, {{ Auth::user()->name }}!</span>
                        </li>
                        <li class="nav-item">
                            <!-- Logout button with red styling -->
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="logout-button">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzW1BkW3zQZrBoC1F5rTph49WjMJwGhXQFZCG/XpDXZp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYlA+osdX3T16H5nI7mHGrxYZUypL6IjZfjG5C8o4v1p/GAJn5D8m8LfTUR9trX" crossorigin="anonymous"></script>
    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>
