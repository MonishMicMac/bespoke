<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    <form method="POST" action="{{ url('/admin/login') }}">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
