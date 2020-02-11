<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StudentResult Entity
 *
 * @property int $user_id
 * @property int $form_id
 * @property float $result
 * @property bool $published
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Form $form
 */
class StudentResult extends Entity
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
        'result' => true,
        'published' => true,
        'user' => true,
        'form' => true,
    ];
}
