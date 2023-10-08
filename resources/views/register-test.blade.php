<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    @if(Cookie::get('auth'))
        <script>location.href='test';</script>
    @endif

    @if(isset($message))
        <p>Kalimat: {{ $message }}</p>
    @else
        <p>kalimat: -------.</p>
    @endif

    <form method="POST" action="{{ route('registercall')}}">
        @csrf

        <div>
            <label for="email">email</label>
            <input type="text" name="email" id="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div>
            <label for="username">username</label>
            <input type="text" name="username" id="usernameusername" value="{{ old('username') }}" required autofocus>
        </div>

        <div>
            <label for="password">password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div>
            <button type="submit">Login</button>
        </div>
    </form>
</body>
</html>
