<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah User Baru</title>
</head>
<body>
    <h1>Tambah User Baru</h1>
    <a href="{{ route('superadmin.users.index') }}">Kembali ke Daftar User</a>
    <hr>

    <form action="{{ route('superadmin.users.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nama Lengkap:</label><br>
            <input type="text" id="name" name="name" required>
        </div>
        <br>
        <div>
            <label for="email">Alamat Email:</label><br>
            <input type="email" id="email" name="email" required>
        </div>
        <br>
        <div>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
        </div>
        <br>
        <button type="submit">Simpan User</button>
    </form>
</body>
</html>