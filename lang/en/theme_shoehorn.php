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

// Regions....
$string['region-side-post'] = 'Right';
$string['region-side-pre'] = 'Left';
$string['region-page-bottom'] = 'Page bottom';
$string['region-footer-pre'] = 'Footer left';
$string['region-footer-post'] = 'Footer right';

// Course single section page.
$string['editonmainpage'] = 'Please edit on the main course page';
$string['nosectionstoshow'] = 'No sections to show';

// Settings.
$string['generalsettings'] = 'General';

$string['cdnfonts'] = 'Content delivery network fonts where possible';
$string['cdnfonts_desc'] = 'Use content delivery network fonts where possible.  Thus being a CDN source available.';

$string['fonticons'] = 'Use icon font';
$string['fonticons_desc'] = 'Enable this option to use the Glyphicon icon font.';

$string['invert'] = 'Invert navbar';
$string['invert_desc'] = 'Swaps text and background for the navbar at the top of the page.';

$string['showloginmessage'] = 'Display login message';
$string['showloginmessage_desc'] = "Display a brief login message just below the 'Log in' title.  This is not meant to replace the '";
$string['showloginmessage_urlname'] = 'login instructions';
$string['showloginmessage_urllink'] = 'http://docs.moodle.org/26/en/admin/setting/manageauths#Instructions';
$string['loginmessage'] = 'The login message';
$string['loginmessage_desc'] = "The brief login message to show.  Leave blank to use the 'theloginmessage' language string contained in the language file.  Where you can make use of Moodle multi-language functionality.";  // Below!
$string['loginmessage'] = 'The login message';
$string['theloginmessage'] = 'Login here using your username and password';

$string['logo'] = 'Logo';
$string['logo_desc'] = 'Please upload your custom logo here if you want to add it to the header.<br>
If the height of your logo is more than 75px add the following CSS rule to the Custom CSS box below.<br>
a.logo {height: 100px;} or whatever height in pixels the logo is.';

// Page bottom region.
$string['numpagebottomblocks'] = 'Maximum number of blocks per row in the page bottom';
$string['numpagebottomblocks_desc'] = 'The maximum blocks per row in the page bottom.';

$string['one'] = 'One';
$string['two'] = 'Two';
$string['three'] = 'Three';
$string['four'] = 'Four';

// Footer menu.
$string['footermenu'] = 'Footer menu';
$string['footermenu_desc'] = 'Zero or more lines representing the links to place in the footer menu.<br>
Form of name|url|title|lang where title and lang are optional.<br>
The title being the text that is shown when the link is hovered over.<br>
The lang being to only show in this language.<br>
For example:<br>
About|http://mymoodle/about.html|About my site<br>
Anleitung|http://mymoodle/anleitung.html|Wie man mit dieser Website verwenden.|de<br>
Home|//mymoodle/index.php';

// Copyright text.
$string['copyright'] = 'Copyright';
$string['copyright_desc'] = 'Copyright statement, leave blank for none.';

// Custom css.
$string['customcss'] = 'Custom CSS';
$string['customcss_desc'] = 'Whatever CSS rules you add to this textarea will be reflected in every page, making for easier customization of this theme.';

// Headings
$string['loginpage']= 'Login page';
$string['loginpage_desc']= 'Login page settings.';
$string['othersettingpagesconfiguration'] = 'Other setting pages configuration';
$string['othersettingpagesconfiguration_desc'] = 'Change these settings to alter the quantitites for the settings pages they represent.  Setting to zero will hide the page.';

// Marketing spots.
$string['numberofmarketingspots'] = 'Number of marketing spots';
$string['numberofmarketingspots_desc'] = 'Number of marketing spots you want to add.';
$string['marketingspotsheading'] = 'Marketing spots';
$string['marketingspotsheadingsub'] = 'Advertise your site with marketing spots';
$string['marketingspotsheadingdesc'] = "To change the number of marketing spots go to the 'General' settings page for the theme.";
$string['marketingspotsdisplay'] = 'Display marketing spots';
$string['marketingspotsdisplay_desc'] = 'When to display marketing spots.';
$string['marketingspotsdisplaynever'] = 'Never';
$string['marketingspotsdisplayloggedout'] = 'Logged out';
$string['marketingspotsdisplaylogdedin'] = 'Logged in';
$string['marketingspotsdisplayalways'] = 'Always';
$string['marketingspotheading'] = 'Marketing spot heading ';
$string['marketingspotheading_desc'] = 'Marketing spot heading number ';
$string['marketingspotcontent'] = 'Marketing spot content ';
$string['marketingspotcontent_desc'] = 'Marketing spot content number ';
$string['marketingspotlang'] = 'Marketing spot language ';
$string['marketingspotlang_desc'] = 'Marketing spot language number ';
$string['marketingspotlang_desc2'] = ".  Enter language pack code for an installed language pack, the text within the brackets on '";
$string['marketingspotlang_desc3'] = "'.  Leave blank for all languages.";
$string['marketingspotlang_urlname'] = 'Language packs';
$string['marketingspotlang_urllink'] = '/admin/tool/langimport/index.php';

// Site pages.
$string['numberofsitepages'] = 'Number of site pages';
$string['numberofsitepages_desc'] = 'Number of site pages you want to add.  A link will automatically be added to the footer menu.';
$string['sitepagesheading'] = 'Site pages';
$string['sitepagesheadingsub'] = 'Describe your site with site pages';
$string['sitepagesheadingdesc'] = "To change the number of site pages go to the 'General' settings page for the theme.";
$string['sitepagetitle'] = 'Site page title ';
$string['sitepagetitle_desc'] = 'Site page title number ';
$string['sitepageheading'] = 'Site page heading ';
$string['sitepageheading_desc'] = 'Site page heading number ';
$string['sitepagecontent'] = 'Site page content ';
$string['sitepagecontent_desc'] = 'Site page content number ';
$string['sitepagelang'] = 'Site page language ';
$string['sitepagelang_desc'] = 'Site page language number ';
$string['sitepagelang_desc2'] = ".  Enter language pack code for an installed language pack, the text within the brackets on '";
$string['sitepagelang_desc3'] = "'.  Leave blank for all languages.";
$string['sitepagelang_urlname'] = 'Language packs';
$string['sitepagelang_urllink'] = '/admin/tool/langimport/index.php';

$string['unknownsitepage'] = 'Unknown site page number ';
$string['unknownsitepagecontent1'] = 'Site page number ';
$string['unknownsitepagecontent2'] = ' is not known, ask an an administrator to check the settings for the theme.';
$string['pagenotforlanguagetitle1'] = 'Site page number ';
$string['pagenotforlanguagetitle2'] = ' not for language';
$string['pagenotforlanguagecontent1'] = 'Site page number ';
$string['pagenotforlanguagecontent2'] = ' has not been set for the current language, ask an an administrator to check the settings for the theme.';

// Slider settings.
$string['frontpageslidermobile'] = 'Display front page slider on mobile';
$string['frontpageslidermobile_desc'] = 'Display the front page slider on mobile devices.';
$string['frontpageslidertablet'] = 'Display front page slider on tablet';
$string['frontpageslidertablet_desc'] = 'Display the front page slider on tablet devices.';
$string['frontpagenumberofslides'] = 'Number of front page slides';
$string['frontpagenumberofslides_desc'] = 'Number of slides on the front page slider.';
$string['frontpagesliderheading'] = 'Front page slider';
$string['frontpagesliderheadingsub'] = 'Present your portfolio with slides on the front page';
$string['frontpagesliderheadingdesc'] = "Present your portfolio with slides containing an image, URL and text.  To change the number of marketing spots go to the 'General' settings page for the theme.";
$string['frontpageslideimage'] = 'Image for slide ';
$string['frontpageslideimage_desc'] = 'The image for slide ';
$string['frontpageslideurl'] = 'URL for slide ';
$string['frontpageslideurl_desc'] = 'The URL for slide ';
$string['frontpageslidecaptiontitle'] = 'Caption title for slide ';
$string['frontpageslidecaptiontitle_desc'] = 'The caption title for slide ';
$string['frontpageslidecaptiontext'] = 'Caption text for slide ';
$string['frontpageslidecaptiontext_desc'] = 'The caption text for slide ';

// Social links settings.
$string['numberofsociallinks'] = 'Number of social network links';
$string['numberofsociallinks_desc'] = 'Number of social network links you want to add.';
$string['socialheading'] = 'Social networking';
$string['socialheadingsub'] = 'Gather followers with social networking';
$string['socialheadingdesc'] = 'Provide direct links to your social networks.';
$string['socialnetworklink'] = 'Social network link ';
$string['socialnetworklink_desc'] = 'Social network link number ';
$string['socialnetworkicon'] = 'Social network icon ';
$string['socialnetworkicon_desc'] = 'Social network icon number ';
