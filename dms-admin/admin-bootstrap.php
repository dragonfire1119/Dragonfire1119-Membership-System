<?php
/**************************************************************************
* Dragonfire1119 Membership System AKA DMS
* Copyright (C) 2012 Christopher Hicks
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program. If not, see <http://www.gnu.org/licenses/>.
**************************************************************************/

define("admin_INC", dirname(__FILE__));

require_once 'includes/rb.php';
$dms = new R();

require_once '../dms-config.php';
require_once 'includes/hash.php';
require_once 'includes/cookie.class.php';