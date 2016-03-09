Version information
===================
Version 2.9.1.6
  1. Update to FontAwesome 4.5.
  2. Fix typo in toolbox::grid().
  3. Update to BS 3.3.6.
  4. Improvements to child theme support.
  5. Improvements / fixes to layout block areas when editing.
  6. Dotted borders on empty block areas when editing.
  7. Start of PHPUnit tests.
  8. Report layouts have a different HTML tag background to cope with overflow, whilst others have the footer to
     cope with lack of content.
  9. Refactored commit ce9a231112fc0c98726419f69031bef088eab3e4 from M3.0 of 24/11/15.
 10. Refactored commit a6ad6e91b3062feb2a067250268a8b1ccdddfb28 from M3.0 of 26/11/15.
 11. Fixed namespace issue in core_renderer.php.
 12. Fixed tab appearance issue when looking at: Site administration -> Users -> Permissions -> Define roles.
 13. Moved to using this Changes.md file as per: https://docs.moodle.org/dev/Plugin_files#CHANGES
 14. Fix Quiz > Edit quiz -> Edit maximum mark.
 15. Fix all blocks when docked #13.
 16. RTL tidy up.
 17. Dock tidy up.
 18. Travis CI -> https://travis-ci.org/gjb2048/moodle-theme_shoehorn
 19. Tidy up Noticeboard format for one section per page.
 20. Fix issue when switching themes.
 21. Change body font setting text to 'Text'.
 22. Fix background transparency not set.
 23. Fix background colour on carosel hover when link.
 24. Display section name in one section per page indicator on slider.
 25. Changes to child theme mechanism.  For a child theme template, please contact me via https://about.me/gjbarnard.
 26. Fix 'Group members displayed below groups instead of right side of groups' #17 by updating Moodle styles from Bootstrap theme.
 27. Added 'Layout' setting in 'Look and feel settings'.
 28. Fix RTL login page and add activity / resource popup.
 29. Remove different layout in toolbox::grid for RTL due to CSS flip technology.  Put back if this changes.
 30. Tidy up navbar.
 31. Tidy up forum search.
 32. Tidy with theme tester tool (https://moodle.org/plugins/tool_themetester) work in progress.
 33. Use pointer cursor for anti-gravity.
 34. Add return to section button.
 35. Bigger user image in forum discussion.
 36. Fix header hover background not fully over text.
 37. Fix admin colour picker size.
 38. Colour popup in Collapsed Topics and Grid course formats.
 39. Fix incorrect pip calculation when one section per page.
 40. Only resize carousel images on the front page.
 41. Fix glyphicon carousel position.
 42. Update .gitattributes file.
 43. Add 'Inspector Scourer'.
 44. TravisCI Code Checker complaints.
 45. Remove redundant includes in auto-loaded classes.
 46. Add 'Style Guide' admin setting page.
     Can also be accessed via the URL '//yourmoodlesite/theme/shoehorn/pages/styleguide.php' without logging on.
 47. Add 'Format responsive' overrides for the 'Columns format'.
 48. Fix list group active text colour.

Version 2.9.1.5
  1. MDL-51921.
  2. Fix course format autoloading renderers.
  3. Add support for Collapsed Topics responsive feature.
  4. Fix slight Collapsed Topics right column issue when not editing.
  5. Fix group selection boxes, ref: https://github.com/bmbrands/theme_bootstrap/commit/b850d9ba0aaa69e3710ed203fe927860881635b3

Version 2.9.1.4
  1. Update from Bootstrap theme version 2015092400.
  2. Improvements for child theme support.
  3. Minor adjustment to date time selector widths.
  4. Fix dropdown-submenu position.
  5. Fix setting form header text colour.
  6. Focus for social icons.
  7. Fix body background image when docked.

Version 2.9.1.3
  1. MDL-50323.
  2. MDL-51194.
  3. MDL-51229.
  4. Update grade.less from bootstrapbase.
  5. Added 'user preferences' link to user menu.  Code credit 'Hartmut Scherer': https://moodle.org/mod/forum/discuss.php?d=320238.
  6. Port of Essential issue #536.
  7. Port of Essential issue #537.
  8. Port of Essential issue #538.

Version 2.9.1.2
  1. Tidy up user menu.
  2. Add role switched item if required.
  3. MDL-48202.
  4. MDL-46860.
  5. Divider does not show.
  6. MDL-42634.
  7. Tidy up button area on chooser dialog.
  8. Tidy up course when editing.

Version 2.9.1.1
  1. Fix lesson table padding removed.
  2. Fix fake block text colour.
  3. Remove experimental dynamiclang.
  4. Update to FontAwesome 4.4.0.
  5. Fix chart heading colour.
  6. Fix theme renderer not being initialised correctly on custom pages.

Version 2.9.1
  1. First stable version.

Version 2.9.0.9.
  1. Child theme support.
  2. Improve backstretch on login page.
  3. Added 'Shoebrush' child theme in 'shoebrush' sub-folder.  To use, read the 'Installation' instructions in
     'shoebrush/Readme.md'.  The 'shoebrush' sub-folder is just a place to store and distribute the child theme.
     It will NOT be available until you install it.
  4. Add custom font support for headings and body text.

Version 2.9.0.8.
  1. More tidy up.
  2. Fix groups page: https://moodle.org/mod/forum/discuss.php?d=315577#p1265731.
  3. Fix no 'loginas' URL when logged in as another user.
  4. Fix top menu bar message update notifications messages blank.
  5. Update to Bootstrap 3.3.5.
  6. Implement class autoloading and namespace for 'toolbox' like functionality for performance and reduces memory footprint.
     Ref: https://docs.moodle.org/dev/Automatic_class_loading.
  7. Fix $CFG->themedir for syntax highlighting.
  8. Fix bootstrap_grid() in layout\secure.php.

Version 2.9.0.7.
  1. Tidy up user profile, calendar and fix messaging.
  2. Fix RTL.
  3. Tidy up logo and heading area.
  4. Tidy up chart.

Version 2.9.0.6.
  1. Added setting for 'User load' chart.
  2. Removed 'grunt-css-min' as causing 'background:0 0' issues that are too complex to resolve here - #11.
  3. Updated 'grunt-contrib-less' to version '1.0.1'.
  4. Fix small security issue.

Version 2.9.0.5.
  1. Added 'Chartist' to display 'User load' on admin pages.  TODO: Have a setting for this.

Version 2.9.0.4.
  1. Fix padding of lists in popup dialogues.
  2. Conversion to some colour UI settings - work in progress.

Version 2.9.0.3.
  1. Fix renderers after Bootstrap theme separation.
  2. Fix 'My courses' drop down going off screen when you have a long course name and a compact navbar.
  3. Fix multiple definitions of 'Plugin' in amd/src/bootstrap.js.
  4. Fix AMD clash with SyntaxHighlighter, ref: https://github.com/syntaxhighlighter/syntaxhighlighter/issues/62
     and https://github.com/syntaxhighlighter/syntaxhighlighter/commit/556c909a9c258ba9ca59c62fc241e97acbe28a8f
  5. Fix SyntaxHighlighter autoloading jQuery with AMD.
  6. Remove old jQuery mechanism.
  7. Remove AMD dynamic loading test code.
  8. PHP mess detector changes - https://github.com/bmbrands/theme_bootstrap/commit/bd9c68b2b4cadad569ae1d5ed969295cdfb62ca1
  9. Run through CodeChecker 2.3.2 - 2014081500.
 10. Converted renderers to autoloading ones.

Version 2.9.0.2.
  1. Fix some svg core icons.
  2. Tidy up.
  3. Fix maintenance layout after Bootstrap theme separation.

Version 2.9.0.1.
  1. Moodle 2.9 development version.

Version 2.8.1.1.
  1. Fix source map URL for development version after upgrading to 'grunt-contrib-less' version '~1.0.0'.
  2. Tidy up logo code and information in language file.
  3. Tidy up experimental RTL serving.
  4. Tidy up and fix syntax highlighting - work in progress.
  5. Adjust carousel control icons responsively.
  6. Messages popup on the left to avoid anti-gravity icon.
  7. Tidy up compact navbar.
  8. Remove dependancy on parent 'bootstrap' theme.
  9. Update to Bootstrap 3.3.4.
 10. Update to Font Awesome 4.3.0.

18th January 2015 - Version 2.8.1 - Stable.
  1. Tidied up slider such that it does not cause the content to jump on the frontpage and the images are centred.
  2. Added a 'Go to bottom of page' icon in the navbar to make it easier when on settings and course pages.
  3. Tidy up course slider for one page per section courses - always show arrows on mobiles and tablets.
  4. Always show arrows on mobiles and tablets for the front page slider.
  5. Added a 'Go to top of page' icon that shows when the page is scrolled down.
  6. Update to Bootstrap 3.3.1: https://github.com/twbs/bootstrap/releases/tag/v3.3.1.
  7. Fixed 'Exit activity' in a SCORM activity not appearing the same as the breadcrumb.
  8. Fixed blocks in footer not being wide enough.
  9. Fixed issue #406 from Essential: Assignment types: Online Audio Recording.
 10. Fixed issue #408 from Essential with regards to the background.
 11. Fixed issue with social icons with glyphicons.
 12. Rectified need to have separated M2.7 specific Bootstrap as parent theme.  Now can use:
     https://github.com/gjb2048/theme_bootstrap or https://moodle.org/plugins/view.php?plugin=theme_bootstrap
 13. Update grunt packages to latest versions.
 14. Added BCU theme 'This course' menu for courses.

14th November 2014 - Version 2.8.0.2 - Release candidate.
  1. Release candidate for Moodle 2.8.

12th November 2014 - Version 2.8.0.1.
  1. First version for Moodle 2.8.

10th November 2014 - Version 2.7.1.2
  1. Fixed bottom right hover border of last menu item of the compact navbar.
  2. Fixed 'Go' button on the right when administration block in page bottom region.
  3. Fixed float issue with section 0 in the Grid format and course tiles.

5th November 2014 - Version 2.7.1.1
  1. Fix #5 - Scorm report button issues.  Thanks to Kirk Chapman for reporting.
  2. Update readme license details.  Thanks to Antony Borrow.
  3. Tidy up site page images.
  4. Applied MDL-43824 grade.less to experimental CSS and raised https://github.com/bmbrands/theme_bootstrap/pull/347 for parent Bootstrap.
  5. Applied same Essential FitVids solution: https://github.com/gjb2048/moodle-theme_essential/issues/354.
  6. Site page improvements for when they cannot be displayed.
  7. Update to Bootstrap 3.3.0 - https://github.com/twbs/bootstrap/releases/tag/v3.3.0.
  8. Fixed #8 - Course tile description too low.

12th October 2014 - Version 2.7.1 - First stable release.
  1.  Tweaks to editing the quiz as a result of: https://github.com/gjb2048/moodle-theme_essential/issues/318.

4th October 2014 - Version 2.7.0.4 - DO NOT INSTALL ON PRODUCTION SERVERS.
  1.  With the release of a stable parent Bootstrap on: https://moodle.org/mod/forum/discuss.php?d=271448, I have decided to release
      this release candidate version of Shoehorn.
  2.  You will need the parent theme from: https://moodle.org/plugins/download.php/6987/theme_bootstrap_moodle27_2014100300.zip.

27th August 2014 - Version 2.7.0.3 - DO NOT INSTALL ON PRODUCTION SERVERS.
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
 12.  Updated to FontAwesome 4.2.0.
 13.  Fix user svg images for IE11.

11th July 2014 - Version 2.7.0.2 - DO NOT INSTALL ON PRODUCTION SERVERS.
  1.  Added syntax highlighting to courses - http://alexgorbatchev.com/SyntaxHighlighter/.
  2.  Tweaks to question styling, specifically multiple choice.
  3.  Fixed front page and single page course slider with glyphicons.
  4.  Tweaks to course styling when editing.
  5.  Made slider previous and next icons only appear when slider hovered over.
  6.  Added custom Collapsed Topics icons.
  7.  Fixed issue with course tiles and front page blocks in editing mode.
  8.  Updated Gruntfile.js and package.json.
  9.  Fixed docking issues as reported on https://moodle.org/mod/forum/discuss.php?d=263080#p1139975.
 10.  Fixed fake block issue: https://github.com/gjb2048/moodle-theme_shoehorn/issues/1 and quiz number
      navigation hovering / borders.
 11.  Made slider image max sizes responsive.
 12.  Added 'Home' link to footer menu.  Thanks to Natalie Denmeade for reminding me about this.

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