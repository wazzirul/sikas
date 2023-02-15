let dataSiswa;
let validateDelete = true;
let validatePenarikan = true;
const MONTHS = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

if ($("#riwayat-tabungan").length == 1) {
    $('#riwayat-tabungan').DataTable();
}

$('#cari-siswa').keyup((e) => {
    let search = e.currentTarget.value;
    retrieveSiswa(search);
})

$('#filter_id_kelas, #filter_id_jurusan, #filter_nomor_kelas, #filter_angkatan_siswa').change(() => {
    retrieveSiswa();
})

function retrieveSiswa(search = "") {
    let id_kelas = $('#filter_id_kelas').val();
    let id_jurusan = $('#filter_id_jurusan').val();
    let nomor_kelas = $('#filter_nomor_kelas').val();
    let angkatan = $('#filter_angkatan_siswa').val();

    $.ajax({
        url: '/query/dataSiswa',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            search: search,
            id_kelas: id_kelas,
            id_jurusan: id_jurusan,
            nomor_kelas: nomor_kelas,
            angkatan: angkatan,
            limit: 20,
        },
        success: (result) => {
            dataSiswa = result;

            $('.cari-siswa').empty();
            $.each(result, (index, value) => {
                $('.cari-siswa').append(`
                    <a href="#!" class="cari-siswa__item" data-id="${value.id_anggota}">
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
                            ${value.alumni == 0 ? '<span class="text-success">Aktif</span>' :
                        `<span class="text-danger">Alumni (${value.angkatan ?? '-'})</span>`}
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
}

$('.cari-siswa__item').click((e) => {
    clickSiswa(e);
})

function clickSiswa(e) {
    $('.penarikan-button').removeClass('disabled');
    $('.setoran-button').removeClass('disabled');
    $('.id_anggota_input').val(e.currentTarget.dataset.id);
    $('.card--riwayat-tabungan').removeClass('d-none');

    let kasir = $(document).find('#riwayat-tabungan').data('username')
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
            $('.detail-nama').text(result.nama);
            $('.detail-nis').text(result.nis);
            $('.detail-kelas').text(`${result.kelas.nama} ${result.jurusan.nama} ${result.nomor_kelas}`);
            $('.detail-tabungan').text('Rp. ' + numberFormat(result.keuangan_anggota.tabungan));

            if (result.alumni == 0) {
                $('.detail-status-siswa').empty();
                $('.detail-status-siswa').append(`
                      <span class="text-success">Active</span>
                `);
            } else {
                $('.detail-status-siswa').empty();
                $('.detail-status-siswa').append(`
                      <span class="text-danger">Alumni (${result.angkatan ?? '-'})</span>
                `);
            }
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
            let savingsfund = 0;
            if (result == 'undefined') {console.log("benar");} 
            else{savingsfund = result[0].mutasi}
            $.each(result, (index, value) => {
                let tanggal = new Date(Date.parse(value.tanggal));
                let day = tanggal.toLocaleDateString('id', { weekday: 'long' });
                let bulan = tanggal.toLocaleDateString('id', { month: 'long' });
                let date = tanggal.getDate();
                let tahun = tanggal.getFullYear();                 

                $('.list-riwayat-tabungan').append(`
                    <tr>
                        <td>
                            <p class="text-medium color-neutral-100">${bulan}, ${date} ${tahun}</p>
                        </td>
                        <td class="text-medium">
                            <p class="text-medium color-neutral-100">${value.tipe_transaksi == 2 ? 'Setor' : 'Tarik'}</p>              
                        </td>
                        <td>
                            <p class="text-medium color-neutral-100">${value.admin.nama}</p>
                        </td>
                        <td>
                            <p class="text-medium color-neutral-100">Rp. ${numberFormat(value.jumlah)}</p>
                        </td>
                        <td>
                            <p class="text-bold color-neutral-100">Rp. ${numberFormat(value.mutasi)}</p>
                        </td>
                        <td>
                            <p class="text-bold color-neutral-100">${value.approved == 0 && value.tipe_transaksi != 2 ? 'Butuh Konfirmasi Admin' : 'Sudah Dikonfirmasi'}</p>
                        </td>
                        <td>
                        ${value.approved == 0 && value.tipe_transaksi != 2 && document.getElementById('session_admin').value == 1 ? `
                            <a href="#" class="btn btn-success approve-button" data-jumlah="Rp. ${numberFormat(value.jumlah)}" onClick="changeTransaksi(${value.id_transaksi})" data-bs-toggle="modal" data-bs-target="#modalConfrimData">
                                Konfrimasi
                            </a>` : `
                            <a href="#" class="btn btn-dark disabled approve-button">
                                Konfrimasi
                            </a>`
                    }
                        </td>
                        <td>
                        <div class="d-flex align-items-center justify-content-end gap-3">
                        
                        <a href="javascript:void(0)" title="Cetak ulang struk" class="table__link-detail text-dark" onClick="printReceipt(this)" data-username="${kasir}" data-numberanddate="${day}, ${date} ${bulan} ${tahun}" data-removetransactionnumber="${true}" data-numberandname="${nis} / ${name}" data-classname="${classname}" data-transactiontype="${value.nama_transaksi}" data-total="${value.jumlah}" data-savingsfund="${savingsfund}">
                          <i class="fa-solid fa-print table-icon__link"></i>
                        </a>

                        ${document.getElementById('session_admin').value == 1 || value.approved == 0 || value.tipe_transaksi == 2 ? `
                          <a href="#" class="table__link-detail text-info" onClick="changeTransaksi(${value.id_transaksi})" data-bs-toggle="modal" data-bs-target="#modalEditData">
                            <i class="fa-solid fa-pen table-icon__link"></i>
                          </a>
                        ` : ''}
                          
                          <a href="#" class="table__link-detail text-danger" onClick="changeTransaksi(${value.id_transaksi})" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
                            <i class="fa-regular fa-trash-can table-icon__link"></i>
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

            $('.approve-button').click((e) => {
                $('.modal--transaksi__nominal-penarikan').text(e.currentTarget.dataset.jumlah);
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

    if (validateDelete) {
        validateDelete = false;
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

$('.confirm-transaksi-button').click(() => {
    let id_transaksi = $('#id_transaksi').val();
    let id_anggota = $('#id_anggota_setoran').val();

    $.ajax({
        url: '/query/approvePenarikanTabunganSiswa',
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
})

$('#tabungan-upload-file').change(() => {
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
                let tgl = new Date(Date.parse(tanggal));
                let day = tgl.toLocaleDateString('id', { weekday: 'long' });
                let bulan = tgl.getMonth();
                let date = tgl.getDate();
                let tahun = tgl.getFullYear();

                let username = kasir,
                    numberanddate = `${day}, ${date} ${MONTHS[bulan]} ${tahun}`,
                    removetransactionnumber = true,
                    numberandname = `${anggota.nis} / ${anggota.nama}`,
                    classname = anggota.detail_kelas,
                    transactiontype = 'Setor Dana Tabungan',
                    total = transaksi.jumlah,
                    savingsfund = transaksi.mutasi

                printReceipt(null, { username, numberanddate, removetransactionnumber, numberandname, classname, transactiontype, total, savingsfund })
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

    let total_tabungan = $('.detail-tabungan')[0].innerHTML;
    let nominal_penarikan = $('#nominalPenarikan').val();

    total_tabungan = total_tabungan.replaceAll('Rp', '');
    total_tabungan = total_tabungan.replaceAll('.', '');
    total_tabungan = total_tabungan.replaceAll(' ', '');

    nominal_penarikan = nominal_penarikan.replaceAll('Rp', '');
    nominal_penarikan = nominal_penarikan.replaceAll('.', '');
    nominal_penarikan = nominal_penarikan.replaceAll(' ', '');

    if (parseInt(total_tabungan) < parseInt(nominal_penarikan)) {
        $('#button_penarikan_gagal').click();
        return
    }

    if (validatePenarikan) {
        validatePenarikan = false;

        $.ajax({
            url,
            method,
            data,
            success: (result) => {
                try {
                    let { tanggal, anggota, kasir, transaksi } = result
                    let tgl = new Date(Date.parse(tanggal));
                    let day = tgl.toLocaleDateString('id', { weekday: 'long' });
                    let bulan = tgl.getMonth();
                    let date = tgl.getDate();
                    let tahun = tgl.getFullYear();

                    let username = kasir,
                        numberanddate = `${day}, ${date} ${MONTHS[bulan]} ${tahun}`,
                        removetransactionnumber = true,
                        numberandname = `${anggota.nis} / ${anggota.nama}`,
                        classname = anggota.detail_kelas,
                        transactiontype = 'Penarikan Dana Tabungan',
                        total = transaksi.jumlah,
                        savingsfund = transaksi.mutasi                        

                    $('#button_penarikan_sukses').click();
                    printReceipt(null, { username, numberanddate, removetransactionnumber, numberandname, classname, transactiontype, total, savingsfund })
                } catch (error) {
                    console.error(error);
                }
                validatePenarikan = true;
            },
            error: (err) => {
                console.log(err);
                validatePenarikan = true;
            },
            complete: () => {
                $('#nominalPenarikan').val('')

                let id = $('.id_anggota_input').val()
                $(document).find(`.cari-siswa__item[data-id="${id}"]`).trigger('click')
                validatePenarikan = true;
            }
        })
    }
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