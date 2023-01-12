$(document).ready(function () {
  if ($("#riwayat-transaksi").length == 1) {
    $('#riwayat-transaksi').DataTable({
      "aaSorting": [],
    });
  }
  if ($("#riwayat-tabungan-sekolah").length == 1) {
    $('#riwayat-tabungan-sekolah').DataTable({
      "aaSorting": [],
    });
  }
  if ($("#history-transaksi-siswa").length == 1) {
    $('#history-transaksi-siswa').DataTable({
      "aaSorting": [],
    });
  }

  if ($("#upload-surat-pengajuan").length == 1) {
    $('#upload-surat-pengajuan').change(function () {
      var f = this.files[0];
      var name = f.name;
      $('.pengajuan-keringanan-form__item-upload').find('.file-name').text(name);
    });
  }
  $(function () {
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('#date-range-span span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
      $('#date-range-input').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }

    $('#date-range-span').daterangepicker({
      startDate: start,
      endDate: end,
      alwaysShowCalendars: true,
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    }, cb);

    cb(start, end);

  });

  $.each($('.jumlah-pembayaran'), (index, value) => {
    $(value).text('Rp. ' + numberFormat($(value).text()))
  })
});

function numberFormat(x) {
  var parts = x.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  return parts.join(",");
}
