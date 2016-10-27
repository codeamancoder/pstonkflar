$(document).ready(function () {

    $('[data-toggle="modal"]').click(function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if (url.indexOf('#') == 0) {
            $(url).modal('open');
        }
        else {
            $('#dialog').html('<br><br><center><img src="/static/v2/img/ajax.gif"></center>');
            $.get(url, function (data) {
                $('#dialog').html(data);
                $('#dialog').modal('show');
            }).success(function () {
                $('input:text:visible:first').focus();
            });
        }
    });

    if ($('div.sonduyuru a').size()) {
        $("div.sonduyuru").scrollable({circular: true, items: '.items', mousewheel: true}).autoscroll({
            interval: 10000
        });
    }

    if ($('div.test-slider .items2 > div').size()) {
        $("div.test-slider").scrollable({circular: true, items: '.items2', mousewheel: true}).autoscroll({
            interval: 5000
        });
    }


    $('input[name=eposta]').change(function () {
        if ((/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test($(this).val()))) {
            $.get('index.php?a=uye/eposta&d=' + $(this).val(), function (r) {
                $('#jxPosta').html(r >= 1 ? '<span style=\"color:red;\">Bu eposta zaten kayıtlı!</span>' : '');
            });
        }
        else $('#jxPosta').html('<span style="color:red">Lütfen doğru bir eposta giriniz.</span>');
    });
    $('input[name=sifre2]').change(function () {
        if ($(this).val() != $('input[name=sifre1]').val()) alert('Girilen Şifreler Uyuşmuyor');
    });

    $('select[name=ulke]').change(function () {
        if ($(this).val() == 'Türkiye') $('select[name=sehir]').removeAttr('disabled');
        else $('select[name=sehir]').attr('disabled', 'disabled');
    });

    $('form.register_form').submit(function () {
        var e = '';
        if (!$('input[name=ad]').val()) e += '• Adınızı ve Soyadınızı girmediniz.\n';
        if (!$('input[name=eposta]').val()) e += '• Eposta adresinizi girmediniz.\n';
        else if (!(/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test($('input[name=eposta]').val())))     e += '• Eposta adresiniz yanlış.\n';
        if (!$('input[name=sifre1]').val()) e += '• Şifrenizi girmediniz.\n';
        else if ($('input[name=sifre1]').val() != $('input[name=sifre2]').val()) e += '• Şifreleriniz uyuşmuyor.\n';
        else if ($('input[name=sifre1]').val().length < 5) e += '• Şifreniz en az 6 karakterden oluşmalı.\n';
        if (!$('[name=sozlesme]:checked').val()) e += '• Hizmet sözleşmesini onaylamadınız.\n';
        if (e) {
            alert(e);
            return false;
        }
    });

});

function pencere(w, h, t, a, r) {
    dialog.dialog({width: w, height: h, title: t});
    if (r) dialog.dialog({close: r});
    dialog.load(a);
    dialog.dialog('open');
    return false;
}

function jsdogrula() {
    var x = Math.floor((Math.random() * 10000)) + 1000;
    var r = prompt("İşleme devam etmek için onay kodunuzu kutucuğa giriniz. \n\nKodunuz : " + x)

    if (r != null) {
        if (r == x) return true;
        else {
            alert("Girilen kod yanlış!");
            return jsdogrula();
        }
    }
    else return false;
}

