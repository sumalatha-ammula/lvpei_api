<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Partcipant Entity
 *
 * @property int $id
 * @property string $name
 * @property int $fe_id
 * @property int $survey_id
 * @property string $is_survey
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property string $age
 * @property string $mobile
 * @property string $adharnumber
 * @property string $occupation
 * @property string $gender
 * @property string $status
 * @property string $monthlyincome
 */
class Partcipant extends Entity
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
        'fe_id' => true,
        'survey_id' => true,
        'is_survey' => true,
        'created_on' => true,
        'created_by' => true,
        'age' => true,
        'mobile' => true,
        'adharnumber' => true,
        'occupation' => true,
        'gender' => true,
        'status' => true,
        'monthlyincome' => true,
    ];
}
