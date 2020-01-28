<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Theme[]|\Cake\Collection\CollectionInterface $themes
 */
?>

<div class="row">
    <aside class="column">
        <?= $this->element('admin/sidenav') ?>
    </aside>
    <div class="column column-75">
        <?= $this->Html->link('Nouveau thème', ['action' => 'add'], ['class' => 'button float-right']) ?>
        <h3>Liste des thèmes</h3>
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('display_name', ['label' => 'Thème']) ?></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($themes as $theme): ?>
                <tr>
                    <td><?= h($theme->display_name) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('Modifier', ['action' => 'edit', $theme->id]) ?> |
                        <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $theme->id], ['confirm' => 'Etes-vous sûr de vouloir supprimer le thème '.$theme->display_name.' ?']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?= $this->element('admin/pagination', ['paginator' => $this->Paginator]) ?>
    </div>
</div>
