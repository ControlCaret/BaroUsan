function onScanSuccess(qrMessage)
{
    console.log(`QR matched = ${qrMessage}`);
    Html5QrcodeScanner.clear();
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader", { fps: 10, qrbox: 250 });
    
html5QrcodeScanner.render(onScanSuccess);