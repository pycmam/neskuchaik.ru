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

<?php echo link_to('Все пользователи', 'users', array(), array(
    'class' => 'ajax',
)) ?>