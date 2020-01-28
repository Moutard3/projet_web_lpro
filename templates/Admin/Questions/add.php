<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Question $question
 * @var \App\Model\Entity\Theme[] $themes
 */
?>
<div class="row">
    <aside class="column">
        <?= $this->element('admin/sidenav') ?>
    </aside>
    <div class="column column-75">
        <?= $this->Form->create($question) ?>
        <fieldset>
            <legend>Ajouter une question</legend>
            <?php
                echo $this->Form->control('theme_id', ['options' => $themes]);
                echo $this->Form->control('display_text', ['label' => 'Question']);
            ?>
        </fieldset>
        <?= $this->Form->button('Ajouter la question') ?>
        <?= $this->Form->end() ?>
    </div>
</div>
