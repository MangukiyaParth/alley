<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alley Games</title>
    <link rel="stylesheet" href="assets/css/custom.css">
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4824731361768973" crossorigin="anonymous"></script>
    <meta name="google-adsense-account" content="ca-pub-4824731361768973">
    <script type="module">
        let is_completeNext = false;
        let is_videoAd = false;
        let is_interstitial = false;

        // Import the functions you need from the SDKs you need
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.4/firebase-app.js";
        import { getFirestore, getDocs, collection } from "https://www.gstatic.com/firebasejs/10.12.4/firebase-firestore.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
            apiKey: "AIzaSyD1zKVxsNfRqEnl5DCtLmyUiy7K3pgj_Rc",
            authDomain: "alley-b9d49.firebaseapp.com",
            projectId: "alley-b9d49",
            storageBucket: "alley-b9d49.appspot.com",
            messagingSenderId: "466077068329",
            appId: "1:466077068329:web:d2215cf58588f6fa594038",
            measurementId: "G-CLVTHKDXPW"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const db = getFirestore(app);

        const querySnapshot = await getDocs(collection(db, "alley"));
        querySnapshot.forEach((doc) => {
            const FireRes = doc.data();
            is_completeNext = FireRes.is_completeNext;
            is_videoAd = FireRes.is_videoAd;
            is_interstitial = FireRes.is_interstitial;
        });

    </script>
</head>
<body>
    <header>
        <div class="header-container">
            <a class="header-logo" href="index.php">
                <img src="assets/img/logo.png" alt="Alley">
                <span class="logo-text">Alley Games</span>
            </a>
            <div class="search-div">
                <img src="assets/img/search_icon.png" class="search-icon" alt="search-icon">
                <input type="text" class="search-box" name="search" id="search" placeholder="search..." autocomplete="off">
            </div>
            <div class="menu-div">
                <img src="assets/img/menu.png" class="menu-icon" id="toggle_menu" alt="menu-icon">
            </div>
        </div>
    </header>
    <div class="main-page">
        <section class="sidebar" id="sidebar">
            <ul class="category-list" id="cat_list">
                <span>Loading...</span>
            </ul>
            <div class="sidebar-ads">Ads</div>
        </section>
        <section class="games-container hidden" id="game_list">
            <span>Loading...</span>
        </section>
        <section class="games-container play-game">
            <div class="game-div" id="fullscreen_div">
                <div class="banner-div hidden">
                    <div class="bg-banner-div">
                        <div class="bg-color"></div>
                        <img class="game-banner w-100" />
                    </div>
                    <div class="game-logo-div">
                        <img class="game-logo" />
                        <button class="play-now" >Play Now</button>
                    </div>
                </div>
                <div class="back-btn" id="back_btn">
                    <img src="assets/img/back-icon.png" alt="">
                    <img src="assets/img/back-logo.png" alt="" class="back-logo">
                </div>
                <iframe id="game" class="game-frame" allowfullscreen='true' webkitallowfullscreen='true' mozallowfullscreen='true'></iframe>
                <div class="games-container game-suggestion" id="side_similar_game_list"></div>
                <div class="side-ads">Ads</div>
            </div>
            <div class="bottom-ads">Ads</div>
            <div class="games-container game-suggestion" id="similar_game_list"></div>
        </section>
    </div>
    <div id="backdrop" class="backdrop"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
        let mobile_width = 600;
        let event_name_stored = "";
        let soundCheck = "";
        let view_type = "";
        let game_link = "";
        let game_key = "?key=9gHj3sP5Kq7Rt4A1fBz0uXmN2vYc6DwE8iF7oLpQbVdSjCkMn";

        $(document).ready(async function(){
            var gameDetail = decodeURIComponent(localStorage.getItem('game-detail'));
            if(gameDetail){
                var gameData = JSON.parse(gameDetail, true);
                game_link = gameData.gamelink;
                var game_type = gameData.category;
                var game_banner = gameData.banner_link;
                var game_logo = gameData.img;
                view_type = gameData.view_type;
                await getCategory(is_index_page=false);
                await getSimilarGames(game_type);
                
                if($(window).width() <= mobile_width){
                    $(".banner-div").removeClass("hidden");
                    $(".game-banner").attr("src", game_banner);
                    $(".game-logo").attr("src", game_logo);
                    $("#game").addClass("hidden");
                    $("#side_similar_game_list").addClass("hidden");
                    $("#similar_game_list").removeClass("hidden");
                }
                else{
                    var frame_height = 600;
                    var frame_width = 350;
                    if(view_type == "horizontal"){
                        $("#side_similar_game_list").addClass("hidden");
                        $("#similar_game_list").removeClass("hidden");

                        frame_width = Math.round($("#game").width() - 20);
                        frame_height = Math.round((4 * frame_width) / 7);
                    }
                    else {
                        $("#side_similar_game_list").removeClass("hidden");
                        $("#similar_game_list").addClass("hidden");

                        if(($(document).height() - $('header').height()) <= 600){
                            frame_height = $(document).height() - $('header').height() - 20;
                            frame_width = Math.round((4 * frame_height) / 7);
                        }
                    }
                    let dimensions = frame_width+"/"+frame_height;
                    
                    $("#game").prop('src', game_link+game_key);
                    $("#game").on("load", function () {
                        setScreenSize(dimensions);
                    });

                    $("#game").css({
                        width: frame_width+10,
                        height: frame_height+10,
                        overflow: 'hidden',
                        border: 'none'
                    });
                }
            }
        });

        $(".play-now").on("click", function(){
            fullScreenGame();
            $(".play-game").addClass("fullscreen");
            $(".banner-div").addClass("hidden");
            $("#game").removeClass("hidden");
            const screen = document.getElementById('fullscreen_div');
            if (screen.requestFullscreen) {
                screen.requestFullscreen();
            } else if (screen.mozRequestFullScreen) { // Firefox
                screen.mozRequestFullScreen();
            } else if (screen.webkitRequestFullscreen) { /* Safari */
                screen.webkitRequestFullscreen();
            } else if (screen.msRequestFullscreen) { /* IE11 */
                screen.msRequestFullscreen();
            }
            
            if(view_type == "horizontal"){
                screen.orientation.lock('landscape');
            }
        });

        $("#back_btn").on("click", function(){
            if(view_type == "horizontal"){
                screen.orientation.lock('portrait');
            }
            console.log('call_back');
            $(".play-game").removeClass("fullscreen");
            $(".banner-div").removeClass("hidden");
            $("#game").addClass("hidden");
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) { // Firefox
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) { // Chrome, Safari, and Opera
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { // IE/Edge
                document.msExitFullscreen();
            }
        });

        function fullScreenGame() {
            $("#game").prop('src', game_link+game_key);
            $("#game").on("load", function () {
                const iframe = document.getElementById('game');
                iframe.contentWindow.postMessage('fullscreen', 'https://gamersaimstorage.s3.ap-south-1.amazonaws.com');
            });
        }
        function setScreenSize(dimensions) {
            const iframe = document.getElementById('game');
            iframe.contentWindow.postMessage('size_event,' + dimensions, 'https://gamersaimstorage.s3.ap-south-1.amazonaws.com');
        }

        document.addEventListener('fullscreenchange', () => {
            const buttonContainer = document.getElementById('back_btn');
            if (document.fullscreenElement) {
                buttonContainer.style.display = 'flex';
            } else {
                buttonContainer.style.display = 'none';
            }
        });

        function getSimilarGames(game_type){
            $.ajax({
                type: "POST",
                url: "https://gamersaim.com/Apis/games_spot_web/category_by_data.php",
                data: {type:'category', category_name:game_type},
                dataType: 'json',
                async: true,
            }).done(function (response) {
                var gameData = response;
                var game_html = "";
                gameData.forEach(function(game){
                    var gameDetails = JSON.stringify(game);
                    game_html += `<div class="game-item" onclick="openGame('${encodeURIComponent(gameDetails)}');">
                                    <img src="${game.img}" alt="game1" loading="lazy">
                                </div>`;
                });
                $(".game-suggestion").html(game_html);
            });
        }

        function sendUnityMsg(arg) {
            // "STOP_SOUND"
            //"PLAY_SOUND"
            const iframe = document.getElementById('game');
            iframe.contentWindow.postMessage('unity_event,'+arg, 'https://gamersaimstorage.s3.ap-south-1.amazonaws.com');
        }
        window.addEventListener('message', (event) => {
            if (event.origin !== 'https://gamersaimstorage.s3.ap-south-1.amazonaws.com') return; // Add your WebGL domain

            let args;
            if (event.data.includes(',')) {
                args = event.data.split(',');
            } else {
                args = [event.data];
            }
            
            if(args[0]=="COMPLETE_NEXT"){
                event_name_stored=args[1];
                if(is_completeNext){
                    if(args.length>2){
                        soundCheck=args[2];
                    }

                    setSound(soundCheck, false);
                    manageAdCloseEvent(soundCheck,false,event_name_stored);
                }
                else{
                    sendUnityMsg(event_name_stored);
                }
            }
            else if(args[0]=="SHOW_VIDEO"){
                event_name_stored=args[1];
                if(is_videoAd){
                    if(args.length>2){
                        soundCheck=args[2];
                    }
                    setSound(soundCheck, false);
                    manageAdCloseEvent(soundCheck,false,event_name_stored);
                }
                else{
                    sendUnityMsg(event_name_stored);
                }
            }
            else if(args[0]=="SHOW_INTER"){
                event_name_stored=args[1];
                if(is_interstitial){
                    if(args.length>2){
                        soundCheck=args[2];
                    }
                    setSound(soundCheck, false);
                    manageAdCloseEvent(soundCheck,false,event_name_stored);
                }
                else{
                    sendUnityMsg(event_name_stored);
                }
            }
            console.log('Message received from iframe:', event.data);
        });

        function setSound(soundCheck, isOn) {
            if (isOn) {
                if (soundCheck === "ON" || soundCheck === "") {
                    sendUnityMsg("PLAY_SOUND");
                }
            } else {
                if (soundCheck === "ON" || soundCheck === "") {
                    sendUnityMsg("STOP_SOUND");
                }
            }
        }

        function manageAdCloseEvent(soundCheck, isOn, nextevent){
            setSound(soundCheck, isOn);
            sendUnityMsg(event_name_stored);
        }
    </script>
</body>
</html>