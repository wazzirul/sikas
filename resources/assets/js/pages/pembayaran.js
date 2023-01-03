$(document).ready(function () {
  if($("#history-pembayaran").length == 1) {
    $('#history-pembayaran').DataTable();
  }
  if($("#riwayat-transaksi").length == 1) {
    $('#riwayat-transaksi').DataTable();
  }
  if($("#riwayat-tabungan-sekolah").length == 1) {
    $('#riwayat-tabungan-sekolah').DataTable();
  }
});