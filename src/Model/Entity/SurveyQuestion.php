<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SurveyQuestion Entity
 *
 * @property int $id
 * @property int $survey_id
 * @property string $section
 * @property string $question
 * @property string $option_type
 * @property int $master_main_id
 * @property int|null $parent_id
 * @property string|null $show_if
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property int $is_clinical
 *
 * @property \App\Model\Entity\SurveyQuestion $parent_survey_question
 * @property \App\Model\Entity\SurveyQuestion[] $child_survey_questions
 * @property \App\Model\Entity\MasterMain $master_main
 * @property \App\Model\Entity\MasterOption $master_option
 * @property \App\Model\Entity\Survey $survey
 */
class SurveyQuestion extends Entity
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
        'section' => true,
        'question' => true,
        'option_type' => true,
        'master_main_id' => true,
        'parent_id' => true,
        'show_if' => true,
        'created_on' => true,
        'created_by' => true,
        'is_clinical' => true,
        'parent_survey_question' => true,
        'child_survey_questions' => true,
        'master_main' => true,
        'master_option' => true,
        'survey' => true,
    ];
}
