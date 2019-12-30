function QRSourcetoPrint(invNummer, img) {
    return "<html><head><script>function step1(){\n" +
            "setTimeout('step2()', 10);}\n" +
            "function step2(){window.print();window.close()}\n" +
            "</scri" + "pt></head><body onload='step1()'>\n" +
            "<strong>"+ invNummer +"</strong><br><img src='" + img + "' /></body></html>";
}
function printQRCode(invNummer, img) {
    Pagelink = "about:blank";
    var pwa = window.open(Pagelink, "_new");
    pwa.document.open();
    pwa.document.write(QRSourcetoPrint(invNummer, img));
    pwa.document.close();
}