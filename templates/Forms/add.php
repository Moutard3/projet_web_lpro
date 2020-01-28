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
        <?= $this->Form->create($form) ?>
        <fieldset>
            <legend>Ajouter un QCM</legend>
            <hr>
            <?= $this->Form->control('display_name', ['label' => 'Titre']); ?>
            <div class="float-left">
                <div>
                    <input type="checkbox" id="hasClosedDate">
                    <label for="hasClosedDate" class="label-inline">Cochez pour limiter le QCM dans le temps.</label>
                </div>
                <div class="hidden" id="closedOnDiv">
                    <?= $this->Form->control('closed_on', ['label' => 'Date de fin', 'type' => 'date']); ?>
                </div>
            </div>
            <div class="float-right">
                <?= $this->Form->control('active', ['label' => ['class' => 'label-inline', 'text' => 'Cochez pour ouvrir le QCM aux réponses.']]); ?>
            </div>
        </fieldset>
        <?= $this->Form->button('Créer le QCM') ?>
        <?= $this->Form->end() ?>
    </div>
</div>

<?php $this->start('script'); ?>
<script>
    $('#hasClosedDate').on('click', function() {
        const isChecked = $('#hasClosedDate').prop('checked');
        if (isChecked) {
            $('#closedOnDiv').removeClass('hidden');
            $('#closed-on').attr('required', true);
        } else {
            $('#closedOnDiv').addClass('hidden');
            $('#closed-on').attr('required', false);
        }
    });
</script>
<?php $this->end(); ?>
