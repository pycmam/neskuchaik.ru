<?php
/**
 * Кнопочки авторизации
 */

$default = array(
    'token_url' => url_for(sfConfig::get('app_loginza_token_url'), array(), true),
);

?>

<script type="text/javascript" src="http://loginza.ru/js/widget.js"></script>

<ul id="auth-buttons">
    <li>
        <a title="Войти" id="loginza-all" href="<?php echo sfConfig::get('app_loginza_widget_url') . '?' . http_build_query($default) ?>" class="loginza">Войти:</a>
    </li>
    <?php foreach (sfConfig::get('app_loginza_buttons') as $name => $config): ?>
    <li>
        <a class="loginza" href="<?php echo sfConfig::get('app_loginza_widget_url') . '?' . http_build_query(array_merge($default, array(
            'provider' => $config['provider'],
        ))) ?>"><?php echo image_tag($config['image'], array('alt' => $name, 'title' => $config['name'])) ?></a>
    </li>
    <?php endforeach ?>
</ul>