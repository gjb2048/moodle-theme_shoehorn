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
 * Shoehorn theme.
 *
 * @package    theme
 * @subpackage shoehorn
 * @copyright  &copy; 2014-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace theme_shoehorn\output;

use block_contents;
use block_move_target;
use coding_exception;
use custom_menu;
use custom_menu_item;
use html_writer;
use moodle_url;
use stdClass;

class core_renderer extends \core_renderer {
    use core_renderer_toolbox;

    protected $shoehorn = null; // Used for determining if this is a Shoehorn or child of renderer.

    protected $enrolledcourses = null;
    protected $syntaxhighlighterenabled = false;
    protected $themeconfig = null;
    protected $fontawesome = null;

    public function __construct(\moodle_page $page, $target) {
        parent::__construct($page, $target);
        $this->themeconfig = array(\theme_config::load('shoehorn'));
    }

    public function get_tile_file($filename) {
        global $CFG;
        $filename .= '.php';

        if (file_exists("$CFG->dirroot/theme/shoehorn/layout/tiles/$filename")) {
            return "$CFG->dirroot/theme/shoehorn/layout/tiles/$filename";
        } else if (!empty($CFG->themedir) and file_exists("$CFG->themedir/shoehorn/layout/tiles/$filename")) {
            return "$CFG->themedir/shoehorn/layout/tiles/$filename";
        } else {
            return dirname(__FILE__) . "/$filename";
        }
    }

    public function get_file_contents($filename) {
        global $CFG;

        if (file_exists("$CFG->dirroot/theme/shoehorn/$filename")) {
            return file_get_contents("$CFG->dirroot/theme/shoehorn/$filename");
        } else if (!empty($CFG->themedir) and file_exists("$CFG->themedir/shoehorn/$filename")) {
            return file_get_contents("$CFG->themedir/shoehorn/$filename");
        } else {
            return file_get_contents(dirname(__FILE__) . "/$filename");
        }
    }

    protected function is_fontawesome() {
        if ($this->fontawesome == null) {
            $this->fontawesome = $this->get_setting('fontawesome');
        }
        return $this->fontawesome;
    }

    public function htmlattributes() {
        $attr = parent::htmlattributes();

        if ($this->page->pagelayout == 'report') {
            $attr .= ' class="report"';
        }

        return $attr;
    }

    protected function navbar_items() {
        global $CFG, $SITE;
        $output = html_writer::link($CFG->wwwroot, $SITE->shortname,
                        array('title' => $SITE->shortname, 'class' => 'navbar-brand'));

        if (($this->page->pagelayout == 'course') || ($this->page->pagelayout == 'incourse') ||
            ($this->page->pagelayout == 'admin')) { // Go to bottom.
            if ($this->is_fontawesome()) {
                $gotobottom = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'fa fa-arrow-circle-o-down'));
            } else {
                $gotobottom = html_writer::tag('span', '',
                    array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-circle-arrow-down'));
            }
            $output .= html_writer::link(new moodle_url('#region-main-shoehorn-shadow'), $gotobottom,
                            array('title' => get_string('gotobottom', 'theme_shoehorn'), 'class' => 'goto-bottom'));
        }

        return $output;
    }

    /**
     * This code renders the navbar button to control the display of the custom menu
     * on smaller screens.
     *
     * Do not display the button if the menu is empty.
     *
     * @return string HTML fragment
     */
    protected function navbar_button() {
        $iconbar = html_writer::tag('span', '', array('class' => 'icon-bar'));
        $sronly = html_writer::tag('span', get_string('togglenavigation', 'theme_shoehorn'), array('class' => 'sr-only'));
        $button = html_writer::tag('button',
            $sronly . "\n" . $iconbar . "\n" . $iconbar . "\n" . $iconbar . "\n" . $iconbar,
                array(
                    'class' => 'navbar-toggle',
                    'data-toggle' => 'collapse',
                    'data-target' => '#moodle-navbar',
                    'type' => 'button'
                )
            );
        return $button;
    }

    private function debug_listing($message) {
        $message = str_replace('<ul style', '<ul class="list-unstyled" style', $message);
        return html_writer::tag('pre', $message, array('class' => 'alert alert-info'));
    }

    protected function render_custom_menu_item(custom_menu_item $menunode, $level = 0) {
        static $submenucount = 0;

        if ($menunode->has_children()) {

            if ($level == 1) {
                $dropdowntype = 'dropdown';
            } else {
                $dropdowntype = 'dropdown-submenu';
            }

            $content = html_writer::start_tag('li', array('class' => $dropdowntype));
            // If the child has menus render it as a sub menu.
            $submenucount++;
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#cm_submenu_' . $submenucount;
            }
            $linkattributes = array(
                'href' => $url,
                'class' => 'dropdown-toggle',
                'data-toggle' => 'dropdown',
                'title' => $menunode->get_title(),
            );
            $content .= html_writer::start_tag('a', $linkattributes);
            $content .= $menunode->get_text();
            if ($level == 1) {
                $content .= '<b class="caret"></b>';
            }
            $content .= '</a>';
            $content .= '<ul class="dropdown-menu">';
            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->render_custom_menu_item($menunode, 0);
            }
            $content .= '</ul>';
        } else {
            // Also, if the node's text matches '####', add a class so we can treat it as a divider.
            $content = '';
            if (preg_match("/^#+$/", $menunode->get_text())) {
                // This is a divider.
                $content = html_writer::start_tag('li', array('class' => 'divider'));
            } else {
                $content = html_writer::start_tag('li');
                // The node doesn't have children so produce a final menuitem.
                if ($menunode->get_url() !== null) {
                    $url = $menunode->get_url();
                } else {
                    $url = '#';
                }
                $content .= html_writer::link($url, $menunode->get_text(), array('title' => $menunode->get_title()));
            }
            $content .= html_writer::end_tag('li');
        }
        return $content;
    }

    protected function render_tabtree(\tabtree $tabtree) {
        if (empty($tabtree->subtree)) {
            return '';
        }
        $firstrow = $secondrow = '';
        foreach ($tabtree->subtree as $tab) {
            $firstrow .= $this->render($tab);
            if (($tab->selected || $tab->activated) && !empty($tab->subtree) && $tab->subtree !== array()) {
                $secondrow = $this->tabtree($tab->subtree);
            }
        }
        return html_writer::tag('ul', $firstrow, array('class' => 'nav nav-tabs')) . $secondrow;
    }

    protected function render_tabobject(\tabobject $tab) {
        if ($tab->selected or $tab->activated) {
            return html_writer::tag('li', html_writer::tag('a', $tab->text), array('class' => 'active'));
        } else if ($tab->inactive) {
            return html_writer::tag('li', html_writer::tag('a', $tab->text), array('class' => 'disabled'));
        } else {
            if (!($tab->link instanceof moodle_url)) {
                // Backward compatibility when link was passed as quoted string.
                $link = "<a href=\"$tab->link\" title=\"$tab->title\">$tab->text</a>";
            } else {
                $link = html_writer::link($tab->link, $tab->text, array('title' => $tab->title));
            }
            return html_writer::tag('li', $link);
        }
    }

    public function box($contents, $classes = 'generalbox', $id = null, $attributes = array()) {
        if (isset($attributes['data-rel']) && $attributes['data-rel'] === 'fatalerror') {
            return html_writer::div($contents, 'alert alert-danger', $attributes);
        }
        return parent::box($contents, $classes, $id, $attributes);
    }

    /**
     * Gets HTML for the page heading.
     *
     * @param string $tag The tag to encase the heading in, h1 by default.
     * @return string HTML.
     */
    public function page_heading($tag = 'h1') {
        $o = '';

        $logo = $this->setting_file_url('logo', 'logo');
        if (!is_null($logo)) {
            $o .= html_writer::start_tag('div', array('class' => 'row')).
                html_writer::tag($tag, $this->page->heading,
                array('class' => 'logoheading col-xs-8 col-sm-9 col-md-9 col-lg-10')).
                html_writer::start_tag('div', array('class' => 'col-xs-4 col-sm-3 col-md-3 col-lg-2')).
                html_writer::link(new moodle_url('/'),
                html_writer::empty_tag('img', array('src' => $logo, 'alt' => get_string('logo', 'theme_shoehorn'),
                'class' => 'logo img-responsive')),
                array('title' => get_string('home'), 'class' => 'logoarea')).
                html_writer::end_tag('div') .
                html_writer::end_tag('div');
        } else {
            $o .= html_writer::tag($tag, html_writer::link(new moodle_url('/'), $this->page->heading,
                array('title' => get_string('home'))), array('class' => 'heading'));
        }

        $ieprop = \core_useragent::check_ie_properties();
        if (is_array($ieprop)) {
            if ($ieprop['version'] < 10) {
                $o .= html_writer::tag('h2', get_string('iewarning', 'theme_shoehorn', array('ieversion' => $ieprop['version'])));
            }
        }

        return $o;
    }

    /*
     * This renders the navbar.
     * Uses bootstrap compatible html.
     */

    public function navbar() {
        $items = $this->page->navbar->get_items();
        if (empty($items)) { // See: MDL-46107.
            return '';
        }
        if ($this->is_fontawesome()) {
            if (right_to_left()) {
                $dividericon = 'fa-angle-left';
            } else {
                $dividericon = 'fa-angle-right';
            }
            $icon = html_writer::start_tag('span', array('aria-hidden' => 'true', 'class' => 'fa '.$dividericon.' fa-lg')).
                html_writer::end_tag('span');
        } else {
            if (right_to_left()) {
                $dividericon = 'glyphicon-chevron-left';
            } else {
                $dividericon = 'glyphicon-chevron-right';
            }
            $icon = html_writer::start_tag('span', array('aria-hidden' => 'true', 'class' => 'glyphicon '.$dividericon)).
                html_writer::end_tag('span');
        }
        $divider = html_writer::tag('span', $icon, array('class' => 'divider'));
        $breadcrumbs = array();
        foreach ($items as $item) {
            $item->hideicon = true;
            $breadcrumbs[] = $this->render($item);
        }
        $listitems = html_writer::start_tag('li') . implode("$divider" . html_writer::end_tag('li').
            html_writer::start_tag('li'), $breadcrumbs) . html_writer::end_tag('li');
        $title = html_writer::tag('span', get_string('pagepath'), array('class' => 'accesshide', 'id' => 'navbar-label'));
        return $title.html_writer::start_tag('nav',
            array('aria-labelledby' => 'navbar-label',
                'aria-label' => 'breadcrumb',
                'class' => 'breadcrumb-nav',
                'role' => 'navigation')).
            html_writer::tag('ul', "$listitems", array('class' => 'breadcrumb')).
            html_writer::end_tag('nav');
    }

    public function custom_menu($custommenuitems = '') {
        /* The custom menu is always shown, even if no menu items
          are configured in the global theme settings page. */
        global $CFG;

        if (empty($custommenuitems) && !empty($CFG->custommenuitems)) { // See: MDL-45507.
            $custommenuitems = $CFG->custommenuitems;
        }
        $custommenu = new custom_menu($custommenuitems, current_language());
        return $this->render_custom_menu($custommenu);
    }

    protected function render_custom_menu(custom_menu $menu) {
        $langs = get_string_manager()->get_list_of_translations();
        $haslangmenu = $this->lang_menu() != '';

        if (!$menu->has_children() && !$haslangmenu) {
            return '';
        }

        if ($haslangmenu) {
            $languagetext = get_string('language');
            $currentlang = current_language();
            if (isset($langs[$currentlang])) {
                $currentlang = $langs[$currentlang];
            } else {
                $currentlang = $languagetext;
            }
            if ($this->is_fontawesome()) {
                $langhtml = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'fa fa-language'));
            } else {
                $langhtml = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-book'));
            }
            $langhtml .= html_writer::tag('span', $currentlang);
            $this->language = $menu->add($langhtml, new moodle_url('#'), $languagetext, 10000);
            foreach ($langs as $langtype => $langname) {
                $this->language->add($langname, new moodle_url($this->page->url, array('lang' => $langtype)), $langname);
            }
        }

        $content = '';
        foreach ($menu->get_children() as $item) {
            $content .= $this->render_custom_menu_item($item, 1);
        }

        return $content;
    }

    public function user_menu($user = null, $withlinks = null) {
        $usermenu = new custom_menu('', current_language());
        return $this->render_user_menu($usermenu);
    }

    protected function render_user_menu(custom_menu $menu) {
        global $CFG, $USER;

        $addmessagemenu = true;

        if (!isloggedin() || isguestuser()) {
            $addmessagemenu = false;
        }

        if ($addmessagemenu) {
            $messages = $this->get_user_messages();
            $messagecount = 0;
            foreach ($messages as $message) {
                if (!$message->from) { // Workaround for issue #103.
                    continue;
                }
                $messagecount++;
            }
            $messagemenutext = html_writer::tag('span', $messagecount);
            if ($this->is_fontawesome()) {
                $class = 'fa fa-envelope';
                if ($messagecount == 0) {
                    $class .= '-o';
                }
                $messagemenutext .= html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => $class));
                $timeicon = 'fa fa-clock-o';
            } else {
                $messagemenutext .= html_writer::tag('span', '',
                    array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-envelope'));
                $timeicon = 'glyphicon glyphicon-time';
            }
            $messagemenucount = $messagecount.' ';
            if ($messagecount == 1) {
                $messagemenucount .= get_string('message', 'message');
            } else {
                $messagemenucount .= get_string('messages', 'message');
            }
            $messagemenu = $menu->add(
                    $messagemenutext, new moodle_url('/message/index.php', array('viewing' => 'recentconversations')),
                    $messagemenucount, 9999
            );
            foreach ($messages as $message) {
                if (!$message->from) { // Workaround for issue #103.
                    continue;
                }
                $senderpicture = new \user_picture($message->from);
                $senderpicture->link = false;
                $senderpicture = $this->render($senderpicture);

                $messagecontent = $senderpicture;
                $messagecontent .= html_writer::start_span('msg-body');
                $messagecontent .= html_writer::start_span('msg-title');
                $messagecontent .= html_writer::span($message->from->firstname . ': ', 'msg-sender');
                $messagecontent .= htmlspecialchars($message->text, ENT_COMPAT | ENT_HTML401, 'UTF-8');
                $messagecontent .= html_writer::end_span();
                $messagecontent .= html_writer::start_span('msg-time');
                $messagecontent .= html_writer::tag('i', '', array('class' => $timeicon));
                $messagecontent .= html_writer::span($message->date);
                $messagecontent .= html_writer::end_span();

                $messageurl = new moodle_url('/message/index.php',
                        array('user1' => $USER->id, 'user2' => $message->from->id));
                $messagemenu->add($messagecontent, $messageurl,
                        htmlspecialchars($message->text, ENT_COMPAT | ENT_HTML401, 'UTF-8'));
            }
        }

        $displaymycourses = $this->get_setting('displaymycoursesmenu');
        if (isloggedin() && !isguestuser() && $displaymycourses) {
            switch ($displaymycourses) {
                case 1:
                    $branchtitle = get_string('myclasses', 'theme_shoehorn');
                    break;
                case 2:
                    $branchtitle = get_string('mycourses', 'theme_shoehorn');
                    break;
                case 3:
                    $branchtitle = get_string('mymodules', 'theme_shoehorn');
                    break;
                case 4:
                    $branchtitle = get_string('mysubjects', 'theme_shoehorn');
                    break;
                case 5:
                    $branchtitle = get_string('myunits', 'theme_shoehorn');
                    break;
                default:
                    $branchtitle = get_string('mycourses', 'theme_shoehorn');
            }
            if ($this->is_fontawesome()) {
                $branchlabel = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'fa fa-dashboard'));
            } else {
                $branchlabel = html_writer::tag('span', '',
                    array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-dashboard'));
            }
            $branchlabel .= html_writer::tag('span', $branchtitle);
            $branchurl = new moodle_url('/my/index.php');
            $branchsort = 10000;

            $mycoursesmenu = $menu->add($branchlabel, $branchurl, $branchtitle, $branchsort);

            $hometext = get_string('myhome');
            if ($this->is_fontawesome()) {
                $homelabel = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'fa fa-home'));
            } else {
                $homelabel = html_writer::tag('span', '',
                    array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-home'));
            }
            $homelabel .= html_writer::tag('span', $hometext);
            $mycoursesmenu->add($homelabel, new moodle_url('/my/index.php'), $hometext);

            if ($this->is_fontawesome()) {
                $courseicons = array('list', 'list-alt', 'list-ul', 'book', 'tasks', 'suitcase', 'graduation-cap');
            } else {
                $courseicons = array('list', 'list-alt', 'book', 'tasks', 'briefcase');
            }

            $courses = $this->get_enrolled_courses();
            $rhosts = array();
            $rcourses = array();
            if (!empty($CFG->mnet_dispatcher_mode) && $CFG->mnet_dispatcher_mode === 'strict') {
                $rcourses = get_my_remotecourses($USER->id);
                $rhosts = get_my_remotehosts();
            }
            if (!empty($courses) || !empty($rcourses) || !empty($rhosts)) {
                foreach ($courses as $course) {
                    if ($course->visible) {
                        $coursetext = format_string($course->fullname);
                        if ($this->is_fontawesome()) {
                             // 7 is the courseicons array length.
                            $courselabel = html_writer::tag('span', '',
                                array('aria-hidden' => 'true', 'class' => 'fa fa-' . $courseicons[$course->id % 7]));
                        } else {
                            $courselabel = html_writer::tag('span', '',
                                array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-' . $courseicons[$course->id % 5]));
                        }
                        $courselabel .= html_writer::tag('span', $coursetext);

                        $mycoursesmenu->add($courselabel, new moodle_url('/course/view.php?id=' . $course->id),
                            format_string($course->shortname));
                    }
                }
                // MNET.
                if (!empty($rcourses)) {
                    // At the IDP, we know of all the remote courses.
                    foreach ($rcourses as $course) {
                        $url = new moodle_url('/auth/mnet/jump.php',
                            array(
                                'hostid' => $course->hostid,
                                'wantsurl' => '/course/view.php?id=' . $course->remoteid
                            )
                        );
                        $tooltip = format_string($course->hostname).' : '.format_string($course->cat_name).' : '.
                            format_string($course->shortname);

                        $coursetext = format_string($course->fullname);
                        if ($this->is_fontawesome()) {
                            // Five is the courseicons array length.
                            $courselabel = html_writer::tag('span', '',
                                array('aria-hidden' => 'true', 'class' => 'fa fa-' . $courseicons[$course->remoteid % 5]));
                        } else {
                            $courselabel = html_writer::tag('span', '', array(
                                'aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-'.$courseicons[$course->remoteid % 5]));
                        }
                        $courselabel .= html_writer::tag('span', $coursetext);

                        $mycoursesmenu->add($courselabel, $url, $tooltip);
                    }
                }
                if (!empty($rhosts)) {
                    // Non-IDP, we know of all the remote servers, but not courses.
                    foreach ($rhosts as $host) {
                        $coursetext = format_string($course->fullname);
                        if ($this->is_fontawesome()) {
                            $courselabel = html_writer::tag('span', '',
                                array('aria-hidden' => 'true', 'class' => 'fa fa-' . $courseicons[0]));
                        } else {
                            $courselabel = html_writer::tag('span', '',
                                array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-' . $courseicons[0]));
                        }
                        $courselabel .= html_writer::tag('span', $coursetext);

                        $mycoursesmenu->add($courselabel,
                            html_writer::link($host['url'], s($host['name']), array('title' => s($host['name']))),
                            $host['count'] . ' ' . get_string('courses'));
                    }
                }
            } else {
                $noenrolments = get_string('noenrolments', 'theme_shoehorn');
                $mycoursesmenu->add('<em>' . $noenrolments . '</em>', new moodle_url('/'), $noenrolments);
            }
        }

        if (($this->page->pagelayout == 'course') || ($this->page->pagelayout == 'incourse')) {
            if (!isguestuser()) {
                if (isset($this->page->course->id) && $this->page->course->id > 1) {
                    $branchtitle = get_string('thiscourse', 'theme_shoehorn');
                    if ($this->is_fontawesome()) {
                        $branchlabel = '<span aria-hidden="true" class="fa fa-book"></span>';
                    } else {
                        $branchlabel = '<span aria-hidden="true" class="glyphicon glyphicon-book"></span>';
                    }
                    $branchlabel .= html_writer::tag('span', $branchtitle);
                    $branchurl = new moodle_url('#');
                    $activitystreammenu = $menu->add($branchlabel, $branchurl, $branchtitle, 10001);
                    $branchtitle = get_string('people', 'theme_shoehorn');
                    if ($this->is_fontawesome()) {
                        $branchlabel = '<span aria-hidden="true" class="fa fa-users"></span>';
                    } else {
                        $branchlabel = '<span aria-hidden="true" class="glyphicon glyphicon-user"></span>';
                    }
                    $branchlabel .= html_writer::tag('span', $branchtitle);
                    $branchurl = new moodle_url('/user/index.php', array('id' => $this->page->course->id));
                    $activitystreammenu->add($branchlabel, $branchurl, $branchtitle, 100003);
                    $branchtitle = get_string('grades');
                    if ($this->is_fontawesome()) {
                        $branchlabel = '<span aria-hidden="true" class="fa fa-list-alt icon"></span>';
                    } else {
                        $branchlabel = '<span aria-hidden="true" class="glyphicon glyphicon-list"></span>';
                    }
                    $branchlabel .= html_writer::tag('span', $branchtitle);
                    $branchurl = new moodle_url('/grade/report/index.php', array('id' => $this->page->course->id));
                    $activitystreammenu->add($branchlabel, $branchurl, $branchtitle, 100004);

                    $data = $this->get_course_activities();
                    foreach ($data as $modname => $modfullname) {
                        if ($modname === 'resources') {
                            $icon = $this->pix_icon('icon', '', 'mod_page', array('class' => 'icon'));
                            $activitystreammenu->add($icon . $modfullname,
                                new moodle_url('/course/resources.php', array('id' => $this->page->course->id)));
                        } else {
                            $icon = '<img src="' . $this->pix_url('icon', $modname) . '" class="icon" alt="" />';
                            $activitystreammenu->add($icon . $modfullname,
                                new moodle_url('/mod/' . $modname . '/index.php',
                                array('id' => $this->page->course->id)));
                        }
                    }
                }
            }
        }

        if (!isloggedin()) {
            if ($this->page->pagelayout != 'login') {
                $logintext = get_string('login');
                if ($this->is_fontawesome()) {
                    $login = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'fa fa-sign-in'));
                } else {
                    $login = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-off'));
                }
                $login .= html_writer::tag('span', $logintext);
                $loginurl = new moodle_url('/login/index.php');
                $usermenu = $menu->add(
                    $login, $loginurl, $logintext, 10003
                );
            }
        } else if (isguestuser()) {
            $usertext = fullname($USER);
            if ($this->is_fontawesome()) {
                $userhtml = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'fa fa-user'));
            } else {
                $userhtml = html_writer::tag('span', '',
                    array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-user'));
            }
            $userhtml .= html_writer::tag('span', $usertext);

            $usermenu = $menu->add($userhtml, new moodle_url('#'), $usertext, 10003);

            $logintext = get_string('login');
            if ($this->is_fontawesome()) {
                $login = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'fa fa-sign-in'));
            } else {
                $login = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-off'));
            }
            $login .= html_writer::tag('span', $logintext);
            $loginurl = new moodle_url('/login/index.php');
            $usermenu->add(
                $login, $loginurl, $logintext, 10004
            );
        } else {
            $usertext = fullname($USER);
            if ($this->is_fontawesome()) {
                $userhtml = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'fa fa-user'));
            } else {
                $userhtml = html_writer::tag('span', '',
                    array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-user'));
            }
            $userhtml .= html_writer::tag('span', $usertext);

            $usermenu = $menu->add($userhtml, new moodle_url('#'), $usertext, 10003);

            $viewprofiletext = get_string('viewprofile');
            if ($this->is_fontawesome()) {
                $viewprofile = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'fa fa-user'));
            } else {
                $viewprofile = html_writer::tag('span', '',
                    array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-user'));
            }
            $viewprofile .= html_writer::tag('span', $viewprofiletext);
            $usermenu->add(
                $viewprofile, new moodle_url('/user/profile.php', array('id' => $USER->id)), $viewprofiletext
            );

            $editmyprofiletext = get_string('editmyprofile');
            if ($this->is_fontawesome()) {
                $editmyprofile = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'fa fa-suitcase'));
            } else {
                $editmyprofile = html_writer::tag('span', '',
                    array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-cog'));
            }
            $editmyprofile .= html_writer::tag('span', $editmyprofiletext);
            $usermenu->add(
                $editmyprofile, new moodle_url('/user/edit.php', array('id' => $USER->id)), $editmyprofiletext
            );

            $preferencestext = get_string('preferences');
            if ($this->is_fontawesome()) {
                $preferences = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'fa fa-key'));
            } else {
                $preferences = html_writer::tag('span', '',
                    array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-cog'));
            }
            $preferences .= html_writer::tag('span', $preferencestext);
            $usermenu->add($preferences, new moodle_url('/user/preferences.php', array('id' => $USER->id)), $preferencestext);

            if (is_role_switched($this->page->course->id)) { // Has switched roles.
                global $DB;
                $context = \context_course::instance($this->page->course->id);
                if ($role = $DB->get_record('role', array('id' => $USER->access['rsw'][$context->path]))) {
                    $rolename = role_get_name($role, $context);
                } else {
                    $rolename = get_string('unknownrole', 'theme_shoehorn');
                }
                if ($this->is_fontawesome()) {
                    $loggedinas = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'fa fa-clock-o'));
                } else {
                    $loggedinas = html_writer::tag('span', '',
                        array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-time'));
                }
                $loggedinas .= get_string('loggedinas', 'theme_shoehorn', $rolename);
                $url = new moodle_url('/course/switchrole.php', array(
                    'id' => $this->page->course->id, 'sesskey' => sesskey(), 'switchrole' => 0,
                    'returnurl' => $this->page->url->out_as_local_url(false)));
                $usermenu->add($loggedinas, $url);
            }

            $logouttext = get_string('logout');
            if ($this->is_fontawesome()) {
                $logout = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'fa fa-sign-out'));
            } else {
                $logout = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-off'));
            }
            $logout .= html_writer::tag('span', $logouttext);
            if (\core\session\manager::is_loggedinas()) {
                $logouturl = new moodle_url('/course/loginas.php',
                    array('id' => $this->page->course->id, 'sesskey' => sesskey()));
            } else {
                $logouturl = new moodle_url('/login/logout.php', array('sesskey' => sesskey()));
            }
            $usermenu->add(
                $logout, $logouturl, $logouttext
            );
        }

        $content = '';
        foreach ($menu->get_children() as $item) {
            $content .= $this->render_custom_menu_item($item, 1);
        }

        return $content;
    }

    public function page_heading_menu() {
        $menu = parent::page_heading_menu();
        if (!empty($menu)) {
            $menu = '<li>'.$menu.'</li>';
        }
        return $menu;
    }

    private function get_course_activities() {
        // A copy of block_activity_modules.
        $course = $this->page->course;
        $modinfo = get_fast_modinfo($course);
        $course = course_get_format($course)->get_course();
        $modfullnames = array();
        $archetypes = array();
        foreach ($modinfo->get_section_info_all() as $section => $thissection) {
            if (($section > $course->numsections) or ( empty($modinfo->sections[$section]))) {
                // This is a stealth section or is empty.
                continue;
            }
            foreach ($modinfo->sections[$thissection->section] as $modnumber) {
                $cm = $modinfo->cms[$modnumber];
                // Exclude activities which are not visible or have no link (=label).
                if (!$cm->uservisible or ! $cm->has_view()) {
                    continue;
                }
                if (array_key_exists($cm->modname, $modfullnames)) {
                    continue;
                }
                if (!array_key_exists($cm->modname, $archetypes)) {
                    $archetypes[$cm->modname] = plugin_supports('mod', $cm->modname, FEATURE_MOD_ARCHETYPE,
                            MOD_ARCHETYPE_OTHER);
                }
                if ($archetypes[$cm->modname] == MOD_ARCHETYPE_RESOURCE) {
                    if (!array_key_exists('resources', $modfullnames)) {
                        $modfullnames['resources'] = get_string('resources');
                    }
                } else {
                    $modfullnames[$cm->modname] = $cm->modplural;
                }
            }
        }
        \core_collator::asort($modfullnames);

        return $modfullnames;
    }

    /**
     * Returns the HTML for the mycourses area on the 'mydashboard' layout.
     * Adapted from Elegance by J Ridden and my work on 2014.imoot.org.
     *
     * @return string HTML.
     */
    protected function mycourses() {
        $content = '';
        $displaymycourses = $this->get_setting('displaymycourses');
        if ($displaymycourses == 2) {
            $mycourses = $this->get_enrolled_courses();

            $content .= html_writer::start_tag('div', array('class' => 'block block_dashboardcourses', 'role' => 'complementary'));
            $content .= html_writer::start_tag('div', array('class' => 'header'));
            $content .= html_writer::start_tag('div', array('class' => 'title'));
            $allurl = new moodle_url('/course/');
            $content .= html_writer::start_tag('div', array('id' => 'allcourses'));
            $content .= html_writer::link($allurl, get_string('fulllistofcourses'), array('class' => 'btn btn-default'));
            $content .= html_writer::end_tag('div');
            $content .= html_writer::tag('h2', get_string('mycourses'));
            $content .= html_writer::end_tag('div');
            $content .= html_writer::end_tag('div');

            if (!empty($mycourses)) {
                $content .= html_writer::start_tag('div', array('class' => 'content'));
                $content .= html_writer::start_tag('div', array('class' => 'mycourseboxes'));
                foreach ($mycourses as $course) {
                    if ($course->visible) {
                        $content .= html_writer::start_tag('div', array('class' => 'view'));
                        $content .= html_writer::start_tag('div', array('class' => 'mask'));
                        $content .= html_writer::tag('h2', $course->fullname);
                        $courseurl = new moodle_url('/course/view.php', array('id' => $course->id));
                        $content .= html_writer::link($courseurl, get_string('enter', 'theme_shoehorn'), array('class' => 'info'));
                        $content .= html_writer::end_tag('div');
                        $content .= html_writer::end_tag('div');
                    }
                }
                $content .= html_writer::end_tag('div');
                $content .= html_writer::end_tag('div');
            }

            $content .= '</div>';
        }
        return $content;
    }

    protected function get_enrolled_courses() {
        if ($this->enrolledcourses == null) {
            global $CFG;
            // Info from: /course/renderer.php::frontpage_my_courses().
            if (!empty($CFG->navsortmycoursessort)) {
                // Sort courses the same as in navigation menu.
                $sortorder = 'visible DESC,' . $CFG->navsortmycoursessort . ' ASC';
            } else {
                $sortorder = 'visible DESC,sortorder ASC';
            }
            $this->enrolledcourses = enrol_get_my_courses('summary, summaryformat', $sortorder);
        }
        return $this->enrolledcourses;
    }

    protected function get_user_messages() {
        global $USER, $DB;
        $messagelist = array();

        $newmessagesql = "SELECT id, smallmessage, useridfrom, useridto, timecreated, fullmessageformat, notification
            FROM {message} WHERE useridto = :userid";

        $newmessages = $DB->get_records_sql($newmessagesql, array('userid' => $USER->id));

        foreach ($newmessages as $message) {
            $messagelist[] = $this->process_message($message);
        }

        $showoldmessages = $this->get_setting('showoldmessages');
        if ($showoldmessages == 2) {
            $maxmessages = 5;
            $readmessagesql = "SELECT id, smallmessage, useridfrom, useridto, timecreated, fullmessageformat, notification
                FROM {message_read} WHERE useridto = :userid ORDER BY timecreated DESC LIMIT $maxmessages";

            $readmessages = $DB->get_records_sql($readmessagesql, array('userid' => $USER->id));

            foreach ($readmessages as $message) {
                if (!$message->notification) {
                    $messagelist[] = $this->process_message($message);
                }
            }
        }

        return $messagelist;
    }

    protected function process_message($message) {
        global $DB;
        $messagecontent = new stdClass();

        if ($message->notification) {
            $messagecontent->text = get_string('unreadnewnotification', 'theme_shoehorn');
        } else {
            if ($message->fullmessageformat == FORMAT_HTML) {
                $message->smallmessage = html_to_text($message->smallmessage);
            }
            if (\core_text::strlen($message->smallmessage) > 15) {
                $messagecontent->text = \core_text::substr($message->smallmessage, 0, 15) . '...';
            } else {
                $messagecontent->text = $message->smallmessage;
            }
        }

        $options = new stdClass();
        $options->para = false;
        $messagecontent->text = format_text($messagecontent->text, FORMAT_PLAIN, $options);

        if ((time() - $message->timecreated ) <= (3600 * 3)) {
            $messagecontent->date = format_time(time() - $message->timecreated);
        } else {
            $messagecontent->date = userdate($message->timecreated, get_string('strftimetime', 'langconfig'));
        }
        $messagecontent->from = $DB->get_record('user', array('id' => $message->useridfrom));

        return $messagecontent;
    }

    public function footer_menu() {
        $o = '';
        $items = array();
        $loggedin = isloggedin();
        $sesskey = sesskey();

        // Home.
        switch ($this->page->pagelayout) {
            case 'course':
                $url = new moodle_url('/my/');
                break;
            case 'incourse':
                $url = new moodle_url('/course/view.php', array('id' => $this->page->course->id));
                break;
            default:
                $url = new moodle_url('/');
        }
        $url = preg_replace('|^https?://|i', '//', $url->out(false));
        $items[] = html_writer::tag('a', get_string('home'), array('href' => $url, 'target' => '_self'));

        // Footer menu setting.
        if ($this->get_setting('footermenu')) {
            $lang = current_language();
            $lines = explode("\n", $this->get_setting('footermenu'));

            foreach ($lines as $line) {
                $line = trim($line);
                $bits = explode('|', $line, 4); // Is: name|url|title|lang.
                if ((!empty($bits[3]) or ( array_key_exists(3, $bits)))) {
                    if ($bits[3] !== $lang) {
                        continue;
                    }
                }
                $title = '';
                if ((!empty($bits[2]) or ( array_key_exists(2, $bits)))) {
                    $title = $bits[2];
                }

                if (strstr($bits[1], '[[site]]')) {
                    // If URL has the '[[site]]' tag, then replace with moodle_url for the site....
                    $bits[1] = str_replace('[[site]]', '', $bits[1]);  // Strip....
                    $thispageurl = new moodle_url($bits[1]);
                    $bits[1] = $thispageurl->out();
                }
                $items[] = html_writer::tag('a', $bits[0], array('href' => $bits[1], 'title' => $title));
            }
        }

        // Syntax highlighting.
        // Show the information page if syntax highlighting has been enabled on the course or if it could be when editing.
        if (($this->syntaxhighlighterenabled) ||
            (($this->get_setting('syntaxhighlight') == 2) && ($this->page->user_is_editing()))) {
            $url = new moodle_url('/theme/shoehorn/pages/syntaxhighlight.php');
            $url = preg_replace('|^https?://|i', '//', $url->out(false));
            $items[] = html_writer::tag('a', get_string('syntaxhighlightpage', 'theme_shoehorn'),
                array('href' => $url, 'target' => '_blank'));
        }

        // Site page setting.
        $pages = \theme_shoehorn\toolbox::shown_sitepages();
        foreach ($pages as $pageid => $status) {
            if ($status == 2) {
                $url = new moodle_url('/theme/shoehorn/pages/sitepage.php');
                $url->param('pageid', $pageid);
                if ($loggedin) {
                    $url->param('sesskey', $sesskey);
                }
                $url = preg_replace('|^https?://|i', '//', $url->out(false));
                $sitepagetitle = $this->get_setting('sitepagetitle' . $pageid);
                $items[] = html_writer::tag('a', $sitepagetitle, array('href' => $url, 'class' => 'sitepagelink'));
            }
        }

        // Copyright setting.
        if ($this->get_setting('copyright')) {
            $items[] = html_writer::tag('span',
                            ' ' . $this->get_setting('copyright') . ' ' . userdate(time(), '%Y'),
                            array('class' => 'copyright'));
        }

        if (count($items) > 0) {
            $o = html_writer::start_tag('div', array('id' => 'footermenu'));
            if (count($items) == 1) {
                $o .= $items[0];
            } else {
                $divider = html_writer::tag('span', '|', array('class' => 'divider'));
                $o .= implode("$divider", $items);
            }
            $o .= html_writer::end_tag('div');
        }

        return $o;
    }

    /**
     * Outputs a heading
     *
     * @param string $text The text of the heading
     * @param int $level The level of importance of the heading. Defaulting to 2
     * @param string $classes A space-separated list of CSS classes. Defaulting to null
     * @param string $id An optional ID
     * @return string the HTML to output.
     */
    public function heading($text, $level = 2, $classes = null, $id = null) {
        $heading = parent::heading($text, $level, $classes, $id);

        if (($level == 2) && ($this->page->pagelayout == 'incourse') && (is_object($this->page->cm))) {
            static $called = false;
            if (!$called) {
                $markup = html_writer::start_tag('div', array('class' => 'row'));

                $markup .= html_writer::start_tag('div', array('class' => 'col-xs-6 col-sm-6 col-md-8 col-lg-10'));
                $markup .= $heading;
                $markup .= html_writer::end_tag('div');

                $markup .= html_writer::start_tag('div', array('class' => 'col-xs-6 col-sm-6 col-md-4 col-lg-2 heading-rts'));
                $markup .= $this->return_to_section();
                $markup .= html_writer::end_tag('div');

                $markup .= html_writer::end_tag('div');
                $called = true;

                return $markup;
            }
        }
        return $heading;
    }

    /**
     * Returns course-specific information to be output immediately below content on any course page
     * (for the current course)
     *
     * @param bool $onlyifnotcalledbefore output content only if it has not been output before
     * @return string
     */
    public function course_content_footer($onlyifnotcalledbefore = false) {
        if ($this->page->course->id == SITEID) {
            // Return immediately and do not include /course/lib.php if not necessary.
            return '';
        }
        static $functioncalled = false;
        if ($functioncalled && $onlyifnotcalledbefore) {
            // We have already output the content header.
            return '';
        }
        $functioncalled = true;

        $markup = parent::course_content_footer($onlyifnotcalledbefore);
        if (($this->page->pagelayout == 'incourse') && (is_object($this->page->cm))) {
            $markup .= html_writer::start_tag('div', array('class' => 'row'));
            $markup .= html_writer::start_tag('div', array('class' => 'col-md-12 text-center footer-rts'));
            $markup .= $this->return_to_section();
            $markup .= html_writer::end_tag('div');
            $markup .= html_writer::end_tag('div');
        }

        return $markup;
    }

    /**
     * Generate the return to section X button code.
     * @return markup.
     */
    protected function return_to_section() {
        static $markup = null;
        if ($markup === null) {
            $courseformatsettings = \course_get_format($this->page->course)->get_format_options();
            $url = new moodle_url('/course/view.php');
            $url->param('id', $this->page->course->id);
            $url->param('sesskey', sesskey());
            $courseformatsettings = \course_get_format($this->page->course)->get_format_options();
            if ((!empty($courseformatsettings['coursedisplay'])) &&
                ($courseformatsettings['coursedisplay'] == \COURSE_DISPLAY_MULTIPAGE)) {
                $url->param('section', $this->page->cm->sectionnum);
                $href = $url->out(false);
            } else {
                $href = $url->out(false).'#section-'.$this->page->cm->sectionnum;
            }
            $title = get_string('returntosection', 'theme_shoehorn', array('section' => $this->page->cm->sectionnum));

            if ($this->is_fontawesome()) {
                $icon = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'fa-sign-in fa fa-fw'));
            } else {
                $icon = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-log-in'));
            }
            $markup = html_writer::tag('a', $title.$icon,
                array('href' => $href, 'class' => 'btn btn-default', 'title' => $title));
        }

        return $markup;
    }

    /**
     * Internal implementation of user image rendering.
     *
     * @param user_picture $userpicture
     * @return string
     */
    protected function render_user_picture(\user_picture $userpicture) {
        if ($this->page->pagetype == 'mod-forum-discuss') {
            $userpicture->size = 1;
        }
        return parent::render_user_picture($userpicture);
    }

    // Page bottom block region.
    /**
     * Get the HTML for blocks for region page-bottom.
     *
     * @return string HTML.
     */
    public function pagebottom_block() {
        $region = 'page-bottom';
        $classes = array();
        $classes[] = 'block-region';
        $classes[] = 'col-md-12';
        $editing = $this->page->user_is_editing();

        $attributes = array(
            'id' => 'block-region-' . preg_replace('#[^a-zA-Z0-9_\-]+#', '-', $region),
            'class' => join(' ', $classes),
            'data-blockregion' => $region,
            'data-droptarget' => '1'
        );

        $output = html_writer::start_tag('aside', $attributes);
        $output .= html_writer::start_tag('div', array('class' => 'row'));

        $region = $this->page->apply_theme_region_manipulations($region);
        $blockcontents = $this->page->blocks->get_content_for_region($region, $this);

        $blockcount = count($blockcontents);

        if ($blockcount >= 1) {
            $blocks = $this->page->blocks->get_blocks_for_region($region);
            $lastblock = null;
            $zones = array();
            foreach ($blocks as $block) {
                $zones[] = $block->title;
            }

            $blocksperrow = $this->get_setting('numpagebottomblocks');
            // When editing we want all the blocks to be the same.
            if (($blocksperrow > 4) || ($editing)) {
                $blocksperrow = 4; // Will result in a 'col-sm-3 col-md-3 col-lg-3'.
            }
            $rows = $blockcount / $blocksperrow; // Maximum blocks per row.

            if (!$editing) {
                if ($rows <= 1) {
                    $col = 12 / $blockcount;
                    if ($col < 1) {
                        // Should not happen but a fail safe - block will be small so good for screen shots when this happens.
                        $col = 1;
                    }
                } else {
                    $col = 12 / $blocksperrow;
                }
            } else {
                $col = 3;
            }

            $currentblockcount = 0;
            $currentrow = 0;
            $currentrequiredrow = 1;
            foreach ($blockcontents as $bc) {
                if (!$editing) { // When not editing use rows to break up the blocks.
                    $currentblockcount++;
                    if ($currentblockcount > ($currentrequiredrow * $blocksperrow)) {
                        // Tripping point.
                        $currentrequiredrow++;
                        // Break...
                        $output .= html_writer::end_tag('div');
                        $output .= html_writer::start_tag('div', array('class' => 'row'));
                        // Recalculate col if needed...
                        $remainingblocks = $blockcount - ($currentblockcount - 1);
                        if ($remainingblocks < $blocksperrow) {
                            $col = 12 / $remainingblocks;
                            if ($col < 1) {
                                /* Should not happen but a fail safe - block will be small so good for screen shots
                                   when this happens. */
                                $col = 1;
                            }
                        }
                    }

                    if ($currentrow < $currentrequiredrow) {
                        $currentrow = $currentrequiredrow;
                    }
                }

                $output .= html_writer::start_tag('div',
                                array('class' => 'col-sm-' . $col . ' col-md-' . $col . ' col-lg-' . $col));
                if ($bc instanceof block_contents) {
                    $output .= $this->block($bc, $region);
                    $lastblock = $bc->title;
                } else if ($bc instanceof block_move_target) {
                    $output .= $this->block_move_target($bc, $zones, $lastblock);
                } else {
                    throw new coding_exception('Unexpected type of thing ('.get_class($bc).') found in list of block contents.');
                }
                $output .= html_writer::end_tag('div');
            }
        }

        $output .= html_writer::end_tag('div'); // Matched with 'row'.
        $output .= html_writer::end_tag('aside');
        return $output;
    }

    /**
     * Get the HTML for blocks in the given region.
     *
     * @since Moodle 2.5.1 2.6
     * @param string $region The region to get HTML for.
     * @return string HTML.
     */
    public function blocks($region, $classes = array(), $tag = 'aside') {
        $output = '';
        $accordionblocks = $this->get_setting('accordion');
        if ($accordionblocks == 2) {
            if (($region == 'side-pre') || ($region == 'side-post')) {
                $output = $this->collapse_blocks($region, $classes, $tag);
            } else {
                $output = parent::blocks($region, $classes, $tag);
            }
        } else {
            $output = parent::blocks($region, $classes, $tag);
        }
        return $output;
    }

    /**
     * Output all the blocks in a particular region.
     *
     * @param string $region the name of a region on this page.
     * @return string the HTML to be output.
     */
    public function blocks_for_region($region) {
        $blockcontents = $this->page->blocks->get_content_for_region($region, $this);
        $blocks = $this->page->blocks->get_blocks_for_region($region);
        $lastblock = null;
        $zones = array();
        foreach ($blocks as $block) {
            $zones[] = $block->title;
        }
        $output = '';

        $chartblock = false;
        foreach ($blockcontents as $bc) {
            if ($bc instanceof block_contents) {
                if (!empty($bc->attributes['chart'])) {
                    $chartblock = $bc;
                } else {
                    $output .= $this->block($bc, $region);
                    $lastblock = $bc->title;
                }
            } else if ($bc instanceof block_move_target) {
                $output .= $this->block_move_target($bc, $zones, $lastblock, $region);
            } else {
                throw new coding_exception('Unexpected type of thing ('.get_class($bc).') found in list of block contents.');
            }
        }

        if ($chartblock) {
            $output .= $this->block($chartblock, $region);
        }

        return $output;
    }

    /**
     * Get the HTML for blocks in the given region.
     *
     * @since Moodle 2.5.1 2.6
     * @param string $region The region to get HTML for.
     * @return string HTML.
     */
    public function collapse_blocks($region, $classes = array(), $tag = 'aside') {
        $displayregion = $this->page->apply_theme_region_manipulations($region);
        $classes = (array) $classes;
        $classes[] = 'block-region';
        $classes[] = 'panel-group';
        $classes[] = 'collapse-blocks';
        $regionid = preg_replace('#[^a-zA-Z0-9_\-]+#', '-', $displayregion);
        $attributes = array(
            'id' => 'block-region-' . $regionid,
            'class' => join(' ', $classes),
            'data-blockregion' => $displayregion,
            'data-droptarget' => '1'
        );
        if ($this->page->blocks->region_has_content($displayregion, $this)) {
            $content = $this->collapse_blocks_for_region($displayregion, $regionid);
        } else {
            $content = '';
        }
        return html_writer::tag($tag, $content, $attributes);
    }

    /**
     * Output all the blocks in a particular region.
     *
     * @param string $region the name of a region on this page.
     * @return string the HTML to be output.
     */
    public function collapse_blocks_for_region($region, $regionid) {
        $blockcontents = $this->page->blocks->get_content_for_region($region, $this);
        $blocks = $this->page->blocks->get_blocks_for_region($region);
        $lastblock = null;
        $zones = array();
        foreach ($blocks as $block) {
            $zones[] = $block->title;
        }
        $output = '';

        $editing = $this->page->user_is_editing();

        $chartblock = false;
        foreach ($blockcontents as $bc) {
            if ($bc instanceof block_contents) {
                $bc->attributes['regionid'] = $regionid;
                $bc->attributes['editing'] = $editing;
                if (!empty($bc->attributes['chart'])) {
                    $chartblock = $bc;
                } else {
                    $output .= $this->collapse_block($bc, $region);
                    $lastblock = $bc->title;
                }
            } else if ($bc instanceof block_move_target) {
                $output .= $this->block_move_target($bc, $zones, $lastblock, $region);
            } else {
                throw new coding_exception('Unexpected type of thing ('.get_class($bc).') found in list of block contents.');
            }
        }

        if ($chartblock) {
            $output .= $this->collapse_block($chartblock, $region);
        }

        return $output;
    }

    /**
     * Prints a nice side block with an optional header.
     *
     * The content is described
     * by a {@link core_renderer::block_contents} object.
     *
     * <div id="inst{$instanceid}" class="block_{$blockname} block">
     *      <div class="header"></div>
     *      <div class="content">
     *          ...CONTENT...
     *          <div class="footer">
     *          </div>
     *      </div>
     *      <div class="annotation">
     *      </div>
     * </div>
     *
     * @param block_contents $bc HTML for the content
     * @param string $region the region the block is appearing in.
     * @return string the HTML to be output.
     */
    public function collapse_block(block_contents $bc, $region) {
        $bc = clone($bc); // Avoid messing up the object passed in.
        if (empty($bc->blockinstanceid) || !strip_tags($bc->title)) {
            $bc->collapsible = block_contents::NOT_HIDEABLE;
        }
        if (!empty($bc->blockinstanceid)) {
            $bc->attributes['data-instanceid'] = $bc->blockinstanceid;
        }
        $skiptitle = strip_tags($bc->title);
        if ($bc->blockinstanceid && !empty($skiptitle)) {
            $bc->attributes['aria-labelledby'] = 'instance-' . $bc->blockinstanceid . '-header';
        } else if (!empty($bc->arialabel)) {
            $bc->attributes['aria-label'] = $bc->arialabel;
        }
        $bc->add_class('panel');
        $bc->add_class('panel-default');

        $output = html_writer::start_tag('div', $bc->attributes);

        $output .= $this->collapse_block_header($bc);
        $output .= $this->collapse_block_content($bc);

        $output .= html_writer::end_tag('div');

        $output .= $this->block_annotation($bc);

        $this->init_block_hider_js($bc);
        return $output;
    }

    /**
     * Produces a header for a block
     *
     * @param block_contents $bc
     * @return string
     */
    protected function collapse_block_header(block_contents $bc) {
        $title = '';
        $attributes = array();
        if ($bc->blockinstanceid) {
            $attributes['id'] = 'instance-' . $bc->blockinstanceid . '-header';
        }
        if ($bc->title) {
            $title = $bc->title;
        } else if (!empty($bc->arialabel)) {
            $title = $bc->arialabel;
        } else {
            $title = get_string('blocktitleunknown', 'theme_shoehorn');
        }
        $title = html_writer::tag('h2', $title, $attributes);

        $blockid = null;
        if (isset($bc->attributes['id'])) {
            $blockid = $bc->attributes['id'];
        }
        $controlshtml = $this->block_controls($bc->controls, $blockid);

        $headerattributes = array('class' => 'header panel-heading',
            'data-parent' => '#block-region-'.$bc->attributes['regionid']);
        if (!$this->block_has_class($bc, 'block_fake')) {
            $headerattributes['data-toggle'] = 'collapse';
            $headerattributes['href'] = '#collapse-' . $bc->blockinstanceid;
        }
        $output = html_writer::tag('a', html_writer::tag('div', $title, array('class' => 'title panel-title')), $headerattributes);

        if ($controlshtml) {
            $output .= html_writer::tag('div', html_writer::tag('div', $controlshtml, array('class' => 'title')),
                array('class' => 'header controlshtml'));
        }

        return $output;
    }

    /**
     * Produces the content area for a block
     *
     * @param block_contents $bc
     * @return string
     */
    protected function collapse_block_content(block_contents $bc) {
        $blockattributes = array('class' => 'content panel-collapse');
        if (!$this->block_has_class($bc, 'block_fake')) {
            $blockattributes['class'] .= ' collapse';
            if (($bc->attributes['editing']) || ($this->block_has_class($bc, 'block_adminblock'))) {
                $blockattributes['class'] .= ' in';
            }
            $blockattributes['id'] = 'collapse-' . $bc->blockinstanceid;
        }
        $output = html_writer::start_tag('div', $blockattributes);
        $output .= $bc->content;
        $output .= $this->block_footer($bc);
        $output .= html_writer::end_tag('div');

        return $output;
    }

    protected function block_has_class(block_contents $bc, $class) {
        return strpos($bc->attributes['class'], $class) !== false;
    }

    /**
     * The standard tags (meta tags, links to stylesheets and JavaScript, etc.)
     * that should be included in the <head> tag. Designed to be called in theme
     * layout.php files.
     *
     * @return string HTML fragment.
     */
    public function standard_head_html() {
        switch ($this->page->pagelayout) {
            case 'course':
            case 'incourse':
                $this->syntax_highlighter();
        }
        return parent::standard_head_html();
    }

    protected function syntax_highlighter() {
        if ($this->get_setting('syntaxhighlight') == 2) {
            if (strpos($this->page->course->summary, get_string('syntaxsummary', 'theme_shoehorn')) !== false) {
                $this->page->requires->js('/theme/shoehorn/javascript/syntaxhighlighter_3_0_83/scripts/shCore.js');
                $this->page->requires->js('/theme/shoehorn/javascript/syntaxhighlighter_3_0_83/scripts/shAutoloader.js');
                $this->page->requires->css('/theme/shoehorn/javascript/syntaxhighlighter_3_0_83/styles/shCore.css');
                $this->page->requires->css('/theme/shoehorn/javascript/syntaxhighlighter_3_0_83/styles/shThemeDefault.css');
                $this->syntaxhighlighterenabled = true;
            }
        }
    }

    /**
     * The standard tags (typically script tags that are not needed earlier) that
     * should be output after everything else. Designed to be called in theme layout.php files.
     *
     * @return string HTML fragment.
     */
    public function standard_end_of_body_html() {
        global $CFG;
        $output = html_writer::start_tag('div', array ('class' => 'themecredit')).
            get_string('credit', 'theme_shoehorn').
            html_writer::link('//about.me/gjbarnard', 'Gareth J Barnard', array('target' => '_blank')).
            html_writer::end_tag('div');
        $output .= parent::standard_end_of_body_html();

        if ($this->syntaxhighlighterenabled) {
            $syscontext = \context_system::instance();
            $itemid = \theme_get_revision();
            $url = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php",
                "/$syscontext->id/theme_shoehorn/syntaxhighlighter/$itemid/");
            $url = preg_replace('|^https?://|i', '//', $url->out(false));

            $script = "require(['jquery', 'core/log'], function($, log) {";  // Use AMD to get jQuery.
            $script .= "log.debug('Shoehorn SyntaxHighlighter AMD autoloader');";
            $script .= "$('document').ready(function(){";
            $script .= "SyntaxHighlighter.autoloader(";
            $script .= "[ 'applescript', '" . $url . "shBrushAppleScript.js' ],";
            $script .= "[ 'actionscript3', 'as3', '" . $url . "shBrushAS3.js' ],";
            $script .= "[ 'bash', 'shell', '" . $url . "shBrushBash.js' ],";
            $script .= "[ 'coldfusion', 'cf', '" . $url . "shBrushColdFusion.js' ],";
            $script .= "[ 'cpp', 'c', '" . $url . "shBrushCpp.js' ],";
            $script .= "[ 'c#', 'c-sharp', 'csharp', '" . $url . "shBrushCSharp.js' ],";
            $script .= "[ 'css', '" . $url . "shBrushCss.js' ],";
            $script .= "[ 'delphi', 'pascal', '" . $url . "shBrushDelphi.js' ],";
            $script .= "[ 'diff', 'patch', 'pas', '" . $url . "shBrushDiff.js' ],";
            $script .= "[ 'erl', 'erlang', '" . $url . "shBrushErlang.js' ],";
            $script .= "[ 'groovy', '" . $url . "shBrushGroovy.js' ],";
            $script .= "[ 'haxe hx', '" . $url . "shBrushHaxe.js', ],";
            $script .= "[ 'java', '" . $url . "shBrushJava.js' ],";
            $script .= "[ 'jfx', 'javafx', '" . $url . "shBrushJavaFX.js' ],";
            $script .= "[ 'js', 'jscript', 'javascript', '" . $url . "shBrushJScript.js' ],";
            $script .= "[ 'perl', 'pl', '" . $url . "shBrushPerl.js' ],";
            $script .= "[ 'php', '" . $url . "shBrushPhp.js' ],";
            $script .= "[ 'text', 'plain', '" . $url . "shBrushPlain.js' ],";
            $script .= "[ 'py', 'python', '" . $url . "shBrushPython.js' ],";
            $script .= "[ 'ruby', 'rails', 'ror', 'rb', '" . $url . "shBrushRuby.js' ],";
            $script .= "[ 'scala', '" . $url . "shBrushScala.js' ],";
            $script .= "[ 'sql', '" . $url . "shBrushSql.js' ],";
            $script .= "[ 'vb', 'vbnet', '" . $url . "shBrushVb.js' ],";
            $script .= "[ 'xml', 'xhtml', 'xslt', 'html', '" . $url . "shBrushXml.js' ]";
            $script .= ');';
            $script .= 'SyntaxHighlighter.all(); console.log("Syntax Highlighter Init");';
            $script .= '});';
            $script .= '});';
            $output .= html_writer::script($script);
        }

        return $output;
    }

    public function anti_gravity() {
        if ($this->is_fontawesome()) {
            $icon = html_writer::start_tag('span', array('aria-hidden' => 'true', 'class' => 'fa fa-arrow-circle-o-up')).
                html_writer::end_tag('span');
        } else {
            $icon = html_writer::start_tag('span', array('aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-upload')).
                html_writer::end_tag('span');
        }
        $antigravity = html_writer::tag('a', $icon,
            array('class' => 'antiGravity', 'title' => get_string('antigravity', 'theme_shoehorn')));

        return $antigravity;
    }
}
