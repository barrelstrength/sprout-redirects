<?php

/**
 * Sprout Redirects config.php
 *
 * This file exists only as a template for the Sprout Redirects settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'sprout-redirects.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [
    // The name to display in the control panel in place of the plugin name
    'pluginNameOverride' => 'Sprout Redirects',

    // Process Redirect rules and log 404 requests.
    'enableRedirects' => true,

    // Log 'Page Not Found' errors as 404 Redirects
    'enable404RedirectLog' => false,

    // How to match 404 requests with Redirect records already captured in the database.
    // urlWithQueryStrings: match the entire URL including query strings
    // urlWithoutQueryStrings: remove all parameters from the request URL before searching for a match
    'redirectMatchStrategy' => 'urlWithoutQueryStrings',

    // How to treat query strings after processing a redirect
    // removeQueryStrings - remove the query string from the incoming URL entirely
    // appendQueryStrings - add any query string from the incoming URL to the New Url
    'queryStringStrategy' => 'removeQueryStrings',

    // Enable to capture the IP Address used when a 404 request is saved
    'trackRemoteIp' => false,

    // The target number of 404 Redirects that will be stored in the database per-site, after the cleanup task runs.
    'total404Redirects' => 250,

    // The probability that the 404 Redirect cleanup task will run each web request
    // 0 - None
    // 100000 - 1 in 10
    // 10000 - 1 in 100
    // 1000 - selected>1 in 1,000
    // 100 - 1 in 10,000
    // 10 - 1 in 100,000
    // 1 - 1 in 1,000,000
    'cleanupProbability' => 1000,

    // Add any regular expression patterns you wish to exclude from the Redirect log.
    // Overriding this setting will override any updates made by the "Add to Excluded URLs" action.
    // 'excludedUrlPatterns' => ''
];
