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
                            <label class="label-inline"><?= $answer->display_text ?></label>
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
    $('#sendAnswer').on('click', function(e) {
        e.preventDefault();

        $.ajax({
            url: '<?= $this->Url->build('/forms/ajaxAnswer') ?>/',
            type: 'POST',
            data: $('#formAnswer').serialize(),
            success: function (data) {
                window.location = '';
            },
        });

        return false;
    });
</script>
<?php $this->end(); ?>
