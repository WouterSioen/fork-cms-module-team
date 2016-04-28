<?php

namespace Backend\Modules\Team\Actions;

use Rhumsaa\Uuid\Uuid;
use Backend\Core\Engine\Model;
use Backend\Core\Engine\Base\ActionEdit;
use Backend\Modules\Team\Form\TeamType;

/**
 * This class will be used to edit team members
 *
 * @author Wouter Sioen <wouter@woutersioen.be>
 */
final class Edit extends ActionEdit
{
    public function execute()
    {
        parent::execute();

        try {
            $id = Uuid::fromString($this->getParameter('id', 'string'));
            $teamMember = $this->get('team_repository')->find($id);
        } catch (\Exception $e) {
            return $this->redirect(
                Model::createURLForAction('Index') . '&error=non-existing'
            );
        }

        $form = new TeamType('edit', $teamMember);
        if ($form->handle()) {
            $teamMember = $form->getData();
            $this->get('team_repository')->save($teamMember);

            return $this->redirect(
                Model::createURLForAction('Index') . '&report=edited'
                . '&highlight=row-' . $teamMember->getId()
            );
        }

        // assign the detail url to the template if available
        $url = Model::getURLForBlock($this->URL->getModule(), 'Detail');
        if (Model::getURL(404) != $url) {
            $this->tpl->assign('detailURL', SITE_URL . $url);
        }

        $form->parse($this->tpl);
        $this->tpl->assign('teamMember', $teamMember->toArray());
        $this->parse();
        $this->display();
    }
}
