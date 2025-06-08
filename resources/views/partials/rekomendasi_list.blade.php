@if ($rekomendasi->isEmpty())
    <p>Tidak ada rekomendasi.</p>
@else
    <table class="table table-bordered table-striped table-hover table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>IPK</th>
                <th>Angkatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekomendasi as $item)
                <tr>
                    <td>{{ $item->rekomendasi_id }}</td>
                    <td>{{ $item->mahasiswa->nim }}</td>
                    <td>{{ $item->mahasiswa->user->nama }}</td>
                    <td>{{ $item->mahasiswa->ipk }}</td>
                    <td>{{ $item->mahasiswa->angkatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
