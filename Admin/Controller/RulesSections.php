<?php

namespace Evil\HelpDocs\Admin\Controller;

use XF\Mvc\ParameterBag;

class RulesSections extends \XF\Pub\Controller\AbstractController {

    public function actionIndex()
    {
        $sections = $this->finder('Evil\HelpDocs:RuleSection')->order('id', 'ASC')->fetch();
        $viewParams = [
            'sections' => $sections
        ];
        
        return $this->view('Evil\HelpDocs\Admin\View:View', 'rules_sections', $viewParams);
    }


    public function actionAdd()
    {
        return $this->view('Evil\HelpDocs\Admin\View:View', 'add_rule_section');
    }

    public function actionStore() {
        if($this->isPost()) {
            $form = $this->formAction();
            $input = $this->filter([
                'name' => 'str',
                'order' => 'uint',
            ]);
            
            $section = $this->em()->create('Evil\HelpDocs:RuleSection');
            var_dump($section);
            $form->basicEntitySave($section, $input);
           
            $form->run();
            return $this->redirect($this->buildLink('rules-sections'));
        }

        $categories = $this->finder('Evil\HelpDocs:RuleSection')->order('id', 'ASC')->fetch();
        $viewParams = [
            'categories' => $categories
        ];
        
        return $this->view('Evil\HelpDocs\Admin\View:View', 'rules_sections', $viewParams);
    }

    public function actionEdit(ParameterBag $params) {
        if($params['id']) {
            $section = $this
            ->finder('Evil\HelpDocs:RuleSection')
            ->where('id', $params['id'])
            ->fetchOne();

            $viewParams = [
                'section' => $section
            ];

            if($this->isPost()) {
                $input = $this->filter([
                    'name' => 'str',
                    'order' => 'uint',
                ]);

                $section->name = $input['name'];
                $section->order = $input['order'];

                $section->save();
                return $this->redirect($this->buildLink('rules-sections'));
            }

            return $this->view('Evil\HelpDocs\Admin\View:View', 'edit_rule_section', $viewParams);
        }
    }

    public function actionDelete(ParameterBag $params) {
        $section = $this->assertSectionExists($params->id);
        $plugin = $this->plugin('XF:Delete');

        return $plugin->actionDelete(
            $section,
            $this->buildLink('rules-sections/delete', $section),
            $this->buildLink('rules-sections/edit', $section),
            $this->buildLink('rules-sections'),
            $section->name
        );
    }

    /**
	 * @param string $id
	 * @param array|string|null $with
	 * @param null|string $phraseKey
	 *
	 * @return \XF\Entity\ActivitySummarySection
	 */
	protected function assertSectionExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('Evil\HelpDocs:RuleSection', $id, $with, $phraseKey);
	}
}