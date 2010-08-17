<?php include_partial('sfAdminDash/header_top') ?>

<?php if (($sf_context->getModuleName() != 'sfAdminAuth') && ($sf_context->getActionName() != 'signin')): ?>
    <div id='sf_admin_menu'>
        <?php include_component('sfAdminDash', 'menu') ?>
        <?php if (sfAdminDash::getProperty('logout') && ($sf_user->isAuthenticated())): ?>
            <div id="logout">[<?php echo link_to('Выйти', 'sfGuardAuth/signout') ?>] <?php echo $sf_user ?></div>
        <?php endif; ?>
        <div class="clear"></div>
    </div>
    <div id='sf_admin_path'>
      <strong>
        <a href='<?php echo url_for('homepage') ?>'><?php echo sfAdminDash::getProperty('site') ?></a>
      </strong> /
      <?php echo ucfirst(__(sfAdminDash::getModuleName($sf_context->getModuleName()))) ?>
    </div>
<?php endif ?>
