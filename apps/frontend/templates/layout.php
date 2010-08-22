<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" type="image/png" href="/favicon.png" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>

    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-11261412']);
      _gaq.push(['_trackPageview']);
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
</head>
<body onunload="GUnload()">

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
                            <div id="actions">
                                Привет, <?php echo $sf_user->getGuardUser()->getUsername() ?>!
                                [ <strong><?php echo link_to('выйти', 'signout') ?></strong> ]

                                <?php echo link_to('отметить место', 'place_new', array(), array(
                                    'id' => 'add-place',
                                    'class' => 'ajax action',
                                )) ?>

                                <?php echo link_to('добавить событие', 'event_new', array(), array(
                                    'id' => 'add-event',
                                    'class' => 'ajax action',
                                )) ?>
                            </div>
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

</body>
</html>
