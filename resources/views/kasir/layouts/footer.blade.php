<footer>
    <div class="footer clearfix mb-0 text-muted">
        <div class="float-end">
            <p>Created by Admin</p>
        </div>
    </div>
</footer>
</div>
</div>
<script src="/vendor/admin/assets/js/feather-icons/feather.min.js"></script>
<script src="/vendor/admin/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/vendor/admin/assets/js/app.js"></script>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>

<script src="/vendor/datatables/datatables.min.js"></script>
<script src="/vendor/datatables/Datatables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets/modules/izitoast/js/iziToast.min.js"></script>

<script src="/vendor/admin/assets/vendors/chartjs/Chart.min.js"></script>
<script src="/vendor/admin/assets/vendors/apexcharts/apexcharts.min.js"></script>
<script src="/vendor/admin/assets/js/pages/dashboard.js"></script>
<script src="{{ asset('vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('vendor/vendors.js') }}"></script>

<!-- Load jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Load DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- Load Feather Icons -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

<script src="/vendor/admin/assets/js/main.js"></script>

@if(session('berhasil'))
<script>
    window.open("/kasir/transaksi/{{session('berhasil')}}/print")
</script>
@endif

</body>

</html>