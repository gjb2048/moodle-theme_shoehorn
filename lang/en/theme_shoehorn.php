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
<p><img class="img-polaroid" src="shoehorn/pix/Shoehorn_logo.png" /></p>
</div>
<div class="well">
<h3>About</h3>
<div class="lead"><p>Shoehorn is a Bootstrap v3 based theme that has many innovative features:</p>
<ul>
<li>Bespoke copyright statement.</li>
<li>Bespoke login page message.</li>
<li>Dynamic and customisable footer menu.</li>
<li>Dynamic social icons sign with correct icon colours.</li>
<li>Front page slider that can be disabled on mobiles / tablets reducing bandwidth.</li>
<li>Footer blocks.</li>
<li>Image bank for storing images that you can use anywhere on the site.</li>
<li>Individual control over: front page slides, marketing spots and site pages with:</li>
<ul>
<li>\'Draft\' / \'Published\' state.</li>
<li>\'before login\', \'after login\' or \'always\' visibility.</li>
<li>Set specific language only visibility.</li>
</ul><li>Marketing spots.</li>
<li>Page bottom blocks.</li>
<li>Site pages that you can customise with your own content.</li>
<li>Slider navigation of course content with the \'One section per page\' course layout setting.</li>
</ul>
<h3>Parents</h3>
<p>This theme is based upon the Bootstrap theme, which was created for Moodle 2.6 by: Bas Brands, David Scotson and many other contributors.</p>
<h3>Theme Credits</h3>
<p>Author: G J Barnard - <a href="//about.me/gjbarnard" target="_blank">About.me</a> - <a href="//moodle.org/user/profile.php?id=442195">Moodle profile</a> - <a href="//uk.linkedin.com/in/gjbarnard">Linkedin</a></p>
<h3>Report a bug:</h3>
<p><a href="//github.com/gjb2048/moodle-theme_shoehorn/issues">Shoehorn issues.</a></p>
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

$string['inversenavbar'] = 'Inverse navbar';
$string['inversenavbar_desc'] = 'Swaps text and background for the navbar at the top of the page.';

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
If the url is prefixed with [[site]] then the site domain will be substituted, i.e. [[site]]/about.html becomes http://mymoodle/about.html or http://mymoodle/subfolder/about.html if Moodle is in a sub-folder on your domain.<br>
The title being the text that is shown when the link is hovered over.<br>
The lang being to only show in this language.<br>
For example:<br>
About|http://mywebsite/about.html|About my site<br>
About|[[site]]/about.html|About my site<br>
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

// Settings.
$string['langpack_urlname'] = 'Language packs';
// Status:....
$string['draft'] = 'Draft';
$string['published'] = 'Published';
// Display:....
$string['loggedout'] = 'Logged out';
$string['loggedin'] = 'Logged in';
$string['always'] = 'Always';

// Front page slider settings.
$string['frontpagesliderheading'] = 'Front page slider';
$string['frontpagesliderheadingsub'] = 'Present your portfolio with slides on the front page';
$string['frontpagesliderheadingdesc'] = "Present your portfolio with slides containing an image, URL and text.  To change the number of slides change the 'Number of front page slides' below and save the page to update.";
$string['frontpageslidersettingspageheading'] = 'Slide {$a->slide}';
$string['frontpagesliderspeed'] = 'Set the slider transition speed in ms';
$string['frontpagesliderspeed_desc'] = 'Set the slide transition speed in milliseconds.  Set to 0 for manual control.';
$string['frontpageslidermobile'] = 'Display front page slider on mobile';
$string['frontpageslidermobile_desc'] = 'Display the front page slider on mobile devices.';
$string['frontpageslidertablet'] = 'Display front page slider on tablet';
$string['frontpageslidertablet_desc'] = 'Display the front page slider on tablet devices.';
$string['frontpagenumberofslides'] = 'Number of front page slides';
$string['frontpagenumberofslides_desc'] = 'Number of slides on the front page slider.';
$string['frontpageslideimage'] = 'Slide {$a->slide} image';
$string['frontpageslideimage_desc'] = 'The image for slide {$a->slide}';
$string['frontpageslideurl'] = 'Slide {$a->slide} URL';
$string['frontpageslideurl_desc'] = 'The URL for slide {$a->slide}';
$string['frontpageslidecaptiontitle'] = 'Slide {$a->slide} caption title';
$string['frontpageslidecaptiontitle_desc'] = 'The caption title for slide {$a->slide}';
$string['frontpageslidecaptiontext'] = 'Slide {$a->slide} caption text';
$string['frontpageslidecaptiontext_desc'] = 'The caption text for slide {$a->slide}';
$string['frontpageslidestatus'] = 'Slide {$a->slide} status';
$string['frontpageslidestatus_desc'] = 'Set to \'Draft\' when you are creating the slide and \'Published\' when you want it to be seen taking into account the display and language settings.';
$string['frontpageslidedisplay'] = 'Slide {$a->slide} status';
$string['frontpageslidedisplay_desc'] = 'When to display slide {$a->slide}.';
$string['frontpageslidelang'] = 'Slide {$a->slide} language';
$string['frontpageslidelang_desc'] = 'Slide language number {$a->slide}.  To see more languages, install language packs on \'{$a->url}\'.  Set to \'all\' for all languages.';

// Image bank.
$string['numberofimagebankimages'] = 'Number of images in the image bank';
$string['numberofimagebankimages_desc'] = 'Number of images you want in the image bank.';
$string['imagebankheading'] = 'Image bank';
$string['imagebankheadingsub'] = 'Use images anywhere by using the image bank.';
$string['imagebankheadingdesc'] = "To change the number of available images in the image bank change the 'Number of images in the image bank' below and save the page to update.";
$string['imagebankimage'] = 'Image ';
$string['imagebankimage_desc'] = 'Image URL to copy: \'{$a->imagedesc}\' and use, i.e. insert in an HTML editor.';
$string['none'] = 'none';

// Marketing spots.
$string['numberofmarketingspots'] = 'Number of marketing spots';
$string['numberofmarketingspots_desc'] = 'Number of marketing spots you want to add.';
$string['marketingspotsheading'] = 'Marketing spots';
$string['marketingspotsheadingsub'] = 'Advertise your site with marketing spots';
$string['marketingspotsheadingdesc'] = "To change the number of marketing spots change the 'Number of marketing spots' below and save the page to update.";
$string['marketingspotsettingspageheading'] = 'Marketing spot {$a->spot}';
$string['marketingspotheading'] = 'Marketing spot {$a->spot} heading';
$string['marketingspotheading_desc'] = 'Marketing spot number {$a->spot} heading.';
$string['marketingspotcontent'] = 'Marketing spot {$a->spot} content';
$string['marketingspotcontent_desc'] = 'Marketing spot number {$a->spot} content.';
$string['marketingspotstatus'] = 'Marketing spot {$a->spot} status';
$string['marketingspotstatus_desc'] = 'Set to \'Draft\' when you are creating the spot and \'Published\' when you want it to be seen taking into account the display and language settings.';
$string['marketingspotdisplay'] = 'Marketing spot {$a->spot} status';
$string['marketingspotdisplay_desc'] = 'When to display marketing spot {$a->spot}.';
$string['marketingspotlang'] = 'Marketing spot {$a->spot} language';
$string['marketingspotlang_desc'] = 'Marketing spot language number {$a->spot}.  To see more languages, install language packs on \'{$a->url}\'.  Set to \'all\' for all languages.';

// Site pages.
$string['sitepage'] = 'Site page '; // Used in sitepage.php.
$string['numberofsitepages'] = 'Number of site pages';
$string['numberofsitepages_desc'] = 'Number of site pages you want to add.  A link will automatically be added to the footer menu.';
$string['sitepagesheading'] = 'Site pages';
$string['sitepagesheadingsub'] = 'Describe your site with site pages';
$string['sitepagesheadingdesc'] = "To change the number of site pages change the 'Number of site pages' below and save the page to update.";
$string['sitepagesettingspageheading'] = 'Site page {$a->pageid}';
$string['sitepagetitle'] = 'Site page {$a->pageid} title';
$string['sitepagetitle_desc'] = 'Site page number {$a->pageid} title';
$string['sitepageheading'] = 'Site page {$a->pageid} heading';
$string['sitepageheading_desc'] = 'Site page number {$a->pageid} heading';
$string['sitepagecontent'] = 'Site {$a->pageid} page content ';
$string['sitepagecontent_desc'] = 'Site page number {$a->pageid} content';
$string['sitepagestatus'] = 'Site page {$a->pageid} status';
$string['sitepagestatus_desc'] = 'Set to \'Draft\' when you are creating the page and \'Published\' when you want it to be seen taking into account the display and language settings.';
$string['sitepagedisplay'] = 'Site page {$a->pageid} status';
$string['sitepagedisplay_desc'] = 'When to display site page {$a->pageid}.';
$string['sitepagelang'] = 'Site page {$a->pageid} language';
$string['sitepagelang_desc'] = 'Site page language number {$a->pageid}.  To see more languages, install language packs on \'{$a->url}\'.  Set to \'all\' for all languages.';

$string['unknownsitepage'] = 'Unknown site page number ';
$string['unknownsitepagecontent'] = 'Site page number {$a->pageid} is not known, ask an an administrator to check the settings for the theme.';
$string['pagenotdisplayedtitle'] = 'Site page number {$a->pageid} not displayed';
$string['pagenotdisplayedcontent'] = 'Site page number {$a->pageid} has not been set for the current criteria, ask an an administrator to check the settings for the theme.';

// Social links settings.
$string['numberofsociallinks'] = 'Number of social network links';
$string['numberofsociallinks_desc'] = 'Number of social network links you want to add.';
$string['socialheading'] = 'Social networking';
$string['socialheadingsub'] = 'Gather followers with social networking';
$string['socialheadingdesc'] = "Provide direct links to your social networks.  To change the number of social networks change the 'Number of social network links' below and save the page to update.";
$string['socialnetworklink'] = 'Social network link ';
$string['socialnetworklink_desc'] = 'Social network link number ';
$string['socialnetworkicon'] = 'Social network icon ';
$string['socialnetworkicon_desc'] = 'Social network icon number ';
