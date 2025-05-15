$(document).ready(function () {
    $('.aktifPasif').click(function (event) {
        var id = $(this).attr("id");  //id değerini alıyoruz

        var durum = ($(this).is(':checked')) ? '1' : '0';
        //checkbox a göre aktif mi pasif mi bilgisini alıyoruz.

        $.ajax({
            type: 'POST',
            url: 'aktifPasif.php',  //işlem yaptığımız sayfayı belirtiyoruz
            data: {id: id, durum: durum}, //datamızı yolluyoruz
            success: function (result) {
                $('#sonuc').text(result);
                //gelen sonucu h2 tagında gösteriyoruz
            },
            error: function () {
                alert('Hata');
            }
        });
    });
});
