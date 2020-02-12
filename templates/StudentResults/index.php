<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StudentResult[]|\Cake\Collection\CollectionInterface $studentResults
 */
?>

<div class="row">
    <aside class="column">
        <?= $this->element('sidenav') ?>
    </aside>
    <div class="column column-75">
        <h3>Liste de vos résultats</h3>
        <table>
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('forms.display_name', ['label' => 'Titre']) ?></th>
                <th><?= $this->Paginator->sort('results', ['label' => 'Note']) ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($studentResults as $studentResult): ?>
                <tr>
                    <td><?= h($studentResult->form->display_name) ?></td>
                    <td><?= $studentResult->result ?>/20</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?= $this->element('pagination', ['paginator' => $this->Paginator]) ?>
    </div>
</div>

