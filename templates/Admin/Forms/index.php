<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Form[]|\Cake\Collection\CollectionInterface $forms
 */
?>

<div class="row">
    <aside class="column">
        <?= $this->element('admin/sidenav') ?>
    </aside>
    <div class="column column-75">
        <?= $this->Html->link('Nouveau QCM', ['action' => 'add'], ['class' => 'button float-right']) ?>
        <h3>QCM</h3>
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('created_by', ['label' => 'Créé par']) ?></th>
                    <th><?= $this->Paginator->sort('display_name', ['label' => 'Titre']) ?></th>
                    <th><?= $this->Paginator->sort('active', ['label' => 'Ouvert']) ?></th>
                    <th><?= $this->Paginator->sort('closed_on', ['label' => 'Date fin']) ?></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($forms as $form): ?>
                <tr>
                    <td><?= $form->user->login ?></td>
                    <td><?= h($form->display_name) ?></td>
                    <td><?= h($form->active)?'Ouvert':'Fermé' ?></td>
                    <td><?= h($form->closed_on) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('Voir', ['action' => 'view', $form->id]) ?> |
                        <?= $this->Html->link('Modifier', ['action' => 'edit', $form->id]) ?> |
                        <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $form->id], ['confirm' => 'Etes-vous sûr de vouloir supprimer ce QCM ? ('.$form->display_name.')']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?= $this->element('admin/pagination', ['paginator' => $this->Paginator]) ?>
    </div>
</div>

