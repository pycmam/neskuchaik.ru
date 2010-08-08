<?php

if (strpos($_SERVER['HTTP_HOST'], 'admin.') === 0) {
    $app   = 'admin';
} else {
    $app   = 'frontend';
}

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration($app, 'dev', true);
sfContext::createInstance($configuration)->dispatch();
