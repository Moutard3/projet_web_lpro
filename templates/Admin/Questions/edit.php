<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Question $question
 * @var \App\Model\Entity\Theme[] $themes
 */
?>
<div class="row">
    <aside class="column">
        <?= $this->element('admin/sidenav') ?>
    </aside>
    <div class="column column-75">
        <?= $this->Form->create($question) ?>
        <fieldset>
            <legend>Modification d'une question</legend>
            <?php
            echo $this->Form->control('theme_id', ['options' => $themes]);
            echo $this->Form->control('display_text', ['label' => 'Question']);
            ?>
        </fieldset>
        <?= $this->Form->button('Modifier la question') ?>
        <?= $this->Form->end() ?>

        <hr>

        <form>
            <fieldset>
                <legend>Réponses</legend>

                <div id="answersList">
                    <?php
                    foreach ($question->answers as $response):
                        ?>
                        <div class="row" data-answer-id="<?= $response->id ?>">
                            <div class="column">
                                <label
                                    for="answer-<?= $response->id ?>">Réponse</label>
                                <textarea rows="2"
                                          id="answer-<?= $response->id ?>"
                                          name="answer-<?= $response->id ?>"
                                          class="m-0 answer"><?=
                                    h($response->display_text)
                                    ?></textarea>
                            </div>
                            <div class="column">
                                <label for="feedback-<?= $response->id ?>">Feedback</label>
                                <textarea rows="2"
                                          id="feedback-<?= $response->id ?>"
                                          name="feedback-<?= $response->id ?>"
                                          class="m-0 feedback"><?=
                                    h($response->feedback)
                                    ?></textarea>
                            </div>
                            <div
                                class="column column-20 text-center">
                                <label for="valid-a<?= $response->id ?>">Bonne
                                    réponse</label>
                                <input type="checkbox"
                                       name="valid-a<?= $response->id ?>"
                                       class="m-0 v-align-middle"
                                       id="valid-a<?= $response->id ?>"
                                       value="<?= $response->id ?>" <?= $response->valid ? 'checked' : '' ?>>
                            </div>
                            <div
                                class="column column-10 text-center">
                                <label>&nbsp;</label>
                                <a href="#" class="deleteAnswer">Supprimer</a>
                            </div>
                        </div>
                        <hr>
                    <?php
                    endforeach;
                    ?>
                </div>

                <div class="row">
                    <div class="column">
                        <label for="newAnswer">Nouvelle réponse</label>
                        <textarea rows="2" id="newAnswer"
                                  class="m-0 answer"></textarea>
                    </div>
                    <div class="column">
                        <label for="newFeedback">Feedback</label>
                        <textarea rows="2" id="newFeedback"
                                  class="m-0 feedback"></textarea>
                    </div>
                    <div class="column">
                        <label>&nbsp;</label>
                        <button id="addAnswer" class="button-outline">
                            Ajouter cette réponse
                        </button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<?php $this->start('script'); ?>
<script>
    const $inputNewAnswer = $('#newAnswer');
    const $inputNewFeedback = $('#newFeedback');
    const $divAnswersList = $('#answersList');
    const $inputUpdate = $('textarea.answer:not(#newAnswer),' +
        'textarea.feedback:not(#newFeedback)');

    $('#addAnswer').on('click', function (e) {
        e.preventDefault();

        const valNewAnswer = $inputNewAnswer.val();
        const valNewFeedback = $inputNewFeedback.val();
        if (valNewAnswer !== "") {
            $inputNewAnswer.prop('disabled', true);
            $inputNewFeedback.prop('disabled', true);
            addAnswer(valNewAnswer, valNewFeedback);
            $inputNewAnswer.prop('disabled', false);
            $inputNewFeedback.prop('disabled', false);
        }

        return false;
    });

    $inputUpdate.on('input', function () {
        const answer_id = $(this).parents('.row').first().data('answer_id');

        $('#answer-' + answer_id + ',#feedback-' + answer_id)
        .removeClass('border-green')
        .addClass('border-orange');
    });

    $inputUpdate.on('change', function () {
        const answer_id = $(this).parents('.row').first().data('answer-id');
        const answer = $('#answer-' + answer_id).val();
        const feedback = $('#feedback-' + answer_id).val();

        updateAnswer(answer_id, answer, feedback);
    });

    $('input[name*=valid-a]').on('change', function () {
        const answer = $(this).val();

        $.ajax({
            url: '<?= $this->Url->build('/admin/answers/toggleValid') ?>',
            type: 'POST',
            data: {
                answer_id: answer,
            },
            dataType: 'json',
            success: function (data) {
                if (data.error !== 0) {
                    alert(data.message);
                }
            }
        });
    });

    $(".deleteAnswer").on('click', function (e) {
        e.preventDefault();
        const answer_id = $(this).parents('.row').first().data('answer-id');

        deleteAnswer(answer_id);
        return false;
    });

    function addAnswer(answer, feedback) {
        $.ajax({
            url: '<?= $this->Url->build('/admin/answers/add') ?>',
            type: 'POST',
            data: {
                answer: answer,
                feedback: feedback,
                question_id: <?= $question->id ?>,
            },
            dataType: 'json',
            success: function (data) {
                if (data.error === 0) {
                    $inputNewAnswer.val('');
                    $divAnswersList.append(
                        `
<div class="row" data-answer-id="${data.answer.id}">
    <div class="column">
        <label for="answer-${data.answer.id}">Réponse</label>
        <textarea rows="2" id="answer-${data.answer.id}" name="answer-${data.answer.id}" class="m-0 answer">${data.answer.display_text}</textarea>
    </div>
    <div class="column">
        <label for="feedback-${data.answer.id}">Feedback</label>
        <textarea rows="2" id="feedback-${data.answer.id}" name="feedback-${data.answer.id}" class="m-0 feedback">${data.answer.feedback}</textarea>
    </div>
    <div class="column column-20 text-center column-center">
        <label for="valid-a${data.answer.id}">Bonne réponse</label>
        <input type="checkbox" name="valid-a${data.answer.id}" class="m-0 v-align-middle" id="valid-a${data.answer.id}" value="${data.answer.id}">
    </div>
    <div class="column column-10 text-center column-center">
        <a href="#" class="deleteAnswer">Supprimer</a>
    </div>
</div>
<hr>
                        `);
                } else {
                    alert(data.message);
                }
            }
        });
    }

    function updateAnswer(answer_id, answer, feedback) {
        $.ajax({
            url: '<?= $this->Url->build('/admin/answers/edit') ?>',
            type: 'POST',
            data: {
                answer: answer,
                answer_id: answer_id,
                feedback: feedback,
            },
            dataType: 'json',
            success: function (data) {
                if (data.error === 0) {
                    $('#answer-' + answer_id + ',#feedback-' + answer_id)
                    .removeClass('border-orange')
                    .addClass('border-green');
                } else {
                    alert(data.message);
                }
            }
        })
    }

    function deleteAnswer(answer_id) {
        $.ajax({
            url: '<?= $this->Url->build('/admin/answers/delete') ?>',
            type: 'POST',
            data: {
                answer_id: answer_id,
            },
            dataType: 'json',
            success: function (data) {
                if (data.error === 0) {
                    $('#answer-' + answer_id).parents('.row').first().remove();
                } else {
                    alert(data.message);
                }
            }
        });
    }
</script>
<?php $this->end(); ?>
