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
                    <div class="row">
                        <div
                            class="column column-20 column-offset-50 text-center">
                            <strong>Bonne réponse</strong>
                        </div>
                    </div>
                    <?php
                    foreach ($question->answers as $response):
                        ?>
                        <div class="row">
                            <div class="column column-50">
                            <textarea rows="2" id="answer-<?= $response->id ?>"
                                      name="answer-<?= $response->id ?>"
                                      class="m-0 answer"><?=
                                h($response->display_text)
                                ?></textarea>
                            </div>
                            <div
                                class="column column-20 text-center column-center">
                                <input type="radio" name="valid"
                                       class="m-0 v-align-middle"
                                       value="<?= $response->id ?>" <?= $response->valid ? 'checked' : '' ?>>
                            </div>
                            <div
                                class="column column-10 text-center column-center">
                                <a href="#" class="deleteAnswer"
                                   data-answerid="<?= $response->id ?>">Supprimer</a>
                            </div>
                        </div>
                        <hr>
                    <?php
                    endforeach;
                    ?>
                </div>

                <label for="newAnswer">Nouvelle réponse</label>
                <div class="row">
                    <div class="column">
                        <textarea rows="2" id="newAnswer"
                                  class="m-0 answer"></textarea>
                    </div>
                    <div class="column">
                        <button id="addAnswer" class="button-outline">Ajouter
                            cette réponse
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
    const $divAnswersList = $('#answersList');

    $('#addAnswer').on('click', function (e) {
        e.preventDefault();

        const valNewAnswer = $inputNewAnswer.val();
        if (valNewAnswer !== "") {
            $inputNewAnswer.prop('disabled', true);
            addAnswer(valNewAnswer);
            $inputNewAnswer.prop('disabled', false);
        }

        return false;
    });

    $('textarea.answer:not(#newAnswer)').on('input', function () {
        $(this).removeClass('border-green').addClass('border-orange');
    });

    $('textarea.answer:not(#newAnswer)').on('change', function () {
        const answer_id = $(this).attr('id').split('-')[1];
        const answer = $(this).val();

        updateAnswer(answer_id, answer)
    });

    $('input[name=valid]').on('change', function () {
        const validAnswer = $(this).val();

        $.ajax({
            url: '<?= $this->Url->build('/admin/answers/changeValid') ?>',
            type: 'POST',
            data: {
                answer_id: validAnswer,
                question_id: <?= $question->id ?>,
            },
            dataType: 'json',
            success: function (data) {
                if (data.error === 0) {
                    $inputNewAnswer.val('');
                    $divAnswersList.append(
                        $inputNewAnswer.clone().attr('id',
                            'answer-' + data.id));
                } else {
                    alert(data.message);
                }
            }
        });
    });

    $(".deleteAnswer").on('click', function (e) {
        e.preventDefault();
        const answer_id = $(this).data('answerid');

        deleteAnswer(answer_id);
        return false;
    });

    function addAnswer(answer) {
        $.ajax({
            url: '<?= $this->Url->build('/admin/answers/add') ?>',
            type: 'POST',
            data: {
                answer: answer,
                question_id: <?= $question->id ?>,
            },
            dataType: 'json',
            success: function (data) {
                if (data.error === 0) {
                    $inputNewAnswer.val('');
                    $divAnswersList.append(
                        `
<div class="row">
    <div class="column column-50">
        <textarea rows="2" id="answer-${data.answer.id}" name="answer-${data.answer.id}" class="m-0 answer">${data.answer.display_text}</textarea>
    </div>
    <div
        class="column column-20 text-center column-center">
        <input type="radio" name="valid" class="m-0 v-align-middle"
               value="${data.answer.id}">
    </div>
    <div
        class="column column-10 text-center column-center">
        <a href="#" class="delete" data-answerid="${data.answer.id}">Supprimer</a>
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

    function updateAnswer(answer_id, answer) {
        $.ajax({
            url: '<?= $this->Url->build('/admin/answers/edit') ?>',
            type: 'POST',
            data: {
                answer: answer,
                answer_id: answer_id
            },
            dataType: 'json',
            success: function (data) {
                if (data.error === 0) {
                    $('#answer-' + answer_id).removeClass(
                        'border-orange').addClass(
                        'border-green');
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
