<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Login') ?></th>
                    <td><?= h($user->login) ?></td>
                </tr>
                <tr>
                    <th><?= __('Password') ?></th>
                    <td><?= h($user->password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= h($user->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Student Answers') ?></h4>
                <?php if (!empty($user->student_answers)) : ?>
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
                        <?php foreach ($user->student_answers as $studentAnswers) : ?>
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
            <div class="related">
                <h4><?= __('Related Student Results') ?></h4>
                <?php if (!empty($user->student_results)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Form Id') ?></th>
                            <th><?= __('Published') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->student_results as $studentResults) : ?>
                        <tr>
                            <td><?= h($studentResults->id) ?></td>
                            <td><?= h($studentResults->user_id) ?></td>
                            <td><?= h($studentResults->form_id) ?></td>
                            <td><?= h($studentResults->published) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'StudentResults', 'action' => 'view', $studentResults->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'StudentResults', 'action' => 'edit', $studentResults->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'StudentResults', 'action' => 'delete', $studentResults->id], ['confirm' => __('Are you sure you want to delete # {0}?', $studentResults->id)]) ?>
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
