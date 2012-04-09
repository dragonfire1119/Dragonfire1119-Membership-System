<?php

/*
 * The core files - These are the core files do not touch this at all
 */
include_once("includes/core/security.php");
include_once("includes/core/database.php");
include_once("includes/core/dmsform.php");
include_once("includes/core/session.php");
include_once("includes/helpers/dms.php");
include_once("includes/helpers/api.php");
include_once("config/DMS_Config.php");
include_once("includes/core/mailer.php");

/**
 * Load Modules
 */
include_once("checksModule.php");
include_once("forgotpasswordModule.php");
include_once("loginModule.php");
include_once("logoutModule.php");
include_once("pmModule.php");
include_once("registerModule.php");
 
/*
 * Load the Lang
 * You can load as many langs in here but what ever your not using put these in front of the
 * //include_once("whatever");
 */
include_once("includes/lang/english.lang.php");

/*
 * Loader all the modules - These are being slowly replaced by helpers now
 */
include_once("includes/helpers/css.php");
include_once("includes/helpers/html.php");
include_once("includes/helpers/javascript.php");

?>