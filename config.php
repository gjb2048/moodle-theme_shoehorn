<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Shoehorn theme with the underlying Bootstrap theme.
 *
 * @package    theme
 * @subpackage shoehorn
 * @version    See the value of '$plugin->version' in version.php.
 * @copyright  &copy; 2014-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$THEME->doctype = 'html5';
$THEME->name = 'shoehorn';
$THEME->parents = array('bootstrap');

$tdm = '';
if (!get_config('core', 'themedesignermode')) {
    $tdm = '_min';
}

if (empty($THEME->settings->dynamiclang)) {
    if ('ltr' === get_string('thisdirection', 'langconfig')) {
        $THEME->sheets = array('moodle'.$tdm);
    } else {
        $THEME->sheets = array('moodle-rtl'.$tdm, 'tinymce-rtl', 'yui2-rtl', 'forms-rtl');
    }
} else {
    $THEME->sheets = array('theme');  // moodle / moodle-rtl served in layout/tiles/header.php separately.
}
$THEME->sheets[] = 'general';
if (!(!empty($THEME->settings->cdnfonts) && ($THEME->settings->cdnfonts == 2))) { // NOT of CDN Font setting does exist and is set to yes.
    $THEME->sheets[] = 'font';
    if (!empty($THEME->settings->fontawesome) && ($THEME->settings->fontawesome == 1)) { // Use FontAwesome locally.
        $THEME->sheets[] = 'font-awesome';
    }
}
$THEME->sheets[] = 'font-local'; // Fonts that must be local because there is no CDN for them.
if ((!empty($THEME->settings->numberofsociallinks)) && ($THEME->settings->numberofsociallinks > 0)) {
    $THEME->sheets[] = 'social';
}
$THEME->sheets[] = 'custom';
$THEME->supportscssoptimisation = false;
$THEME->yuicssmodules = array();

if ((!empty($THEME->settings->docking) && ($THEME->settings->docking == 2)) &&
    (empty($THEME->settings->accordion) || ((!empty($THEME->settings->accordion) && ($THEME->settings->accordion == 1))))) {
    $THEME->enable_dock = true;
} else {
    $THEME->enable_dock = false;
}

$THEME->editor_sheets = array('editor'.$tdm);

$THEME->parents_exclude_sheets = array(
    'bootstrap' => array(
        'moodle',
        'editor'
    )
);

$THEME->plugins_exclude_sheets = array(
    'block' => array(
        'html'
    )
);

$THEME->parents_exclude_javascripts = array(
    'bootstrap' => array(
        'moodlebootstrap'
    )
); // Exclude the conflicting YUI JS.

$allregions = array('side-pre', 'side-post', 'page-bottom', 'footer-pre', 'footer-post');
$sidepreregions = array('side-pre', 'page-bottom', 'footer-pre', 'footer-post');
$bottomregions = array('page-bottom', 'footer-pre', 'footer-post');

$THEME->layouts = array(
    // Most backwards compatible layout without the blocks - this is the layout used by default.
    'base' => array(
        'file' => 'default.php',
        'regions' => array(),
    ),
    // Standard layout with blocks, this is recommended for most pages with general information.
    'standard' => array(
        'file' => 'default.php',
        'regions' => $sidepreregions,
        'defaultregion' => 'side-pre',
    ),
    // Main course page.
    'course' => array(
        'file' => 'default.php',
        'regions' => $sidepreregions,
        'defaultregion' => 'side-pre',
        'options' => array('langmenu'=>true),
    ),
    'coursecategory' => array(
        'file' => 'default.php',
        'regions' => $allregions,
        'defaultregion' => 'side-pre',
    ),
    // Part of course, typical for modules - default page layout if $cm specified in require_login().
    'incourse' => array(
        'file' => 'default.php',
        'regions' => $allregions,
        'defaultregion' => 'side-pre',
    ),
    // The site home page.
    'frontpage' => array(
        'file' => 'frontpage.php',
        'regions' => $sidepreregions,
        'defaultregion' => 'side-pre',
        'options' => array('nonavbar'=>true),
    ),
    // Server administration scripts.
    'admin' => array(
        'file' => 'default.php',
        'regions' => $sidepreregions,
        'defaultregion' => 'side-pre',
        'options' => array('fluid'=>true),
    ),
    // My dashboard page.
    'mydashboard' => array(
        'file' => 'mydashboard.php',
        'regions' => $sidepreregions,
        'defaultregion' => 'side-pre',
        'options' => array('langmenu'=>true),
    ),
    // My public page.
    'mypublic' => array(
        'file' => 'default.php',
        'regions' => $allregions,
        'defaultregion' => 'side-pre',
    ),
    'login' => array(
        'file' => 'login.php',
        'regions' => array(),
        'options' => array('langmenu'=>true, 'nonavbar'=>true),
    ),

    // Pages that appear in pop-up windows - no navigation, no blocks, no header.
    'popup' => array(
        'file' => 'popup.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true),
    ),
    // No blocks and minimal footer - used for legacy frame layouts only!
    'frametop' => array(
        'file' => 'default.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nocoursefooter'=>true),
    ),
    // Embeded pages, like iframe/object embeded in moodleform - it needs as much space as possible.
    'embedded' => array(
        'file' => 'embedded.php',
        'regions' => array()
    ),
    // Used during upgrade and install, and for the 'This site is undergoing maintenance' message.
    // This must not have any blocks, links, or API calls that would lead to database or cache interaction.
    // Please be extremely careful if you are modifying this layout.
    'maintenance' => array(
        'file' => 'maintenance.php',
        'regions' => array(),
    ),
    // Should display the content and basic headers only.
    'print' => array(
        'file' => 'default.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>false),
    ),
    // The pagelayout used when a redirection is occuring.
    'redirect' => array(
        'file' => 'embedded.php',
        'regions' => array(),
    ),
    // The pagelayout used for reports.
    'report' => array(
        'file' => 'default.php',
        'regions' => $bottomregions,
        'defaultregion' => 'page-bottom',
        'options' => array('fluid'=>true),
    ),
    // The pagelayout used for safebrowser and securewindow.
    'secure' => array(
        'file' => 'secure.php',
        'regions' => $allregions,
        'defaultregion' => 'side-pre'
    ),
    // The shoehorn custom page layout.  Not listed on: http://docs.moodle.org/dev/Themes_overview.
    'page' => array(
        'file' => 'page.php',
        'regions' => $sidepreregions,
        'defaultregion' => 'side-pre'
    ),
);

$THEME->rendererfactory = 'theme_overridden_renderer_factory';

$THEME->csspostprocess = 'theme_shoehorn_process_css';

$THEME->blockrtlmanipulations = array(
    'side-pre' => 'side-post',
    'side-post' => 'side-pre',
    'side-footer-pre' => 'side-footer-post',
    'side-footer-post' => 'side-footer-pre'
);
