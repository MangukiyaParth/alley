document.getElementById("toggle_menu").onclick = function() {toggleMenu()};

function toggleMenu() {
    document.getElementById("sidebar").classList.toggle("open");
    document.getElementById("backdrop").classList.toggle("active");
}

function decryptData(encryptedData, key, iv) {
    console.log(encryptedData);
    // Decode the base64 encoded encrypted data
    var encryptedDataBytes = CryptoJS.enc.Base64.parse(encryptedData);
    
    // Convert the key and IV to WordArray format
    var keyBytes = CryptoJS.enc.Hex.parse(key);
    var ivBytes = CryptoJS.enc.Hex.parse(iv);
    // var keyBytes = key;
    // var ivBytes = iv;
    
    // Decrypt the data
    var decrypted = CryptoJS.AES.decrypt(
        { ciphertext: encryptedDataBytes },
        keyBytes,
        {
            iv: ivBytes,
            mode: CryptoJS.mode.CBC,
            padding: CryptoJS.pad.Pkcs7
        }
    );

    // console.log("Encrypted Data (Base64):", encryptedData);
    // console.log("Key (Hex):", key);
    // console.log("IV (Hex):", iv);
    // console.log("Encrypted Data Bytes:", encryptedDataBytes);
    // console.log("Key Bytes:", keyBytes);
    // console.log("IV Bytes:", ivBytes);
    
    // Convert the decrypted data to a UTF-8 string
    var decryptedData = decrypted.toString(CryptoJS.enc.Utf8);
    
    return decryptedData;
}