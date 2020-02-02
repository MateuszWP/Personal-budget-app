<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'matpacz_mvclogin';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'matpacz_root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '451M@teusz';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * Secret key for hashing
     * @var boolean
     */
    const SECRET_KEY = '451M@teusz';
}
