<section class="section">
    <div class="container-fluid pt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow p-3 mb-5 bg-white rounded">
                    <div class="card-body">
                        <h3>Data Ukuran</h3>
                        <a href="/admin/ukuran/create" class="btn btn-primary">Tambah Ukuran</a>
                        <table class='table table-striped' id="table1">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Ukuran</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ukuran as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->size }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="/admin/ukuran/{{$item->id}}/edit" class="btn btn-info btn-sm"><i data-feather="edit"></i></a>
                                            <!--<a href="" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>-->
                                            <form action="/admin/ukuran/{{$item->id}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm ml-1"><i data-feather="trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
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