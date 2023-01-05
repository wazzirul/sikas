'use strict';

function testPrint() {
  printJS({
    printable: `
      <div class="page">
        <div>
          <h4 class="page-header">Bukti Transaksi</h4>
          <div class="row">
            <div class="col-left list">
              <div class="list-key">
                <div>No. Bukti / Tgl</div>
                <div>:</div>
              </div>
              <div class="list-value">092202000241 / Selasa, 3 Januari 2023</div>
            </div>
            <div class="col-right nowrap ml-16">Kelas : X TKR 3</div>
          </div>
          <div class="row">
            <div class="list">
              <div class="list-key">
                <div>No. Induk / Nama</div>
                <div>:</div>
              </div>
              <div class="list-value uppercase">8198/2101040 / M. SIFA'UL PUTRA ROMADHON</div>
            </div>
          </div>
          <div class="row">Untuk Pembayaran</div>
          <div class="row">
            <div class="col">
              <div class="list">
                <div class="list-key"></div>
                <div class="list-value uppercase row border-bottom">
                  <div class="col-left">BIAYA PENUNJANG PENDIDIKAN ANGSURAN</div>
                  <div class="col-right nowrap">225.000,-</div>
                </div>
              </div>
              <div class="list">
                <div class="list-key"></div>
                <div class="list-value uppercase row">
                  <div class="col-left">TOTAL</div>
                  <div class="col-right nowrap">225.000,-</div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="nominal-pronouncing uppercase">TERBILANG : DUA RATUS DUA PULUH LIMA RIBU RUPIAH</div>
          </div>
        </div>
        <div class="page-footer">
          <div class="row">
            <div class="col-left">0B6ULAD8P06PV1BOXRJAW</div>
            <div class="col-right">
              <div class="signature">
                <div class="signature-name">IMEL</div>
                <div class="signature-desc">(kasir)</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      `,
    type: 'raw-html',
    header: null,
    style: '@media print { @page { margin-top: 0; margin-bottom: 0; } body { --main-color: #000000; font-family: monospace; font-size: 14px; padding: 0; color: var(--main-color); } } .page { width: 100%; height: 80vh; padding-top: 16px; padding-bottom: 16px; display: flex; flex-direction: column; align-items: stretch; justify-content: space-between; } .ml-16 { margin-left: 16px !important; } .nowrap { white-space: nowrap !important; } .uppercase { text-transform: uppercase !important; } .border-bottom { border-bottom: 1px solid currentColor !important; } .align-items-center { align-items: center !important; } .page-header { text-transform: uppercase; text-align: center; text-decoration: underline; margin-bottom: 16px; } .page-footer { margin-top: 32px; } .row { width: 100%; display: flex; flex-direction: row; align-items: flex-start; justify-content: space-between; margin-bottom: 2px; } .row .col-right { text-align: right; margin-left: 4px; } .row .col { flex: 1; } .list { width: 100%; display: flex; flex-direction: row; align-items: flex-start; } .list .list-key { flex: 0 0 auto; width: 144px; display: flex; flex-direction: row; align-items: flex-start; justify-content: space-between; } .list .list-value { flex: 1; margin-left: 4px; } .nominal-pronouncing { margin-top: 8px; } .signature { width: 144px; display: flex; flex-direction: column; align-items: stretch; } .signature-name { text-transform: uppercase; text-align: center; border-bottom: 1px solid currentColor } .signature-desc { text-align: center; }',
    documentTitle: 'BUKTI TRANSAKSI'
  })
}