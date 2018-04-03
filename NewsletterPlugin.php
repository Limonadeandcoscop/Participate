<?php
/**
 * Newsletter
 *
 * Manage newsletter subscriptions
 *
 * @copyright Copyright 2017-2020 Limonade and Co
 * @author Franck Dupont <technique@limonadeandco.fr>
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @package ParticipativeCartPlugin
 */

define('NEWSLETTER_PLUGIN_DIR', dirname(__FILE__));

require_once NEWSLETTER_PLUGIN_DIR . '/functions.php';

/**
 * The Participate plugin.
 * @package Omeka\Plugins\Participate
 */
class NewsletterPlugin extends Omeka_Plugin_AbstractPlugin
{

    /**
     * @var array Hooks for the plugin.
     */
    protected $_hooks = array(
        'install',
        'config',
        'config_form',
        'public_items_show',
        'define_routes'
    );


    /**
     * @var array Filters for the plugin.
     */
    protected $_filters = array(
        
    );


    /**
     * The install process
     */
    public function hookInstall()
    {
        $sql  = "
        CREATE TABLE IF NOT EXISTS `{$this->_db->Newsletter}` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `email` varchar(255) NOT NULL,
          `key` varchar(255) NOT NULL,
          `status` varchar(20) NOT NULL DEFAULT 'waiting',
          `inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`),
          UNIQUE KEY `id` (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        $this->_db->query($sql);
    }


    /**
     * Manage config
     */
    public function hookConfig($args)
    {
        $post = $args['post'];

        if ($post['presentation']) {
            set_option('presentation', $post['presentation']);
        }
    }


    /**
     * Load the config form
     */
    public function hookConfigForm()
    {
        $presentation = __("Subcribe to our newsletter.");
        include('config_form.php');
    }


    /**
     * Manage display of "add/remove to cart" links
     */
    public function hookPublicItemsShow($args) {

        if (is_admin_theme()) return;

        $html  = '<div class="newsletter-subscription">';
        $html .= '<a href="'.url(array(), 'newsletter').'">'.get_option('presentation').'</a>';
        $html .= '</div>';
        echo $html;
    }


    /**
     * Add the routes
     *
     * @param Zend_Controller_Router_Rewrite $router
     */
    public function hookDefineRoutes($args)
    {
        // Don't add these routes on the admin side to avoid conflicts.
        if (is_admin_theme()) return;

        // Include routes file
        $router = $args['router'];
        $router->addConfig(new Zend_Config_Ini(NEWSLETTER_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'routes.ini', 'routes'));
    }



}




