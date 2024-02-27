<section class="section">
<div class="container-fluid pt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h3>Data Transaksi</h3>
                    @if (auth()->user()->level=="Kasir")
                    <a href="/kasir/transaksi/create" class="btn btn-primary">Tambah Transaksi</a>
                    @endif
                    <table class='table table-striped' id="table1">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Total</th>
                                @if (auth()->user()->level=="Kasir")
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ 'Rp. '.format_rupiah($item->total) }}</td>
                                @if (auth()->user()->level=="Kasir")
                                <td>
                                    <div class="d-flex">
                                        <a href="/kasir/transaksi/{{$item->id}}/edit" class="btn btn-info btn-sm"><i data-feather="edit"></i></a>
                                        <a href="/kasir/transaksi/{{$item->id}}/print" class="btn btn-sm btn-success mr-1" target="_blank"><i data-feather="printer"></i></a>
                                        <a href="/kasir/transaksi/{{$item->id}}" class="btn btn-warning btn-sm"><i data-feather="eye"></i></a>
                                        <!--<a href="" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>-->
                                        <form action="/kasir/transaksi/{{$item->id}}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm ml-1"><i data-feather="trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<script>
$(document).ready(function() {
    var table = $('#table1').DataTable();
    
    // Event delegation for delete button
    $('#table1').on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var confirmDelete = confirm('Are you sure you want to delete?');
        if (confirmDelete) {
            form.submit();
        }
    });
    
    // Reinitialize Feather Icons after DataTables pagination
    table.on('draw.dt', function () {
        feather.replace();
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>