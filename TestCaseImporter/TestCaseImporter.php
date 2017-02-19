<?php
/**
 * TestCaseImporter - https://github.com/Aderthad/testlink-testcase-importer
 * This script is distributed under the GNU General Public License 2 or later.
 *
 */

require_once(TL_ABS_PATH . '/lib/functions/tlPlugin.class.php');

class TestCaseImporterPlugin extends TestlinkPlugin
{
  function _construct()
  {

  }

  function register()
  {
    $this->name = 'TestCaseImporter';
    $this->description = 'TestCaseImporter';

    $this->version = '1.00';

    $this->author = 'Jakub Hrachovec';
    $this->contact = 'jakubhrachovec@seznam.cz';
    $this->url = 'https://github.com/Aderthad/testlink-testcase-importer';
  }

  function config()
  {
    return array(
      'config1' => '',
      'config2' => 0
    );
  }
  
  public function init()
  {
	  
  }

  function hooks()
  {
    $hooks = array(
      'EVENT_LEFTMENU_BOTTOM' => 'import_link',
    );
    return $hooks;
  }

  function import_link() 
  {
    return "<a href='" . plugin_page('import.php') . "'>".plugin_lang_get('left_bottom_link')."</a>";
  }
}
