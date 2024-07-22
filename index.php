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
        </section>
        <section class="games-container" id="game_list">
            <span>Loading...</span>
        </section>
    </div>
    <div id="backdrop" class="backdrop"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
        $(document).ready(async function(){
            await getCategory();
            await getGames('all','');
        });
    </script>
</body>
</html>