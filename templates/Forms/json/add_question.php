<?php
/**
 * @var string $message
 * @var int    $error
 * @var \App\Model\Entity\Question $question
 */
?>
{"message": "<?= h($message) ?>", "error": <?= $error ?>, "question": <?= json_encode($question->jsonSerialize()) ?>}
