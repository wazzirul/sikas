
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

  $(document).on('click', 'button#button-cetak-laporan', function () {
    let table = $(document).find('#data-laporan').parent().html()
    let date = `${$('#date-range-span').data('daterangepicker').startDate.format('D MMMM YYYY')} - ${$('#date-range-span').data('daterangepicker').endDate.format('D MMMM YYYY')}`

    printJS({
      printable: `
      <div>
        <div class="page-header">
          <h2 class="page-header-title">Laporan Pembayaran Siswa</h2>
          <div class="page-header">${date}</div>
        </div>
        <div class="page-content">${table}</div>
      </div>`,
      type: 'raw-html',
      header: null,
      style: '@media print { @page { margin-top: 0; margin-bottom: 0; } body { font-size: 14px; padding: 0; } } .page { width: 100%; min-height: 420px; padding-top: 16px; padding-bottom: 16px; display: flex; flex-direction: column; align-items: stretch; justify-content: space-between; } .page-header { display: flex; flex-direction: row; align-items: center; justify-content: space-between; } .page-content { margin-top: 16px; } table { border: 1px solid #E0E0E0; border-collapse: collapse; } table th, table td { border: 1px solid #E0E0E0; padding: 8px 16px !important; } table thead th, table thead td { text-align: left; white-space: nowrap; }',
      gridStyle: 'padding: 2px;',
      documentTitle: 'Laporan Pembayaran Siswa'
    })
  })

});