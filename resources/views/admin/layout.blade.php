<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('admin/style.css') }}">
</head>
<body>

<div class="sidebar">
    <h2>Admin</h2>
    <a href="/admin">Dashboard</a>
    <a href="/admin/users">User</a>
    <a href="/admin/barang">Barang</a>
</div>

<div class="content">
    @yield('content')
</div>

</body>
</html>
