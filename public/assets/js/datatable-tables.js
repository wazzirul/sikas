$(document).ready(function () {
  if ($("#data-jenis-pembayaran").length == 1) {
    $('#data-jenis-pembayaran').DataTable();
  }
  if ($("#data-laporan").length == 1) {
    $('#data-laporan').DataTable({
      "aaSorting": [],
    });
  }
  if ($("#data-laporan-penggunaan-dana").length == 1) {
    $('#data-laporan-penggunaan-dana').DataTable();
  }
  if ($("#data-laporan-pemasukan-sumber-lain").length == 1) {
    $('#data-laporan-pemasukan-sumber-lain').DataTable();
  }
  if ($("#data-laporan-pengajuan-keringanan").length == 1) {
    $('#data-laporan-pengajuan-keringanan').DataTable();
  }
  if ($("#data-laporan-pembayaran-spp").length == 1) {
    $('#data-laporan-pembayaran-spp').DataTable();
  }
  if ($("#data-laporan-pembayaran-tabungan").length == 1) {
    $('#data-laporan-pembayaran-tabungan').DataTable();
  }
  if ($("#data-master-jabatan").length == 1) {
    $('#data-master-jabatan').DataTable();
  }
});