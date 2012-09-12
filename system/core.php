<?php
/**
 *
 * @category   Membership System
 * @package    DMS
 * @author     Christopher Hicks <dms@dragonfire1119.com>
 * @copyright  2012 dragonfire1119.com
 * @license    GPL3
 * @version    1.0
 * @link       http://dms.dragonfire1119.com
 * @since      File available since Release 1.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 */

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
?>

<?php
define("ABSPATH", dirname(__FILE__));
define("DMSSYS", "system");
define("END", ".php");

// Get config
require_once 'dms_config' . END;

// Get 3rdparty
require_once '3rdparty/rb' . END;

// Get the controllers
require_once 'controllers/login.class' . END;
require_once 'controllers/register.class' . END;

// Get the helpers
require_once 'helpers/app.class' . END;
require_once 'helpers/check.class' . END;
require_once 'helpers/hash.class' . END;
require_once 'helpers/load.class' . END;
require_once 'helpers/security.class' . END;
require_once 'helpers/session.class' . END;

// Now lets load them up
$db = new R();
$login = new Login();
$register = new Register();
$app = new App();
$hash = new Hash();
$check = new Check();
$load = new Load();
$security = new Security();
$session = new Session();

// Get the settings
require_once 'dms_settings' . END;