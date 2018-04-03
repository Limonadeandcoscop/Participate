<?php
/**
 * Newsletter
 *
 * @copyright Copyright 2017-2020 Limonade and Co
 * @author Franck Dupont <technique@limonadeandco.fr>
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @package NewsletterPlugin
 */


/**
 * A Newsletter row.
 *
 * @package Omeka\Plugins\Newsletter
 */
class Newsletter extends Omeka_Record_AbstractRecord
{
    public $email;
    public $key;
    public $status;
    public $inserted;


    /**
     * Returns the "User" object for this cart
     *
     * @return User object
     */
    public function getUser() {

        $user = get_record_by_id('User', $this->user_id);
        if (get_class($user) != 'User')
            throw new Exception("Invalid user ID");
        return $user;
    }


    /**
     * Check if an email already exists in databse
     *
     * @return Boolean
     */
    public static function emailExists($email) {

        if (!strlen(trim($email))) return false;

        $table = get_db()->getTable('Newsletter');
        $results = $table->findBy(array('email' => $email));

        if ($results) return true;
    }

}
