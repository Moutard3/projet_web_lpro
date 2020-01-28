<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Form $form
 */
?>
<div class="row">
    <aside class="column">
        <?= $this->element('admin/sidenav') ?>
    </aside>
    <div class="column column-75">
        <div class="forms view content">
            <h3>Affichage d'un QCM</h3>
            <table>
                <tr>
                    <th>Titre</th>
                    <td><?= h($form->display_name) ?></td>
                </tr>
                <tr>
                    <th>Créé par</th>
                    <td><?= h($form->user->login) ?></td>
                </tr>
                <tr>
                    <th>Fermeture le</th>
                    <td><?= h($form->closed_on) ?></td>
                </tr>
                <tr>
                    <th>Accepte les réponses</th>
                    <td><?= $form->active ? 'Oui' : 'Non' ?></td>
                </tr>
            </table>
            <div class="related">
                <h4>Questions du QCM</h4>
                <?php if (!empty($form->form_questions)) : ?>
                <table>
                    <tr>
                        <th>Question</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($form->form_questions as $formQuestions) : ?>
                    <tr>
                        <td><?= h($formQuestions->form_id) ?></td>
                        <td><?= h($formQuestions->question_id) ?></td>
                        <td class="actions">
                            <?= $this->Form->postLink('Retirer', ['controller' => 'FormQuestions', 'action' => 'delete', $formQuestions->form_id], ['confirm' => 'Etes-vous sûr de vouloir retirer cette question du QCM ?']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
