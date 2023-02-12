$(document).ready(function () {

    $.each($('.nominal-pembayaran'), (index, value) => {
        $(value).val('Rp. ' + numberFormat($(value).data('value')))
    })

    $('.nominal-pembayaran').keyup((e) => {
        let input = e.currentTarget.value;
        e.currentTarget.value = formatRupiah(input, 'RP. ');
    })
})

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

let validateRisetTahun = true;
$(document).on('submit', 'form#myform', function (e) {
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

    if (validateRisetTahun) {
        validateRisetTahun = false;

        $.ajax({
            url,
            method,
            data,
            success: (result) => {
                $('.success-button').click()

            },
            error: (err) => {
                console.log(err);
            },
            complete: () => {
                form.trigger('reset')
                validateRisetTahun = true;
            }
        })
    }
})