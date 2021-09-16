<?php

namespace Evil\HelpDocs\Entity;

use XF\Mvc\Entity\Structure;

class RuleCategory extends \XF\Mvc\Entity\Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_evil_helpdocs_rules_categories';
        $structure->shortName = 'Evil\HelpDocs:RuleCategory';
        $structure->primaryKey = 'id';

        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'rule_section_id' => ['type' => self::UINT, 'default' => 0],

            'name' => ['type' => self::STR, 'required' => true],
            'description' => ['type' => self::STR, 'required' => true],

            'order' => ['type' => self::UINT, 'default' => 0]
        ];

        $structure->getters = [];

        $structure->relations = [
            'Rules' => [
                'entity' => 'Evil\HelpDocs:Rule',
                'type' => self::TO_MANY,
                'conditions' => [['rule_category_id', '=', '$id']],
                'key' => 'id',
            ],
            'RuleSection' => [
                'entity' => 'Evil\HelpDocs:RuleSection',
                'type' => self::TO_ONE,
                'conditions' => 'rule_section_id',
                'primary' => true
            ],
        ];

        return $structure;
    }
}