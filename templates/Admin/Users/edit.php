<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <?= $this->element('admin/sidenav') ?>
    </aside>
    <div class="column column-75">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend>Modification d'un utilisateur</legend>
                <?php
                    echo $this->Form->control('login');
                    echo $this->Form->control('password', ['value' => '']);
                    echo $this->Form->control('role', ['type' => 'select', 'options' => ['user' => 'Etudiant', 'admin' => 'Professeur']]);
                    echo $this->Form->control('email');
                ?>
            </fieldset>
            <?= $this->Form->button('Modifier l\'utilisateur') ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
