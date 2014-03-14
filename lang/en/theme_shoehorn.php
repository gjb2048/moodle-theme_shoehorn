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
 * Strings for component 'theme_shoehorn', language 'en'.
 *
 * @package    theme
 * @subpackage shoehorn
 * @copyright  &copy; 2014-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['choosereadme'] = '
<div class="clearfix">
<div class="well">
<h2>Shoehorn</h2>
<p><img class="img-polaroid" src="shoehorn/pix/shoehorn_logo.png" /></p>
</div>
<div class="well">
<h3>About</h3>
<p>Shoelace is a modified Moodle bootstrap theme which inherits styles and renderers from its parent theme.</p>
<h3>Parents</h3>
<p>This theme is based upon the Bootstrap theme, which was created for Moodle 2.6 by:<br>
Bas Brands, David Scotson and many other contributors.</p>
<h3>Theme Credits</h3>
<p>Author: G J Barnard<br>
Contact: <a href="http://moodle.org/user/profile.php?id=442195">Moodle profile</a><br>
Website: <a href="http://about.me/gjbarnard">about.me/gjbarnard</a>
</p>
<h3>Report a bug:</h3>
<p><a href="http://tracker.moodle.org">http://tracker.moodle.org</a></p>
<h3>More information</h3>
<p><a href="shoehorn/Readme.md">How to use this theme.</a></p>
</div></div>';

$string['configtitle'] = 'Shoehorn';

$string['pluginname'] = 'Shoehorn';

$string['region-side-post'] = 'Right';
$string['region-side-pre'] = 'Left';

// Settings.
$string['generalsettings'] = 'General';

$string['cdnfonts'] = 'Content delivery network fonts';
$string['cdnfonts_desc'] = 'Use content delivery network fonts';

$string['invert'] = 'Invert navbar';
$string['invertdesc'] = 'Swaps text and background for the navbar at the top of the page.';

$string['logo'] = 'Logo';
$string['logodesc'] = 'Please upload your custom logo here if you want to add it to the header.<br>
If the height of your logo is more than 75px add the following CSS rule to the Custom CSS box below.<br>
a.logo {height: 100px;} or whatever height in pixels the logo is.';

// Footer menu.
$string['footermenu'] = 'Footer menu';
$string['footermenu_desc'] = 'Zero or more lines representing the links to place in the footer menu.<br>
Form of name|url|title|lang where title and lang are optional.<br>
The title being the text that is shown when the link is hovered over.<br>
The lang being to only show in this language.<br>
For example:<br>
About|//mymoodle/theme/shoehorn/pages/about.html|About my site<br>
Anleitung|//mymoodle/theme/shoehorn/pages/anleitung.html|Wie man mit dieser Website verwenden.|de<br>
Home|//mymoodle/index.php';

// Custom css.
$string['customcss'] = 'Custom CSS';
$string['customcss_desc'] = 'Whatever CSS rules you add to this textarea will be reflected in every page, making for easier customization of this theme.';

// Slider settings.
$string['numberofslides'] = 'Number of slides';
$string['numberofslides_desc'] = 'Number of slides on the slider.';
$string['sliderheading'] = 'Slider';
$string['sliderheadingsub'] = 'Present your portfolio with slides.';
$string['sliderdesc'] = 'Present your portfolio with slides containing an image, URL and text.';
$string['slideimage'] = 'Image for slide ';
$string['slideimage_desc'] = 'The image for slide ';
$string['slideurl'] = 'URL for slide ';
$string['slideurl_desc'] = 'The URL for slide ';
$string['slidecaptiontitle'] = 'Caption title for slide ';
$string['slidecaptiontitle_desc'] = 'The caption title for slide ';
$string['slidecaptiontext'] = 'Caption text for slide ';
$string['slidecaptiontext_desc'] = 'The caption text for slide ';

// Social links settings.
$string['numberofsociallinks'] = 'Number of social network links';
$string['numberofsociallinks_desc'] = 'Number of social network links you want to add.';
$string['socialheading'] = 'Social networking';
$string['socialheadingsub'] = 'Gather followers with social networking';
$string['socialdesc'] = 'Provide direct links to your social networks.';
$string['socialnetworklink'] = 'Social network link ';
$string['socialnetworklink_desc'] = 'Social network link number ';
$string['socialnetworkicon'] = 'Social network icon ';
$string['socialnetworkicon_desc'] = 'Social network icon number ';
