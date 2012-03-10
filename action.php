<?php

if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');
require_once(DOKU_PLUGIN . 'action.php');

/**
 * Proofread Page Plugin.
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Sam Wilson <sam@samwilson.id.au>
 */
class action_plugin_proofreadpage extends DokuWiki_Action_Plugin {

    /**
     * Get information about this plugin.
     * 
     * @return array
     */
    function getInfo() {
        return array(
            'author' => 'Sam Wilson',
            'email' => 'sam@samwilson.id.au',
            'date' => '2012-03-10',
            'name' => 'Proofread Page',
            'desc' => 'View images side-by-side with pages, for viewing and editing.',
            'url' => 'http://www.dokuwiki.org/plugin:proofreadpage',
        );
    }

    /**
     * Register hooks to display associated images on viewing and editing pages.
     * 
     * @param Doku_Event_Handler $controller The event handler.
     */
    function register(&$controller) {
        global $ACT;
        if ($ACT=='edit') {
            $controller->register_hook('HTML_EDITFORM_OUTPUT', 'BEFORE', $this, 'display_image');
        } elseif ($ACT=='show') {
            $controller->register_hook('TPL_ACT_RENDER', 'BEFORE', $this, 'display_image');
        }
    }

    /**
     * If an image exists with the same name (and namespace) as the current
     * page, display it now.
     * 
     * @global string $ID The ID of the current page.
     * @todo Check that the matching file is actually an image.
     * @return void
     */
    public function display_image($data) {
        global $ID;
        if (file_exists(mediaFN($ID))) {
            echo '<img class="proofreadpage" alt="" width="500" src="' . ml($ID, array('w' => '500')) . '" />';
        }
    }

}
