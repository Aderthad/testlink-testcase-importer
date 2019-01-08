<?php
require_once(TL_ABS_PATH . '/lib/functions/tlPlugin.class.php');

/**
 * TestCaseImporter - https://github.com/Aderthad/testlink-testcase-importer
 * This script is distributed under the GNU General Public License 3 or later.
 *
 * This file specifies plugin's properties and 
 * gets loaded by TestLink's plugin API.
 */
class TestCaseImporterPlugin extends TestlinkPlugin
{
  /**
   * this function registers your plugin - must set at least name and version
   */ 
  function register()
  {
    $this->name = 'TestCaseImporter';
    $this->description = 'TestCaseImporter';

    $this->version = '1.00';

    $this->author = 'Jakub Hrachovec';
    $this->contact = 'jakubhrachovec@seznam.cz';
    $this->url = 'https://github.com/Aderthad/testlink-testcase-importer';
  }

  /**
   * return an array of default configuration name/value pairs
   */
  function config()
  {
    return array();
  }
  
  /**
   * this function allows your plugin to set itself up, include any necessary API's,
   * declare or hook events, etc. This is also where you would initialize support
   * classes (setting include_path etc to allow other classes to be loaded)
   */
  function init()
  {
	  
  }
  
  /**
   * This function allows for the plugins to do any specific install activities.
   * Return false if u want to stop installation
   */
  public function install()
  {
    return true;
  }

  /**
   * This function allows for the plugins to do any specific uninstall
   * activities that maybe required to cleanup
   */
  public function uninstall()
  {
    
  }

  /**
   * Defines a hooks exposed by the plugin. There will be a hyperlink to the plugin
   * page shown in the plugin section of the left menu.
   */
  function hooks()
  {
    $hooks = array(
      'EVENT_LEFTMENU_BOTTOM' => 'import_link',
    );
    return $hooks;
  }

  /**
   * This function returns a hyperlink that will be displayed in the plugins section.
   */
  function import_link() 
  {
    $menu_item['href'] = plugin_page('import.php');
    $menu_item['label'] = plugin_lang_get('left_bottom_link');
    return $menu_item;
  }
}
