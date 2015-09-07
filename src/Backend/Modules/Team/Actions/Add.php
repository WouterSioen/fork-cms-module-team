<?php

namespace Backend\Modules\Team\Actions;

use Backend\Core\Engine\Model;
use Backend\Core\Engine\Base\ActionAdd;
use Backend\Modules\Team\Form\TeamType;

/**
 * This class will be used to add team members
 *
 * @author Wouter Sioen <wouter@woutersioen.be>
 */
class Add extends ActionAdd
{
    public function execute()
    {
        parent::execute();

        $form = new TeamType('add');
        if ($form->handle()) {
            $teamMember = $form->getData();
            $this->get('team_repository')->add($teamMember);

            return $this->redirect(
                Model::createURLForAction('Index') . '&report=added'
                . '&highlight=row-' . $teamMember->getId()
            );
        }

        // assign the detail url to the template if available
        $url = Model::getURLForBlock($this->URL->getModule(), 'Detail');
        if (Model::getURL(404) != $url) {
            $this->tpl->assign('detailURL', SITE_URL . $url);
        }

        $form->parse($this->tpl);
        $this->parse();
        $this->display();
    }
}
