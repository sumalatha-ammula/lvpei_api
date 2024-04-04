<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SurveyData Entity
 *
 * @property int $id
 * @property int $survey_id
 * @property int $question_id
 * @property int $field_executive_id
 * @property \Cake\I18n\FrozenTime $datetime
 * @property string $geo_location
 * @property string|null $question
 * @property string|null $option_data
 * @property string|null $answer
 * @property string|null $optionvalue
 * @property \Cake\I18n\FrozenTime $sync_time
 * @property int $partcipants_id
 * @property int $unid
 * @property bool $is_clinical
 * @property int $section_id
 * @property string $section
 *
 * @property \App\Model\Entity\Partcipant $partcipant
 * @property \App\Model\Entity\SurveyQuestion $survey_question
 * @property \App\Model\Entity\Survey $survey
 * @property \App\Model\Entity\MasterOption $master_option
 * @property \App\Model\Entity\FieldExecutive $field_executive
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
        'question_id' => true,
        'field_executive_id' => true,
        'datetime' => true,
        'geo_location' => true,
        'question' => true,
        'option_data' => true,
        'answer' => true,
        'optionvalue' => true,
        'sync_time' => true,
        'partcipants_id' => true,
        'unid' => true,
        'is_clinical' => true,
        'section_id' => true,
        'section' => true,
        'partcipant' => true,
        'survey_question' => true,
        'survey' => true,
        'master_option' => true,
        'field_executive' => true,
    ];
}
