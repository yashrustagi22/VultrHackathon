{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Medical Chatbot</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Basic Reset and Font */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #c7f1b6; /* Light green background */
            color: #333;
            font-family: 'Nunito', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        /* Container Styling */
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 400px;
            text-align: center;
            width: 90%;
        }

        /* Header Styling */
        h2 {
            color: #2e7d32; /* Dark green for headers */
            font-weight: bold;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        /* Paragraph Styling */
        p {
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Button Styling */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
            width: 100%;
            margin-top: 0.5rem;
        }
        .btn-primary {
            background-color: #2e7d32; /* Green background */
            color: #ffffff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #256629; /* Darker green on hover */
        }
        .btn-secondary {
            background-color: transparent;
            color: #2e7d32;
            border: 2px solid #2e7d32;
        }
        .btn-secondary:hover {
            background-color: #2e7d32;
            color: #ffffff;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .container {
                padding: 1.5rem;
            }
            h2 {
                font-size: 1.25rem;
            }
            p, .btn {
                font-size: 0.9rem;
            }
        }
        @media (max-width: 480px) {
            h2 {
                font-size: 1.1rem;
            }
            p, .btn {
                font-size: 0.85rem;
            }
            .btn {
                padding: 0.6rem 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to the Medical Chatbot</h2>
        <p>Upload your prescription and get medicine information instantly.</p>

        <!-- Conditional Buttons -->
        @if(Auth::check())
            <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-secondary">Login to Access Chat</a>
        @endif
    </div>
</body>
</html>
