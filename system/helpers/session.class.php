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
class Session {

    /**
     *
     * @var string
     * @return NULL
     */
    public $quickString = "";

    /**
     * Magic function
     *
     * @return NULL
     */
    function __construct() {

    }

    /**
     * Starts the session
     *
     * @return \Session|boolean
     */
    public function startSession() {
        if (!isset($_SESSION)) {
            if (!headers_sent()) {
                session_start();
                return $this;
            }
        }
        return false;
    }

    /**
     * setSession will set a key and value for your session, this splits one plugin sessions from another
     * plugins sessions, so two different plugins can have the same session key/value without interferance.
     *
     * @param string $sessionKey
     * @param string $sessionValue
     * @return string
     */
    public function setSession($sessionKey, $sessionValue = null) {
        $this->startSession();
        $_SESSION['dms'][$sessionKey] = $sessionValue;
    }

    /**
     * getSession will get a session from your plugins session, so if two plugins use the same
     * session key/value as your plugin, the other plugins session will be ignored, and the one
     * from the current working plugin will be returned.
     *
     * @param string $sessionKey
     * @param string $default
     * @return \Session
     */
    public function getSession($sessionKey, $default = false) {
        $this->startSession();
        if (isset($_SESSION['dms'][$sessionKey])) {
            $this->quickString = $_SESSION['dms'][$sessionKey];
        }
        return $this;
    }

    /**
     * removeSession will remove a session for the current working plugin.
     * When this is called within a plugin, it will delete a particular session value
     * $live->removeSession("my_session");
     * The above will remove the session with the key "my_session" and leave other alone.
     *
     * @param string $sessionKey
     * @return NULL
     */
    public function removeSession($sessionKey) {
        if (is_string($sessionKey)) {
            $sessionKey = array($sessionKey);
        }
        $this->startSession();
        foreach ($sessionKey as $key) {
            if (isset($_SESSION['phpLive'][$section['sessionRef']][$key])) {
                unset($_SESSION['phpLive'][$section['sessionRef']][$key]);
            }
        }
    }

    /**
     * killSession will kill the current phplive session including ALL plugins, this will
     * ignore sessions created outside the phplive session.
     *
     * @return NULL
     */
    public function killSession() {
        $this->startSession();
        unset($_SESSION['dms']);
    }

    /**
     * killSessions will kill ALL sessions, including those created by plugins
     *
     * @return NULL
     */
    public function killSessions() {
        $this->startSession();
        unset($_SESSION);
        session_destroy();
    }

}