<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Form[]|\Cake\Collection\CollectionInterface $forms
 */
?>

<div class="row">
    <aside class="column">
        <?= $this->element('sidenav') ?>
    </aside>
    <div class="column column-75">
        <h3>Liste des QCM</h3>
        <table>
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('display_name', ['label' => 'Titre']) ?></th>
                <th><?= $this->Paginator->sort('closed_on', ['label' => 'Date de fermeture']) ?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($forms as $form): ?>
                <tr>
                    <td><?= h($form->display_name) ?></td>
                    <td><?= h($form->closed_on) ?></td>
                    <?php if (count($form->questions) > count($form->student_answers)) : ?>
                    <td class="actions">
                        <?= $this->Html->link('Effectuer ce QCM', ['action' => 'take', $form->id]) ?>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?= $this->element('pagination', ['paginator' => $this->Paginator]) ?>
    </div>
</div>

