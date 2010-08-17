<?php
/**
 * Главная
 */
?>

<?php if ($sf_user->isAuthenticated()): ?>
    <p>Привет! <?php echo $sf_user->getGuardUser()->getFirstName() ?>!
    <?php echo link_to('[выйти]', 'signout') ?>
<?php else: ?>
    <p>Привет, анонимус!</p>
    <a href="<?php echo sfConfig::get('app_loginza_widget_url') . '?' . http_build_query(array(
        'token_url' => url_for(sfConfig::get('app_loginza_token_url'), array(), true),
        'providers_set' => sfConfig::get('app_loginza_providers'),
        'provider' => sfConfig::get('app_loginza_default_provider'),
    )) ?>" class="loginza">
        <img src="http://loginza.ru/img/sign_in_button_gray.gif" alt="Войти"/>
    </a>
<?php endif ?>
