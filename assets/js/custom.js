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

function getCategory() {
    $.get("https://gamersaim.com/Apis/games_spot_web/get_category.php", function(data, status){
        // console.log("Data: " + data + "\nStatus: " + status);
        if(status == 'success'){
            // var key = "mvjfhcbgrjdknclgoidhcjsyrkalswuq";
            // var iv = "bhdtfycloudowbvh";

            // var decryptedData = decryptData(data, key, iv);
            // console.log(decryptedData);

            let resData = JSON.parse(data);
            let cat = resData.category;
            let cat_html = "";
            cat.forEach(function(catData) {
                var type = "category";
                var cat_name = catData.category;
                if(catData.category == "New Releases"){ type = "new_releases";cat_name=""; }
                else if(catData.category == "Trending"){ type = "trending";cat_name=""; }

                cat_html += `<li class="category-item" id="cat_${catData.id}" onclick="getGames('${type}','${cat_name}')">
                                <img src="${catData.img}" alt=" " class="menu-icon">
                                <span class="menu-name">${catData.category}</span>
                            </li>`;
            });
            $("#cat_list").html(cat_html);
        }
    });
}