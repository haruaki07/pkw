@extends('layouts.app')

@php
    $is_user = Request::user()->role === App\Enums\UserRole::User;
@endphp

@section('title', $is_user ? 'My Articles' : 'Articles')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __($is_user ? 'My Articles' : 'Articles') }}</div>

                    <div class="card-body">
                        @if (session('status') === 'article-created')
                            <div class="alert alert-success" role="alert">
                                Posted new article!
                            </div>
                        @endif

                        @if (session('status') === 'article-deleted')
                            <div class="alert alert-success" role="alert">
                                Article has been deleted!
                            </div>
                        @endif

                        <a href="{{ route('articles.create') }}" class="btn btn-primary mb-2">Write new article</a>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <caption>
                                    Showing {{ count($articles) }} article{{ count($articles) > 1 ? 's' : '' }}
                                </caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Title</th>
                                        @if (Request::user()->role !== \App\Enums\UserRole::User)
                                            <th scope="col">Author</th>
                                        @endif
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($articles as $article)
                                        <tr>
                                            <td>{{ $article->title }}</td>
                                            @if (Request::user()->role !== \App\Enums\UserRole::User)
                                                <th scope="col">{{ $article->author->name }}</th>
                                            @endif
                                            <td>{{ $article->created_at }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route('articles.edit', $article->id) }}">
                                                    Edit
                                                </a>

                                                <form method="POST" action="{{ route('articles.destroy', $article->id) }}"
                                                    style="display:inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault(); confirm('Are you sure? This action is irreversible!') && form.submit()">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                @if ($is_user)
                                                    You don't have any articles yet.
                                                @else
                                                    There are no articles yet.
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
