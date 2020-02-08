<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StudentAnswer Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $form_id
 * @property int $question_id
 * @property int $answer_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Form $form
 * @property \App\Model\Entity\Question $question
 * @property \App\Model\Entity\Answer $answer
 */
class StudentAnswer extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'form_id' => true,
        'question_id' => true,
        'answer_id' => true,
        'user' => true,
        'form' => true,
        'question' => true,
        'answer' => true,
    ];
}
