<?php

namespace Backend\Modules\Team\Actions;

use Backend\Core\Engine\Base\ActionIndex;
use Backend\Core\Engine\Authentication;
use Backend\Core\Engine\DataGridDB;
use Backend\Core\Engine\DataGridFunctions;
use Backend\Core\Engine\Language;
use Backend\Core\Engine\Model;

/**
 * This is the index-action, it will display the overview of team members
 *
 * @author Wouter Sioen <wouter@woutersioen.be>
 */
final class Index extends ActionIndex
{
    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();
        $this->loadDataGrid();
        $this->parse();
        $this->display();
    }

    /**
     * Loads the datagrids
     */
    private function loadDataGrid()
    {
        // create datagrid
        $this->dataGrid = new DataGridDB(
            $this->get('team_repository')->getDataGridQuery(),
            [ 'language' => Language::getWorkingLanguage() ]
        );

        $this->dataGrid->setColumnFunction(
            [ 'Rhumsaa\Uuid\Uuid', 'fromBytes' ],
            [ '[id]' ],
            'id',
            true
        );

        $this->dataGrid->setColumnFunction(
            [ new DataGridFunctions(), 'getLongDate' ],
            [ '[created_on]' ],
            'created_on',
            true
        );

        // check if this action is allowed
        if (Authentication::isAllowedAction('Edit')) {
            // add column
            $this->dataGrid->addColumn(
                'edit',
                null,
                Language::lbl('Edit'),
                Model::createURLForAction('Edit'),
                Language::lbl('Edit')
            );
            $this->dataGrid->setColumnFunction(
                [ __CLASS__, 'addIdToEditUrl' ],
                [ '[edit]', '[id]' ],
                'edit',
                true
            );
        }

        $this->tpl->assign('dataGrid', (string) $this->dataGrid->getContent());
    }

    public static function addIdToEditUrl($edit, $id)
    {
        return preg_replace(
            '/<a(.*)href="([^"]*)"(.*)>/',
            '<a$1href="$2' . '&amp;id=' . $id . '"$3>',
            $edit
        );
    }
}
