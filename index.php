<?php include "header.php"; ?>
<section class="sidebar" id="sidebar">
    <ul class="category-list" id="cat_list">
        <span>Loading...</span>
    </ul>
</section>
<section class="games-container" id="game_list">
    <span>Loading...</span>
</section>
<?php include "footer.php"; ?>
<script>
    $(document).ready(async function(){
        await getCategory();
        await getGames('all','');
    });
</script>