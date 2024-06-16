@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @forelse ($articles as $article)
                    <div class="mb-5">
                        <h2 class="h1 fw-semibold">{{ $article->title }}</h2>
                        <p class="text-secondary">By {{ $article->author->name }} at {{ $article->created_at }}</p>
                        <div style="white-space: pre" class="lead">{{ $article->content }}</div>
                    </div>
                @empty
                    <div class="text-center">No articles yet.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
