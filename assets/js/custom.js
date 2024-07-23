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

function getCategory(is_index_page=true) {
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

                cat_html += `<li class="category-item" id="cat_${catData.id}" onclick="getGames('${type}','${cat_name}',${is_index_page})">
                                <img src="${catData.img}" alt=" " class="menu-icon">
                                <span class="menu-name">${catData.category}</span>
                            </li>`;
            });
            $("#cat_list").html(cat_html);
        }
    });
}

async function getGames(type, cat_name = "", is_indx_page=true){
    $.ajax({
        type: "POST",
        url: "https://gamersaim.com/Apis/games_spot_web/category_by_data.php",
        data: {type:type, category_name:cat_name},
        dataType: 'json',
        async: true,
    }).done(function (response) {
        var gameData = response;
        var game_html = "";
        gameData.forEach(function(game){
            game_html += `<div class="game-item" onclick="openGame('${game.gamelink}','${game.view_type}','${game.category}','${game.banner_link}');">
                            <img src="${game.img}" alt="game1" load="lezy">
                        </div>`;
        });
        $("#game_list").html(game_html);
        if(!is_indx_page){
            $("#game_list").removeClass('hidden');
            $(".play-game").addClass('hidden');
        }
    });
}

async function openGame(gamelink, view_type, category, banner_link){
    localStorage.setItem('game-link', gamelink);
    localStorage.setItem('view-type', view_type);
    localStorage.setItem('game-type', category);
    localStorage.setItem('game-banner', banner_link);
    window.location.href = 'game.php';
}