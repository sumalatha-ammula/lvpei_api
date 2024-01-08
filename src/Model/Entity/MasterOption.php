<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MasterOption Entity
 *
 * @property int $id
 * @property int $master_main_id
 * @property string $option_value
 * @property int $sort
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property int $status
 */
class MasterOption extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'master_main_id' => true,
        'option_value' => true,
        'sort' => true,
        'created_on' => true,
        'created_by' => true,
        'status' => true,
    ];
}
