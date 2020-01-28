<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>

<div class="row">
    <aside class="column">
        <?= $this->element('admin/sidenav') ?>
    </aside>
    <div class="column column-75">
        <?= $this->Html->link('Nouvel utilisateur', ['action' => 'add'], ['class' => 'button float-right']) ?>
        <h3>Utilisateurs</h3>
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('login') ?></th>
                    <th><?= $this->Paginator->sort('role') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= h($user->login) ?></td>
                    <td><?= h($user->role) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('Voir', ['action' => 'view', $user->id]) ?> |
                        <?= $this->Html->link('Modifier', ['action' => 'edit', $user->id]) ?> |
                        <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $user->id], ['confirm' => 'Voulez-vous vraiment supprimer '.$user->login.' ?']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?= $this->element('admin/pagination', ['paginator' => $this->Paginator]) ?>
    </div>
</div>
