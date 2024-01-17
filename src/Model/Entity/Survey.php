<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Survey Entity
 *
 * @property int $id
 * @property string $name
 * @property string $country
 * @property string $village
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property int $status
 * @property int|null $field_executive_id
 */
class Survey extends Entity
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
        'name' => true,
        'country' => true,
        'village' => true,
        'created_on' => true,
        'created_by' => true,
        'status' => true,
        'field_executive_id' => true,
    ];
}
