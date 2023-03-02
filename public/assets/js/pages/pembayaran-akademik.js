$(document).ready(function () {
    $('.js-tahun-multiple').select2({
        placeholder: "Pilih Tahun ...",
        initSelection: function (element, callback) {
        }
    });

    retrieveSiswa();
});

// Toast Alert
function tempAlert(msg, duration) {
    let el = document.createElement("div");
    el.classList.add("alert-bulan");
    el.setAttribute("style", "position:fixed;top:24px;right:24px;background-color:#ffa700;color:#fff;z-index:1100;transition:all linear .2s;padding:16px;border-radius:8px;text-align:center;font-weight:500;");
    el.innerHTML = msg;
    setTimeout(function () {
        el.parentNode.removeChild(el);
    }, duration);
    document.body.appendChild(el);
}
tempAlert("Pilih bulan <span style='font-weight:700;'>JULI</span> terlebih dahulu <br> Pilih bulan secara berurutan",2500);

let validateDelete = true;

if ($("#history-pembayaran").length == 1) {
    $('#history-pembayaran').DataTable();
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

    $.ajax({
        url: '/query/dataSiswa',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            search: search,
            id_kelas: id_kelas,
            id_jurusan: id_jurusan,
            nomor_kelas: nomor_kelas,
            alumni: '0',
            limit: 20,
        },
        success: (result) => {
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
    $('#id_anggota').val(e.currentTarget.dataset.id);
    $('.ajukan-penambahan-button').attr('href', `/transaksi/pengajuan-penambahan/${e.currentTarget.dataset.id}`);
    $('.ajukan-keringanan-button').attr('href', `/transaksi/pengajuan-keringanan/${e.currentTarget.dataset.id}`);

    $('.empty-detail-pembayaran').addClass('d-none');
    $('.pembayaran-button').removeClass('d-none');
    $('.input-nominal').removeClass('d-none');
    $('.card--riwayat-transaksi').removeClass('d-none');
    $('.form-check-bulanan').empty();
    $('#nominalPembayaran').val('')

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
            $('#tipe_pembayaran').val(result.keuangan_anggota.tipe_tagihan);

            if (result.alumni == 0) {
                $('.detail-status-siswa').empty();
                $('.detail-status-siswa').append(`
                      <span class="text-success">Aktif</span>
                `);
            } else {
                $('.detail-status-siswa').empty();
                $('.detail-status-siswa').append(`
                      <span class="text-danger">Alumni (${result.angkatan ?? '-'})</span>
                `);
            }

            if (result.keuangan_anggota.tipe_tagihan == 1) {
                $('.pembayaran-bulanan').addClass('d-none');
                $('.pembayaran-angsuran').removeClass('d-none');

                $('#angsuran_ke').val(result.keuangan_anggota.angsuran_ke + 1)
            } else {
                $('.pembayaran-bulanan').removeClass('d-none');
                $('.pembayaran-angsuran').addClass('d-none');
            }

            jumlahTagihan = result.keuangan_anggota.tagihan;
            $('.detail-tagihan').text('Rp. ' + numberFormat(jumlahTagihan));

            return jumlahTagihan;
        },
        error: (err) => {
            console.log(err);
        }
    })

    $.ajax({
        url: '/query/getPembayaranBulananSiswa',
        method: 'POST',
        data: {
            _token: $('#ctoken').val(),
            id_anggota: e.currentTarget.dataset.id
        },
        success: (result) => {
            if (result.length != 0) {
                $('#nominal_pembayaran_perbulan').val(result[result.length - 1].jumlah);

                $.each(result, (index, value) => {
                    $('.form-check-bulanan').append(`
                    
                        <div class="form-check">
                            <input class="form-check-input bulan-checkbox" type="checkbox" value="${value.id_history_tagihan}" name="bulan[]" id="tagihan-${value.id_history_tagihan}" ${value.status == 0 ? '' : 'disabled'}>
                            <label class="form-check-label ${value.status == 0 ? '' : 'disabled'}" for="tagihan-${value.id_history_tagihan}">${value.bulan.toUpperCase()} <i class="fa-solid fa-check form-check-label__icon"></i></label>
                        </div>
                    `);
                })

                $('input.bulan-checkbox').on('change', () => {
                    let total_nominal = $('input.bulan-checkbox:checked').length * parseInt($('#nominal_pembayaran_perbulan').val());
                    $('#nominalPembayaran').val(formatRupiah(total_nominal.toString(), 'RP. '))
                });
            }
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

                $.ajax({
                    url: '/query/siswaById',
                    method: 'POST',
                    data: {
                        _token: $('#ctoken').val(),
                        id: value.id_anggota
                    },
                    success: (hasil) => {
                        remainingbill = hasil.keuangan_anggota.tagihan;
                        $('.list-riwayat-pembayaran-spp').append(`
                        <tr>
                            <td class="color-neutral-100">${bulan}, ${date} ${tahun}</td>
                            <td class="color-neutral-100">${value.admin.nama}</td>
                            <td class="color-neutral-100">${value.nama_transaksi}</td>
                            <td class="color-neutral-100 nominal-transaksi">Rp. ${numberFormat(value.jumlah)}</td>
                            <td>
                            <div class="d-flex align-items-center justify-content-end gap-3">
                                <a href="javascript:void(0)" title="Cetak ulang struk" class="table__link-detail text-dark" onClick="printReceipt(this)" data-username="${kasir}" data-numberanddate="${value.nomor_transaksi} / ${day}, ${date} ${bulan} ${tahun}" data-numberandname="${nis} / ${name}" data-classname="${classname}" data-transactiontype="${value.nama_transaksi}" data-total="${value.jumlah}" data-transactioncode="${value.kode_transaksi}" data-remainingbill="${remainingbill}">
                                <i class="fa-solid fa-print table-icon__link"></i>
                                </a>
                                <a href="#" class="table__link-detail text-info" onClick="changeTransaksi(${value.id_transaksi})" data-bs-toggle="modal" data-bs-target="#modalEditData">
                                <i class="fa-solid fa-pen table-icon__link"></i>
                                </a>
                                <a href="#" class="table__link-detail text-danger" onClick="changeTransaksi(${value.id_transaksi})" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
                                <i class="fa-regular fa-trash-can table-icon__link"></i>
                                </a>
                            </div>
                        </td>
                    `);
                    },
                    error: (err) => {
                        console.log(err);
                    }
                })


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
                        remainingbill = hasil.keuangan_anggota.tagihan;
                        console.log(remainingbill);
                        printReceipt(null, { username, numberanddate, numberandname, classname, transactiontype, total, transactioncode, remainingbill });
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