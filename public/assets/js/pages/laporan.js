
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

$(document).ready(function () {
  $('.applyBtn').click(() => {
    let tanggal_awal = $('#date-range-span').data('daterangepicker').startDate.format('YYYY-MM-DD');
    let tanggal_akhir = $('#date-range-span').data('daterangepicker').endDate.format('YYYY-MM-DD');

    $.ajax({
      url: '/query/laporan',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        tanggal_awal: tanggal_awal,
        tanggal_akhir: tanggal_akhir,
      },
      success: (result) => {
        $('#tbody-laporan').empty();

        // Saldo
        $('#tbody-laporan').append(`
          <tr>
            <td>
              <p class="text-bold text-primary">${moment(tanggal_akhir).format('DD MMMM YYYY')}</p>
            </td>
            <td class="data-laporan__keterangan">
              <p class="text-bold text-primary">Saldo ${moment(tanggal_akhir).format('MMMM YYYY')}</p>
            </td>
            <td>
              <p class="text-bold text-primary nominal-transaksi">Rp. ${numberFormat(result.bpp_sekolah)}</p>
            </td>
            <td>
              <p class="text-bold text-primary nominal-transaksi">-</p>
            </td>
            <td>
              <p class="text-bold text-primary nominal-transaksi">Rp. ${numberFormat(result.tabungan_sekolah)}</p>
            </td>
            <td>
              <p class="text-bold text-primary nominal-transaksi">-</p>
            </td>
          </tr>
        `);

        // Penerimaan BPP
        $('#tbody-laporan').append(`
          <tr>
            <td>
              <p class="text-medium color-neutral-100">${result.data_spp_bulan_ini != null ? moment(result.data_spp_bulan_ini.tanggal).format('DD MMMM YYYY') : moment(tanggal_akhir).format('DD MMMM YYYY')}</p>
            </td>
            <td class="data-laporan__keterangan">
              <p class="text-medium color-neutral-100">Penerimaan BPP</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi">Rp. ${numberFormat(result.spp_bulan_ini)}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi">-</p>
            </td>
          </tr>
        `);

        // Penerimaan Tabungan
        $('#tbody-laporan').append(`
          <tr>
            <td>
              <p class="text-medium color-neutral-100">${result.data_tabungan_bulan_ini != null ? moment(result.data_tabungan_bulan_ini.tanggal).format('DD MMMM YYYY') : moment(tanggal_akhir).format('DD MMMM YYYY')}</p>
            </td>
            <td class="data-laporan__keterangan">
              <p class="text-medium color-neutral-100">Penerimaan Tabungan</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi">Rp. ${numberFormat(result.tabungan_bulan_ini)}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi">-</p>
            </td>
          </tr>
        `);

        // Penarikan Tabungan
        $('#tbody-laporan').append(`
          <tr>
            <td>
              <p class="text-medium color-neutral-100">${result.data_tarik_tabungan_bulan_ini != null ? moment(result.data_tarik_tabungan_bulan_ini.tanggal).format('DD MMMM YYYY') : moment(tanggal_akhir).format('DD MMMM YYYY')}</p>
            </td>
            <td class="data-laporan__keterangan">
              <p class="text-medium color-neutral-100">Penarikan Tabungan</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi">Rp. ${numberFormat(result.tarik_tabungan_bulan_ini)}</p>
            </td>
          </tr>
        `);

        $.each(result.transaksi_lain_bulan_ini, (index, value) => {
          $('#tbody-laporan').append(`
            <tr>
              <td>
                <p class="text-medium color-neutral-100">${moment(value.tanggal).format('DD MMMM YYYY')}</p>
              </td>
              <td class="data-laporan__keterangan">
                <p class="text-medium color-neutral-100">${value.nama_transaksi}</p>
              </td>
              <td>
                <p class="text-medium color-neutral-100 nominal-transaksi">${value.tipe_transaksi == 5 ? 'Rp. ' + numberFormat(value.jumlah) : '-'}</p>
              </td>
              <td>
                <p class="text-medium color-neutral-100 nominal-transaksi">${value.tipe_transaksi == 4 ? 'Rp. ' + numberFormat(value.jumlah) : '-'}</p>
              </td>
              <td>
                <p class="text-medium color-neutral-100 nominal-transaksi">-</p>
              </td>
              <td>
                <p class="text-medium color-neutral-100 nominal-transaksi">-</p>
              </td>
            </tr>
          `);
        })
      },
      error: (err) => {
        console.log(err);
      }
    })

  })

  $.each($('.nominal-transaksi'), (index, value) => {
    $(value).text() != "-" && $(value).text('Rp. ' + numberFormat($(value).text()))
  })
})

function numberFormat(x) {
  var parts = x.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  return parts.join(",");
}
