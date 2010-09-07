<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" type="image/png" href="/favicon.png" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>

    <?php /** rss-фиды */?>

    <?php echo tag('link', array(
        'title' => 'Новые места',
        'type' => 'application/atom+xml',
        'rel' => 'alternate',
        'href' => url_for('feed_places'),
    )) ?>

    <?php echo tag('link', array(
        'title' => 'События',
        'type' => 'application/atom+xml',
        'rel' => 'alternate',
        'href' => url_for('feed_events'),
    )) ?>

    <?php echo tag('link', array(
        'title' => 'Последние комментарии',
        'type' => 'application/atom+xml',
        'rel' => 'alternate',
        'href' => url_for('feed_last_comments'),
    )) ?>

    <?php include_partial('global/ga') ?>
</head>
<body onunload="GUnload()">
    <div id="map-layout">

        <div id="sidebar">
            <div id="sidebar-wrap">
                <ul id="main-menu" class="menu">
                    <?php include_component('sfRichMenu', 'menu', array('menu' => 'header')) ?>
                </ul>

                <div id="header">
                    <a id="logo" href="<?php echo url_for('homepage') ?>"></a>

                    <div id="account">
                        <?php if ($sf_user->isAuthenticated()): ?>
                            <div id="actions">
                                Привет, <?php echo $sf_user->getGuardUser()->getUsername() ?>!
                                [ <strong><?php echo link_to('выйти', 'signout') ?></strong> ]

                                <?php echo link_to('<span>отметить место</span>', 'place_new', array(), array(
                                    'id' => 'add-place',
                                    'class' => 'ajax action',
                                )) ?>

                                <?php echo link_to('<span>добавить событие</span>', 'event_new', array(), array(
                                    'id' => 'add-event',
                                    'class' => 'ajax action',
                                )) ?>
                            </div>
                        <?php else: ?>
                            <?php include_partial('loginza/signin') ?>
                        <?php endif ?>
                    </div>
                </div>

                <div id="content">
                    <div class="content">
                        <?php echo $sf_content ?>
                    </div>
                    <div class="loader"></div>
                </div>

                <ul id="footer-menu" class="menu">
                    <?php include_component('sfRichMenu', 'menu', array('menu' => 'footer')) ?>
                </ul>
            </div>
        </div>

        <div id="map">
            <?php include_partial('global/map') ?>
        </div>
    </div>

    <div id="overlay">
        <div id="overlay-wrap">
            <div class="content"></div>
            <div class="loader"></div>
        </div>
    </div>
</body>
</html>
