<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Form $form
 * @var \App\Model\Entity\Question[] $questions
 * @var \App\Model\Entity\Theme[] $themes
 */
?>
<div class="row">
    <aside class="column">
        <?= $this->element('admin/sidenav') ?>
    </aside>
    <div class="column column-75">
        <?= $this->Form->create($form) ?>
        <fieldset>
            <legend>Modifier le QCM</legend>
            <?= $this->Form->control('display_name', ['label' => 'Titre']); ?>
            <div class="float-left">
                <div>
                    <input type="checkbox" id="hasClosedDate" <?= $form->closed_on ? 'checked' : '' ?>>
                    <label for="hasClosedDate" class="label-inline">Cochez pour
                        limiter le QCM dans le temps.</label>
                </div>
                <div class="<?= $form->closed_on ? '' : 'hidden' ?>" id="closedOnDiv">
                    <?= $this->Form->control('closed_on', ['label' => 'Date de fin', 'type' => 'date']); ?>
                </div>
            </div>
            <div class="float-right">
                <?= $this->Form->control('active', ['label' => ['class' => 'label-inline', 'text' => 'Cochez pour ouvrir le QCM aux réponses.']]); ?>
            </div>
        </fieldset>
        <?= $this->Form->button('Modifier le QCM') ?>
        <?= $this->Form->end() ?>

        <form>
            <fieldset>
                <div id="questionsList">
                    <?php foreach($form->questions as $q): ?>
                    <div id="question-<?= $q->id ?>">
                        <div class="row">
                            <div class="column column-75">
                                <input type="text" value="<?= $q->display_text ?>" readonly>
                            </div>
                            <button class="button-outline column deleteQuestion" data-questionid="<?= $q->id ?>">
                                Retirer la question
                            </button>
                        </div>
                        <hr>
                    </div>
                    <?php endforeach; ?>
                </div>
            </fieldset>

            <fieldset>
                <legend>Ajouter une question au QCM</legend>

                <div class="row">
                    <select class="column column-25" id="selectThemes">
                        <option value="">Tous</option>
                        <?php foreach ($themes as $k => $v): ?>
                            <option value="<?= $k ?>"><?= $v ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select class="column column-50" id="selectQuestion">
                        <?php foreach ($questions as $k => $v): ?>
                            <option value="<?= $k ?>"><?= $v ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button class="button column" id="addQuestion">
                        Ajouter la question
                    </button>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<?php $this->start('script'); ?>
<script>
    $('#hasClosedDate').on('click', function () {
        const isChecked = $('#hasClosedDate').prop('checked');
        if (isChecked) {
            $('#closedOnDiv').removeClass('hidden');
            $('#closed-on').attr('required', true);
        } else {
            $('#closedOnDiv').addClass('hidden');
            $('#closed-on').attr('required', false);
        }
    });

    $('#addQuestion').on('click', function (e) {
        e.preventDefault();

        const question_id = $('#selectQuestion').val();
        addQuestion(question_id);

        return false;
    });

    $('#questionsList').on('click', '.deleteQuestion', function (e) {
        e.preventDefault();

        const question_id = $(this).data('questionid');
        deleteQuestion(question_id);

        return false;
    });

    $('#selectThemes').on('change', function() {
        $.ajax({
            url: '<?= $this->Url->build('/admin/forms/getQuestionsByTheme') ?>',
            type: 'POST',
            data: {
                theme_id: $('#selectThemes').val(),
            },
            dataType: 'JSON',
            success: function(data) {
                if (data.error === 0) {
                    $('#selectQuestion').empty();
                    $.each(data.questions, function (i, v) {
                        $('#selectQuestion').append('<option value='+i+'>'+v+'</option>');
                    });
                } else {
                    alert(data.message);
                }
            }
        });
    });

    function addQuestion(question_id) {
        $.ajax({
            url: '<?= $this->Url->build('/admin/forms/addQuestion') ?>',
            type: 'POST',
            data: {
                question_id: question_id,
                form_id: <?= $form->id ?>,
            },
            dataType: 'json',
            success: function (data) {
                if (data.error === 0) {
                    $('#questionsList').append(`
<div id="question-${data.question.id}">
    <div class="row" id="question-${data.question.id}">
        <div class="column column-75">
            <input type="text" value="${data.question.display_text}" readonly>
        </div>
        <button class="button-outline column deleteQuestion" data-questionid="${data.question.id}">
            Retirer la question
        </button>
    </div>
    <hr>
</div>
                        `);
                } else {
                    alert(data.message);
                }
            }
        });
    }

    function deleteQuestion(question_id) {
        $.ajax({
            url: '<?= $this->Url->build('/admin/forms/deleteQuestion') ?>',
            type: 'POST',
            data: {
                question_id: question_id,
                form_id: <?= $form->id ?>,
            },
            dataType: 'json',
            success: function (data) {
                if (data.error === 0) {
                    $('#questionsList').find('#question-'+question_id).remove();
                } else {
                    alert(data.message);
                }
            }
        });
    }
</script>
<?php $this->end(); ?>
