<?php

/**
 * Called on script load for any Data Generator page. It does all the heavy lifting and initializes various
 * general vars and data for the script. It's used instead of the global namespace to store info needed throughout
 * the code; the class is static so we don't need to re-instantiate it all over the place, and force it to
 * reload/re-instantiate the various components.
 *
 * @author Ronit Passwala <ronit.passwala@gmail.com>
 * @package Core
 */
class Core {

	// overridable settings that the user may define in settings.php
	private static $dbHostname;
	private static $dbName;
	private static $dbUsername;
	private static $dbPassword;
	private static $dbTablePrefix = "ltp_";
	private static $settingsFileExists = false;
	private static $timeout = 300; // 5 minutes
	
	// left as public, because they're often modified / accessed, and it's just too fussy otherwise. The
	// PHPDoc helps my IDE figure out what the hell each of them are

	/**
	 * @var Database
	 */
	public static $db;

	/**
	 * Core::init()
	 *
	 * Our initialization function. This is called on all page requests to initialize the Core
	 * object. Since it's also used during installation (when the database and/or plugins haven't been
	 * installed), the optional parameter controls whether or not the database object, plugins, sessions and user
	 * should be initialized. Different call contexts require different initialization.
	 *
	 * @access public
	 * @static
	 * @param string $runtimeContext This determines the context in which the Core is being initialized. This
	 *          info is used to let plugins instantiate themselves differently, as well as prevent the loading
	 *          of incomplete parts of the script.<br />
	 *          <b>installation</b>:              a fresh installation, DB not installed yet<br />
	 *          <b>installationDatabaseReady</b>: during installation after the DB has been installed<br />
	 *          <b>ui</b>:                        (default) for the main generator page<br />
	 *          <b>generation</b>:                when we're in the process of creating actual data
	 *          <b>resetPlugins</b>:              initialized everything except the plugins, which may be safely reset
	 */
	public static function init($runtimeContext = "ui") {
		self::loadSettingsFile();

        // the order is significant in all of this
		self::initDatabase();

		set_time_limit(self::$timeout);
	}

	/**
     * Core::loadSettingsFile()
     *
	 * Attempts to load the settings file. If successful, it updates the various private member vars
	 * with whatever's been defined.
	 * @access private
	 */
	private static function loadSettingsFile() {
		$settingsFilePath = realpath(__DIR__ . "/../../settings.php");
		if (file_exists($settingsFilePath)) {
			self::$settingsFileExists = true;
			require_once($settingsFilePath);
			self::$dbHostname = (isset($dbHostname)) ? $dbHostname : null;
			self::$dbName     = (isset($dbName)) ? $dbName : null;
			self::$dbUsername = (isset($dbUsername)) ? $dbUsername : null;
			self::$dbPassword = (isset($dbPassword)) ? $dbPassword : null;
			self::$dbTablePrefix = (isset($dbTablePrefix)) ? $dbTablePrefix : null;

		}
	}

	/**
	 * @access public
	 */
	public static function getHostname() {
		return self::$dbHostname;
	}

	/**
	 * @access public
	 */
    public static function getDbName() {
		return self::$dbName;
	}

	/**
	 * @access public
	 */
    public static function getDbUsername() {
		return self::$dbUsername;
	}

	/**
	 * @access public
	 */
    public static function getDbPassword() {
		return self::$dbPassword;
	}

	/**
	 * @access public
	 */
	public static function getDbTablePrefix() {
		return self::$dbTablePrefix;
	}

	/**
	 * @access public
	 */
	public static function checkSettingsFileExists() {
		return self::$settingsFileExists;
	}

	/**
	 * Initializes the Database object and stores it in Core::$db.
	 * @access private
	 */
	private static function initDatabase() {
		if (Core::$settingsFileExists) {
			self::$db = new Database();
		}
	}

	public static function initSessions() {
		if (session_id() == '') {
			session_start();
			header("Cache-control: private");
		}
	}
}
