<?php

use_helper('HumanDate');
?>

<div id="sf_admin_container">
    <h1>Импортированные события</h1>
    <table>
        <?php foreach ($events as $event): ?>
        <tr>
            <td><?php echo $event->getTitle() ?></td>
            <td><?php echo $event->getDescription() ?></td>
            <td><?php echo human_date($event->getFireAt(), true, false) ?></td>
            <td><?php echo link_to('Редактировать', 'event_edit', $event) ?>
        </tr>
        <?php endforeach ?>
    </table>

    <p><?php echo link_to('Импортировать еще', 'import') ?></p>
</div>