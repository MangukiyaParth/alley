<?php include "header.php"; ?>
<section class="sidebar" id="sidebar">
    <ul class="category-list" id="cat_list">
        <span>Loading...</span>
    </ul>
    <div class="sidebar-ads">Ads</div>
</section>
<section class="games-container hidden" id="game_list_section">
    <div class="game-list" id="game_list">
        <span>Loading...</span>
    </div>
    <div class="side-ads">Ads</div>
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
<?php include "footer.php"; ?>
<script>
    let mobile_width = 600;
    let event_name_stored = "";
    let soundCheck = "";
    let view_type = "";
    let game_link = "";
    let game_key = "?key=9gHj3sP5Kq7Rt4A1fBz0uXmN2vYc6DwE8iF7oLpQbVdSjCkMn";

    $(document).ready(async function(){
        var gameDetail = decodeURIComponent(localStorage.getItem('game-detail'));
        if(gameDetail && gameDetail != "null"){
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
        else {
            window.location.href = "/index.php";
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