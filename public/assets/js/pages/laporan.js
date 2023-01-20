
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
  $(document).on('click', 'button#button-cetak-laporan', function () {
    let tableInnerHTML = $(document).find('table#data-laporan').html()
    let date = `${$('#date-range-span').data('daterangepicker').startDate.format('D MMMM YYYY')} - ${$('#date-range-span').data('daterangepicker').endDate.format('D MMMM YYYY')}`

    printJS({
      printable: `
      <div>
        <div class="page-header">
          <h2 class="page-header-title">Data Laporan</h2>
          <div class="page-header">${date}</div>
        </div>
        <div class="page-content">
          <table>
            ${tableInnerHTML}
          </table>
        </div>
      </div>`,
      type: 'raw-html',
      header: null,
      style: '@media print { @page { margin-top: 0; margin-bottom: 0; } body { font-size: 14px; padding: 0; } } .page { width: 100%; min-height: 420px; padding-top: 16px; padding-bottom: 16px; display: flex; flex-direction: column; align-items: stretch; justify-content: space-between; } .page-header { display: flex; flex-direction: row; align-items: center; justify-content: space-between; } .page-content { margin-top: 16px; } table { border: 1px solid #E0E0E0; border-collapse: collapse; } table th, table td { border: 1px solid #E0E0E0; padding: 8px 16px !important; } table thead th, table thead td { text-align: left; white-space: nowrap; }',
      gridStyle: 'padding: 2px;',
      documentTitle: 'Data Laporan'
    })
  })

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
              <p class="text-bold text-primary nominal-transaksi-laporan">Rp. ${numberFormat(result.bpp_sekolah)}</p>
            </td>
            <td>
              <p class="text-bold text-primary nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-bold text-primary nominal-transaksi-laporan">Rp. ${numberFormat(result.tabungan_sekolah)}</p>
            </td>
            <td>
              <p class="text-bold text-primary nominal-transaksi-laporan">-</p>
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
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">Rp. ${numberFormat(result.spp_bulan_ini)}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
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
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">Rp. ${numberFormat(result.tabungan_bulan_ini)}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
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
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">Rp. ${numberFormat(result.tarik_tabungan_bulan_ini)}</p>
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
                <p class="text-medium color-neutral-100 nominal-transaksi-laporan">${value.tipe_transaksi == 5 ? 'Rp. ' + numberFormat(value.jumlah) : '-'}</p>
              </td>
              <td>
                <p class="text-medium color-neutral-100 nominal-transaksi-laporan">${value.tipe_transaksi == 4 ? 'Rp. ' + numberFormat(value.jumlah) : '-'}</p>
              </td>
              <td>
                <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
              </td>
              <td>
                <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
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

  $.each($('.nominal-transaksi-laporan'), (index, value) => {
    $(value).text() != "-" && $(value).text('Rp. ' + numberFormat($(value).text()))
  })
})

function numberFormat(x) {
  var parts = x.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  return parts.join(",");
}