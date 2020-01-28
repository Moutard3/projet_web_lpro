<?php
/**
 * @var string $message
 * @var int    $error
 * @var \App\Model\Entity\Answer $answer
 */
?>
{"message": "<?= h($message) ?>", "error": <?= $error ?>, "answer": <?= json_encode($answer->jsonSerialize()) ?>}
