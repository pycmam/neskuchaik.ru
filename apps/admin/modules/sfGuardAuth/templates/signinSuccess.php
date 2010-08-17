<div id="ctr" align="center">
  <div class="login">
    <div class="login-form">
      <form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
        <div class="form-block">
          <?php echo $form->renderGlobalErrors() ?>
          <?php echo $form->renderHiddenFields(); ?>
          <div class="inputlabel"><?php echo $form['username']->renderLabel() ?>:</div>
          <div>
            <?php echo $form['username']->renderError() ?>
            <?php echo $form['username']->render(array('class' => 'inputbox')); ?>
          </div>
          <div class="inputlabel"><?php echo $form['password']->renderLabel() ?>:</div>
          <div>
            <?php echo $form['password']->renderError() ?>
            <?php echo $form['password']->render(array('class' => 'inputbox')); ?>
          </div>
          <div class="inputlabel">
            <?php echo $form['remember']->renderLabel() ?>
            <?php echo $form['remember']->render(array('class' => 'inputcheck')); ?>
          </div>
          <div align="left"><input type="submit" name="submit" class="button clr" value="Войти" /></div>
        </div>
      </form>
    </div>
    <div class="login-text">
      <div class="ctr"><img alt="Безопасность" src="/sfAdminDashPlugin/images/login_security.jpg" /></div>
    </div>

    <div class="clr"></div>
	<div class="login-footer">
      <p><?php echo 'Используйте логин и пароль для входа в панель администрирования.'; ?></p>
	</div>
  </div>
</div>
