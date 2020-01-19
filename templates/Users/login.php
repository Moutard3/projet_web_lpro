<?php $this->assign('main-class', 'main-center') ?>

<?= $this->Form->create(null, ['class' => 'form-login']) ?>
<fieldset>
    <?= $this->Form->control('email') ?>
    <?= $this->Form->control('password') ?>
    <?= $this->Form->submit('Se connecter', ['class' => 'button-primary']) ?>
</fieldset>
<?= $this->Form->end() ?>
