Introduction
============
Shoehorn theme.

![image1](pix/screenshot.png "Shoehorn screenshot")

About
=====
![image2](pix/Shoehorn_logo_sm.png "Shoehorn logo")
 * copyright  &copy; 2014-onwards G J Barnard in respect to modifications of the Bootstrap theme for Moodle.
 * author     G J Barnard - http://about.me/gjbarnard and http://moodle.org/user/profile.php?id=442195
 * author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

Customisation
=============
If you like this theme and would like me to customise it, transpose functionality to another theme or build a new theme
from scratch, then I offer competitive rates.  Please contact me via www.gjbarnard.co.uk/contact/ or gjbarnard at gmail dot com
to discuss your requirements.

Required version of Moodle
==========================
This version works with Moodle version 2014051200.00 release 2.7 (Build: 20140512) and above within the 2.7 branch until the
next release.

Please ensure that your hardware and software complies with 'Requirements' in 'Installing Moodle' on
'docs.moodle.org/27/en/Installing_Moodle'.

Required version of Bootstrap 3
===============================
The Bootstrap 3 theme for Moodle is currently under development, so I maintain a 'fork' upon which I test against.  This is
here: https://github.com/gjb2048/theme_bootstrap

Each time I make a release I will 'tag' the version to use.  Please see the 'Version information' below for details on the
'tag' to use and install in the same way as Shoehorn.

The main development is maintained here: https://github.com/bmbrands/theme_bootstrap

I would like to thank Bas Brands and David Scotson for their work on the theme.  With a special mention to: Stuart Lamour,
Mark Aberdour, Paul Hibbitts, Mary Evans and Joby Harding.

Installation
============
 1. Ensure you have the version of Moodle as stated above in 'Required version of Moodle'.  This is essential as the
    theme relies on underlying core code that is out of my control.
 2. Login as an administrator and put Moodle in 'Maintenance Mode' so that there are no users using it bar you as the administrator.
 3. Copy the extracted 'shoehorn' folder to the '/theme/' folder.
 4. Go to 'Site administration' -> 'Notifications' and follow standard the 'plugin' update notification.
 5. Select as the theme for the site.
 6. Put Moodle out of Maintenance Mode.

Upgrading
=========
 1. Ensure you have the version of Moodle as stated above in 'Required version of Moodle'.  This is essential as the
    theme relies on underlying core code that is out of my control.
 2. Login as an administrator and put Moodle in 'Maintenance Mode' so that there are no users using it bar you as the administrator.
 3. Make a backup of your old 'shoehorn' folder in '/theme/' and then delete the folder.
 4. Copy the replacement extracted 'shoehorn' folder to the '/theme/' folder.
 5. Go to 'Site administration' -> 'Notifications' and follow standard the 'plugin' update notification.
 6. If automatic 'Purge all caches' appears not to work by lack of display etc. then perform a manual 'Purge all caches'
   under 'Home -> Site administration -> Development -> Purge all caches'.
 7. Put Moodle out of Maintenance Mode.

Uninstallation
==============
 1. Put Moodle in 'Maintenance Mode' so that there are no users using it bar you as the administrator.
 2. Change the theme to another theme of your choice.
 3. In '/theme/' remove the folder 'shoehorn'.
 4. Put Moodle out of Maintenance Mode.

Reporting issues
================
Before reporting an issue, please ensure that you are running the latest version for your release of Moodle.  It is essential
that you are operating the required version of Moodle as stated at the top - this is because the theme relies on core
functionality that is out of its control.

I operate a policy that I will fix all genuine issues for free.  Improvements are at my discretion.  I am happy to make bespoke
customisations / improvements for a negotiated fee. 

When reporting an issue you can post in the theme's forum on Moodle.org (currently 'moodle.org/mod/forum/view.php?id=46')
or check the issue list https://github.com/gjb2048/moodle-theme_shoehorn/issues and if the problem does not exist, create an
issue.

It is essential that you provide as much information as possible, the critical information being the contents of the theme's 
'version.php' file.  Other version information such as specific Moodle version, theme name and version also helps.  A screen shot
can be really useful in visualising the issue along with any files you consider to be relevant.

Todo
====
1. Consider moving fluid container setting from Bootstrap 3 settings.
2. Fix D&D moving blocks into the page-bottom region and moving around not having the right width / position.

Version information
===================
7th August 2014 - Version 2.7.0.3 - DO NOT INSTALL ON PRODUCTION SERVERS.
  1.  Added look and feel settings to control background image and content transparency for the content area
      for all pages and the front page as an individual separate.
  2.  Various transparency changes to navbar, menu and footer.
  3.  Fixed the slider minimum height at varying device widths as so to prevent transition jitter in the content area.
  4.  Added IE detection with request to upgrade.
  5.  Use Bootstrap JS way of data-toggle for course summary on front page, see: https://github.com/bmbrands/theme_bootstrap/issues/301.
  6.  Fixed two column login page when 'auth_instructions' setting is set.
  7.  Fixed all pages image showing on front page when it has none.
  8.  Placed a panel around the page heading when an image is shown and change the text to the text colour.
  9.  Added option to compact the navigation bar.
 10.  Added option to fix the navigation bar at the top of the page.
 11.  Added experimental dynamic language option to test: https://moodle.org/mod/forum/discuss.php?d=264955.

11th July 2014 - Version 2.7.0.2 - DO NOT INSTALL ON PRODUCTION SERVERS.
  1.  Added syntax highlighting to courses - http://alexgorbatchev.com/SyntaxHighlighter/.
  2.  Tweaks to question styling, specifically multiple choice.
  3.  Fixed frontpage and single page course slider with glyphicons.
  4.  Tweaks to course styling when editing.
  5.  Made slider previous and next icons only appear when slider hovered over.
  6.  Added custom Collapsed Topics icons.
  7.  Fixed issue with course tiles and front page blocks in editing mode.
  8.  Updated Gruntfile.js and package.json.
  9.  Fixed docking issues as reported on https://moodle.org/mod/forum/discuss.php?d=263080#p1139975.
 10.  Fixed fake block issue: https://github.com/gjb2048/moodle-theme_shoehorn/issues/1 and quiz number
      navigation hovering / borders.
 11.  Made slider image max sizes responsive.
 12.  Added 'Home' link to footer menu.  Thanks to Natalie Denmeade for remding me about this.

17th June 2014 - Version 2.7.0.1 - DO NOT INSTALL ON PRODUCTION SERVERS.
  1.  Update development to Moodle 2.7.
  2.  Switch to using YUI version of Bootstrap theme: https://github.com/bmbrands/theme_bootstrap as master has changed.
      jQuery version is now: https://github.com/bmbrands/theme_bootstrap/tree/bootstrap3_dev and base theme is:
      https://github.com/bmbrands/theme_bootstrap/tree/bootstrap3_basetheme
  3.  Improved svg colour change in Gruntfile.js for plugins too.
  4.  Converted user icons to svg.
  5.  Added docking.
  6.  Added docking setting.
  7.  Added optional 'My courses' menu.
  8.  Fixed grade report: https://moodle.org/mod/forum/discuss.php?d=261626.
  9.  Added in and adapted 'mycourses' layout from the Elegance theme.
 10.  Added in and adapted 'course tiles' from the Elegance theme.
 11.  Added optional 'Backstretch' (https://github.com/srobbin/jquery-backstretch) for the login page.
 12.  Added optional side block region accordion functionality.  Note: This disables docking for side regions.
 13.  Added FitVids to scale media - http://fitvidsjs.com/
 14.  Added credits to this readme.
 15.  Updated to FontAwesome 4.1.
 16.  Removed old Glyphicon font setting and introduced a FontAwesome setting that works across the theme.  Note:
      I have decided to not introduce the icon replacement code that is in other themes for this as it is not yet
      consistent with being able to replace everything due to the fixed icons in the JavaScript.
 17.  Borrowed and adapted the FontAwesome icon styles for components from the Elegance theme as found in elegance.css.
 18.  Made the social icon signpost optional.
 19.  Added dynamic course icons on the course menu based on course id.

5th May 2014 - Version 2.6.0.3 - DO NOT INSTALL ON PRODUCTION SERVERS.
  1.  Fixed no navbar on the login page.
  2.  Fixed enrolment button not showing background colour.
  3.  Fixed search box and icon at the top of forums.
  4.  Fixed hover over messages in message drop-down.
  5.  Fixed user profile picture on view profile page of course participants.
  6.  Fixed pop-up user message.
  7.  Fixed bottom colour needing to be the footer colour and the body background the top of page for the 'navbar' by applying the
      bottom footer colour to the 'html' tag.
  8.  Fixed validator links to be inline in page info section with dividers.
  9.  Added favicon.
 10.  Separated out course format renderers and updated for bootstrap fix https://github.com/bmbrands/theme_bootstrap/pull/250.
 11.  Created 'imagebank.php' to serve image bank images so that theme designer mode off can be used and therefore
      using 'purge all caches' will not affect the url.  Need to think of perhaps shortening the process by somehow using
      '$theme->setting_file_serve' in 'theme_shoehorn_pluginfile' of lib.php, but current process has safeguards.  However,
      this is implementation-al and should not affect 'imagebank.php' URLs.
 12.  Collapsed Topics inspired CONTRIB-4099 to look again at the course layout and fix.
 13.  Bootstrap parent: https://github.com/gjb2048/theme_bootstrap/releases/tag/V2014032100_2
 14.  Implemented show old messages setting I developed on: https://github.com/gjb2048/theme_bootstrap/commit/86ca17108e5f03daf9697899188dffc7f8e5b7f2

 2nd April 2014 - Version 2.6.0.2 - DO NOT INSTALL ON PRODUCTION SERVERS.
  1.  Bootstrap parent: https://github.com/gjb2048/theme_bootstrap/releases/tag/V2014032100
  2.  Beta development version.

 8th March 2014 - Version 2.6.0.1 - DO NOT INSTALL ON PRODUCTION SERVERS.
  1.  Alpha development version.
  2.  Dynamic social icon colour footer sign.
  3.  Dynamic customisable footer menu.

Thanks
======
My thanks go to all the creators and participants of the Bootstrap theme:
Bas Brands, David Scotson and many other contributors.

Credits
=======

Bootstrap
------------
Authors: Mark Otto and Jacob Thornton
URL: http://getbootstrap.com/
License: https://github.com/twbs/bootstrap/blob/master/LICENSE

Bootstrap 3 for Moodle conversion
------------
Authors: Bas Brands and David Scotson
URL: https://github.com/bmbrands/theme_bootstrap
License: MIT/GPL2 Licensed

Course tiles idea and initial coding
------------
Author: Jason La Greca
URL: http://beenlearning.com/
License: MIT/GPL2 Licensed

Backstretch.js
------------
Author: Scott Robbin
URL: http://srobbin.com/jquery-plugins/backstretch/
License: https://raw.githubusercontent.com/srobbin/jquery-backstretch/master/LICENSE-MIT

FitVid.js
------------
Authors: Chris Coyier and Paravel
URL: http://fitvidsjs.com/
License: None

Me
==
G J Barnard MSc. BSc(Hons)(Sndw). MBCS. CEng. CITP. PGCE.
Moodle profile: http://moodle.org/user/profile.php?id=442195
Web profile   : http://about.me/gjbarnard
