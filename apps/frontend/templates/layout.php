<?php
/**
 * Шаблон с картой
 */
?>
<?php include_partial('global/header') ?>

<div id="map-layout">
    <div id="map">
        <?php include_partial('map/map') ?>
    </div>

    <div id="sidebar">
        <div class="content">
            <!-- меню -->
            <ul id="main-menu" class="menu">
                <?php include_component('sfRichMenu', 'menu', array('menu' => 'header')) ?>
            </ul>

            <!-- лого, профиль -->
            <div id="header">
                <a id="logo" href="<?php echo url_for('homepage') ?>"></a>

                <div id="account">
                    <?php if ($sf_user->isAuthenticated()): ?>
                        <p>Привет, <?php echo $sf_user->getGuardUser()->getUsername() ?>!
                        <?php echo link_to('[выйти]', 'signout') ?>
                    <?php else: ?>
                        <?php include_partial('loginza/signin') ?>
                    <?php endif ?>
                </div>
            </div>

            <!-- контент -->
            <div id="content">
                <div class="content">
                    <?php echo $sf_content ?>
                </div>
                <div class="loader"></div>
            </div>
        </div>
    </div>
</div>

<?php include_partial('global/footer') ?>