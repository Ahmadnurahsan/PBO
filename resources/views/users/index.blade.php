<!DOCTYPE html>
<html>
<head>
    <title>Daftar User</title>
</head>
<body>
    <h1>Daftar User</h1>

    <a href="{{ route('users.create') }}">Buat User Baru</a>

    <ul>
        @foreach ($users as $user)
            <li>{{ $user->name }} ({{ $user->email }})</li>
        @endforeach
    </ul>
</body>
</html>
