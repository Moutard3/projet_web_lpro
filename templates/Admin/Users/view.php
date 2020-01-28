<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <?= $this->element('admin/sidenav') ?>
    </aside>
    <div class="column column-75">
        <div class="users view content">
            <h3>Affichage d'un utilisateur</h3>
            <table>
                <tr>
                    <th>Login</th>
                    <td><?= h($user->login) ?></td>
                </tr>
                <tr>
                    <th>Statut</th>
                    <td><?= h($user->role) == 'admin'?'Professeur':'Etudiant' ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= h($user->email) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4>Réponses fournies</h4>
                <?php if (!empty($user->student_answers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th>QCM</th>
                            <th>Question</th>
                            <th>Réponse</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($user->student_answers as $studentAnswers) : ?>
                        <tr>
                            <td><?= h($studentAnswers->form->title) ?></td>
                            <td><?= h($studentAnswers->question->display_name) ?></td>
                            <td><?= h($studentAnswers->answer->display_name) ?></td>
                            <td class="actions">
                                <?= $this->Form->postLink('Supprimer', ['controller' => 'StudentAnswers', 'action' => 'delete', $studentAnswers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $studentAnswers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4>Résultats</h4>
                <?php if (!empty($user->student_results)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th>QCM</th>
                            <th>Publié</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($user->student_results as $studentResults) : ?>
                        <tr>
                            <td><?= h($studentResults->id) ?></td>
                            <td><?= h($studentResults->user_id) ?></td>
                            <td><?= h($studentResults->form_id) ?></td>
                            <td><?= h($studentResults->published) ?></td>
                            <td class="actions">
                                <?= $this->Form->postLink('Supprimer', ['controller' => 'StudentResults', 'action' => 'delete', $studentResults->id], ['confirm' => __('Are you sure you want to delete # {0}?', $studentResults->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
