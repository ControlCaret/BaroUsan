function onScanSuccess(qrMessage)
{
    console.log(`QR matched = ${qrMessage}`);
    Html5QrcodeScanner.clear();
    document.getElementById("card_id").value = qrMessage;
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader", { fps: 10, qrbox: 250 });
    
html5QrcodeScanner.render(onScanSuccess);

function returnNum(num)
{
    document.getElementById("returnNum").value = num;
}
