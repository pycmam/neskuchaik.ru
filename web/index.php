<?php
// Не показывать ошибки PHP на PROD
ini_set('display_errors', false);

if (strpos($_SERVER['HTTP_HOST'], 'admin.') === 0) {
    $app   = 'admin';
} else {
    $app   = 'frontend';
}

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration($app, 'prod', false);
sfContext::createInstance($configuration)->dispatch();
