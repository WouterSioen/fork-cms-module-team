<?php

namespace Backend\Modules\Team\Engine;

use Common\Uri as CommonUri;
use Backend\Core\Engine\Language;
use Backend\Core\Engine\Model as BackendModel;

/**
 * In this file we store all generic functions that we will be using in the faq module
 *
 * @author Wouter Sioen <wouter@woutersioen.be>
 */
final class Model
{
    /**
     * Retrieve the unique URL for an teamMember
     *
     * @param string $url
     * @param int $id The id of the teamMember to ignore.
     * @return string
     */
    public static function getUrl($url, $id = null)
    {
        $url = CommonUri::getUrl((string) $url);
        $database = BackendModel::get('database');

        if ($id === null) {
            $urlExists = (bool) $database->getVar(
                'SELECT 1
                   FROM team_members AS i
                        INNER JOIN meta AS m
                        ON i.meta_id = m.id
                  WHERE i.language = ? AND m.url = ?
                  LIMIT 1',
                [ Language::getWorkingLanguage(), $url ]
            );
        } else {
            $urlExists = (bool) $database->getVar(
                'SELECT 1
                   FROM team_members AS i
                        INNER JOIN meta AS m
                        ON i.meta_id = m.id
                  WHERE i.language = ? AND m.url = ? AND i.id != ?
                  LIMIT 1',
                [ Language::getWorkingLanguage(), $url, $id ]
            );
        }

        if ($urlExists) {
            $url = Model::addNumber($url);

            return self::getUrl($url, $id);
        }

        return $url;
    }
}
