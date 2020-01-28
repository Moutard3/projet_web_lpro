<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Question Entity
 *
 * @property int $id
 * @property int $theme_id
 * @property string $display_text
 *
 * @property \App\Model\Entity\Theme $theme
 * @property \App\Model\Entity\Answer[] $answers
 * @property \App\Model\Entity\Form[] $forms
 * @property \App\Model\Entity\StudentAnswer[] $student_answers
 */
class Question extends Entity
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
        'theme_id' => true,
        'display_text' => true,
        'theme' => true,
        'answers' => true,
        'forms' => true,
        'student_answers' => true,
    ];
}
