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
        <div class="themes form content">
            <?= $this->Form->create($theme) ?>
            <fieldset>
                <legend>Ajouter un thème</legend>
                <?php
                    echo $this->Form->control('display_name', ['label' => 'Nom du thème']);
                ?>
            </fieldset>
            <?= $this->Form->button('Ajouter le thème') ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
