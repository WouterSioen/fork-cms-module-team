<?php

namespace Backend\Modules\Team\Repository;

use SpoonDatabase;
use Rhumsaa\Uuid\Uuid;
use Backend\Core\Engine\Model;
use Backend\Modules\Team\Entity\TeamMember;

class TeamMemberRepository
{
    /**
     * @var SpoonDatabase
     */
    private $database;

    /**
     * @param SpoonDatabase $database
     */
    public function __construct(SpoonDatabase $database)
    {
        $this->database = $database;
    }

    /**
     * @param TeamMember $teamMember
     * @return string
     */
    public function add(TeamMember $teamMember)
    {
        // reform objects to a format our db understands
        $teamMemberArray = $teamMember->toArray();
        $teamMemberArray['id'] = $teamMemberArray['id']->getBytes();
        $teamMemberArray['edited_on'] = $teamMemberArray['edited_on']->format('Y-m-d H:i:s');
        $teamMemberArray['created_on'] = $teamMemberArray['created_on']->format('Y-m-d H:i:s');

        return $this->database->insert(
            'team_members',
            $teamMemberArray
        );
    }
}
