<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>

<body>
    <form id="contactForm" action="{{ route('password.store') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ request()->route('token') }}">
        <input type="hidden" name="email" value="{{ request()->email }}">
        <input type="text" name="password" id="password" placeholder="Password *">
        <input type="text" name="password_confirmation" id="password_confirmation" placeholder="Conform Password *">

        <button type="submit">Send Message</button>
    </form>

</body>

</html>
