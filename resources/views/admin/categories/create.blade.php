<!-- resources/views/admin/categories/create.blade.php -->

@extends('layouts.app')

@section('content-title', 'Upload Data Category')

@section('content')
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <h3 style="text-align: center">Upload Data Kategori</h3>

        <form action="{{ route('admin.categories.store') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="name">Nama Kategori:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
@endsection
