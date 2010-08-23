<?php
/**
 * Хелпер для работы с gravatar.com
 */

/**
 * Путь к аватарке
 *
 * @param string $email
 * @param integer $size
 * @return string
 */
function gravatar_image_url($email, $size = 48)
{
    $hash = md5(strtolower(trim($email)));

    return sprintf('http://www.gravatar.com/avatar/%s?size=%d', $hash, $size);
}


/**
 * Отрисовать <img .. /> c аватаркой
 *
 * @param string $email
 * @param integer $size
 * @param array $arguments
 * @return string
 */
function gravatar($email, $size = 48, array $arguments = array())
{
    return image_tag(gravatar_image_url($email, $size), $arguments);
}