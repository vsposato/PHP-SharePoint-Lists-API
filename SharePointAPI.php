<?php

/**
 * SharepointAPI
 *
 * Simple PHP API for reading/writing and modifying SharePoint list items.
 *
 * @version 0.6.2
 * @licence MIT License
 * @source: http://github.com/thybag/PHP-SharePoint-Lists-API
 *
 *
 * Add backwards compatability for none composer users:
 * Include this file and add `use Thybag\SharePointAPI;` below in order the PHP SP API as before.
 */

// PSR-0 Autoloader
// see: http://zaemis.blogspot.fr/2012/05/writing-minimal-psr-0-autoloader.html


spl_autoload_register(function ($classname) {

    // Gets the basedire of this file to prepend for the filename
    $basedir = dirname(__FILE__) . '/';

    // Remove the double slashes at the front, if they exist
    $classname = ltrim($classname, "\\");

    // Pull out the chunks of the class to get directories
    preg_match('/^(.+)?([^\\\\]+)$/U', $classname, $match);

    // Determine if this is a test or not, because a test will need to be loaded from the test
    // directory, not the src directory
    if ( substr($classname, -4) === 'Test' ) {
        $basedir .= 'test/';
    } else {
        $basedir .= 'src/';
    }

    // Build the classname including path
    $classname = $basedir . str_replace("\\", "/", $match[1])
        . str_replace(array("\\", "_"), "/", $match[2])
        . ".php";

    // Check to see if file exists, before loading it - this is to prevent a bunch of errors
    if (file_exists($classname)) {
        include_once $classname;
    }
});
