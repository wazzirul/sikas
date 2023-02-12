$(document).ready(function () {
  $('.js-bulan-multiple').select2({
    placeholder: "Pilih Bulan ...",
    initSelection: function(element, callback) {                   
    }
  });
});
let dataSiswa;
let validateDelete = true;

if ($("#history-pembayaran").length == 1) {
    $('#history-pembayaran').DataTable();
}

$('#cari-siswa').keyup((e) => {
    let search = e.currentTarget.value;
    let id_kelas = $('#filter_id_kelas').val();
    let id_jurusan = $('#filter_id_jurusan').val();
    let nomor_kelas = $('#filter_nomor_kelas').val();

    $.ajax({
        url: '/query/dataSiswa',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            search: search,
            id_kelas: id_kelas,
            id_jurusan: id_jurusan,
            nomor_kelas: nomor_kelas,
            limit: 3,
        },
        success: (result) => {
            dataSiswa = result;

            $('.cari-siswa').empty();
            $.each(result, (index, value) => {
                $('.cari-siswa').append(`
                    <a href="#" class="cari-siswa__item" data-id="${value.id_anggota}">
                        <div class="d-flex flex-row gap-3 align-items-center cari-siswa__item-nama">
                        <i class="fa-regular fa-user cari-siswa__icon color-neutral-100"></i>
                        <div class="d-flex flex-column gap-1">
                            <p class="text-bold color-neutral-100 cari-siswa__nama-siswa">${value.nama}</p>
                            <p class="nomor-siswa color-neutral-80">${value.nis}</p>
                        </div>
                        </div>
                        <div class="d-flex flex-column gap-1">
                          <p class="kelas-siswa text-bold text-info">${value.kelas.nama} ${value.jurusan.nama} ${value.nomor_kelas}</p>
                          <p class="text-bold">
                            <span class="text-success">Aktif</span>
                            <span class="text-danger">Alumni - 2018/2019</span>
                          </p>
                        </div>
                        <div href="#" class="cari-siswa__item-detail">
                        	<i class="fa-solid fa-chevron-right cari-siswa__item-detail__icon color-neutral-100"></i>
                        </div>
                    </a>
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
    $('.ajukan-penambahan-button').attr('href', `/transaksi/pengajuan-penambahan/${e.currentTarget.dataset.id}`);
    $('.ajukan-keringanan-button').attr('href', `/transaksi/pengajuan-keringanan/${e.currentTarget.dataset.id}`);
    $('.card--riwayat-transaksi').removeClass('d-none');

    let kasir = $(document).find('#history-pembayaran').data('username')
    let name = $(e.currentTarget).find('.cari-siswa__nama-siswa').text()
    let nis = $(e.currentTarget).find('.nomor-siswa').text()
    let classname = $(e.currentTarget).find('.kelas-siswa').text()

    $.ajax({
        url: '/query/siswaById',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            id: e.currentTarget.dataset.id
        },
        success: (result) => {
            let jumlahTagihan
            $('.detail-nama').text(result.nama);
            $('.detail-nis').text(result.nis);
            $('.detail-kelas').text(`${result.kelas.nama} ${result.jurusan.nama} ${result.nomor_kelas}`);
            $('.detail-tagihan').text('Rp. ' + numberFormat(result.keuangan_anggota.tagihan));
            return jumlahTagihan = result.keuangan_anggota.tagihan;
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
                let day = tanggal.toLocaleDateString('id', { weekday: 'long' });
                let bulan = tanggal.toLocaleDateString('id', { month: 'long' });
                let date = tanggal.getDate();
                let tahun = tanggal.getFullYear();

                $('.list-riwayat-pembayaran-spp').append(`
                    <tr>
                        <td class="color-neutral-100">${bulan}, ${date} ${tahun}</td>
                        <td class="color-neutral-100">${value.admin.nama}</td>
                        <td class="color-neutral-100">${value.nama_transaksi}</td>
                        <td class="color-neutral-100 nominal-transaksi">Rp. ${numberFormat(value.jumlah)}</td>
                        <td>
                        <div class="d-flex align-items-center justify-content-end gap-3">
                            <a href="javascript:void(0)" title="Cetak ulang struk" class="table__link-detail text-dark" onClick="printReceipt(this)" data-username="${kasir}" data-numberanddate="${value.nomor_transaksi} / ${day}, ${date} ${bulan} ${tahun}" data-numberandname="${nis} / ${name}" data-classname="${classname}" data-transactiontype="${value.nama_transaksi}" data-total="${value.jumlah}" data-transactioncode="${value.kode_transaksi}">
                              <i class="fa-solid fa-print table-icon__link"></i>
                            </a>
                            <a href="#" class="table__link-detail text-info update-transaksi-button" onClick="changeTransaksi(${value.id_transaksi})" data-bs-toggle="modal" data-bs-target="#modalEditData">
                            <i class="fa-solid fa-pen table-icon__link"></i>
                            </a>
                            <a href="#" class="table__link-detail text-danger delete-transaksi-button" onClick="changeTransaksi(${value.id_transaksi})" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
                            <i class="fa-regular fa-trash-can table-icon__link"></i>
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

$('#bpp-upload-file').change(() => {
    $('#importForm').submit();
})

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

    if (validateDelete) {
        validateDelete = false;
        $.ajax({
            url: '/query/deleteHistoryPembayaran',
            method: 'POST',
            data: {
                _token: $('#ctoken').val(),
                id_transaksi: id_transaksi,
            },
            success: () => {
                setTimeout(() => {
                    validateDelete = true;
                    location.reload()
                }, 2000);
            },
            error: (err) => {
                validateDelete = true;
                console.log(err);
            }
        })
    }
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

    let total_tagihan = $('.detail-tagihan')[0].innerHTML;
    let nominal_pembayaran = $('#nominalPembayaran').val();

    total_tagihan = total_tagihan.replaceAll('Rp', '');
    total_tagihan = total_tagihan.replaceAll('.', '');
    total_tagihan = total_tagihan.replaceAll(' ', '');

    nominal_pembayaran = nominal_pembayaran.replaceAll('Rp', '');
    nominal_pembayaran = nominal_pembayaran.replaceAll('.', '');
    nominal_pembayaran = nominal_pembayaran.replaceAll(' ', '');

    if (parseInt(total_tagihan) < parseInt(nominal_pembayaran)) {
        $('.sisa-partisipasi').text('Rp. ' + formatRupiah(total_tagihan));
        $('#button_pembayaran_gagal').click();
        return
    }

    $.ajax({
        url,
        method,
        data,
        success: (result) => {
            try {
                let { tanggal, anggota, transaksi, kasir } = result
                let tgl = new Date(Date.parse(tanggal));
                let day = tgl.toLocaleDateString('id', { weekday: 'long' });
                let bulan = tgl.toLocaleDateString('id', { month: 'long' });
                let date = tgl.getDate();
                let tahun = tgl.getFullYear();

                let username = kasir,
                    numberanddate = `${transaksi.nomor_transaksi} / ${day}, ${date} ${bulan}, ${tahun}`,
                    numberandname = `${anggota.nis} / ${anggota.nama}`,
                    classname = anggota.detail_kelas,
                    transactiontype = transaksi.nama_transaksi,
                    total = transaksi.jumlah,
                    transactioncode = transaksi.kode_transaksi

                $.ajax({
                    url: '/query/siswaById',
                    method: 'POST',
                    data: {
                        _token: $('#ctoken').val(),
                        id: anggota.id_anggota
                    },
                    success: (hasil) => {
                        $('#button_pembayaran_sukses').click();
                        remainingBill = hasil.keuangan_anggota.tagihan;
                        printReceipt(null, { username, numberanddate, numberandname, classname, transactiontype, total, transactioncode, remainingBill });
                    },
                    error: (err) => {
                        console.log(err);
                    }
                })
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