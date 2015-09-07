<?php

namespace Backend\Modules\Team\Entity;

use Rhumsaa\Uuid\Uuid;

/**
 * TeamMember entity
 *
 * @author Wouter Sioen <wouter@woutersioen.be>
 */
class TeamMember
{
    private $id;
    private $metaId;
    private $language;
    private $name;
    private $description;
    private $isHidden = false;
    private $editedOn;
    private $createdOn;

    private function __construct(
        $id,
        $metaId,
        $language,
        $name,
        $description,
        $isHidden,
        \DateTime $editedOn,
        \DateTime $createdOn
    ) {
        $this->id = $id;
        $this->metaId = $metaId;
        $this->language = $language;
        $this->name = $name;
        $this->description = $description;
        $this->isHidden = $isHidden;
        $this->editedOn = $editedOn;
        $this->createdOn = $createdOn;
    }

    public static function create(
        $metaId,
        $language,
        $name,
        $description
    ) {
        return new self(
            Uuid::uuid4(),
            $metaId,
            $language,
            $name,
            $description,
            false,
            new \DateTime(),
            new \DateTime()
        );
    }

    public static function fromArray(array $teamMemberArray)
    {
        return new self(
            Uuid::fromBytes($teamMemberArray['id']),
            $teamMemberArray['meta_id'],
            $teamMemberArray['language'],
            $teamMemberArray['name'],
            $teamMemberArray['description'],
            (bool) $teamMemberArray['is_hidden'],
            \DateTime::createFromFormat(
                'Y-m-d H:i:s',
                $teamMemberArray['edited_on']
            ),
            \DateTime::createFromFormat(
                'Y-m-d H:i:s',
                $teamMemberArray['created_on']
            )
        );
    }

    public function change($metaId, $name, $description)
    {
        $this->metaId = $metaId;
        $this->name = $name;
        $this->description = $description;
        $this->editedOn = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMetaId()
    {
        return $this->metaId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'meta_id' => $this->metaId,
            'language' => $this->language,
            'name' => $this->name,
            'description' => $this->description,
            'is_hidden' => $this->isHidden,
            'edited_on' => $this->editedOn,
            'created_on' => $this->createdOn,
        ];
    }
}
