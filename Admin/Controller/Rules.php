<?php

namespace Evil\HelpDocs\Admin\Controller;

use XF\Mvc\ParameterBag;

class Rules extends \XF\Pub\Controller\AbstractController {

    public function actionIndex()
    {
        $rules = $this->finder('Evil\HelpDocs:Rule')->order('id', 'ASC')->fetch();
        $viewParams = [
            'rules' => $rules
        ];
        
        return $this->view('Evil\HelpDocs\Admin\View:View', 'rules', $viewParams);
    }

    public function actionAdd()
    {
        $categories = $this->finder('Evil\HelpDocs:RuleCategory')->order('id', 'ASC')->fetch();
        $viewParams = [
            'categories' => $categories
        ];
        
        return $this->view('Evil\HelpDocs\Admin\View:View', 'add_rule', $viewParams);
    }

    public function actionStore() {
        if($this->isPost()) {
            $form = $this->formAction();
            $input = $this->filter([
                'body' => 'str',
                'rule_category_id' => 'uint',
                'order' => 'uint',
            ]);

            $rule = $this->em()->create('Evil\HelpDocs:Rule');

            $form->basicEntitySave($rule, $input);
            $form->run();

            return $this->redirect($this->buildLink('rules'));
        }

        $rules = $this->finder('Evil\HelpDocs:Rule')->order('id', 'ASC')->fetch();
        $viewParams = [
            'rules' => $rules
        ];
        
        return $this->view('Evil\HelpDocs\Admin\View:View', 'rules', $viewParams);
    }

    public function actionEdit(ParameterBag $params) {
        $rule = $this->assertRuleExists($params->id);
        $categories = $this->finder('Evil\HelpDocs:RuleCategory')->order('id', 'ASC')->fetch();

        $viewParams = [
            'rule' => $rule,
            'categories' => $categories,
        ];

        if($this->isPost()) {
            $input = $this->filter([
                'body' => 'str',
                'rule_category_id' => 'uint',
                'order' => 'uint',
            ]);

            $rule->body = $input['body'];
            $rule->order = $input['order'];
            $rule->rule_category_id = $input['rule_category_id'];

            $rule->save();

            return $this->redirect($this->buildLink('rules'));
        }

        return $this->view('Evil\HelpDocs\Admin\View:View', 'edit_rule', $viewParams);
        
    }

    public function actionDelete(ParameterBag $params) {
        $rule = $this->assertRuleExists($params->id);
        $plugin = $this->plugin('XF:Delete');

        return $plugin->actionDelete(
            $rule,
            $this->buildLink('rules/delete', $rule),
            $this->buildLink('rules/edit', $rule),
            $this->buildLink('rules'),
            $rule->body
        );
    }

    
    /**
	 * @param string $id
	 * @param array|string|null $with
	 * @param null|string $phraseKey
	 *
	 * @return \Evil\HelpDocs\Entity\Rule
	 */
	protected function assertRuleExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('Evil\HelpDocs:Rule', $id, $with, $phraseKey);
	}
}