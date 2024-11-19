@extends('layouts.app')

@section('content')


<div class="container">
    <h1>{{ $post->title }}</h1>

    {{-- Display the post image if available --}}
    @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" style="width: 200px; height: auto;">
    @else
        <p>No image available for this post.</p>
    @endif

    <p>{{ $post->description }}</p>

    <p><strong>Posted by:</strong> {{ $post->user->name }}</p>

    {{-- Display comments --}}
    <h3>Comments</h3>
    @foreach($post->comments as $comment)
        <div class="comment">
            <strong>{{ $comment->user->name }}</strong> said:
            <p>{{ $comment->content }}</p>
        </div>
    @endforeach

    {{-- Comment form --}}
    @auth
        <h3>Leave a Comment</h3>
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <div class="form-group">
                <textarea name="content" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Comment</button>
        </form>
    @else
        <p>Please <a href="{{ route('login') }}">log in</a> to leave a comment.</p>
    @endauth

    
    <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Back to All Posts</a>
</div>
@endsection
