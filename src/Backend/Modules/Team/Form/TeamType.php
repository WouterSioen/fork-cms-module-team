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
     * @param string $name
     */
    public function __construct($name)
    {
        $this->form = new Form($name);

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
        $this->teamMember = TeamMember::create(
            $this->meta->save(),
            Language::getWorkingLanguage(),
            $fields['title']->getValue(),
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
            'title',
            null,
            null,
            'inputText title',
            'inputTextError title'
        );

        $this->form->addEditor(
            'description',
            null
        );

        $this->meta = new Meta(
            $this->form,
            null,
            'title',
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

        $fields['title']->isFilled(Language::err('FieldIsRequired'));
        $fields['description']->isFilled(Language::err('FieldIsRequired'));

        $this->meta->validate();

        return $this->form->isCorrect();
    }
}
