@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 p-4" style="background-color: #e9f7ea;">
            <div class="card border-light">
                <div class="card-header text-white" style="background-color: #2f855a; padding: 15px; border-radius: 0.5rem;">
                    <h1 class="mb-0">{{ $chat->title }}</h1>
                </div>
                <div class="card-body text-dark-green">
                    <!-- Display the chat content -->
                    <p>{{ $chat->content }}</p>

                    @if(empty($chat->content))
                        <h5 class="text-muted">No messages to display.</h5> <!-- Just a placeholder -->
                    @endif

                    <a href="{{ route('home') }}" class="btn btn-success mt-3" style="background-color: #2f855a; color: white;">
                        Back to Chat List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom color theme */
    .text-dark-green {
        color: #2f855a;
    }

    .btn-success {
        background-color: #2f855a;
        border-color: #2f855a;
    }

    .btn-success:hover {
        background-color: #276749;
        border-color: #276749;
    }

    /* Title Box Style */
    .card-header {
        padding: 15px; /* Added padding for the title box */
        border-radius: 0.5rem; /* Rounded corners */
    }
</style>
@endsection
