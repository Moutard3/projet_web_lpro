<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Form $form
 * @var \App\Model\Entity\Question $question
 */
?>
<div class="row">
    <aside class="column">
        <?= $this->element('sidenav') ?>
    </aside>
    <div class="column column-75">
        <div class="forms view content">
            <h3><?= $form->display_name ?></h3>
            <?php if (!empty($form->closed_on)): ?>
            <h4>A rendre avant le <?= $form->closed_on ?></h4>
            <?php endif; ?>

            <form id="formAnswer">
                <input name="form" value="<?= $form->id ?>" type="hidden">
                <input name="question" value="<?= $question->id ?>" type="hidden">
                <h5><?= h($question->display_text) ?></h5>
                <?php foreach ($question->answers as $answer) : ?>
                    <div class="row">
                        <div class="column">
                            <input type="radio" name="answer" value="<?= $answer->id ?>">
                            <label class="label-inline" id="label-a<?= $answer->id ?>"><?= $answer->display_text ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column">
                            <div id="feedback-a<?= $answer->id ?>" class="feedback"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="row">
                    <div class="column">
                        <button class="button" id="sendAnswer">Envoyer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->start('script') ?>
<script>
    $btnSendAnswer = $('#sendAnswer');
    $btnSendAnswer.on('click', function(e) {
        e.preventDefault();

        $('input').prop('readonly', true);

        $.ajax({
            url: '<?= $this->Url->build('/forms/ajaxAnswer') ?>/',
            type: 'POST',
            data: $('#formAnswer').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    $.each(data.answers, function (i, answer) {
                        $('#feedback-a'+answer.id).html(answer.feedback);
                        if (answer.valid) {
                            $('#label-a'+answer.id).addClass('text-green');
                        } else {
                            $('#label-a'+answer.id).addClass('text-orange');
                        }
                    });

                    $btnSendAnswer.html('Suivant');
                } else {
                    $btnSendAnswer.html('Recharger');
                }

                $btnSendAnswer.off('click');
                $btnSendAnswer.on('click', function(e) {
                    e.preventDefault();

                    location.href = '';

                    return false;
                });
            },
        });

        return false;
    });
</script>
<?php $this->end(); ?>
