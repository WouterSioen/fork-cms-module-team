<?php

namespace Backend\Modules\Team\Form;

use SpoonTemplate;
use Backend\Core\Engine\Form;
use Backend\Core\Engine\Language;
use Backend\Core\Engine\Meta;
use Backend\Modules\Team\Entity\TeamMember;

/**
 * Represents a form to add/edit team members
 *
 * @author Wouter Sioen <wouter@woutersioen.be>
 */
class TeamType
{
    /**
     * @var Form
     */
    private $form;

    /**
     * @var Meta
     */
    private $meta;

    /**
     * @var null|TeamMember
     */
    private $teamMember = null;

    /**
     * @param string $name
     * @param array $teamMember
     */
    public function __construct($name, TeamMember $teamMember = null)
    {
        $this->form = new Form($name);
        $this->teamMember = $teamMember;

        $this->build();
    }

    /**
     * Handles the form
     *
     * @return bool
     */
    public function handle()
    {
        if (!$this->form->isSubmitted() || !$this->isValid()) {
            return false;
        }

        $fields = $this->form->getFields();

        // we already have a teammember? Let's update
        if ($this->teamMember instanceof TeamMember) {
            $this->teamMember->change(
                $this->meta->save(),
                $fields['name']->getValue(),
                $fields['description']->getValue()
            );

            return true;
        }

        // time to create a new entity
        $this->teamMember = TeamMember::create(
            $this->meta->save(),
            Language::getWorkingLanguage(),
            $fields['name']->getValue(),
            $fields['description']->getValue()
        );

        return true;
    }

    /**
     * Returns the data currently in the form.
     *
     * @return array
     */
    public function getData()
    {
        return $this->teamMember;
    }

    /**
     * Parses the form to the template
     *
     * @param SpoonTemplate $template
     */
    public function parse(SpoonTemplate $template)
    {
        $this->form->parse($template);
    }

    /**
     * Adds all needed fields to the form
     */
    private function build()
    {
        $this->form->addText(
            'name',
            $this->teamMember === null ? null : $this->teamMember->getName(),
            null,
            'inputText title',
            'inputTextError title'
        );

        $this->form->addEditor(
            'description',
            $this->teamMember === null ? null : $this->teamMember->getDescription()
        );

        $this->meta = new Meta(
            $this->form,
            $this->teamMember === null ? null : $this->teamMember->getMetaId(),
            'name',
            true
        );
    }

    /**
     * Checks if the form is valid
     *
     * @return bool
     */
    private function isValid()
    {
        $fields = $this->form->getFields();

        $fields['name']->isFilled(Language::err('FieldIsRequired'));
        $fields['description']->isFilled(Language::err('FieldIsRequired'));

        $this->meta->validate();

        return $this->form->isCorrect();
    }
}
