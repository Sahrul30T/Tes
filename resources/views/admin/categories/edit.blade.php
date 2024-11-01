<!-- resources/views/admin/categories/edit.blade.php -->

@extends('layouts.app')

@section('content-title', 'Edit Data Category')

@section('content')
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <h3 style="text-align: center">Edit Data Kategori</h3>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Kategori:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
