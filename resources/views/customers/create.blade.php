@extends('layouts.app')

@section('title', 'Add Customer')

@section('content')
    <div class="container">
        <h1 class="my-4"></h1>
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
            <div class="form-group">
                <label for="phone">Phone number</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Add</button>
                <a href="{{ route('customers.index') }}" class="btn btn-secondary">Return</a>
            </div>
        </form>
    </div>
@endsection