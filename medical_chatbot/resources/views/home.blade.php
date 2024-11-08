{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar for chat history -->
        <div class="col-12 col-md-3 p-3" style="height: auto; max-height: 100vh; overflow-y: auto; background-color: #e9f7ea; border-right: 1px solid #c7e3cc;">
            <h4 class="text-dark-green">Chat History</h4>
            <ul class="list-group" id="chat-history">
                @foreach($chats as $chat)
                    <li class="list-group-item d-flex justify-content-between align-items-center text-dark-green" style="transition: background-color 0.3s; cursor: pointer; background-color: #e9f7ea;">
                        <a href="{{ route('chat.show', $chat->id) }}" class="text-dark-green" style="text-decoration: none;">
                            {{ $chat->title }}
                        </a>
                        <small class="text-muted">{{ $chat->created_at->format('M d, Y') }}</small>
                        <form action="{{ route('chat.destroy', $chat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this chat?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" style="background-color: #b91c1c; color: white; border: none;">🗑️</button>
                        </form>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                <!-- New Chat Button to trigger modal -->
                <button class="btn w-100 text-white" style="background-color: #2f855a;" onclick="openChatTitleModal()">
                    New Chat
                </button>
            </div>
        </div>

        <!-- Main content area -->
        <div class="col-12 col-md-9 p-4" style="background-color: #e9f7ea;">
            <div class="card border-light">
                <div class="card-header bg-dark-green text-white d-flex justify-content-between">
                    <span>{{ __('Dashboard') }}</span>
                </div>
                <div class="card-body text-dark-green">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>{{ __('You are logged in!') }}</p>
                    <p>{{ __('Select a previous chat from the history or start a new one to begin.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for entering chat title -->
<div class="modal fade" id="chatTitleModal" tabindex="-1" role="dialog" aria-labelledby="chatTitleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chatTitleModalLabel">Enter Chat Title</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <form id="chatTitleForm" action="{{ route('chat.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="chatTitle">Chat Title</label>
                        <input type="text" class="form-control" id="chatTitle" name="chatTitle" required>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
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

    .list-group-item {
        border: none;
    }

    .list-group-item:hover {
        background-color: #d6eadb;
    }

    /* Responsive styling adjustments */
    @media (max-width: 768px) {
        /* Adjust sidebar height for mobile */
        .col-12.col-md-3 {
            height: auto;
            max-height: 60vh;
        }

        .list-group-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .list-group-item small {
            display: inline;
            margin-top: 4px;
        }
    }
</style>

<script>
function openChatTitleModal() {
    $('#chatTitleModal').modal('show');
}
</script>
@endsection
