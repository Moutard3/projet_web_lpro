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
        <?= $this->Form->create($user) ?>
        <fieldset>
            <legend>Ajouter un utilisateur</legend>
            <hr>
            <?php
                echo $this->Form->control('login');
                echo $this->Form->control('password');
                echo $this->Form->control('role', ['type' => 'select', 'options' => ['user' => 'Etudiant', 'admin' => 'Professeur']]);
                echo $this->Form->control('email');
            ?>
        </fieldset>
        <?= $this->Form->button('Créer l\'utilisateur') ?>
        <?= $this->Form->end() ?>
    </div>
</div>
