<?php
/**
 * Инфа пользователя
 *
 * @param sfGuardUser $user
 */

use_helper('Gravatar');
?>

<h1 class="username">
    <?php echo gravatar($user->getEmailAddress(), 32) ?>
    <span><?php echo $user->getUsername() ?></span>
</h1>

<p>
<?php echo link_to('Подписаться на события', 'feed_user_events', $user, array(
    'class' => 'feed',
    'title' => 'подписаться на события',
)) ?>
</p>

<?php echo link_to('Все пользователи', 'users', array(), array(
    'class' => 'ajax',
)) ?>