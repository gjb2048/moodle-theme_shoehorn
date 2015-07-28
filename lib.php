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
 * @copyright  &copy; 2014-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function theme_shoehorn_process_css($css, $theme) {
    // Set the background image for the logo.
    $logo = $theme->setting_file_url('logo', 'logo');
    $css = theme_shoehorn_set_setting($css, '[[setting:logo]]', $logo);

    // Show login message if desired.
    $css = theme_shoehorn_set_loginmessage($css, $theme);

    // Process look and feel.
    $css = theme_shoehorn_set_landf($css, $theme);

    // Set custom CSS.
    if (!empty($theme->settings->customcss)) {
        $customcss = $theme->settings->customcss;
    } else {
        $customcss = null;
    }
    $css = theme_shoehorn_set_setting($css, '[[setting:customcss]]', $customcss);

    return $css;
}

function theme_shoehorn_set_setting($css, $tag, $replacement) {
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

function theme_shoehorn_set_loginmessage($css, $theme) {
    $tag = '[[setting:theloginmessge]]';

    if ((!empty($theme->settings->showloginmessage)) && ($theme->settings->showloginmessage == 2)) {
        $content = "content: '";
        if (!empty($theme->settings->loginmessage)) {
            $replacement = $content.$theme->settings->loginmessage."';";
        } else {
            $replacement = $content.get_string('theloginmessage', 'theme_shoehorn')."';";
        }
    } else {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

function theme_shoehorn_set_landf($css, $theme) {

    // All pages image.
    $tag = '[[setting:landfallpagesbackgroundimage]]';
    $landfallpagesbackgroundimage = $theme->setting_file_url('landfallpagesbackgroundimage', 'landfallpagesbackgroundimage');
    if ($landfallpagesbackgroundimage) {
        $replacement = 'background:  url(\''.$landfallpagesbackgroundimage.'\') repeat; margin-bottom: -26px;';
    } else {
        $replacement = '';
    }
    $css = str_replace($tag, $replacement, $css);

    // All pages transparency.
    $tag = '[[setting:landfallpagescontenttransparency]]';
    $tagmain = '[[setting:landfallpagescontenttransparencymain]]';

    $replacement = 'background-color: rgba(255, 255, 255, ';
    /* http://css-tricks.com/css-transparency-settings-for-all-broswers/ */
    $replacementmain = 'zoom: 1; filter: alpha(opacity=';
    if (!empty($theme->settings->landfallpagescontenttransparency)) {
        $allpages = round($theme->settings->landfallpagescontenttransparency, 2);
        $replacement .= $allpages / 100;
        $replacementmain .= $allpages;
        $replacementmain .= '); opacity: ';
        $replacementmain .= $allpages / 100;
    } else {
        $replacementmain .= '100); opacity: 1.0';
        $replacement = '1.0';
    }
    $replacement .= ');';
    $replacementmain .= ';';

    $css = str_replace($tag, $replacement, $css);
    $css = str_replace($tagmain, $replacementmain, $css);

    // Front page image.
    $tag = '[[setting:landffrontpagebackgroundimage]]';
    $landffrontpagebackgroundimage = $theme->setting_file_url('landffrontpagebackgroundimage', 'landffrontpagebackgroundimage');
    if ($landffrontpagebackgroundimage) {
        $replacement = 'background:  url(\''.$landffrontpagebackgroundimage.'\') repeat; margin-bottom: -26px;';
    } else {
        $replacement = '';
    }
    $css = str_replace($tag, $replacement, $css);

    // Front page transparency.
    $tag = '[[setting:landffrontpagecontenttransparency]]';
    $tagmain = '[[setting:landffrontpagecontenttransparencymain]]';

    $replacement = 'background-color: rgba(255, 255, 255, ';
    /* http://css-tricks.com/css-transparency-settings-for-all-broswers/ */
    $replacementmain = 'zoom: 1; filter: alpha(opacity=';
    if (!empty($theme->settings->landffrontpagecontenttransparency)) {
        $frontpage = round($theme->settings->landffrontpagecontenttransparency, 2);
        $replacement .= $frontpage / 100;
        $replacementmain .= $frontpage;
        $replacementmain .= '); opacity: ';
        $replacementmain .= $frontpage / 100;
    } else {
        $replacementmain .= '100); opacity: 1.0';
        $replacement = '1.0';
    }
    $replacement .= ');';
    $replacementmain .= ';';

    $css = str_replace($tag, $replacement, $css);
    $css = str_replace($tagmain, $replacementmain, $css);

    return $css;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_shoehorn_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    static $theme;
    if (empty($theme)) {
        $theme = theme_config::load('shoehorn');
    }

    if ($context->contextlevel == CONTEXT_SYSTEM) {
        if ($filearea === 'logo') {
            return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
        } else if (substr($filearea, 0, 19) === 'frontpageslideimage') {
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else if (substr($filearea, 0, 14) === 'imagebankimage') {
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else if (substr($filearea, 0, 27) === 'loginbackgroundchangerimage') {
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else if ($filearea === 'syntaxhighlighter') {
            theme_shoehorn_serve_syntaxhighlighter($args[1]);
        } else if ($filearea === 'landffrontpagebackgroundimage') {
            return $theme->setting_file_serve('landffrontpagebackgroundimage', $args, $forcedownload, $options);
        } else if ($filearea === 'landfallpagesbackgroundimage') {
            return $theme->setting_file_serve('landfallpagesbackgroundimage', $args, $forcedownload, $options);
        } else {
            send_file_not_found();
        }
    } else {
        send_file_not_found();
    }
}

function theme_shoehorn_serve_syntaxhighlighter($filename) {
    global $CFG;
    if (file_exists("{$CFG->dirroot}/theme/shoehorn/javascript/syntaxhighlighter_3_0_83/scripts/")) {
        $thesyntaxhighlighterpath = $CFG->dirroot . '/theme/shoehorn/javascript/syntaxhighlighter_3_0_83/scripts/';
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/shoehorn/javascript/syntaxhighlighter_3_0_83/scripts/")) {
        $thesyntaxhighlighterpath = $CFG->themedir . '/shoehorn/javascript/syntaxhighlighter_3_0_83/scripts/';
    } else {
        header('HTTP/1.0 404 Not Found');
        die('Shoehorn syntax highlighter scripts folder not found, check $CFG->themedir is correct.');
    }
    $thefile = $thesyntaxhighlighterpath . $filename;

    /* http://css-tricks.com/snippets/php/intelligent-php-cache-control/ - rather than /lib/csslib.php as it is a static file who's
      contents should only change if it is rebuilt.  But! There should be no difference with TDM on so will see for the moment if
      that decision is a factor. */

    $etagfile = md5_file($thefile);
    // File.
    $lastmodified = filemtime($thefile);
    // Header.
    $ifmodifiedsince = (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
    $etagheader = (isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);

    if ((($ifmodifiedsince) && (strtotime($ifmodifiedsince) == $lastmodified)) || $etagheader == $etagfile) {
        theme_shoehorn_send_unmodified($lastmodified, $etagfile, 'application/javascript');
    }
    theme_shoehorn_send_cached($thesyntaxhighlighterpath, $filename, $lastmodified, $etagfile, 'application/javascript');
}

function theme_shoehorn_send_unmodified($lastmodified, $etag, $contenttype) {
    $lifetime = 60 * 60 * 24 * 60;
    header('HTTP/1.1 304 Not Modified');
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $lifetime) . ' GMT');
    header('Cache-Control: public, max-age=' . $lifetime);
    header('Content-Type: '.$contenttype.'; charset=utf-8');
    header('Etag: "' . $etag . '"');
    if ($lastmodified) {
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastmodified) . ' GMT');
    }
    die;
}

function theme_shoehorn_send_cached($path, $filename, $lastmodified, $etag, $contenttype) {
    global $CFG;
    require_once($CFG->dirroot . '/lib/configonlylib.php'); // For min_enable_zlib_compression().
    // 60 days only - the revision may get incremented quite often.
    $lifetime = 60 * 60 * 24 * 60;

    header('Etag: "' . $etag . '"');
    header('Content-Disposition: inline; filename="'.$filename.'"');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastmodified) . ' GMT');
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $lifetime) . ' GMT');
    header('Pragma: ');
    header('Cache-Control: public, max-age=' . $lifetime);
    header('Accept-Ranges: none');
    header('Content-Type: '.$contenttype.'; charset=utf-8');
    if (!min_enable_zlib_compression()) {
        header('Content-Length: ' . filesize($path . $filename));
    }

    readfile($path . $filename);
    die;
}
