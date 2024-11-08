@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 text-center mt-4">
            <button class="homeButton" onclick="window.location.href='{{ route('home') }}'">Back to Home</button>
        </div>
    </div>

    <div class="row justify-content-center"> <!-- Centering the row -->
        <div class="col-md-8"> <!-- Adjusted column width to keep it centered -->
            <div class="card border-light">
                <div class="card-header bg-light text-muted">{{ __('Chat with Your Doctor') }}</div>
                <div class="card-body d-flex flex-column" style="height: 60vh; padding: 0;">
                    <div id="chat-window" style="flex: 1; overflow-y: auto; padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 5px;">
                        @foreach($messages ?? [] as $message)
                            <div class="chat-message {{ $message->type }}">
                                <strong>{{ $message->user->name }}:</strong>
                                <p>{{ $message->content }}</p>
                                @if($message->image_path)
                                    <img src="{{ asset('storage/' . $message->image_path) }}" alt="Image" style="max-width: 150px; height: auto;">
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="input-group mt-3">
                        <button class="btn btn-primary" onclick="showInput('device')">Upload from Device</button>
                        <button class="btn btn-primary" onclick="showInput('camera')">Use Camera</button>
                    </div>

                    <form id="uploadFormDevice" enctype="multipart/form-data" style="display: none;">
                        @csrf
                        <input type="file" name="image" accept="image/*" id="fileInputDevice" required>
                        <button type="submit" class="btn btn-primary">Upload Prescription</button>
                    </form>

                    <form id="uploadFormCamera" action="{{ route('chat.upload') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                        @csrf
                        <input type="file" name="image" accept="image/*" capture="environment" id="fileInputCamera" required>
                        <button type="submit" class="btn btn-primary">Upload Prescription</button>
                    </form>

                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">Cancel</button>

                    <div id="loading" class="loading" style="display:none;">
                        <i class="fas fa-spinner fa-spin"></i> Processing your prescription...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Main theme colors */
    body {
        background-color: #002d25; /* Dark background */
    }

    h4.text-muted {
        color: #2e7d32; /* Dark green for header */
    }

    /* Chat message styling */
    .chat-message {
        padding: 10px 15px;
        border-radius: 20px;
        max-width: 70%;
        margin: 5px 0;
        transition: background-color 0.2s ease;
    }

    .sent {
        background-color: transparent; /* Dark green for sent messages */
        color: white;
        text-align: right;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
        align-self: flex-end; /* Aligns to the right */
        margin-left: auto;
    }

    .received {
        background-color: #e9f7e9; /* Light green for received messages */
        color: black;
        text-align: left;
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
        align-self: flex-start; /* Aligns to the left */
        margin-right: auto;
        margin-top: 10px;
    }

    /* Button styling */
    .btn-primary {
        background-color: #2e7d32; /* Dark green */
        border-color: #2e7d32;
        color: white;
    }
    .btn-primary:hover {
        background-color: #256629; /* Darker green */
    }

    .btn-secondary {
        background-color: transparent;
        color: #2e7d32;
        border: 2px solid #2e7d32;
    }
    .btn-secondary:hover {
        background-color: #2e7d32;
        color: white;
    }

    /* Loading spinner styling */
    .loading {
        font-size: 16px;
        color: #2e7d32;
        display: none;
    }

    /* Uniform small size for uploaded images */
    .chat-message img {
        width: 90px;
        height: auto;
        border-radius: 8px;
    }

    .homeButton {
        background: #256629;
        color: black;
        padding: 10px;
        border-radius: 8px;
        margin: 10px;
        border: 2px solid #2e7d32;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .col-md-8 {
            padding: 25px; /* No padding for mobile */
        }
        .card-header, .btn-primary, .btn-secondary {
            font-size: 0.9rem;
            padding: 15px;
        }
        .chat-message {
            font-size: 0.9rem;
        }
    }

    /* Full-width adjustments for larger screens */
    @media (min-width: 769px) {
        #chat-window {
            width: 100%; /* Ensure full width */
            max-width: 100%; /* Prevent overflow */
        }

        .card {
            width: 100%; /* Ensure card is full width */
            max-width: 100%; /* Prevent overflow */
        }

        .input-group {
            width: 100%; /* Ensure input group is full width */
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const isAuthenticated = @json(auth()->check());
        if (!isAuthenticated) {
            alert("Session has expired. Please log in again.");
            window.location.href = "{{ route('login') }}";
        }
    });

    document.getElementById('uploadFormDevice').addEventListener('submit', submitForm);
    document.getElementById('uploadFormCamera').addEventListener('submit', submitForm);

    function showInput(method) {
        // Hide both forms initially
        document.getElementById('uploadFormDevice').style.display = 'none';
        document.getElementById('uploadFormCamera').style.display = 'none';

        // Show the selected form based on the button clicked
        if (method === 'device') {
            document.getElementById('uploadFormDevice').style.display = 'block';
        } else if (method === 'camera') {
            document.getElementById('uploadFormCamera').style.display = 'block';
        }
    }

    async function submitForm(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        const loadingElement = document.getElementById('loading');
        loadingElement.style.display = 'block';

        const fileInput = event.target.querySelector('input[type="file"]');
        const file = fileInput.files[0];
        const imageUrl = URL.createObjectURL(file);

        addChatMessage(imageUrl, 'sent', true);

        try {
            const response = await fetch("{{ route('chat.upload') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (!response.ok) {
                const errorResponse = await response.json();
                addChatMessage(errorResponse.errors ? errorResponse.errors.image[0] : 'Unexpected error', 'received', false);
                throw new Error('Invalid image format! Please try again');
            }

            const data = await response.json();
            addChatMessage(data.text || 'File uploaded successfully!', 'received', false);
        } catch (error) {
            addChatMessage(`Error: ${error.message}`, 'received', false);
        } finally {
            loadingElement.style.display = 'none';
        }
    }

    function addChatMessage(message, type, isImage) {
        const chatWindow = document.getElementById('chat-window');
        const messageDiv = document.createElement('div');
        
        if (isImage) {
            const img = document.createElement('img');
            img.src = message;
            img.alt = 'Uploaded Image';
            img.style.width = '150px';
            img.style.height = 'auto';
            messageDiv.appendChild(img);
        } else {
            messageDiv.innerText = message;
        }
        
        messageDiv.className = 'chat-message ' + (type === 'sent' ? 'sent' : 'received');
        chatWindow.appendChild(messageDiv);
        chatWindow.scrollTop = chatWindow.scrollHeight;
    }

    if (performance.navigation.type === performance.navigation.TYPE_RELOAD) {
    window.location.href = "{{ route('home') }}";
    }
</script>

<div id="error-message" style="color: red; margin-top: 10px;"></div>
@endsection
