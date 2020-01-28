<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 */
?>

<div class="row">
    <aside class="column">
        <?= $this->element('admin/sidenav') ?>
    </aside>
    <div class="column column-75">
        <?= $this->Html->link('Nouvelle question', ['action' => 'add'], ['class' => 'button float-right']) ?>
        <h3>Questions</h3>
        <table>
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('theme_id') ?></th>
                <th><?= $this->Paginator->sort('display_text', ['label' => 'Question']) ?></th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($questions as $question): ?>
                <tr>
                    <td><?= $question->has('theme') ? $this->Html->link($question->theme->display_name, ['controller' => 'Themes', 'action' => 'view', $question->theme->id]) : '' ?></td>
                    <td><?= h($question->display_text) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('Voir', ['action' => 'view', $question->id]) ?> |
                        <?= $this->Html->link('Modifier', ['action' => 'edit', $question->id]) ?> |
                        <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $question->id], ['confirm' => 'Etes-vous sûr de vouloir supprimer cette question ?']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?= $this->element('admin/pagination', ['paginator' => $this->Paginator]) ?>
    </div>
</div>
