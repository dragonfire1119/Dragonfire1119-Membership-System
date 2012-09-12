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
class Load {

    private $enabled;

    private $login;
    private $register;

    private $header;
    private $content;
    private $footer;

    public function app($enabled=NULL) {
        $this->enabled = $enabled;
        return $this;
    }

    public function login() {
        $this->login = 'login';
        return $this;
    }

    public function register() {
        $this->register = 'register';
        return $this;
    }

    /**
     *
     * @return \load
     */
    public function header() {
        $this->header = ABSPATH . '/views/header.php';
        return $this;
    }

    /**
     *
     * @param string $get
     * @return \Load
     */
    public function content($get) {
        $this->content = ABSPATH . '/views/' . $get . '/' . $get . '.view.php';
        return $this;
    }

    /**
     *
     * @return \load
     */
    public function footer() {
        $this->footer = ABSPATH . '/views/footer.php';
        return $this;
    }

    /**
     *
     * @return string
     */
    public function run() {
        global $register;

        if ($this->enabled != true) {
            die('ERROR: The app is turned off please turn it on by $app(true)->example()->run();');
        }

        if (!empty($this->login)) {
            $this->content('login')->run();
        }

        if (!empty($this->register)) {
            $register->init();
            $this->content('register')->run();
        }

        /////////////

        if (!empty($this->header)) {
            require_once $this->header;
        }

        if (!empty($this->content)) {
            require_once $this->content;
        }

        if (!empty($this->footer)) {
            require_once $this->footer;
        }
    }

}

?>
