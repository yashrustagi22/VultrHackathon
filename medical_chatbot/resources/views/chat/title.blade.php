{{-- resources/views/chat/title.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Set Chat Title</h1>
    <form action="{{ route('chat.store') }}" method="POST">
        @csrf
        <input type="hidden" name="extracted_text" value="{{ $extractedText }}">
        <div class="form-group">
            <label for="title">Chat Title</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Chat</button>
    </form>
</div>
@endsection
