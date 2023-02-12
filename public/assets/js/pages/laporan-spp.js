$(document).ready(function () {
    $(document).on('click', 'button#button-cetak-laporan', function () {
        let tableInnerHTML = $(document).find('table#data-laporan-pembayaran-spp').html()
        let date = `${$('#date-range-span').data('daterangepicker').startDate.format('D MMMM YYYY')} - ${$('#date-range-span').data('daterangepicker').endDate.format('D MMMM YYYY')}`

        printJS({
            printable: `
          <div>
            <div class="page-header">
              <h2 class="page-header-title">Laporan Pembayaran Partisipasi</h2>
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
            style: '@media print { @page { margin-top: 48px; margin-bottom: 48px; } @page:first { margin-top: 0; margin-bottom: 0; } body { font-size: 14px; padding: 0; } } .page { width: 100%; min-height: 420px; padding-top: 16px; padding-bottom: 16px; display: flex; flex-direction: column; align-items: stretch; justify-content: space-between; } .page-header { display: flex; flex-direction: row; align-items: center; justify-content: space-between; } .page-content { margin-top: 16px; page-break-before: auto; } table { border: 1px solid #E0E0E0; border-collapse: collapse;} table th, table td { border: 1px solid #E0E0E0; padding: 4px 16px !important;} table thead th, table thead td { text-align: left; white-space: nowrap; border: 1px solid #E0E0E0} p.kelas { width:64px !important } .d-none{ display:none !important; }',
            gridStyle: 'padding: 2px;',
            documentTitle: 'Laporan Pembayaran Partisipasi'
        })
    })

    $(document).on('click', 'button#button-cetak-laporan-kelas', function () {
        let tableInnerHTML = $(document).find('table#data-laporan-pembayaran-spp-perkelas').html()
        let date = `${$('#date-range-span').data('daterangepicker').startDate.format('D MMMM YYYY')} - ${$('#date-range-span').data('daterangepicker').endDate.format('D MMMM YYYY')}`

        printJS({
            printable: `
          <div>
            <div class="page-header">
              <h2 class="page-header-title">Laporan Pembayaran Partisipasi Per Kelas</h2>
              <div class="page-header">${date}</div>
            </div>
            <div class="page-subheader">
              <h2 class="page-header-title">Kelas X TKJ 2</h2>
            </div>
            <div class="page-content">
              <table>
                ${tableInnerHTML}
              </table>
            </div>
          </div>`,
            type: 'raw-html',
            header: null,
            style: '@media print { @page {margin-top: 48px; margin-bottom: 48px;} @page:first { margin-top: 0; margin-bottom: 0; } body { font-size: 14px; padding: 0; } } .page { width: 100%; min-height: 420px; padding-top: 16px; padding-bottom: 16px; display: flex; flex-direction: column; align-items: stretch; justify-content: space-between; } .page-header { display: flex; flex-direction: row; align-items: center; justify-content: space-between; } .page-content { margin-top: 16px; } table { border: 1px solid #E0E0E0; border-collapse: collapse; } table th, table td { border: 1px solid #E0E0E0; padding: 4px 16px !important; } table thead th, table thead td { text-align: left; white-space: nowrap; } p.kelas { width:64px !important } .tcolumn-kelas{ display:none !important; } .d-none{ display:none !important; }',
            gridStyle: 'padding: 2px;',
            documentTitle: 'Laporan Pembayaran Partisipasi'
        })
    })

    $('.applyBtn').click(() => {
        fetchDataPembayaran();
    })

    $('#filter_id_kelas, #filter_id_jurusan, #filter_nomor_kelas').change(() => {
        fetchDataPembayaran();
    })

    $('#filter_id_kelas_kelas, #filter_id_jurusan_kelas, #filter_nomor_kelas_kelas').change(() => {
        let id_kelas = $('#filter_id_kelas_kelas').val() ?? null;
        let id_jurusan = $('#filter_id_jurusan_kelas').val() ?? null;
        let nomor_kelas = $('#filter_nomor_kelas_kelas').val() ?? null;

        if (id_kelas && id_jurusan && nomor_kelas) {
            fetchDataPembayaranKelas(id_kelas, id_jurusan, nomor_kelas);
        }
    })

    $.each($('.nominal-transaksi'), (index, value) => {
        $(value).text('Rp. ' + numberFormat($(value).text()))
    })
})

function fetchDataPembayaran() {
    let tanggal_awal = $('#date-range-span').data('daterangepicker').startDate.format('YYYY-MM-DD');
    let tanggal_akhir = $('#date-range-span').data('daterangepicker').endDate.format('YYYY-MM-DD');

    let id_kelas = $('#filter_id_kelas').val();
    let id_jurusan = $('#filter_id_jurusan').val();
    let nomor_kelas = $('#filter_nomor_kelas').val();

    $.ajax({
        url: '/query/laporanPembayaranSpp',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            tanggal_awal: tanggal_awal,
            tanggal_akhir: tanggal_akhir,
            id_kelas: id_kelas,
            id_jurusan: id_jurusan,
            nomor_kelas: nomor_kelas,
        },
        success: (result) => {
            $('#tbody-laporan-spp').empty();
            $('#data-laporan-pembayaran-spp').DataTable().clear().destroy();

            $.each(result, (index, value) => {
                $('#tbody-laporan-spp').append(`
                    <tr>
                        <td>
                            <p class="text-medium color-neutral-100">${moment(value.tanggal).format('DD MMMM YYYY')}</p>
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">${value.admin.nama}</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">${value.anggota.nama}</p>              
                        </td>
                        <td>
                            <p class="text-medium color-neutral-100 kelas">${value.anggota.kelas.nama} ${value.anggota.jurusan.nama} ${value.anggota.nomor_kelas}</p>
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">${value.nama_transaksi}</p>              
                        </td>
                        <td>
                            <p class="text-medium color-neutral-100 nominal-transaksi">Rp. ${numberFormat(value.jumlah)}</p>
                        </td>
                    </tr>
                `);

                if (index == (result.length - 1)) {
                    $('#data-laporan-pembayaran-spp').DataTable({
                        "aaSorting": [],
                    });
                }
            })

            if (result.length == 0) {
                $('#data-laporan-pembayaran-spp').DataTable({
                    "aaSorting": [],
                });
            }
        },
        error: (err) => {
            console.log(err);
        }
    })
}

function fetchDataPembayaranKelas(id_kelas, id_jurusan, nomor_kelas) {
    let tanggal_awal = $('#date-range-span').data('daterangepicker').startDate.format('YYYY-MM-DD');
    let tanggal_akhir = $('#date-range-span').data('daterangepicker').endDate.format('YYYY-MM-DD');

    $.ajax({
        url: '/query/laporanPembayaranSppKelas',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            tanggal_awal: tanggal_awal,
            tanggal_akhir: tanggal_akhir,
            id_kelas: id_kelas,
            id_jurusan: id_jurusan,
            nomor_kelas: nomor_kelas,
        },
        success: (result) => {
            $('#tbody-laporan-spp-kelas').empty();
            $('#data-laporan-pembayaran-spp-perkelas').DataTable().clear().destroy();

            $.each(result, (index, value) => {
                $('#tbody-laporan-spp-kelas').append(`
                    <tr>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">${(index + 1)}</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">${value.nis}</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">${value.nama}</p>              
                        </td>
                        <td class="text-medium tcolumn-kelas">
                            <p class="text-medium color-neutral-100 kelas">${value.kelas.nama} ${value.jurusan.nama} ${value.nomor_kelas}</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">${value.jenis_kelamin ?? 'L'}</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">Rp. ${numberFormat(value.keuangan_anggota.tagihan_pertama)}</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">2</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">Rp. 10.000</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">Rp. 10.000</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">Rp. 10.000</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">Rp. 10.000</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">Rp. 10.000</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">Rp. 10.000</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">Rp. 10.000</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">Rp. 10.000</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">Rp. 10.000</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">Rp. 10.000</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">Rp. 10.000</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">Rp. 10.000</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">Rp. ${numberFormat(value.total_pembayaran)}</p>              
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">Rp. ${numberFormat(value.keuangan_anggota.tagihan)}</p>              
                        </td>
                    </tr>
                `);
                
                $('#data-laporan-pembayaran-spp-perkelas').find('tr').each(function(){ 
                    $(this).find('th').eq(-1).after('<th>HEADER</th>');
                    $(this).find('td').eq(-1).after('<td>ROW</td>'); 
                });

                if (index == (result.length - 1)) {
                    $('#data-laporan-pembayaran-spp-perkelas').DataTable({
                        "aaSorting": [],
                    });
                }
            })

            if (result.length == 0) {
                $('#data-laporan-pembayaran-spp-perkelas').DataTable({
                    "aaSorting": [],
                });
            }
        },
        error: (err) => {
            console.log(err);
        }
    })
}


function numberFormat(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return parts.join(",");
}
