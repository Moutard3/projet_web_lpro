<?php
/** @var \App\Model\Entity\User $loggedUser */
/** @var bool $isLogged */
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        LPDQL:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="//fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/milligram/1.3.0/milligram.css">

    <?= $this->Html->css('main.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <nav class="navigation">
        <section class="container">
            <?= $this->Html->link('Accueil', ['controller' => 'pages', 'action' => 'display', 'home'], ['class' => 'navigation-link']) ?>

            <div class="float-right">
                <?php if ($loggedUser && $loggedUser->isAdmin()): ?>
                    <?= $this->Html->link('Espace professeur', ['controller' => 'users', 'action' => 'index'], ['class' => 'navigation-link']) ?>
                <?php endif; ?>

                <?php if (!$isLogged): ?>
                    <?= $this->Html->link('Connexion', ['controller' => 'users', 'action' => 'login'], ['class' => 'navigation-link']) ?>
                <?php else: ?>
                    <?= $this->Html->link('Déconnexion', ['controller' => 'users', 'action' => 'logout'], ['class' => 'navigation-link']) ?>
                <?php endif; ?>
            </div>
        </section>
    </nav>
    <main class="<?= $this->fetch('main-class') ?>">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
    <script src="//code.jquery.com/jquery-3.4.1.min.js"></script>
    <?= $this->fetch('script') ?>
</body>
</html>
