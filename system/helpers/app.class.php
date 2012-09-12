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
class App {

    private $login;
    private $register;

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
     * @return string
     */
    public function run() {
        global $load;
        $load->app(true)->header()->run();

        if (!empty($this->login)) {
            $load->app(true)->content('login')->run();
        }

        if (!empty($this->register)) {
            $load->app(true)->content('register')->run();
        }

        $load->app(true)->footer()->run();
    }

}

?>
