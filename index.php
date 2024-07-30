<?php include "header.php"; ?>
<section class="sidebar" id="sidebar">
    <ul class="category-list" id="cat_list">
        <span>Loading...</span>
    </ul>
</section>
<section class="games-container">
    <div class="game-list"  id="game_list">
        <span>Loading...</span>
    </div>
    <div class="side-ads">Ads</div>
</section>
<?php include "footer.php"; ?>
<script>
    $(document).ready(async function(){
        await getCategory();
        await getGames('all','');
    });
</script>