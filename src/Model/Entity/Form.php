<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Form Entity
 *
 * @property int $id
 * @property int $created_by
 * @property string $display_name
 * @property bool $active
 * @property \Cake\I18n\FrozenTime $closed_on
 * @property \App\Model\Entity\User $user
 *
 * @property \App\Model\Entity\Question[] $questions
 * @property \App\Model\Entity\StudentAnswer[] $student_answers
 * @property \App\Model\Entity\StudentResult[] $student_results
 */
class Form extends Entity
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
        'created_by' => true,
        'display_name' => true,
        'active' => true,
        'closed_on' => true,
        'questions' => true,
        'student_answers' => true,
        'student_results' => true,
    ];
}
