@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Users') }}</div>

                    <div class="card-body">
                        @if (session('status') === 'user-created')
                            <div class="alert alert-success" role="alert">
                                New user has been created!
                            </div>
                        @endif

                        @if (session('status') === 'user-deleted')
                            <div class="alert alert-success" role="alert">
                                User has been deleted!
                            </div>
                        @endif

                        <a href="{{ route('users.create') }}" class="btn btn-primary mb-2">Create new user</a>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <caption>
                                    Showing {{ count($users) }} user{{ count($users) > 1 ? 's' : '' }}
                                </caption>
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->role->name }}</td>
                                            <td>{{ $user->created_at }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route('users.edit', $user->id) }}">
                                                    Edit
                                                </a>

                                                <form method="POST" action="{{ route('users.destroy', $user->id) }}"
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
                                                There are no users yet.
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
