<?php
/** @var \Cake\View\Helper\PaginatorHelper $paginator */
?>

<div class="paginator">
    <ul class="pagination">
        <?= $paginator->first('<< Premier') ?>
        <?= $paginator->prev('< précédent') ?>
        <?= $paginator->numbers() ?>
        <?= $paginator->next('suivant >') ?>
        <?= $paginator->last('dernière >>') ?>
    </ul>
    <p><?= $paginator->counter('Page {{page}} sur {{pages}}, affichage de {{current}} résultat(s) sur un total de {{count}}') ?></p>
</div>
