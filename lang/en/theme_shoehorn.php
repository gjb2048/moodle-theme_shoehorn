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

$string['fontawesome'] = 'Use the FontAwesome icon font';
$string['fontawesome_desc'] = 'Enable this option to use the FontAwesome icon font.';

$string['docking'] = 'Use docking';
$string['docking_desc'] = 'Enable this option to use docking.';

$string['accordion'] = 'Use accordion block side regions';
$string['accordion_desc'] = 'Enable this option to use accordion functionality for the side regions.  Note: Disables docking.';

$string['compactnavbar'] = 'Compact navbar';
$string['compactnavbar_desc'] = 'Compact navigation bar.';
$string['navbarfixedtop'] = 'Navbar fixed top';
$string['navbarfixedtop_desc'] = 'Fix the navigation bar at the top of the page.';
$string['inversenavbar'] = 'Inverse navbar';
$string['inversenavbar_desc'] = 'Swaps text and background for the navigation bar at the top of the page.';

$string['showloginmessage'] = 'Display login message';
$string['showloginmessage_desc'] = "Display a brief login message just below the 'Log in' title.  This is not meant to replace the '";
$string['showloginmessage_urlname'] = 'login instructions';
$string['showloginmessage_urllink'] = 'http://docs.moodle.org/27/en/admin/setting/manageauths#Instructions';

$string['showoldmessages'] = 'Show old messages';
$string['showoldmessagesdesc'] = 'Show old messages on the message menu.';

$string['logo'] = 'Logo';
$string['logo_desc'] = 'Please upload your custom logo here if you want to add it to the header.<br>
The image will be scaled and responsive to fit the allocated space given to it by the Bootstrap styles in the<br>
\'page_heading()\' method of \'core_renderer.php\'.  If you want to make the space bigger, then adapt that code.';

$string['langpack_urlname'] = 'Language packs';

// Navbar.
$string['togglenavigation'] = 'Toggle navigation';
$string['gotobottom'] = 'Go to the bottom of the page';

// Messages.
$string['unreadnewnotification'] = 'New notification';

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

// Anti-gravity.
$string['antigravity'] = 'Back to top';

// FitVids.
$string['fitvids'] = 'Use FitVids';
$string['fitvidsdesc'] = 'Enable FitVids (fitvidsjs.com) to make your embedded videos responsive.  If FitVids is on and you want a video to be excluded then add \'class="fitvidsignore"\' to the \'iframe\' tag in the HTML mode of the editor.  For example: \'iframe class="fitvidsignore" width="420" height="315" src="//www.youtube.com/embed/enmEmym85xc" frameborder="0" allowfullscreen=""></iframe\'.';

// Copyright text.
$string['copyright'] = 'Copyright';
$string['copyright_desc'] = 'Copyright statement, leave blank for none.';

// Custom css.
$string['customcss'] = 'Custom CSS';
$string['customcss_desc'] = 'Whatever CSS rules you add to this textarea will be reflected in every page, making for easier customization of this theme.';

// Login page.
$string['loginpage']= 'Login page';
$string['loginpage_desc']= 'Login page settings.';

$string['loginmessage'] = 'The login message';
$string['loginmessage_desc'] = "The brief login message to show.  Leave blank to use the 'theloginmessage' language string contained in the language file.  Where you can make use of Moodle multi-language functionality.";  // Below!
$string['loginmessage'] = 'The login message';
$string['theloginmessage'] = 'Login here using your username and password';

// Experimental settings.
$string['experimental']= 'Experimental';
$string['experimental_desc']= 'Experimental settings.';

$string['dynamiclang']= 'Dynamic LTR / RTL language';
$string['dynamiclang_desc']= 'Dynamic LTR / RTL language swapping as described on: moodle.org/mod/forum/discuss.php?d=264955.';

// Status:....
$string['draft'] = 'Draft';
$string['published'] = 'Published';

// Display:....
$string['loggedout'] = 'Logged out';
$string['loggedin'] = 'Logged in';
$string['always'] = 'Always';

// Percentages:....
$string['zeropercent'] =        '  0%';
$string['fivepercent'] =        '  5%';
$string['tenpercent'] =         ' 10%';
$string['fifteenpercent'] =    ' 15%';
$string['twentypercent'] =      ' 20%';
$string['twentyfivepercent'] =  ' 25%';
$string['thirtypercent'] =      ' 30%';
$string['thirtyfivepercent'] =  ' 35%';
$string['fortypercent'] =       ' 40%';
$string['fortyfivepercent'] =   ' 45%';
$string['fiftypercent'] =       ' 50%';
$string['fifyfivepercent'] =    ' 55%';
$string['sixtypercent'] =       ' 60%';
$string['sixtyfivepercent'] =   ' 65%';
$string['seventypercent'] =     ' 70%';
$string['seventyfivepercent'] = ' 75%';
$string['eightypercent'] =      ' 80%';
$string['eightyfivepercent'] =  ' 85%';
$string['ninetypercent'] =      ' 90%';
$string['ninetyfivepercent'] =  ' 95%';
$string['onehundredpercent'] =  '100%';

// Display My Courses Menu:....
$string['displaymycoursesmenu'] = 'Display my courses menu';
$string['displaymycoursesmenu_desc'] = 'Display the my courses menu on the navigation bar with the given title.';
$string['myclasses'] = 'My classes';
$string['mycourses'] = 'My courses';
$string['mymodules'] = 'My modules';
$string['mysubjects'] = 'My subjects';
$string['myunits'] = 'My units';
$string['noenrolments'] = 'No current enrolments';

// My dashboard page.
$string['enter'] = 'Enter';
$string['displaymycourses'] = 'Display my courses';
$string['displaymycourses_desc'] = 'Display your courses on the \'My home\' page.';

// This course menu.
$string['thiscourse'] = 'This course';
$string['people'] = 'People';

// Course tiles.
$string['coursetiles'] = 'Use course tiles';
$string['coursetiles_desc'] = 'Use course tiles for activities and resources.';

// Accordion block regions.
$string['blocktitleunknown'] = 'Block title unknown';

// Front page slider settings.
$string['frontpagesliderheading'] = 'Front page slider';
$string['frontpagesliderheadingsub'] = 'Present your portfolio with slides on the front page';
$string['frontpagesliderheadingdesc'] = "Present your portfolio with slides containing an image, URL and text.  To change the number of slides change the 'Number of front page slides' below and save the page to update.  The best height for an image is 500px as this is the maximum space at greater than 1200px wide window resolution.  The dimensions are then calculated based on the available space and image ratio.";
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

// Login page background image changer.
$string['loginbackgroundchangerheading'] = 'Login page background image changer';
$string['loginbackgroundchangerheadingsub'] = 'Make your login page different with changing background images.';
$string['loginbackgroundchangerheadingdesc'] = "To change the number of images change the 'Number of images' below and save the page to update.";
$string['loginbackgroundchangerspeed'] = 'Set the image transition speed in ms';
$string['loginbackgroundchangerspeed_desc'] = 'Set the image transition speed in milliseconds.';
$string['loginbackgroundchangerfade'] = 'Set the image transition fade in ms';
$string['loginbackgroundchangerfade_desc'] = 'Set the image transition fade in milliseconds.';
$string['loginbackgroundchangermobile'] = 'Display background image changer on mobile';
$string['loginbackgroundchangermobile_desc'] = 'Display the background image changer on mobile devices.';
$string['loginbackgroundchangertablet'] = 'Display background image changer on tablet';
$string['loginbackgroundchangertablet_desc'] = 'Display the background image changer on tablet devices.';
$string['loginbackgroundchangernumberofimages'] = 'Number of images';
$string['loginbackgroundchangernumberofimages_desc'] = 'Number of images on the background image changer.';
$string['loginbackgroundchangerimage'] = 'Image {$a->image}';
$string['loginbackgroundchangerimage_desc'] = 'The image {$a->image}';

// Look and feel settings.
$string['landfheading'] = 'Look and feel settings';
$string['landfheadingsub'] = 'Change various aspects with these look and feel settings';
$string['landfheadingdesc'] = 'Change various aspects of the look and feel with these settings.';
$string['landffontpage'] = 'Front page';
$string['landffontpage_desc'] = 'Front page look and feel settings.';
$string['landffrontpagebackgroundimage'] = 'Front page background image';
$string['landffrontpagebackgroundimage_desc'] = 'Set the front page background image.';
$string['landffrontpagecontenttransparency'] = 'Front page content transparency';
$string['landffrontpagecontenttransparency_desc'] = 'Set the front page content transparency.';
$string['landfallpages'] = 'All pages';
$string['landfallpages_desc'] = 'All pages look and feel settings bar the front.';
$string['landfallpagesbackgroundimage'] = 'All pages background image';
$string['landfallpagesbackgroundimage_desc'] = 'Set all pages background image.';
$string['landfallpagescontenttransparency'] = 'All pages content transparency';
$string['landfallpagescontenttransparency_desc'] = 'Set all pages content transparency.';

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
$string['pagenotdisplayedcontentnotitle'] = 'Site page number {$a->pageid} has no title, ask an an administrator to check the settings for the theme.';
$string['pagenotdisplayedcontentnotpublished'] = 'Site page number {$a->pageid} has not been published, ask an an administrator to check the settings for the theme.';

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
$string['socialsignpost'] = 'Use the signpost';
$string['socialsignpost_desc'] = 'Enable this option to use the signpost to surround the social icons.';

// Syntax highlighter.
$string['syntaxsummary'] = '<pre class="sh"></pre>';
$string['syntaxhighlight'] = 'Activate syntax highlighting';
$string['syntaxhighlight_desc'] = 'Activate syntax highlighting in courses.  A help page will be added to the footer menu of courses.';
$string['syntaxhighlightpage'] = 'Syntax highlighting help';
$string['syntaxhelpone'] = 'Add the html \'{$a->html}\' to the course summary in HTML mode.';
$string['syntaxhelptwo'] = 'Then when editing (such as a label) surround your code with a \'pre\' tag and add the class="brush: alias" where \'alias\' is one of the following:';
$string['syntaxhelpthree'] = 'Brush name';
$string['syntaxhelpfour'] = 'Brush alias';
$string['syntaxhelpfive'] = 'For example:';
$string['syntaxhelpsix'] = 'becomes:';
$string['syntaxhelpseven'] = 'More information on';


// Readme.
$string['readme_title'] = 'Shoehorn read-me';
$string['readme_desc'] = 'Please click on \'{$a->url}\' for lots more information about Shoehorn.';

// IE.
$string['iewarning'] = 'Shoehorn requires Internet Explorer 10+, you are using IE{$a->ieversion}, please upgrade.';
