<div class="side-nav">
    <h4 class="heading">Menu</h4>
    <?= $this->Html->link('Liste des utilisateurs', ['controller' => 'users', 'action' => 'index'], ['class' => 'side-nav-item']) ?>
    <?= $this->Html->link('Liste des QCM', ['controller' => 'forms', 'action' => 'index'], ['class' => 'side-nav-item']) ?>
    <?= $this->Html->link('Liste des Q/R', ['controller' => 'questions', 'action' => 'index'], ['class' => 'side-nav-item']) ?>
    <?= $this->Html->link('Liste des thèmes', ['controller' => 'themes', 'action' => 'index'], ['class' => 'side-nav-item']) ?>
</div>
