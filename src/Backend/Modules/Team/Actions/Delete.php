<?php

namespace Backend\Modules\Team\Actions;

use Rhumsaa\Uuid\Uuid;
use Backend\Core\Engine\Model;
use Backend\Core\Engine\Base\ActionDelete;

/**
 * This class will be used to delete team members
 *
 * @author Wouter Sioen <wouter@woutersioen.be>
 */
final class Delete extends ActionDelete
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

        $this->get('team_repository')->delete($teamMember);

        return $this->redirect(
            Model::createURLForAction('Index') . '&report=deleted'
        );
    }
}
