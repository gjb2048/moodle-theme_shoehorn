Introduction
============
Shoehorn theme.

![image1](pix/screenshot.png "Shoehorn screenshot")

[![Build Status](https://travis-ci.org/gjb2048/moodle-theme_shoehorn.svg?branch=MOODLE_30)](https://travis-ci.org/gjb2048/moodle-theme_shoehorn)

About
=====
![image2](pix/Shoehorn_logo_sm.png "Shoehorn logo")
 * copyright  &copy; 2014-onwards G J Barnard in respect to modifications of the Bootstrap theme for Moodle.
 * author     G J Barnard - http://about.me/gjbarnard and http://moodle.org/user/profile.php?id=442195
 * author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

Free Software
=============
The Shoehorn theme is 'free' software under the terms of the GNU GPLv3 License, please see 'COPYING.txt'.

It can be obtained for free from:
https://moodle.org/plugins/view.php?plugin=theme_shoehorn
and
https://github.com/gjb2048/moodle-theme_shoehorn/releases

You have all the rights granted to you by the GPLv3 license.  If you are unsure about anything, then the
FAQ - http://www.gnu.org/licenses/gpl-faq.html - is a good place to look.

If you reuse any of the code then I kindly ask that you make reference to the theme.

If you make improvements or bug fixes then I would appreciate if you would send them back to me by forking from
https://github.com/gjb2048/moodle-theme_shoehorn and doing a 'Pull Request' so that the rest of the
Moodle community benefits.

Sponsorships
============
This theme is provided to you for free, and if you want to express your gratitude for using this theme, please consider sponsoring
by:

PayPal - Please contact me via my 'Moodle profile' (above) for details as I am an individual and therefore am unable to have
'buy me now' buttons under their terms.

Flattr - https://flattr.com/profile/gjb2048

Sponsorships may allow me to provide you with more or better features in less time.

Customisation
=============
If you like this theme and would like me to customise it, transpose functionality to another theme or
build a new theme from scratch, then I offer competitive rates.  Please contact me via 'www.gjbarnard.co.uk/contact/'
or 'gjbarnard at gmail dot com' or 'about.me/gjbarnard' to discuss your requirements.

Required version of Moodle
==========================
This version works with Moodle version 2015111600.00 3.0 (Build: 20151116) and above within the 3.0 branch until the
next release.

Please ensure that your hardware and software complies with 'Requirements' in 'Installing Moodle' on
'docs.moodle.org/30/en/Installing_Moodle'.

Licenses used
=============
GPLv3 - http://www.gnu.org/licenses/license-list.html#GNUGPL
-----
Shoehorn theme code and icons (including altered core icons) - https://moodle.org/mod/forum/discuss.php?d=135896, 
http://www.gnu.org/licenses/gpl-faq.html#GPLPluginsInNF and http://www.gnu.org/licenses/license-list.html#OtherLicenses

LGPLv3 - http://www.gnu.org/licenses/license-list.html#LGPL
------
Syntax Highlighter - http://alexgorbatchev.com/SyntaxHighlighter/download/

MIT - http://www.gnu.org/licenses/license-list.html#Expat
---
FontAwesome LESS - http://fontawesome.io/license/
backstretch.js - http://srobbin.com/jquery-plugins/backstretch/
Bootstrap - http://getbootstrap.com
Syntax Highlighter - http://alexgorbatchev.com/SyntaxHighlighter/download/

WTFPL - http://www.gnu.org/licenses/license-list.html#WTFPL - http://sam.zoy.org/wtfpl/
-----
fitvids.js - Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com and credit to Thierry Koblentz
- http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/.

SIL - http://www.gnu.org/licenses/license-list.html#SILOFL
---
Fonts:
Cabin - http://www.fontsquirrel.com/fonts/cabin
Railway - http://www.fontsquirrel.com/fonts/railway
FontAwesome - http://fontawesome.io/license/

Installation
============
 1. Ensure you have the version of Moodle as stated above in 'Required version of Moodle'.  This is essential as the
    theme relies on underlying core code that is out of my control.
 2. Login as an administrator and put Moodle in 'Maintenance Mode' so that there are no users using it bar you as the administrator.
 3. Copy the extracted 'shoehorn' folder to the '/theme/' folder.
 4. Go to 'Site administration' -> 'Notifications' and follow standard the 'plugin' update notification.
 5. Select as the theme for the site.
 6. Put Moodle out of Maintenance Mode.

Note: If you get no CSS whatsoever, then please add the following to your Apache web server httpd.conf file after loading the modules
and restart (without the ` if you see them):

```
<IfModule mpm_winnt_module>
   ThreadStackSize 8388608
</IfModule>
```

I have created a screencast to help: https://www.youtube.com/watch?v=nI3LsN0XwKY

Ref: https://github.com/bmbrands/theme_bootstrap/issues/342#issuecomment-58152495 and https://code.google.com/p/minify/issues/detail?id=62.

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

Videos and FitVids
==================
Shoehorn uses FitVids.js - http://fitvidsjs.com/ - to make embedded videos responsive.  If you do not want this feature for a particular
video, then please add the class 'fitvidsignore' to the video element.

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

Customising the LESS
====================
To help you, I have created two screen casts, one 'Production' and one 'Development'. The latter follows the former, so watch
'Production' first.

Production:  https://www.youtube.com/watch?v=8uwYn2im008
Development: https://www.youtube.com/watch?v=6yFAS5-a3o4

Known issues
============
1. RTL functionality is not quite ready.  In the 'General' settings there is an experimental switch 'dynamiclang' which is my first
   attempt at implementing an idea as described on: https://moodle.org/mod/forum/discuss.php?d=264955.  This idea has further been
   developed by me in the Essential theme: https://github.com/gjb2048/moodle-theme_essential/issues/249.  The main area of issue
   has been the quiz.  Once Essential 2.7.8 is released and any other issues resolved, I will take what I have learnt there and
   apply to Shoehorn.  Or it might be the case that the parent Bootstrap theme in
   https://github.com/bmbrands/theme_bootstrap/issues/262 will help to resolve this.  Update 22/4/2015: I have not forgotten about
   this, but do intend in the furture to make this happen with Shoehorn.

Todo
====
1. Consider moving fluid container setting from Bootstrap 3 settings.
2. Fix D&D moving blocks into the page-bottom region and moving around not having the right width / position.

Version information
===================
See Changes.md.

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
