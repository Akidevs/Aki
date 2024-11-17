<!-- resources/views/owner/create-product.blade.php -->

@extends('layouts.app')

@section('title', 'Upload Product')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Upload New Product</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('owner.store-product') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Product Name</label>
            <input type="text" name="name" id="name" class="w-full border px-3 py-2 rounded" value="{{ old('name') }}" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700">Description</label>
            <textarea name="description" id="description" class="w-full border px-3 py-2 rounded" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700">Price ($)</label>
            <input type="number" name="price" id="price" class="w-full border px-3 py-2 rounded" step="0.01" value="{{ old('price') }}" required>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-700">Product Image</label>
            <input type="file" name="image" id="image" class="w-full border px-3 py-2 rounded" accept="image/*" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Upload Product</button>
    </form>
</div>
@endsection