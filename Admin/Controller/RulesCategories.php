<?php

namespace Evil\HelpDocs\Admin\Controller;

use XF\Mvc\ParameterBag;

class RulesCategories extends \XF\Pub\Controller\AbstractController {

    public function actionIndex()
    {
        $categories = $this->finder('Evil\HelpDocs:RuleCategory')->order('id', 'ASC')->fetch();
        $viewParams = [
            'categories' => $categories
        ];
        
        return $this->view('Evil\HelpDocs\Admin\View:View', 'rules_categories', $viewParams);
    }


    public function actionAdd()
    {
        $sections = $this->finder('Evil\HelpDocs:RuleSection')->order('id', 'ASC')->fetch();

        $viewParams = [
            'sections' => $sections
        ];

        return $this->view('Evil\HelpDocs\Admin\View:View', 'add_rule_category', $viewParams);
    }

    public function actionStore() {
        if($this->isPost()) {
            $form = $this->formAction();
            $input = $this->filter([
                'name' => 'str',
                'description' => 'str',
                'rule_section_id' => 'uint',
                'order' => 'uint',
            ]);

            $category = $this->em()->create('Evil\HelpDocs:RuleCategory');

            $form->basicEntitySave($category, $input);
            $form->run();

            return $this->redirect($this->buildLink('rules-categories'));
        }

        $categories = $this->finder('Evil\HelpDocs:RuleCategory')->order('id', 'ASC')->fetch();
        $viewParams = [
            'categories' => $categories
        ];
        
        return $this->view('Evil\HelpDocs\Admin\View:View', 'rules_categories', $viewParams);
    }

    public function actionEdit(ParameterBag $params) {
        $category = $this->assertCategoryExists($params->id);
        $sections = $this->finder('Evil\HelpDocs:RuleSection')->order('id', 'ASC')->fetch();

        $viewParams = [
            'category' => $category,
            'sections' => $sections,
        ];

        if($this->isPost()) {
            $input = $this->filter([
                'name' => 'str',
                'description' => 'str',
                'rule_section_id' => 'uint',
                'order' => 'uint',
            ]);

            $category->name = $input['name'];
            $category->description = $input['description'];
            $category->order = $input['order'];
            $category->rule_section_id = $input['rule_section_id'];

            $category->save();

            return $this->redirect($this->buildLink('rules-categories'));
        }

        return $this->view('Evil\HelpDocs\Admin\View:View', 'edit_rule_category', $viewParams);
        
    }

    public function actionDelete(ParameterBag $params) {
        $category = $this->assertCategoryExists($params->id);
        $plugin = $this->plugin('XF:Delete');

        return $plugin->actionDelete(
            $category,
            $this->buildLink('rules-categories/delete', $category),
            $this->buildLink('rules-categories/edit', $category),
            $this->buildLink('rules-categories'),
            $category->name
        );
    }

    
    /**
	 * @param string $id
	 * @param array|string|null $with
	 * @param null|string $phraseKey
	 *
	 * @return \Evil\HelpDocs\Entity\RuleCategory
	 */
	protected function assertCategoryExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('Evil\HelpDocs:RuleCategory', $id, $with, $phraseKey);
	}
}