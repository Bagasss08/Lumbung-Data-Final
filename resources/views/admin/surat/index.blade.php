<h3>Daftar Template Surat</h3>

<table border="1" cellpadding="8">
    <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Aksi</th>
    </tr>
    @foreach($templates as $t)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $t->judul }}</td>
        <td>
            <a href="{{ route('template-surat.form', $t->id) }}">Pakai Template</a>
        </td>
    </tr>
    @endforeach
</table>