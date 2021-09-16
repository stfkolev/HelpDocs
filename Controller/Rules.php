<?php

namespace Evil\HelpDocs\Controller;

use XF\Mvc\ParameterBag;

class Rules extends \XF\Pub\Controller\AbstractController {

    public function actionIndex()
    {
        $sections = $this
            ->finder('Evil\HelpDocs:RuleSection')
            // ->with('RuleCategories', true)
            ->order('order', 'ASC')
            ->fetch();

        $viewParams = [
            'sections' => $sections
        ];

        return $this->view('Evil\HelpDocs:View', 'help_docs', $viewParams);
    }

    public function actionView(ParameterBag $params)
    {
        $category = $this->assertCategoryExists($params->id);

        $viewParams = [
            'category' => $category
        ];
        
        return $this->view('Evil\HelpDocs:View', 'help_docs_category', $viewParams);
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