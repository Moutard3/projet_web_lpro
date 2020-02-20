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
                <?php if (!empty($form->questions)) : ?>
                <table>
                    <tr>
                        <th>Question</th>
                        <th>Réponses</th>
                        <th>Feedback</th>
                    </tr>
                    <?php foreach ($form->questions as $formQuestions) : ?>
                    <tr class="v-align-top">
                        <td><?= h($formQuestions->display_text) ?></td>
                        <td>
                            <ol>
                            <?php foreach ($formQuestions->answers as $answer) :
                                echo '<li>';

                                if ($answer->valid) {
                                    echo '<strong>';
                                }

                                echo $answer->display_text;

                                if ($answer->valid) {
                                    echo '</strong>';
                                }

                                echo '</li>';
                            endforeach; ?>
                            </ol>
                        </td>
                        <td>
                            <ol>
                                <?php foreach ($formQuestions->answers as $answer) :
                                    echo '<li>';

                                    if ($answer->valid) {
                                        echo '<strong>';
                                    }

                                    echo $answer->feedback;

                                    if ($answer->valid) {
                                        echo '</strong>';
                                    }

                                    echo '</li>';
                                endforeach; ?>
                            </ol>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>

                <h4>Etudiants ayant réalisé le QCM</h4>
                <?php if (!empty($users_done)) : ?>
                    <table>
                        <tr>
                            <th>Etudiant</th>
                            <th>Note</th>
                        </tr>
                        <?php foreach ($users_done as $student) : ?>
                            <tr>
                                <td><?= h($student->login) ?></td>
                                <td><?= !empty($student->student_results) ? $student->student_results[0]->result : '' ?>/20</td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
