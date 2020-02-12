<div class="side-nav">
    <h4 class="heading">Menu</h4>
    <?= $this->Html->link('QCM à faire', ['controller' => 'Forms', 'action' => 'index'], ['class' => 'side-nav-item']) ?>
    <?= $this->Html->link('Résultats', ['controller' => 'StudentResults', 'action' => 'index'], ['class' => 'side-nav-item']) ?>
</div>
