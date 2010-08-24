<?php

/**
 * Ссылка на профиль пользователя
 *
 * @param sfGuardUser $user
 */
function link_to_user($user) {
    return link_to('<span>' . $user->getUsername() . '</span>', 'user_show', $user, array(
        'class' => 'ajax userlink',
        'title' => 'опубликовал',
    ));
}

/**
 * Ссылка на комментарии
 *
 * @param Point $point
 */
function link_to_comments($point) {
    return link_to('<span>комментарии</span>', 'comment', $point, array(
        'class' => 'overlay point-comments',
        'rel' => '#overlay',
    ));
}

/**
 * Ссылка на фотогалерею
 *
 * @param Point $point
 */
function link_to_photos($point) {
    return link_to('<span>фотографии</span>', 'photo', $point, array(
        'class' => 'overlay point-photos',
        'rel' => '#overlay',
    ));
}


/**
 * Ссылка на отмену действия, возвращение на главную
 */
function link_to_cancel() {
    return link_to('Отмена', 'homepage', array(), array(
        'class' => 'ajax',
        'onclick' => 'map.getMarker().hide();',
    ));
}

/**
 * Ссылка на слежение
 *
 * @param Point $point
 * @param sfGuardUser $user
 * @param string $follow_text
 * @param string $unfollow_text
 */
function link_to_follow($point, $user, $follow_text, $unfollow_text) {
    if ($point->hasFollower($user->getId())) {
        return link_to($unfollow_text, $point->getModel() . '_unfollow', $point, array(
            'class' => 'ajax ajax-post point-unfollow',
        ));
    } else {
        return link_to($follow_text, $point->getModel() . '_follow', $point, array(
            'class' => 'ajax ajax-post point-follow',
        ));
    }
}

/**
 * Ссылка на добавление события
 *
 * @param Place $place
 */
function link_to_event_new($place = null) {
    $args = $place ? array('place' => $place->getId()) : array();

    return link_to('Добавить событие', 'event_new', $args, array(
        'class' => 'ajax event-new',
    ));
}