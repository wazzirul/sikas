$(document).ready(function () {
  $('.sisa-tanggungan').text('Rp. ' + numberFormat($('.sisa-tanggungan').text()));

  if ($("#riwayat-pengajuan-keringanan").length == 1) {
    $('#riwayat-pengajuan-keringanan').DataTable();
  }

  $.each($('.nominal-transaksi'), (index, value) => {
    $(value).text('Rp. ' + numberFormat($(value).text()))
  })

  $('#upload-surat-pengajuan').change(() => {
    $('.file-name').text($('#upload-surat-pengajuan').val().split('\\').pop());
    $('.pengajuan-keringanan-form__item-upload').removeClass('d-none');
  })

  $('#nominalPembayaran').keyup((e) => {
    let input = e.currentTarget.value;
    $('#nominalPembayaran').val(formatRupiah(input, 'RP. '))
  })

  $('.detail-pengajuan').click((el) => {
    let jumlah = numberFormat(el.currentTarget.dataset.jumlah);
    let file = el.currentTarget.dataset.file;
    file = file.split('/');

    $('.modal-jumlah').text(jumlah);
    $('.modal-file').text(file[file.length - 1]);
    $('.modal-download').attr('href', '/' + el.currentTarget.dataset.file);
  })

  $('#tahunAjaran').keyup((e) => {
    console.log($('.form-control.form-control-sm').find('input[type=search]'));
    $('.form-control.form-control-sm').find('input[type=search]').prevObject.each((index, value) => {
      $(value).val(e.currentTarget.value);
      $(value).keyup();
    });
  })
});

function numberFormat(x) {
  var parts = x.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  return parts.join(",");
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

$(document).on('submit', 'form#form-pengajuan-keringanan', function (e) {
  e.preventDefault()

  let form = $(this),
    url = form.attr('action'),
    method = form.attr('method'),
    data = new FormData(this)

  let dontSubmit = false
  form.find('input:not([type="hidden"])').each((_, el) => {
    if (!$(el).val()) dontSubmit = true
  })
  if (dontSubmit) return

  $.ajax({
    url,
    method,
    data,
    processData: false,
    contentType: false,
    success: (result) => {
      try {
        let { tanggal, anggota, pengajuan, kasir } = result
        let tgl = new Date(Date.parse(tanggal));
        let day = tgl.toLocaleDateString('id', { weekday: 'long' });
        let bulan = tgl.toLocaleDateString('id', { month: 'long' });
        let date = tgl.getDate();
        let tahun = tgl.getFullYear();

        let username = kasir,
          numberanddate = `${day}, ${date} ${bulan} ${tahun}`,
          removetransactionnumber = true,
          numberandname = `${anggota.nis} / ${anggota.nama}`,
          classname = anggota.detail_kelas,
          transactiontype = 'Pengajuan Keringanan Uang Akademik',
          total = pengajuan.jumlah

        printReceipt(null, { username, numberanddate, removetransactionnumber, numberandname, classname, transactiontype, total }, () => location.reload())
      } catch (error) {
        console.error(error);
      }
    },
    error: (err) => {
      console.log(err);
    },
    complete: () => {
      form.trigger('reset')
      $('.pengajuan-keringanan-form__item-upload').addClass('d-none');
    }
  })
})