$(document).ready(function () {
    $(document).on('click', 'button#button-cetak-laporan', function () {
        let tableInnerHTML = $(document).find('table#data-laporan-pembayaran-tabungan').html()
        let date = `${$('#date-range-span').data('daterangepicker').startDate.format('D MMMM YYYY')} - ${$('#date-range-span').data('daterangepicker').endDate.format('D MMMM YYYY')}`

        printJS({
            printable: `
          <div>
            <div class="page-header">
              <h2 class="page-header-title">Laporan Pembayaran Tabungan</h2>
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
            style: '@media print { @page { margin-top: 48px; margin-bottom: 48px; } @page:first { margin-top: 0; margin-bottom: 0; } body { font-size: 14px; padding: 0; } } .page { width: 100%; min-height: 420px; padding-top: 16px; padding-bottom: 16px; display: flex; flex-direction: column; align-items: stretch; justify-content: space-between; } .page-header { display: flex; flex-direction: row; align-items: center; justify-content: space-between; } .page-content { margin-top: 16px; } table { border: 1px solid #E0E0E0; border-collapse: collapse; } table th, table td { border: 1px solid #E0E0E0; padding: 4px 16px !important; } table thead th, table thead td { text-align: left; white-space: nowrap; }',
            gridStyle: 'padding: 2px;',
            documentTitle: 'Laporan Pembayaran Tabungan'
        })
    })

    $.each($('.nominal-transaksi'), (index, value) => {
        $(value).text('Rp. ' + numberFormat($(value).text()))
    })
})

function numberFormat(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return parts.join(",");
}

function retrieveLaporanDetail() {
    let tanggal_awal = $('#date-range-span').data('daterangepicker').startDate.format('YYYY-MM-DD');
    let tanggal_akhir = $('#date-range-span').data('daterangepicker').endDate.format('YYYY-MM-DD');

    $.ajax({
        url: '/query/laporanPembayaranTabungan',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            tanggal_awal: tanggal_awal,
            tanggal_akhir: tanggal_akhir,
        },
        success: (result) => {
            $('#tbody-laporan-tabungan').empty();
            $('#data-laporan-pembayaran-tabungan').DataTable().clear().destroy();

            $.each(result, (index, value) => {
                let keterangan
                if (value.anggota.tipe_anggota == 1) {
                    keterangan = `${value.anggota.nama} \‘kelas ${value.anggota.jabatan != null ? value.anggota.jabatan.nama : 'Guru'}\’`;
                } else {
                    keterangan = `${value.anggota.nama} \‘kelas ${value.anggota.kelas.nama} ${value.anggota.jurusan.nama} ${value.anggota.nomor_kelas}\’`;
                }

                $('#tbody-laporan-tabungan').append(`
                    <tr>
                        <td>
                        <p class="text-medium color-neutral-100">${moment(value.tanggal).format('DD MMMM YYYY')}</p>
                        </td>
                        <td class="text-medium">
                        <p class="text-medium color-neutral-100">${value.admin.nama}</p>              
                        </td>
                        <td class="text-medium">
                        <p class="text-medium color-neutral-100">${value.nama_transaksi}</p>              
                        </td>
                        <td>
                        <p class="text-medium color-neutral-100">${keterangan}</p>
                        </td>
                        <td>
                        <p class="text-medium color-neutral-100 nominal-transaksi">Rp. ${numberFormat(value.jumlah)}</p>
                        </td>
                    </tr>
                `);

                if (index == (result.length - 1)) {
                    $('#data-laporan-pembayaran-tabungan').DataTable({
                        "aaSorting": [],
                    });
                }
            })

            if (result.length == 0) {
                $('#data-laporan-pembayaran-tabungan').DataTable({
                    "aaSorting": [],
                });
            }
        },
        error: (err) => {
            console.log(err);
        }
    })
}