$(document).ready(function () {
  if($("#data-jenis-pembayaran").length == 1) {
    $('#data-jenis-pembayaran').DataTable();
  }
  if($("#data-laporan").length == 1) {
    $('#data-laporan').DataTable();
  }
  if($("#data-laporan-penggunaan-dana").length == 1) {
    $('#data-laporan-penggunaan-dana').DataTable();
  }  
  if($("#data-laporan-pemasukan-sumber-lain").length == 1) {
    $('#data-laporan-pemasukan-sumber-lain').DataTable();
  }  
  if($("#data-laporan-pengajuan-keringanan").length == 1) {
    $('#data-laporan-pengajuan-keringanan').DataTable();
  }  
  if($("#data-laporan-pembayaran-spp").length == 1) {
    $('#data-laporan-pembayaran-spp').DataTable();
  }  
});