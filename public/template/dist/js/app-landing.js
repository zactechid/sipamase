
function cekDurasi(dbTimeString, jam = 5) {
    // Konversi string waktu database ke objek Date
    function convertToISO(dateString) {
        const isoString = dateString.replace(/\//g, '-').replace(' ', 'T') + '+08:00';
        return new Date(isoString);
    }

    const dbDate = convertToISO(dbTimeString);

    // Dapatkan waktu saat ini
    const currentDate = new Date();

    // Hitung offset dari zona waktu lokal dalam milidetik
    const localOffset = currentDate.getTimezoneOffset() * 60 * 1000;

    // Sesuaikan dengan offset yang Anda inginkan (+8 jam dalam milidetik)
    const desiredOffset = 8 * 60 * 60 * 1000;
    const adjustedDate = new Date(currentDate.getTime() + localOffset + desiredOffset);

    // Hitung selisih waktu dalam jam
    const hoursDifference = (adjustedDate - dbDate) / (1000 * 60 * 60);

    // Cek apakah selisihnya lebih dari jam yang ditentukan
    return hoursDifference > jam;
}


 if ($('.posisi-coldown').length > 0) {
    const couldon = $('.posisi-coldown')
   setInterval(() => {
      $('.posisi-coldown').each(function (i, obj) {
        if (cekDurasi($(obj).attr('data-time'))) {
          $(obj).removeClass('badge-danger').addClass(' badge-success');
        } else {
          $(obj).removeClass('badge-success').addClass(' badge-danger');
         }
      })
    }, 1000);
 }