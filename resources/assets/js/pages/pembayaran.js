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
  if($("#riwayat-tabungan").length == 1) {
    $('#riwayat-tabungan').DataTable();
  }
  if($("#upload-surat-pengajuan").length == 1) {
    $('#upload-surat-pengajuan').change(function(){
      var f = this.files[0];  
      var name = f.name;    
      $('.pengajuan-keringanan-form__item-upload').find('.file-name').text(name);
    });
  }
});