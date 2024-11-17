<!-- resources/views/auth/signup.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Sign Up</h2>

        @if ($errors->any())
            <div class="mb-4">
                <ul class="list-disc list-inside text-red-500">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('signup.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition duration-200">
                Sign Up
            </button>
        </form>

        <p class="mt-4 text-center text-gray-600">
            Already have an account? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Log In</a>
        </p>
    </div>
</body>
</html>