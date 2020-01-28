<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Theme $theme
 */
?>
<div class="row">
    <aside class="column">
        <?= $this->element('admin/sidenav') ?>
    </aside>
    <div class="column column-75">
        <?= $this->Form->create($theme) ?>
        <fieldset>
            <legend>Modification d'un thème</legend>
            <?php
                echo $this->Form->control('display_name', ['label' => 'Nom du thème']);
            ?>
        </fieldset>
        <?= $this->Form->button('Modifier le thème') ?>
        <?= $this->Form->end() ?>
    </div>
</div>
