<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Question $question
 */
?>
<div class="row">
    <aside class="column">
        <?= $this->element('admin/sidenav') ?>
    </aside>
    <div class="column column-75">
        <h3>Visualisation d'une question</h3>
        <table>
            <tr>
                <th>Theme</th>
                <td><?= $question->has('theme') ? $this->Html->link($question->theme->display_name, ['controller' => 'Themes', 'action' => 'view', $question->theme->id]) : '' ?></td>
            </tr>
        </table>
        <blockquote>
            <?= $this->Text->autoParagraph(h($question->display_text)); ?>
        </blockquote>
        <h4>Réponses</h4>
        <?php if (!empty($question->answers)) : ?>
            <table>
                <tr>
                    <th>Réponse</th>
                    <th>Valide</th>
                </tr>
                <?php foreach ($question->answers as $answers) : ?>
                    <tr>
                        <td><?= h($answers->display_text) ?></td>
                        <td><?= $answers->valid ? 'Correcte' : '' ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <div class="related">
            <h4>QCM avec cette question</h4>
            <?php if (!empty($question->forms)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th>Titre</th>
                        </tr>
                        <?php foreach ($question->forms as $form) : ?>
                            <tr>
                                <td><?= h($form->display_name) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <div class="related">
            <h4>Réponses des étudiants</h4>
            <?php if (!empty($question->student_answers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th>Etudiant</th>
                            <th>QCM</th>
                            <th>Réponse</th>
                        </tr>
                        <?php foreach ($question->student_answers as $studentAnswers) : ?>
                            <tr>
                                <td><?= h($studentAnswers->user->login) ?></td>
                                <td><?= h($studentAnswers->form->display_name) ?></td>
                                <td><?= h($studentAnswers->answer->display_text) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
