<?php

namespace Evil\HelpDocs\Entity;

use XF\Mvc\Entity\Structure;

class Rule extends \XF\Mvc\Entity\Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_evil_helpdocs_rules';
        $structure->shortName = 'Evil\HelpDocs:Rule';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'rule_category_id' => ['type' => self::UINT, 'default' => 0],
            'body' => ['type' => self::STR, 'required' => true],
            'order' => ['type' => self::UINT, 'default' => 0]
        ];
        $structure->getters = [];
        $structure->relations = [
            'RuleCategory' => [
                'entity' => 'Evil\HelpDocs:RuleCategory',
                'type' => self::TO_ONE,
                'conditions' => 'rule_category_id',
                'primary' => true
            ],
        ];

        return $structure;
    }
}