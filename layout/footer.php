<!-- /.content-wrapper --> 
<footer class="footer"> 
     
</footer> 
 
<!-- Control Sidebar --> 
<aside class="control-sidebar control-sidebar-dark"> 
    <!-- Control sidebar content goes here --> 
</aside> 
<!-- /.control-sidebar --> 
</div> 
<!-- ./wrapper --> 
 
<!-- jQuery --> 
<script src="assets-template/plugins/jquery/jquery.min.js"></script> 
<!-- jQuery UI 1.11.4 --> 
<script src="assets-template/plugins/jquery-ui/jquery-ui.min.js"></script> 
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip --> 
<script> 
    $.widget.bridge('uibutton', $.ui.button) 
</script> 
<!-- Bootstrap 4 --> 
<script src="assets-template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> 
<!-- ChartJS --> 
<script src="assets-template/plugins/chart.js/Chart.min.js"></script> 
<!-- Sparkline --> 
<script src="assets-template/plugins/sparklines/sparkline.js"></script> 
<!-- daterangepicker --> 
<script src="assets-template/plugins/moment/moment.min.js"></script> 
<script src="assets-template/plugins/daterangepicker/daterangepicker.js"></script> 
<!-- Tempusdominus Bootstrap 4 --> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> 
<!-- overlayScrollbars --> 
<script src="assets-template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> 
<!-- AdminLTE App --> 
<script src="assets-template/dist/js/adminlte.js"></script> 
<!-- AdminLTE dashboard demo (This is only for demo purposes) --> 
<script src="assets-template/dist/js/pages/dashboard.js"></script> 
<!-- DataTables  & Plugins --> 
<script src="assets-template/plugins/datatables/jquery.dataTables.min.js"></script> 
<script src="assets-template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script> 
<script src="assets-template/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script> 
<script src="assets-template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> 
<script src="assets-template/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script> 
<script src="assets-template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script> 
<!-- load ckeditor cdn --> 
<script src="https://cdn.ckeditor.com/4.19.0/full/ckeditor.js"></script> 
 
<script> 
    CKEDITOR.replace('alamat', { 
        filebrowserBrowseUrl: 'assets-template/ckfinder/ckfinder.html', 
        filebrowserUploadUrl: 'assets-template/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files', 
        height: '400px' 
    }); 
</script> 
<script> 
    $(function() { 
        $('#example2').DataTable(); 
    }); 
</script> 
</body> 
 
</html>