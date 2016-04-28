<?php

namespace Backend\Modules\Team\Repository;

use SpoonDatabase;
use Rhumsaa\Uuid\Uuid;
use Backend\Core\Engine\Model;
use Backend\Modules\Team\Entity\TeamMember;

final class TeamMemberRepository
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
     * @return string
     */
    public function getDataGridQuery()
    {
        return 'SELECT id, name, description, UNIX_TIMESTAMP(created_on) AS created_on
                  FROM team_members
                 WHERE language = :language';
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

    /**
     * @param TeamMember $teamMember
     * @return string
     */
    public function save(TeamMember $teamMember)
    {
        // reform objects to a format our db understands
        $teamMemberArray = $teamMember->toArray();
        $teamMemberArray['id'] = $teamMemberArray['id']->getBytes();
        $teamMemberArray['edited_on'] = $teamMemberArray['edited_on']->format('Y-m-d H:i:s');
        $teamMemberArray['created_on'] = $teamMemberArray['created_on']->format('Y-m-d H:i:s');

        return $this->database->update(
            'team_members',
            $teamMemberArray,
            'id = ?',
            $teamMemberArray['id']
        );
    }

    /**
     * @param Uuid $id
     */
    public function find(Uuid $id)
    {
        $teamMember = $this->database->getRecord(
            'SELECT *
               FROM team_members
              WHERE id = :id',
            [ 'id' => $id->getBytes() ]
        );

        if (empty($teamMember)) {
            throw new \Exception('No teammember with id ' . $id->toString() . 'found');
        }

        return TeamMember::fromArray($teamMember);
    }

    /**
     * @param TeamMember $teamMember
     */
    public function delete(TeamMember $teamMember)
    {
        $this->database->delete(
            'meta',
            'id = ?',
            [ $teamMember->getMetaId() ]
        );

        $this->database->delete(
            'team_members',
            'id = ?',
            [ $teamMember->getId()->getBytes() ]
        );
    }
}
