$(document).ready(function () {
    $('.applyBtn').click(() => {
        let tanggal_awal = $('#date-range-span').data('daterangepicker').startDate.format('YYYY-MM-DD');
        let tanggal_akhir = $('#date-range-span').data('daterangepicker').endDate.format('YYYY-MM-DD');

        $.ajax({
            url: '/query/laporanPenggunaanDana',
            method: 'POST',
            data: {
                _token: $('#ctoken').val(),
                tanggal_awal: tanggal_awal,
                tanggal_akhir: tanggal_akhir,
            },
            success: (result) => {
                $('#tbody-penggunaan-dana').empty();
                $.each(result, (index, value) => {
                    $('#tbody-penggunaan-dana').append(`
                        <tr>
                            <td>
                            <p class="text-medium color-neutral-100">${moment(value.tanggal).format('DD MMMM YYYY')}</p>
                            </td>
                            <td class="text-medium">
                            <p class="text-medium color-neutral-100">Penggunaan Dana</p>              
                            </td>
                            <td>
                            <p class="text-medium color-neutral-100">${value.nama_transaksi}</p>              
                            </td>
                            <td>
                            <p class="text-medium color-neutral-100 nominal-transaksi">Rp. ${numberFormat(value.jumlah)}</p>
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
        $(value).text('Rp. ' + numberFormat($(value).text()))
    })
})

function numberFormat(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return parts.join(",");
}