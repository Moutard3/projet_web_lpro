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
                    <th></th>
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
            <h4><?= __('Related Form Questions') ?></h4>
            <?php if (!empty($question->form_questions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Form Id') ?></th>
                            <th><?= __('Question Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($question->form_questions as $formQuestions) : ?>
                            <tr>
                                <td><?= h($formQuestions->form_id) ?></td>
                                <td><?= h($formQuestions->question_id) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'FormQuestions', 'action' => 'view', $formQuestions->form_id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['controller' => 'FormQuestions', 'action' => 'edit', $formQuestions->form_id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'FormQuestions', 'action' => 'delete', $formQuestions->form_id], ['confirm' => __('Are you sure you want to delete # {0}?', $formQuestions->form_id)]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <div class="related">
            <h4><?= __('Related Student Answers') ?></h4>
            <?php if (!empty($question->student_answers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Form Id') ?></th>
                            <th><?= __('Question Id') ?></th>
                            <th><?= __('Answer Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($question->student_answers as $studentAnswers) : ?>
                            <tr>
                                <td><?= h($studentAnswers->id) ?></td>
                                <td><?= h($studentAnswers->user_id) ?></td>
                                <td><?= h($studentAnswers->form_id) ?></td>
                                <td><?= h($studentAnswers->question_id) ?></td>
                                <td><?= h($studentAnswers->answer_id) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'StudentAnswers', 'action' => 'view', $studentAnswers->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['controller' => 'StudentAnswers', 'action' => 'edit', $studentAnswers->id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'StudentAnswers', 'action' => 'delete', $studentAnswers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $studentAnswers->id)]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
