<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SurveyQuestion Entity
 *
 * @property int $id
 * @property int $s_id
 * @property string $section
 * @property string $question
 * @property string $option_type
 * @property int $m_id
 * @property int|null $parent_id
 * @property string|null $show_if
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 *
 * @property \App\Model\Entity\ParentSurveyQuestion $parent_survey_question
 * @property \App\Model\Entity\ChildSurveyQuestion[] $child_survey_questions
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
        's_id' => true,
        'section' => true,
        'question' => true,
        'option_type' => true,
        'm_id' => true,
        'parent_id' => true,
        'show_if' => true,
        'created_on' => true,
        'created_by' => true,
        'parent_survey_question' => true,
        'child_survey_questions' => true,
    ];
}
