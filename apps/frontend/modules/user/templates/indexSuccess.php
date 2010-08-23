<?php
/**
 * Список пользователей
 *
 * @param array of sfGuardUser
 */

use_helper('Gravatar');
?>

<h2>Пользователи</h2>

<ul class="users">
<?php foreach ($users as $user): ?>
    <li>
        <?php echo link_to('<span>'.$user->getUsername().'</span>', 'user_show', $user, array(
            'class' => 'ajax userlink',
        )) ?>
    </li>
<?php endforeach ?>
</ul>