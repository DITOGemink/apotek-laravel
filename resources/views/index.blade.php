@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Welcome to My Laravel App</h1>

    @if (Auth::check())
        <div class="card">
            <div class="card-body">
                <p><strong>ID:</strong> {{ $id }}</p>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Role:</strong> {{ $user->role ?? 'N/A' }}</p>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
                {{-- menu khusus admin --}}
                @if ($user->role === 'admin')
                    <a href="{{ url('/admin/dashboard') }}" class="btn btn-warning mt-3">Admin Panel</a>
                @endif
            </div>
        </div>
    @else
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
    @endif
</div>
@endsection
