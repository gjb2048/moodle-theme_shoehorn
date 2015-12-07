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
    global $PAGE;
    $outputus = $PAGE->get_renderer('theme_shoehorn', 'core');
    \theme_shoehorn\toolbox::set_core_renderer($outputus);

    // Set the background image for the logo.
    $logo = \theme_shoehorn\toolbox::setting_file_url('logo', 'logo');
    $css = theme_shoehorn_set_setting($css, '[[setting:logo]]', $logo);

    // Set the theme font
    $headingfont = \theme_shoehorn\toolbox::get_setting('fontnameheading');
    $bodyfont = \theme_shoehorn\toolbox::get_setting('fontnamebody');

    $css = theme_shoehorn_set_font($css, 'heading', $headingfont);
    $css = theme_shoehorn_set_font($css, 'body', $bodyfont);

    // Show login message if desired.
    $css = theme_shoehorn_set_loginmessage($css);

    // Process look and feel.
    $css = theme_shoehorn_set_landf($css);

    // Colour settings.
    $footerbottomcolour = \theme_shoehorn\toolbox::get_setting('footerbottomcolour', '#267F00');
    $css = theme_shoehorn_set_setting($css, '[[setting:htmlbackground]]', $footerbottomcolour);  // Footer bottom background.
    $css = theme_shoehorn_set_setting($css, '[[setting:htmlbackgroundrgba]]', shoehorn_hex2rgba($footerbottomcolour, 0.6));

    $textcolour = \theme_shoehorn\toolbox::get_setting('textcolour', '#1F4D87');
    $css = theme_shoehorn_set_setting($css, '[[setting:textcolour]]', $textcolour);
    $css = theme_shoehorn_set_setting($css, '[[setting:textcolour8light]]', shoehorn_hexadjust($textcolour, -8));
    $css = theme_shoehorn_set_setting($css, '[[setting:textcolour10light]]', shoehorn_hexadjust($textcolour, -10));
    $css = theme_shoehorn_set_setting($css, '[[setting:textcolour5dark]]', shoehorn_hexadjust($textcolour, 5));
    $css = theme_shoehorn_set_setting($css, '[[setting:textcolour10dark]]', shoehorn_hexadjust($textcolour, 10));
    $css = theme_shoehorn_set_setting($css, '[[setting:textcolour75rgba]]', shoehorn_hex2rgba($textcolour, 0.75));

    $linkcolour = \theme_shoehorn\toolbox::get_setting('linkcolour', '#1F4D87');
    $css = theme_shoehorn_set_setting($css, '[[setting:linkcolour]]', $linkcolour);
    $css = theme_shoehorn_set_setting($css, '[[setting:linkcolour2rgba]]', shoehorn_hex2rgba($linkcolour, 0.2));
    $css = theme_shoehorn_set_setting($css, '[[setting:linkcolour4rgba]]', shoehorn_hex2rgba($linkcolour, 0.4));
    $css = theme_shoehorn_set_setting($css, '[[setting:linkcolour8rgba]]', shoehorn_hex2rgba($linkcolour, 0.8));
    $css = theme_shoehorn_set_setting($css, '[[setting:linkcolourhover]]', $linkcolour);

    $navbartextcolour = \theme_shoehorn\toolbox::get_setting('navbartextcolour', '#653CAE');
    $css = theme_shoehorn_set_setting($css, '[[setting:navbardefaultcolour]]', $navbartextcolour);
    $css = theme_shoehorn_set_setting($css, '[[setting:navbardefaultcolourlight]]', shoehorn_hexadjust($navbartextcolour, -10));

    $navbarbackgroundcolour = \theme_shoehorn\toolbox::get_setting('navbarbackgroundcolour', '#FFD974');
    $css = theme_shoehorn_set_setting($css, '[[setting:navbardefaultbackground]]', $navbarbackgroundcolour);
    $css = theme_shoehorn_set_setting($css, '[[setting:navbardefaultbackgroundrgba]]', shoehorn_hex2rgba($navbarbackgroundcolour, 0.75));
    $css = theme_shoehorn_set_setting($css, '[[setting:navbardefaultbackground8rgba]]', shoehorn_hex2rgba($navbarbackgroundcolour, 0.8));

    $navbarbordercolour = \theme_shoehorn\toolbox::get_setting('navbarbordercolour', '#FFD053');
    $css = theme_shoehorn_set_setting($css, '[[setting:navbardefaultborder]]', $navbarbordercolour);
    $css = theme_shoehorn_set_setting($css, '[[setting:navbardefaultborderrgba]]', shoehorn_hex2rgba($navbarbordercolour, 0.75));
    $css = theme_shoehorn_set_setting($css, '[[setting:navbardefaulthover]]', $navbarbordercolour);
    $css = theme_shoehorn_set_setting($css, '[[setting:navbardefaulthoverrgba]]', shoehorn_hex2rgba($navbarbordercolour, 0.75));

    $pagetopcolour = \theme_shoehorn\toolbox::get_setting('pagetopcolour', '#1F4D87');
    $css = theme_shoehorn_set_setting($css, '[[setting:pagetopbackground]]', $pagetopcolour);
    $css = theme_shoehorn_set_setting($css, '[[setting:pagetopbackgroundrgba]]', shoehorn_hex2rgba($pagetopcolour, 1));
    $css = theme_shoehorn_set_setting($css, '[[setting:pagetopbackground90rgba]]', shoehorn_hex2rgba($pagetopcolour, .9));

    $pagebottomcolour = \theme_shoehorn\toolbox::get_setting('pagebottomcolour', '#C9E6FF');
    $css = theme_shoehorn_set_setting($css, '[[setting:pagebottombackground]]', $pagebottomcolour);
    $css = theme_shoehorn_set_setting($css, '[[setting:pagebottombackgroundrgba]]', shoehorn_hex2rgba($pagebottomcolour, 1));
    $css = theme_shoehorn_set_setting($css, '[[setting:pagebottombackground5rgba]]', shoehorn_hex2rgba($pagebottomcolour, 0.5));
    $css = theme_shoehorn_set_setting($css, '[[setting:pagebottombackground6rgba]]', shoehorn_hex2rgba($pagebottomcolour, 0.6));
    $css = theme_shoehorn_set_setting($css, '[[setting:pagebottombackground65rgba]]', shoehorn_hex2rgba($pagebottomcolour, 0.65));
    $css = theme_shoehorn_set_setting($css, '[[setting:pagebottombackground7rgba]]', shoehorn_hex2rgba($pagebottomcolour, 0.7));
    $css = theme_shoehorn_set_setting($css, '[[setting:pagebottombackground95rgba]]', shoehorn_hex2rgba($pagebottomcolour, 0.95));

    $pagebottombackgroundlight = shoehorn_hexadjust($pagebottomcolour, -5);
    $css = theme_shoehorn_set_setting($css, '[[setting:pagebottombackgroundlight]]', $pagebottombackgroundlight);
    $css = theme_shoehorn_set_setting($css, '[[setting:pagebottombackgroundlight4rgba]]', shoehorn_hex2rgba($pagebottombackgroundlight, 0.4));
    $css = theme_shoehorn_set_setting($css, '[[setting:pagebottombackgroundlight75rgba]]', shoehorn_hex2rgba($pagebottombackgroundlight, 0.75));
    $css = theme_shoehorn_set_setting($css, '[[setting:pagebottombackgroundlight2light]]', shoehorn_hexadjust($pagebottombackgroundlight, -2));
    $css = theme_shoehorn_set_setting($css, '[[setting:pagebottombackgroundlight5dark]]', shoehorn_hexadjust($pagebottombackgroundlight, 5));
    $css = theme_shoehorn_set_setting($css, '[[setting:pagebottombackgroundlight10dark]]', shoehorn_hexadjust($pagebottombackgroundlight, 10));
    $css = theme_shoehorn_set_setting($css, '[[setting:pagebottombackgrounddark]]', shoehorn_hexadjust($pagebottomcolour, 5));
    $css = theme_shoehorn_set_setting($css, '[[setting:pagebottombackgroundlighthover]]', shoehorn_hexadjust($pagebottombackgroundlight, -2));

    $footertextcolour = \theme_shoehorn\toolbox::get_setting('footertextcolour', '#B8D2E9');
    $css = theme_shoehorn_set_setting($css, '[[setting:footertextcolour]]', $footertextcolour);
    $css = theme_shoehorn_set_setting($css, '[[setting:footertextcolourlight]]', shoehorn_hexadjust($footertextcolour, -10));

    $footertopcolour = \theme_shoehorn\toolbox::get_setting('footertopcolour', '#269F00');
    $css = theme_shoehorn_set_setting($css, '[[setting:footertopbackgroundrgba]]', shoehorn_hex2rgba($footertopcolour, 0.5));
    $css = theme_shoehorn_set_setting($css, '[[setting:footerbottombackground]]', $footerbottomcolour);
    $css = theme_shoehorn_set_setting($css, '[[setting:footerbottombackgroundrgba]]', shoehorn_hex2rgba($footerbottomcolour, 0.5));

    $footertopbackgroundlight = shoehorn_hexadjust($footertopcolour, 20);
    $css = theme_shoehorn_set_setting($css, '[[setting:footertopbackgroundlight]]', $footertopbackgroundlight);
    $css = theme_shoehorn_set_setting($css, '[[setting:footertopbackgroundlightrgba]]', shoehorn_hex2rgba($footertopbackgroundlight, 0.25));

    // Set custom CSS.
    if (!empty(\theme_shoehorn\toolbox::get_setting('customcss'))) {
        $customcss = \theme_shoehorn\toolbox::get_setting('customcss');
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

function theme_shoehorn_set_font($css, $type, $fontname) {
    $familytag = '[[setting:' . $type .'font]]';
    $facetag = '[[setting:fontfiles' . $type . ']]';
    if (empty($fontname)) {
        $familyreplacement = '';
        $facereplacement = '';
    } else {

        $fontfiles = array();
        $fontfileeot = \theme_shoehorn\toolbox::setting_file_url('fontfileeot' . $type, 'fontfileeot' . $type);
        if (!empty($fontfileeot)) {
            $fontfiles[] = "url('" . $fontfileeot . "?#iefix') format('embedded-opentype')";
        }
        $fontfilewoff = \theme_shoehorn\toolbox::setting_file_url('fontfilewoff' . $type, 'fontfilewoff' . $type);
        if (!empty($fontfilewoff)) {
            $fontfiles[] = "url('" . $fontfilewoff . "') format('woff')";
        }
        $fontfilewofftwo = \theme_shoehorn\toolbox::setting_file_url('fontfilewofftwo' . $type, 'fontfilewofftwo' . $type);
        if (!empty($fontfilewofftwo)) {
            $fontfiles[] = "url('" . $fontfilewofftwo . "') format('woff2')";
        }
        $fontfileotf = \theme_shoehorn\toolbox::setting_file_url('fontfileotf' . $type, 'fontfileotf' . $type);
        if (!empty($fontfileotf)) {
            $fontfiles[] = "url('" . $fontfileotf . "') format('opentype')";
        }
        $fontfilettf = \theme_shoehorn\toolbox::setting_file_url('fontfilettf' . $type, 'fontfilettf' . $type);
        if (!empty($fontfilettf)) {
            $fontfiles[] = "url('" . $fontfilettf . "') format('truetype')";
        }
        $fontfilesvg = \theme_shoehorn\toolbox::setting_file_url('fontfilesvg' . $type, 'fontfilesvg' . $type);
        if (!empty($fontfilesvg)) {
            $fontfiles[] = "url('" . $fontfilesvg . "') format('svg')";
        }

        if (!empty($fontfiles)) {
            $familyreplacement = '"'.$fontname.'",';
            $facereplacement = '@font-face {' . PHP_EOL . 'font-family: "' . $fontname . '";' . PHP_EOL;
            $facereplacement .= !empty($fontfileeot) ? "src: url('" . $fontfileeot . "');" . PHP_EOL : '';
            $facereplacement .= "src: ";
            $facereplacement .= implode("," . PHP_EOL . " ", $fontfiles);
            $facereplacement .= ";";
            $facereplacement .= '' . PHP_EOL . "}";
        } else {
            // No files no point.
            $familyreplacement = '';
            $facereplacement = '';
        }
    }

    $css = str_replace($familytag, $familyreplacement, $css);
    $css = str_replace($facetag, $facereplacement, $css);

    return $css;
}

function theme_shoehorn_set_loginmessage($css) {
    $tag = '[[setting:theloginmessge]]';

    if (\theme_shoehorn\toolbox::get_setting('showloginmessage') == 2) {
        $content = "content: '";
        if (!empty(\theme_shoehorn\toolbox::get_setting('loginmessage'))) {
            $replacement = $content.\theme_shoehorn\toolbox::get_setting('loginmessage')."';";
        } else {
            $replacement = $content.get_string('theloginmessage', 'theme_shoehorn')."';";
        }
    } else {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

function theme_shoehorn_set_landf($css) {

    // All pages image.
    $tag = '[[setting:landfallpagesbackgroundimage]]';
    $landfallpagesbackgroundimage = \theme_shoehorn\toolbox::setting_file_url('landfallpagesbackgroundimage', 'landfallpagesbackgroundimage');
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
    if (!empty(\theme_shoehorn\toolbox::get_setting('landfallpagescontenttransparency'))){
        $allpages = round(\theme_shoehorn\toolbox::get_setting('landfallpagescontenttransparency'), 2);
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
    $landffrontpagebackgroundimage = \theme_shoehorn\toolbox::setting_file_url('landffrontpagebackgroundimage', 'landffrontpagebackgroundimage');
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
    if (!empty(\theme_shoehorn\toolbox::get_setting('landffrontpagecontenttransparency'))) {
        $frontpage = round(\theme_shoehorn\toolbox::get_setting('landffrontpagecontenttransparency'), 2);
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
        } else if (preg_match("/^fontfile(eot|otf|svg|ttf|woff|woff2)(heading|body)$/", $filearea)) { // http://www.regexr.com/.
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
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

/**
 * Returns the RGB for the given hex.
 *
 * @param string $hex
 * @return array
 */
function shoehorn_hex2rgb($hex) {
    // From: http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/.
    $hex = str_replace("#", "", $hex);

    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    $rgb = array('r' => $r, 'g' => $g, 'b' => $b);
    return $rgb; // Returns the rgb as an array.
}

function shoehorn_hexadjust($hex, $percentage) {
    $percentage = round($percentage / 100, 2);
    $rgb = shoehorn_hex2rgb($hex);
    $r = round($rgb['r'] - ($rgb['r'] * $percentage));
    $g = round($rgb['g'] - ($rgb['g'] * $percentage));
    $b = round($rgb['b'] - ($rgb['b'] * $percentage));

    return '#'.str_pad(dechex(max(0, min(255, $r))), 2, '0', STR_PAD_LEFT)
              .str_pad(dechex(max(0, min(255, $g))), 2, '0', STR_PAD_LEFT)
              .str_pad(dechex(max(0, min(255, $b))), 2, '0', STR_PAD_LEFT);
}

/**
 * Returns the RGBA for the given hex and alpha.
 *
 * @param string $hex
 * @param double $alpha
 * @return string
 */
function shoehorn_hex2rgba($hex, $alpha) {
    $rgba = shoehorn_hex2rgb($hex);
    $rgba[] = $alpha;
    return 'rgba('.implode(", ", $rgba).')'; // Returns the rgba values separated by commas.
}
