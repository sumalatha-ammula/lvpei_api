<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Partcipant Entity
 *
 * @property int $id
 * @property string $name
 * @property int|null $field_executive_id
 * @property int|null $survey_id
 * @property string|null $is_survey
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property string $age
 * @property string $mobile
 * @property string $adharnumber
 * @property string $occupation
 * @property string $gender
 * @property string $status
 * @property int $monthlyincome
 * @property \Cake\I18n\FrozenDate|null $dateofbirth
 * @property string $country
 * @property string $state
 * @property string $district
 * @property string $education
 * @property int $idcode
 * @property string $landmark
 * @property int $clustercode
 * @property int $indiviadualcode
 * @property int $unid
 *
 * @property \App\Model\Entity\Survey $survey
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
        'field_executive_id' => true,
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
        'dateofbirth' => true,
        'country' => true,
        'state' => true,
        'district' => true,
        'education' => true,
        'idcode' => true,
        'landmark' => true,
        'clustercode' => true,
        'indiviadualcode' => true,
        'unid' => true,
        'survey' => true,
    ];
}
