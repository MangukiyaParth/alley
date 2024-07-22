<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alley Games</title>
    <link rel="stylesheet" href="assets/css/custom.css">
    <meta name="Keywords" content="">
    <meta name="Description" content="">
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
            <div class="game-div">
                <iframe id="game" class="game-frame"></iframe>
                <div class="side-ads">Ads</div>
            </div>
            <div class="bottom-ads">Ads</div>
            <div class="games-container" id="similler_game_list"></div>
        </section>
    </div>
    <div id="backdrop" class="backdrop"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
        $(document).ready(async function(){
            await getCategory(is_index_page=false);
            var game_link = localStorage.getItem('game-link');
            var game_type = localStorage.getItem('game-type');
            var view_type = localStorage.getItem('view-type'); // 7/4
            console.log(view_type);
            await getSimilerGames(game_type);
            var fram_height = 600;
            var fram_width = 350; // Landscap
            if(game_type == "horizontal"){
                fram_width = Math.round($(window).width() - $("#sidebar").width() - 250);
                fram_height = Math.round((4 * fram_width) / 7); // Landscap
            }
            var diamentions = fram_width+"/"+fram_height;
            $("#game").prop('src', game_link+"?key=9gHj3sP5Kq7Rt4A1fBz0uXmN2vYc6DwE8iF7oLpQbVdSjCkMn");
            setScreenSize(diamentions);
        });

        function fullScreenGame() {
            const iframe = document.getElementById('game');
            iframe.contentWindow.postMessage('fullscreen', 'https://gamersaimstorage.s3.ap-south-1.amazonaws.com');
        }
        function setScreenSize(diamentions) {
            const iframe = document.getElementById('game');
            iframe.contentWindow.postMessage('size_event,' + diamentions, 'https://gamersaimstorage.s3.ap-south-1.amazonaws.com');
        }

        function getSimilerGames(game_type){
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
                    game_html += `<div class="game-item" onclick="openGame('${game.gamelink}','${game.view_type}');">
                                    <img src="${game.img}" alt="game1" load="lezy">
                                </div>`;
                });
                $("#similler_game_list").html(game_html);
            });
        }

    </script>
</body>
</html>