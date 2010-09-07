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
function link_to_comments($point, $title = 'комментарии') {
    return link_to('<span>'.$title.'</span>', 'comment', $point, array(
        'class' => 'overlay point-comments',
        'rel' => '#overlay',
    ));
}

/**
 * Ссылка на удаление комментария
 *
 * @param Comment $comment
 */
function link_to_comment_delete($comment, $title = null) {
    $user = sfContext::getInstance()->getUser();

    if ($user->isAuthenticated() &&
        $user->getGuardUser()->getId() == $comment->getUserId() &&
        $comment->hasDeletable()) {

        return jq_link_to_remote($title ? $title : 'Удалить', array(
            'method'    => 'post',
            'url'       => url_for('comment_delete', $comment),
            'success'   => 'jQuery("#comment-'.$comment->id.'").remove();',
            'confirm'   => 'Вы точно хотите удалить свой комментарий?',
        ));
    }
}

/**
 * Ссылка на место
 *
 * @param Place $place
 */
function link_to_place($place, $title = null) {
    return link_to($title ? $title : $place->getTitle(), 'place_show', $place, array(
        'class' => 'ajax',
    ));
}

/**
 * Ссылка на редактирование места
 *
 * @param Place $place
 */
function link_to_place_edit($place, $title = 'Правка') {
    return link_to($title, 'place_edit', $place, array(
        'class' => 'ajax point-edit',
    ));
}

/**
 * Ссылка на удаление места
 *
 * @param Place $place
 */
function link_to_place_delete($place, $title = 'Удалить') {
    return link_to($title, 'place_delete', array(
        'id' => $place->id,
        '_csrf_token' => __csrf_token_value(),
    ), array(
        'class' => 'ajax ajax-post point-delete',
    ));
}

/**
 * Ссылка на событие
 *
 * @param Event $event
 */
function link_to_event($event, $title = null) {
    return link_to($title ? $title : $event->getTitle(), 'event_show', $event, array(
        'class' => 'ajax',
    ));
}

/**
 * Ссылка на редактирование события
 *
 * @param Event $event
 */
function link_to_event_edit($event, $title = 'Правка') {
    return link_to($title, 'event_edit', $event, array(
        'class' => 'ajax point-edit',
    ));
}

/**
 * Ссылка на удаление события
 *
 * @param Event $event
 */
function link_to_event_delete($event, $title = 'Удалить') {
    return link_to($title, 'event_delete', array(
        'id' => $event->id,
        '__csrf_token' => __csrf_token_value(),
    ), array(
        'class' => 'ajax ajax-post point-delete',
    ));
}

/**
 * Ссылка на фотогалерею
 *
 * @param Point $point
 */
function link_to_photos($point, $title = 'Фото') {
    return link_to('<span>'.$title.'</span>', 'photo', $point, array(
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

/**
 * CSRF Token
 *
 * @return string
 */
function __csrf_token_value() {
    $form = new sfForm();
    return $form->getCSRFToken();
}
