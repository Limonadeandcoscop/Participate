<?php
/**
 * Participate
 *
 * Provide the ability to send files and comments to administrator
 *
 * @copyright Copyright 2011-2012 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @package ParticipatePlugin
 */

define('PARTICIPATE_PLUGIN_DIR', dirname(__FILE__));
define('PARTICIPATE_UPLOADS_DIR', PARTICIPATE_PLUGIN_DIR . '/uploads');
define('PARTICIPATE_UPLOADS_URL', public_url('/plugins/Participate/uploads/'));

require_once PARTICIPATE_PLUGIN_DIR . '/functions.php';

/**
 * The Participate plugin.
 * @package Omeka\Plugins\Participate
 */
class ParticipatePlugin extends Omeka_Plugin_AbstractPlugin
{
    /**
     * @var array Hooks for the plugin.
     */
    protected $_hooks = array(
      
        'public_items_show',
        'define_routes'
    );


    /**
     * @var array Filters for the plugin.
     */
    protected $_filters = array(
        
    );



    /**
     * Manage display of "add/remove to cart" links
     */
    public function hookPublicItemsShow($args) {

        if (is_admin_theme()) return;

        $html  = '<div class="pdf-items">';
        $html .= '<a href="'.url(array('item-id' => $args['item']->id), 'participate').'">'.__('Participate').'</a>';
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
        $router->addConfig(new Zend_Config_Ini(PARTICIPATE_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'routes.ini', 'routes'));
    }



}




