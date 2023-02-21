/**
 * Download a list of files.
 * @author speedplane
 */
function download_files(files) {
  function download_next(i) {
    if (i >= files.length) {
      return;
    }
    var a = document.createElement('a');
    a.href = files[i].download;
    a.target = '_parent';
    // Use a.download if available, it prevents plugins from opening.
    if ('download' in a) {
      a.download = files[i].filename;
    }
    // Add a to the doc for click to work.
    (document.body || document.documentElement).appendChild(a);
    if (a.click) {
      a.click(); // The click method is supported by most browsers.
    } else {
      $(a).click(); // Backup using jquery
    }
    // Delete the temporary link.
    a.parentNode.removeChild(a);
    // Download the next file with a small timeout. The timeout is necessary
    // for IE, which will otherwise only download the first file.
    setTimeout(function() {
      download_next(i + 1);
    }, 500);
  }
  // Initiate the first download.
  download_next(0);
}

function do_dl() {
  download_files([
    { download: "/assets/files/Contoh Format Import Flow Pembayaran Bulanan.xlsx", filename: "Contoh Format Import Flow Pembayaran Bulanan.xlsx" },
    { download: "/assets/files/Contoh Format Import Flow Pembayaran Angsuran.xlsx", filename: "Contoh Format Import Flow Pembayaran Angsuran.xlsx" }
  ]);
};

function do_dl_karyawan() {
  download_files([
    { download: "/assets/files/Contoh Import Sikas - Data Karyawan.xlsx", filename: "Contoh Import Sikas - Data Karyawan.xlsx" }
  ]);
};

function do_dl_siswa() {
  download_files([
    { download: "/assets/files/Contoh Import Sikas - Data Siswa.xlsx", filename: "Contoh Import Sikas - Data Siswa.xlsx" }
  ]);
};

function do_dl_pengeluaran() {
  download_files([
    { download: "/assets/files/Contoh Import Sikas - Data Pengeluaran.xlsx", filename: "Contoh Import Sikas - Data Pengeluaran.xlsx" }
  ]);
};

function do_dl_tabungan_siswa() {
  download_files([
    { download: "/assets/files/Contoh Import Sikas - Data Tabungan Siswa.xlsx", filename: "Contoh Import Sikas - Data Tabungan Siswa.xlsx" }
  ]);
};

function do_dl_tabungan_karyawan() {
  download_files([
    { download: "/assets/files/Contoh Import Sikas - Data Tabungan Karyawan.xlsx", filename: "Contoh Import Sikas - Data Tabungan Karyawan.xlsx" }
  ]);
};

