<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SurveyData Entity
 *
 * @property int $id
 * @property int $survey_id
 * @property int $survey_questions_id
 * @property int $field_executive_id
 * @property \Cake\I18n\FrozenTime $datetime
 * @property string $geo_location
 * @property string $option_data
 * @property \Cake\I18n\FrozenTime $sync_time
 * @property int $partcipants_id
 *
 * @property \App\Model\Entity\SurveyQuestion $survey_question
 * @property \App\Model\Entity\Partcipant $partcipant
 */
class SurveyData extends Entity
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
        'survey_id' => true,
        'survey_questions_id' => true,
        'field_executive_id' => true,
        'datetime' => true,
        'geo_location' => true,
        'option_data' => true,
        'sync_time' => true,
        'partcipants_id' => true,
        'survey_question' => true,
        'partcipant' => true,
    ];
}
