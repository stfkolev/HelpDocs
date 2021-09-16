<?php

namespace Evil\HelpDocs;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use XF\Db\Schema\Create;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	public function installStep1()
    {
        $this->schemaManager()->createTable('xf_evil_helpdocs_rules', function(Create $table)
        {
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('rule_category_id', 'int');
            $table->addColumn('body', 'varchar', 2048);
            $table->addColumn('order', 'int')->setDefault(0);
			
            $table->addPrimaryKey('id');
			$table->addKey('rule_category_id');
        });

		$this->schemaManager()->createTable('xf_evil_helpdocs_rules_categories', function(Create $table)
        {
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('rule_section_id', 'int');
            $table->addColumn('name', 'varchar', 255);
            $table->addColumn('description', 'varchar', 255);
			$table->addColumn('order', 'int')->setDefault(0);

            $table->addPrimaryKey('id');
			$table->addKey('rule_section_id');
        });
        
        $this->schemaManager()->createTable('xf_evil_helpdocs_rules_sections', function(Create $table)
        {
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('name', 'varchar', 255);
            $table->addColumn('order', 'int')->setDefault(0);
			
            $table->addPrimaryKey('id');
        });
    }
}