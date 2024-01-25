<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FieldExecutive Entity
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property int $status
 * @property string $phone
 *
 * @property \App\Model\Entity\SurveyData $survey_data
 */
class FieldExecutive extends Entity
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
        'username' => true,
        'email' => true,
        'password' => true,
        'status' => true,
        'phone' => true,
        'survey_data' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        'password',
    ];
}
