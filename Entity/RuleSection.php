<?php

namespace Evil\HelpDocs\Entity;

use XF\Mvc\Entity\Structure;

class RuleSection extends \XF\Mvc\Entity\Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_evil_helpdocs_rules_sections';
        $structure->shortName = 'Evil\HelpDocs:RuleSection';
        $structure->primaryKey = 'id';

        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'name' => ['type' => self::STR, 'required' => true],
            'order' => ['type' => self::UINT, 'default' => 0]
        ];
        $structure->getters = [];
        $structure->relations = [
            'RuleCategories' => [
                'entity' => 'Evil\HelpDocs:RuleCategory',
                'type' => self::TO_MANY,
                'conditions' => [['rule_section_id', '=', '$id']],
                'key' => 'id',
            ],
        ];

        return $structure;
    }
}