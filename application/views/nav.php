<nav>
    <div class="dark-bg"></div>
    <a class="home" href="<?=base_url();?>"><img src="<?=base_url();?>asset/images/home.svg"/></a>
    <div class="log">
        <a class="account" href="<?=base_url();?>compte">
            <?php if(isset($_SESSION['user_infos'])):?>
            <img src="<?=base_url();?>asset/images/user.png"/>
            <p><?=strtoupper($_SESSION['user_infos'][0]['user_name']);?></p>
            <?php endif ?>
        </a>
    <?php if(!isset($_SESSION['user_infos'])):?>
        <a href="<?=base_url();?>inscription">Inscription</a>
        <div class="separation"></div>
        <a href="<?=base_url();?>connexion">Connexion</a>
    </div>
    <?php endif ?>
</nav>