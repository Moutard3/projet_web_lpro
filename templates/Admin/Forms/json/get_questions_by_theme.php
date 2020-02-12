<?php
/**
 * @var string $message
 * @var int    $error
 * @var \App\Model\Entity\Question[] $questions
 */
?>
{"message": "<?= h($message) ?>", "error": <?= $error ?>, "questions": <?= json_encode($questions) ?>}
