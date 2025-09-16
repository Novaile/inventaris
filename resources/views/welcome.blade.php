<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative flex items-center justify-center min-h-screen">
    <div class="absolute inset-0 bg-cover bg-center blur-sm" style="background-image: url('/images/ngab.jpg')"></div>
    <div class="relative z-10 w-full max-w-sm p-6 bg-white rounded shadow bg-zinc-700">
        <h1 class="text-2xl font-bold text-center text-white mb-6">Login</h1>
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-white">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full px-4 py-2 border border-white rounded focus:outline-none focus:ring-green-500 focus:border-green-500" />
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-white">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full px-4 py-2 border border-white rounded focus:outline-none focus:ring-green-500 focus:border-green-500" />
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-gray-400 text-white font-semibold py-2 px-4 rounded hover:bg-gray-500 transition">
                    Login
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <p class="text-sm text-white">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-green-600 hover:underline font-medium">Register</a>
            </p>
        </div>
    </div>
</body>
</html>
