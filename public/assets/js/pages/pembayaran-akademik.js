let dataSiswa;
const MONTHS = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

if ($("#history-pembayaran").length == 1) {
    $('#history-pembayaran').DataTable();
}

$('#cari-siswa').keyup((e) => {
    let search = e.currentTarget.value;
    $.ajax({
        url: '/query/dataSiswa',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            search: search,
            limit: 3,
        },
        success: (result) => {
            dataSiswa = result;

            $('.cari-siswa').empty();
            $.each(result, (index, value) => {
                $('.cari-siswa').append(`
                    <div class="cari-siswa__item" data-id="${value.id_anggota}">
                        <div class="d-flex flex-row gap-3 align-items-center cari-siswa__item-nama">
                        <i class="fa-regular fa-user cari-siswa__icon color-neutral-100"></i>
                        <div class="d-flex flex-column gap-1">
                            <p class="text-bold color-neutral-100 cari-siswa__nama-siswa">${value.nama}</p>
                            <p class="nomor-siswa color-neutral-80">${value.nis}</p>
                        </div>
                        </div>
                        <div class="d-flex flex-column gap-1">
                        <p class="text-bold color-neutral-100">Kelas</p>
                        <p class="kelas-siswa color-neutral-80">${value.kelas.nama} ${value.jurusan.nama} ${value.nomor_kelas}</p>
                        </div>
                        <a href="#" class="cari-siswa__item-detail">
                        <i class="fa-solid fa-chevron-right cari-siswa__item-detail__icon color-neutral-100"></i>
                        </a>
                    </div>
                `);
            })

            $('.cari-siswa__item').click((e) => {
                clickSiswa(e);
            })
        },
        error: (err) => {
            console.log(err);
        }
    })
})

$('.cari-siswa__item').click((e) => {
    clickSiswa(e);
})

function clickSiswa(e) {
    $('.pembayaran-button').removeClass('disabled');
    $('#id_anggota').val(e.currentTarget.dataset.id);
    $('.history-pembayaran-button').attr('href', `/transaksi/history-pembayaran/${e.currentTarget.dataset.id}`);
    $('.ajukan-keringanan-button').attr('href', `/transaksi/pengajuan-keringanan/${e.currentTarget.dataset.id}`);
    $('.card--riwayat-transaksi').removeClass('d-none');

    $.ajax({
        url: '/query/siswaById',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            id: e.currentTarget.dataset.id
        },
        success: (result) => {
            $('.detail-nama').text(result.nama);
            $('.detail-nis').text(result.nis);
            $('.detail-kelas').text(`${result.kelas.nama} ${result.jurusan.nama} ${result.nomor_kelas}`);
            $('.detail-tagihan').text('Rp. ' + numberFormat(result.keuangan_anggota.tagihan));
        },
        error: (err) => {
            console.log(err);
        }
    })

    $.ajax({
        url: '/query/riwayatPembayaranSpp',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            id_anggota: e.currentTarget.dataset.id
        },
        success: (result) => {
            $('.list-riwayat-pembayaran-spp').empty();
            $.each(result, (index, value) => {
                let tanggal = new Date(Date.parse(value.tanggal));
                let bulan = tanggal.getMonth();
                let date = tanggal.getDate();
                let tahun = tanggal.getFullYear();

                $('.list-riwayat-pembayaran-spp').append(`
                    <tr>
                        <td class="color-neutral-100">${value.nama_transaksi}</td>
                        <td class="color-neutral-100">${MONTHS[bulan]}, ${date} ${tahun}</td>
                        <td class="color-neutral-100 nominal-transaksi">Rp. ${numberFormat(value.jumlah)}</td>
                        <td>
                        <div class="d-flex align-items-center justify-content-end gap-3">
                            <a href="javascript:void(0)" title="Cetak ulang struk" class="table__link-detail color-neutral-100">
                            <i class="fa-solid fa-print"></i>
                            </a>
                            <a href="#" class="table__link-detail color-neutral-100 update-transaksi-button" onClick="changeTransaksi(${value.id_transaksi})" data-bs-toggle="modal" data-bs-target="#modalEditData">
                            <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="#" class="table__link-detail color-neutral-100 delete-transaksi-button" onClick="changeTransaksi(${value.id_transaksi})" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
                            <i class="fa-regular fa-trash-can"></i>
                            </a>
                        </div>
                    </td>
                `);

            })

            if (result.length == 0) {
                $('.table-responsive').addClass('d-none');
                $('.history-empty').removeClass('d-none');
            } else {
                $('.table-responsive').removeClass('d-none');
                $('.history-empty').addClass('d-none');
            }

            $('.update-transaksi-button').click(() => {
                updateTransaksi();
            })

            $('.delete-transaksi-button').click(() => {
                deleteTransaksi();
            })
        },
        error: (err) => {
            console.log(err);
        }
    })
}

function changeTransaksi($id_transaksi) {
    $('#id_transaksi').val($id_transaksi);
}

function numberFormat(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return parts.join(",");
}

$('#nominalPembayaran').keyup((e) => {
    let input = e.currentTarget.value;
    $('#nominalPembayaran').val(formatRupiah(input, 'RP. '))
})

$('#jumlah-pembayaran').keyup((e) => {
    let input = e.currentTarget.value;
    $('#jumlah-pembayaran').val(formatRupiah(input, 'RP. '))
})

function updateTransaksi() {
    let id_transaksi = $('#id_transaksi').val();
    let id_anggota = $('#id_anggota_setoran').val();
    $('#update-result').text(numberFormat($('#jumlah-pembayaran').val()));

    $.ajax({
        url: '/query/updateHistoryPembayaran',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            id_transaksi: id_transaksi,
            id_anggota: id_anggota,
            nominal: $('#jumlah-pembayaran').val(),
        },
        success: () => {
            setTimeout(() => {
                location.reload()
            }, 2000);
        },
        error: (err) => {
            console.log(err);
        }
    })
}

function deleteTransaksi() {
    let id_transaksi = $('#id_transaksi').val();
    let id_anggota = $('#id_anggota_setoran').val();

    $.ajax({
        url: '/query/deleteHistoryPembayaran',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            id_transaksi: id_transaksi,
            id_anggota: id_anggota,
        },
        success: () => {
            setTimeout(() => {
                location.reload()
            }, 2000);
        },
        error: (err) => {
            console.log(err);
        }
    })
}

function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

$(document).on('submit', 'form#form-pembayaran-akademik', function (e) {
    e.preventDefault()

    let form = $(this),
        url = form.attr('action'),
        method = form.attr('method'),
        data = form.serialize()

    let dontSubmit = false
    form.find('input:not([type="hidden"])').each((_, el) => {
        if (!$(el).val()) dontSubmit = true
    })
    if (dontSubmit) return

    $.ajax({
        url,
        method,
        data,
        success: (result) => {
            try {
                let { tanggal, anggota, transaksi, kasir } = result

                let username = kasir,
                    numberanddate = `${transaksi.nomor_transaksi} / ${tanggal}`,
                    numberandname = `${anggota.nis} / ${anggota.nama}`,
                    classname = anggota.detail_kelas,
                    transactiontype = transaksi.nama_transaksi,
                    total = transaksi.jumlah,
                    transactioncode = transaksi.kode_transaksi

                printReceipt(null, { username, numberanddate, numberandname, classname, transactiontype, total, transactioncode })
            } catch (error) {
                console.error(error);
            }

        },
        error: (err) => {
            console.log(err);
        },
        complete: () => {
            form.trigger('reset')

            let id = $('#id_anggota').val()
            $(document).find(`.cari-siswa__item[data-id="${id}"]`).trigger('click')
        }
    })
})