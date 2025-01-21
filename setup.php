<?php

global $CFG_GLPI;
// Version of the plugin (major.minor.bugfix)
define('WORKSHOP_VERSION', '1.0.0');
define('WORKSHOP_ITSMNG_MIN_VERSION', '2.0');
define('WORKSHOP_AUTHOR', 'ITSMNG Team');

/**
 * Define the plugin's version and informations
 *
 * @return Array [name, version, author, homepage, license, minGlpiVersion]
 */
function plugin_version_workshop()
{
    $requirements = [
       'name'           => 'Workshop Plugin',
       'version'        => WORKSHOP_VERSION,
       'author'         => WORKSHOP_AUTHOR,
       'homepage'       => 'https://github.com/itsmng/workshop',
       'license'        => '<a href="../plugins/plugin-workshop/LICENSE" target="_blank">GPLv3</a>',
    ];
    return $requirements;
}

/**
 * Initialize all classes and generic variables of the plugin
 */
function plugin_init_workshop()
{
    global $PLUGIN_HOOKS;

    // Set the plugin CSRF compliance (required since GLPI 0.84)
    $PLUGIN_HOOKS['csrf_compliant']['workshop'] = true;
    $PLUGIN_HOOKS['menu_toadd']['workshop']     = ['helpdesk' => PluginWorkshopMember::class];
}

/**
 * Check plugin's prerequisites before installation
 *
 * @return boolean
 */
function workshop_check_prerequisites()
{
    $prerequisitesSuccess = true;

    if (version_compare(ITSM_VERSION, WORKSHOP_ITSMNG_MIN_VERSION, 'lt')) {
        echo "This plugin requires ITSM >= " . WORKSHOP_ITSMNG_MIN_VERSION . "<br>";
        $prerequisitesSuccess = false;
    }

    return $prerequisitesSuccess;
}

/**
 * Check plugin's config before activation (if needed)
 *
 * @param string $verbose Set true to show all messages (false by default)
 * @return boolean
 */
function workshop_check_config($verbose = false)
{
    if ($verbose) {
        echo "Checking plugin configuration<br>";
    }
    return true;
}
