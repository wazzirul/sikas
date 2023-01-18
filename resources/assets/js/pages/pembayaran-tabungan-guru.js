let dataSiswa;
const MONTHS = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

if ($("#riwayat-tabungan").length == 1) {
    $('#riwayat-tabungan').DataTable();
}

$('#cari-siswa').keyup((e) => {
    let search = e.currentTarget.value;
    $.ajax({
        url: '/query/dataGuru',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            search: search,
            limit: 2,
        },
        success: (result) => {
            console.log(result);
            dataSiswa = result;

            $('.cari-siswa').empty();
            $.each(result, (index, value) => {
                $('.cari-siswa').append(`
                    <div class="cari-siswa__item" data-id="${value.id_anggota}">
                        <div class="d-flex flex-row gap-3 align-items-center cari-siswa__item-nama">
                            <i class="fa-regular fa-user cari-siswa__icon color-neutral-100"></i>
                            <div class="d-flex flex-column gap-1">
                            <p class="text-bold color-neutral-100 cari-siswa__nama-siswa">${value.nama}</p>
                            <p class="nomor-siswa color-neutral-80">${value.nama}</p>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <p class="text-bold color-neutral-100">Jabatan</p>
                            <p class="kelas-siswa color-neutral-80">${value.jabatan != null ? value.jabatan.jabatan : 'Guru'}</p>
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
    $('.penarikan-button').removeClass('disabled');
    $('.setoran-button').removeClass('disabled');
    $('.id_anggota_input').val(e.currentTarget.dataset.id);
    $('.card--riwayat-tabungan').removeClass('d-none');

    $.ajax({
        url: '/query/guruById',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            id: e.currentTarget.dataset.id
        },
        success: (result) => {
            $('.detail-nama').text(result.nama);
            $('.detail-nip').text(result.nip);
            $('.detail-jabatan').text(`${result.jabatan != null ? result.jabatan.jabatan : 'Guru'}`);
            $('.detail-tabungan').text('Rp. ' + numberFormat(result.keuangan_anggota.tabungan));
        },
        error: (err) => {
            console.log(err);
        }
    })

    $.ajax({
        url: '/query/riwayatTabungan',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            id_anggota: e.currentTarget.dataset.id
        },
        success: (result) => {
            $('.list-riwayat-tabungan').empty();
            $.each(result, (index, value) => {
                let tanggal = new Date(Date.parse(value.tanggal));
                let bulan = tanggal.getMonth();
                let date = tanggal.getDate();
                let tahun = tanggal.getFullYear();

                $('.list-riwayat-tabungan').append(`
                    <tr>
                        <td>
                        <p class="text-medium color-neutral-100">${MONTHS[bulan]}, ${date} ${tahun}</p>
                        </td>
                        <td class="text-medium">
                        <p class="text-medium color-neutral-100">${value.tipe_transaksi == 2 ? 'Setor' : 'Tarik'}</p>              
                        </td>
                        <td>
                        <p class="text-medium color-neutral-100">Rp. ${numberFormat(value.jumlah)}</p>
                        </td>
                        <td>
                        <p class="text-bold color-neutral-100">Rp. ${numberFormat(value.mutasi)}</p>
                        </td>
                        <td>
                        <p class="text-bold color-neutral-100">Butuh Konfrimasi Admin</p>
                        </td>
                        <td>
                        <div class="d-flex align-items-center justify-content-end gap-3">
                            <a href="#" class="table__link-detail text-success" onClick="changeTransaksi(${value.id_transaksi})" data-bs-toggle="modal" data-bs-target="#modalConfrimData">
                            <i class="fa-solid fa-check table-icon__link"></i>
                            </a>
                            <a href="#" class="table__link-detail text-info" onClick="changeTransaksi(${value.id_transaksi})" data-bs-toggle="modal" data-bs-target="#modalEditData">
                            <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="#" class="table__link-detail text-danger" onClick="changeTransaksi(${value.id_transaksi})" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
                            <i class="fa-regular fa-trash-can"></i>
                            </a>
                        </div>
                        </td>
                    </tr>
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

function updateTransaksi() {
    let id_transaksi = $('#id_transaksi').val();
    let id_anggota = $('#id_anggota_setoran').val();
    $('#update-result').text(numberFormat($('#jumlah-pembayaran').val()));

    $.ajax({
        url: '/query/updateHistoryTabungan',
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
        url: '/query/deleteHistoryTabungan',
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

function changeTransaksi($id_transaksi) {
    $('#id_transaksi').val($id_transaksi);
}

function numberFormat(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return parts.join(",");
}

$('#nominalTabungan').keyup((e) => {
    let input = e.currentTarget.value;
    $('#nominalTabungan').val(formatRupiah(input, 'RP. '))
})

$('#nominalPenarikan').keyup((e) => {
    let input = e.currentTarget.value;
    $('#nominalPenarikan').val(formatRupiah(input, 'RP. '))
})

$('#jumlah-pembayaran').keyup((e) => {
    let input = e.currentTarget.value;
    $('#jumlah-pembayaran').val(formatRupiah(input, 'RP. '))
})

$(document).on('submit', 'form#form-setor-tabungan', function (e) {
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
                let { tanggal, anggota, kasir, transaksi } = result

                let username = kasir,
                    numberanddate = `${tanggal}`,
                    removetransactionnumber = true,
                    numberandname = `${anggota.nip} / ${anggota.nama}`,
                    classname = anggota.detail_kelas,
                    transactiontype = 'Setor Dana Tabungan',
                    total = transaksi.jumlah,
                    savingsFund = transaksi.mutasi,
                    notClassname = true

                printReceipt(null, { username, numberanddate, removetransactionnumber, numberandname, classname, transactiontype, total, savingsFund, notClassname })
            } catch (error) {
                console.error(error);
            }
        },
        error: (err) => {
            console.log(err);
        },
        complete: () => {
            $('#nominalTabungan').val('')

            let id = $('.id_anggota_input').val()
            $(document).find(`.cari-siswa__item[data-id="${id}"]`).trigger('click')
        }
    })
})

$(document).on('submit', 'form#form-tarik-tabungan', function (e) {
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
                let { tanggal, anggota, kasir, transaksi } = result

                let username = kasir,
                    numberanddate = `${tanggal}`,
                    removetransactionnumber = true,
                    numberandname = `${anggota.nip} / ${anggota.nama}`,
                    classname = anggota.detail_kelas,
                    transactiontype = 'Penarikan Dana Tabungan',
                    total = transaksi.jumlah,
                    savingsFund = transaksi.mutasi,
                    notClassname = true

                printReceipt(null, { username, numberanddate, removetransactionnumber, numberandname, classname, transactiontype, total, savingsFund, notClassname })
            } catch (error) {
                console.error(error);
            }
        },
        error: (err) => {
            console.log(err);
        },
        complete: () => {
            $('#nominalPenarikan').val('')

            let id = $('.id_anggota_input').val()
            $(document).find(`.cari-siswa__item[data-id="${id}"]`).trigger('click')
        }
    })
})

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