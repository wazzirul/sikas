"use strict";

function printReceipt(el = {}, raw = {}, onPrintDialogClose = null) {
  let {
    username,
    numberanddate,
    numberandname,
    classname,
    transactiontype,
    total,
    transactioncode,
    removetransactionnumber,
    savingsfund,
    remainingbill,
    notClassname,
  } = el?.dataset || raw;
  let formattedTotal = `${new Intl.NumberFormat("id").format(total)},-`;

  if (!numberandname) return;

  printJS({
    printable: `
      <div class="page">
        <div>
          <h4 class="page-header">Bukti Transaksi</h4>
          <div class="row">
            <div class="col-left list">
              <div class="list-key">
                <div>${
                  removetransactionnumber ? "Tgl" : "No. Bukti / Tgl"
                }</div>
                <div>:</div>
              </div>
              <div class="list-value uppercase">${numberanddate}</div>
            </div>
            <div class="col-right nowrap ml-16">${
              classname
                ? `${notClassname ? "Jabatan" : "Kelas"} : ${classname}`
                : ""
            }</div>
          </div>
          <div class="row">
            <div class="list">
              <div class="list-key">
                <div>No. Induk / Nama</div>
                <div>:</div>
              </div>
              <div class="list-value uppercase">${numberandname}</div>
            </div>
          </div>
          <div class="row">Untuk Pembayaran</div>
          <div class="row">
            <div class="col">
              <div class="list">
                <div class="list-key"></div>
                <div class="list-value list-value--first uppercase row border-bottom">
                  <div class="col-left list-value__transaction-type uppercase">${transactiontype}</div>
                  <div class="col-right nowrap">${formattedTotal}</div>
                </div>
              </div>
              <div class="list">
                <div class="list-key"></div>
                <div class="list-value uppercase row">
                  <div class="col-left">TOTAL</div>
                  <div class="col-right nowrap">${formattedTotal}</div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="nominal-pronouncing uppercase">TERBILANG : ${terbilang(
              total
            )} RUPIAH</div>
          </div>
          ${
            savingsfund
              ? `<div class="row savings-fund">
            <div class="nominal-pronouncing uppercase">DANA TABUNGAN SAAT INI : Rp ${new Intl.NumberFormat(
              "id"
            ).format(savingsfund)},-</div>
          </div>`
              : ""
          }
          ${
            remainingbill
              ? `<div class="row savings-fund">
            <div class="nominal-pronouncing uppercase">SISA PARTISIPASI : Rp ${new Intl.NumberFormat(
              "id"
            ).format(remainingbill > 0 ? remainingbill : 0)},-</div>
          </div>`
              : ""
          }
          ${
            remainingbill < 0
              ? `<div class="row savings-fund">
            <div class="nominal-pronouncing uppercase">KELEBIHAN PARTISIPASI : Rp ${new Intl.NumberFormat(
              "id"
            ).format(Math.abs(remainingbill))},-</div>
          </div>`
              : ""
          }
        </div>
        <div class="page-footer">
          <div class="row">
            <div class="col-left">${transactioncode || ""}</div>
            <div class="col-right">
              <div class="signature">
                <div class="signature-name uppercase">${username || ""}</div>
                <div class="signature-desc">(kasir)</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      `,
    type: "raw-html",
    header: null,
    style:
      "@media print { @page { margin-top: 48px; margin-bottom: 48px; } @page:first { margin-top: 0; margin-bottom: 0; } body { --main-color: #000000; font-family: monospace; font-size: 14px; padding: 0; color: var(--main-color); } } .page { width: 100%; min-height: 420px; padding-top: 16px; padding-bottom: 16px; display: flex; flex-direction: column; align-items: stretch; justify-content: space-between; } .ml-16 { margin-left: 16px !important; } .nowrap { white-space: nowrap !important; } .uppercase { text-transform: uppercase !important; } .border-bottom { border-bottom: 1px solid currentColor !important; } .align-items-center { align-items: center !important; } .page-header { text-transform: uppercase; text-align: center; text-decoration: underline; margin-bottom: 16px; } .page-footer { margin-top: 120px; } .row { width: 100%; display: flex; flex-direction: row; align-items: flex-start; justify-content: space-between; margin-bottom: 2px; } .row .col-right { text-align: right; margin-left: 4px; } .row .col { flex: 1; } .list { width: 100%; display: flex; flex-direction: row; align-items: flex-start; } .list .list-key { flex: 0 0 auto; width: 144px; display: flex; flex-direction: row; align-items: flex-start; justify-content: space-between; } .list .list-value { flex: 1; margin-left: 4px; } .list-value--first{margin-bottom:2px;padding-bottom:2px;} .list .list-value__transaction-type{max-width: 450px;} .nominal-pronouncing { margin-top: 8px; } .savings-fund { margin-top: 16px; } .signature { width: 144px; display: flex; flex-direction: column; align-items: stretch; } .signature-name { text-transform: uppercase; text-align: center; border-bottom: 1px solid currentColor } .signature-desc { text-align: center; }",
    documentTitle: "BUKTI TRANSAKSI",
    onPrintDialogClose,
    fallbackPrintable: onPrintDialogClose,
  });
}
