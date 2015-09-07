<?php

namespace Backend\Modules\Team\Installer;

use Backend\Core\Installer\ModuleInstaller;

/**
 * Installer for the team module
 *
 * @author Wouter Sioen <wouter@woutersioen.be>
 */
class Installer extends ModuleInstaller
{
    /**
     * Install the module
     */
    public function install()
    {
        $this->addModule('Team');

        $this->importSQL(dirname(__FILE__) . '/Data/install.sql');
        $this->importLocale(dirname(__FILE__) . '/Data/locale.xml');

        $this->setModuleRights(1, $this->getModule());
        $this->setActionRights(1, $this->getModule(), 'Index');
        $this->setActionRights(1, $this->getModule(), 'Add');
        $this->setActionRights(1, $this->getModule(), 'Edit');
        $this->setActionRights(1, $this->getModule(), 'Delete');

        $this->insertExtra($this->getModule(), 'block', 'Team');

        // set navigation
        $navigationModulesId = $this->setNavigation(null, 'Modules');
        $this->setNavigation(
            $navigationModulesId,
            'Team',
            'team/index',
            [ 'team/add', 'team/edit' ]
        );
    }
}
