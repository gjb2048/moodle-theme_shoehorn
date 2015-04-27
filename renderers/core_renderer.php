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

class theme_shoehorn_core_renderer extends core_renderer {

    protected $enrolledcourses = null;
    protected $syntaxhighlighterenabled = false;

    public function notification($message, $classes = 'notifyproblem') {
        $message = clean_text($message);

        if ($classes == 'notifyproblem') {
            return html_writer::div($message, 'alert alert-danger');
        }
        if ($classes == 'notifywarning') {
            return html_writer::div($message, 'alert alert-warning');
        }
        if ($classes == 'notifysuccess') {
            return html_writer::div($message, 'alert alert-success');
        }
        if ($classes == 'notifymessage') {
            return html_writer::div($message, 'alert alert-info');
        }
        if ($classes == 'redirectmessage') {
            return html_writer::div($message, 'alert alert-block alert-info');
        }
        if ($classes == 'notifytiny') {
            // Not an appropriate semantic alert class!
            return $this->debug_listing($message);
        }
        return html_writer::div($message, $classes);
    }

    private function debug_listing($message) {
        $message = str_replace('<ul style', '<ul class="list-unstyled" style', $message);
        return html_writer::tag('pre', $message, array('class' => 'alert alert-info'));
    }

    protected function render_custom_menu_item(custom_menu_item $menunode, $level = 0 ) {
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
                $url = '#cm_submenu_'.$submenucount;
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
            $content = '<li>';
            // The node doesn't have children so produce a final menuitem.
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#';
            }
            $content .= html_writer::link($url, $menunode->get_text(), array('title' => $menunode->get_title()));
        }
        return $content;
    }

    protected function render_tabtree(tabtree $tabtree) {
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
        return html_writer::tag('ul', $firstrow, array('class' => 'nav nav-tabs nav-justified')) . $secondrow;
    }

    protected function render_tabobject(tabobject $tab) {
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
     * @param string $tag The tag to encase the heading in. h1 by default.
     * @return string HTML.
     */
    public function page_heading($tag = 'h1') {
        $o = '';

        $logo = $this->page->theme->setting_file_url('logo', 'logo');
        if (!is_null($logo)) {
            $o .= html_writer::start_tag('div', array('class' => 'row')).
                  html_writer::start_tag('div', array('class' => 'col-xs-4 col-sm-2 col-md-1')).
                  html_writer::link(new moodle_url('/'),
                  html_writer::empty_tag('img', array('src' => $logo, 'alt' => get_string('logo', 'theme_shoehorn'), 'class' => 'logo img-responsive')),
                  array('title' => get_string('home'), 'class' => 'logoarea')).
                  html_writer::end_tag('div').
                  html_writer::tag($tag, $this->page->heading, array('class' => 'logoheading')).
                  html_writer::end_tag('div');
        } else {
            $o .= html_writer::link(new moodle_url('/'),
                  html_writer::tag($tag, $this->page->heading, array('class' => 'heading')),
                  array('title' => get_string('home'), 'class' => 'logoarea'));
        }

        $ieprop = core_useragent::check_ie_properties();
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
        if (empty($items)) { // MDL-46107
            return '';
        }
        if ($this->page->theme->settings->fontawesome) {
            if (right_to_left()) {
                $dividericon = 'fa-angle-left';
            } else {
                $dividericon = 'fa-angle-right';
            }
            $icon = html_writer::start_tag('i', array('class' => 'fa '. $dividericon .' fa-lg')) . html_writer::end_tag('i');
        } else {
            if (right_to_left()) {
                $dividericon = 'glyphicon-chevron-left';
            } else {
                $dividericon = 'glyphicon-chevron-right';
            }
            $icon = html_writer::start_tag('span', array('class' => 'glyphicon '. $dividericon)) . html_writer::end_tag('span');
        }
        $divider = html_writer::tag('span', $icon, array('class' => 'divider'));
        $breadcrumbs = array();
        foreach ($items as $item) {
            $item->hideicon = true;
            $breadcrumbs[] = $this->render($item);
        }
        $list_items = html_writer::start_tag('li') . implode("$divider" . html_writer::end_tag('li') .
                        html_writer::start_tag('li'), $breadcrumbs) . html_writer::end_tag('li');
        $title = html_writer::tag('span', get_string('pagepath'), array('class' => 'accesshide'));
        return $title . html_writer::tag('ul', "$list_items", array('class' => 'breadcrumb'));
    }

    public function custom_menu($custommenuitems = '') {
        /* The custom menu is always shown, even if no menu items
           are configured in the global theme settings page. */
        global $CFG;

        if (empty($custommenuitems) && !empty($CFG->custommenuitems)) { // MDL-45507
            $custommenuitems = $CFG->custommenuitems;
        }
        $custommenu = new custom_menu($custommenuitems, current_language());
        return $this->render_custom_menu($custommenu);
    }

    protected function render_custom_menu(custom_menu $menu) {
        global $CFG, $USER;

        /* TODO: eliminate this duplicated logic, it belongs in core, not
                 here. See MDL-39565. */

        $content = html_writer::start_tag('ul', array('class' => 'nav navbar-nav'));
        foreach ($menu->get_children() as $item) {
            $content .= $this->render_custom_menu_item($item, 1);
        }
        $content .= html_writer::end_tag('ul');

        return $content;
    }

    public function user_menu($user = NULL, $withlinks = NULL) {
        global $CFG;
        $usermenu = new custom_menu('', current_language());
        return $this->render_user_menu($usermenu);
    }

    protected function render_user_menu(custom_menu $menu) {
        global $CFG, $USER;

        $addusermenu = true;
        $addlangmenu = true;
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
            $messagemenutext = html_writer::tag('span', $messagecount.' ');
            if ($this->page->theme->settings->fontawesome) {
                $class = 'fa fa-envelope';
                if ($messagecount == 0) {
                    $class .= '-o';
                }
                $messagemenutext .= html_writer::tag('i', '', array('class' => $class));
                $timeicon = 'fa fa-clock-o';
            } else {
                $messagemenutext .= html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-envelope'));
                $timeicon = 'glyphicon glyphicon-time';
            }
            $messagemenucount = $messagecount.' ';
            if ($messagecount == 1) {
                 $messagemenucount .= get_string('message', 'message');
            } else {
                 $messagemenucount .= get_string('messages', 'message');
            }
            $messagemenu = $menu->add(
                $messagemenutext,
                new moodle_url('/message/index.php', array('viewing' => 'recentconversations')),
                $messagemenucount,
                9999
            );
            foreach ($messages as $message) {
                if (!$message->from) { // Workaround for issue #103.
                    continue;
                }
                $senderpicture = new user_picture($message->from);
                $senderpicture->link = false;
                $senderpicture = $this->render($senderpicture);

                $messagecontent = $senderpicture;
                $messagecontent .= html_writer::start_span('msg-body');
                $messagecontent .= html_writer::start_span('msg-title');
                $messagecontent .= html_writer::span($message->from->firstname . ': ', 'msg-sender');
                $messagecontent .= $message->text;
                $messagecontent .= html_writer::end_span();
                $messagecontent .= html_writer::start_span('msg-time');
                $messagecontent .= html_writer::tag('i', '', array('class' => $timeicon));
                $messagecontent .= html_writer::span($message->date);
                $messagecontent .= html_writer::end_span();

                $messageurl = new moodle_url('/message/index.php', array('user1' => $USER->id, 'user2' => $message->from->id));
                $messagemenu->add($messagecontent, $messageurl, $message->text);
            }
        }

        $displaymycourses = (empty($this->page->theme->settings->displaymycoursesmenu)) ? false : $this->page->theme->settings->displaymycoursesmenu;
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
            if ($this->page->theme->settings->fontawesome) {
                $branchlabel = html_writer::tag('i', '', array('class' => 'fa fa-dashboard'));
            } else {
                $branchlabel = html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-dashboard'));
            }
            $branchlabel .= html_writer::tag('span', ' '.$branchtitle);
            $branchurl   = new moodle_url('/my/index.php');
            $branchsort  = 10000;
 
            $mycoursesmenu = $menu->add($branchlabel, $branchurl, $branchtitle, $branchsort);

            $hometext = get_string('myhome');
            if ($this->page->theme->settings->fontawesome) {
                $homelabel = html_writer::tag('i', '', array('class' => 'fa fa-home'));
            } else {
                $homelabel = html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-home'));
            }
            $homelabel .= html_writer::tag('span', ' '.$hometext);
            $mycoursesmenu->add($homelabel, new moodle_url('/my/index.php'), $hometext);

            if ($this->page->theme->settings->fontawesome) {
                $courseicons = array('list', 'list-alt', 'book', 'tasks', 'suitcase');
            } else {
                $courseicons = array('list', 'list-alt', 'book', 'tasks', 'briefcase');
            }

            $courses = $this->get_enrolled_courses();
            $rhosts = array();
            $rcourses = array();
            if (!empty($CFG->mnet_dispatcher_mode) && $CFG->mnet_dispatcher_mode==='strict') {
                $rcourses = get_my_remotecourses($USER->id);
                $rhosts   = get_my_remotehosts();
            }
            if (!empty($courses) || !empty($rcourses) || !empty($rhosts)) {
                foreach ($courses as $course) {
                    if ($course->visible){
                        $coursetext = format_string($course->fullname);
                        if ($this->page->theme->settings->fontawesome) {
                            $courselabel = html_writer::tag('i', '', array('class' => 'fa fa-'.$courseicons[$course->id % 5])); // 5 is the courseicons array length.
                        } else {
                            $courselabel = html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-'.$courseicons[$course->id % 5]));
                        }
                        $courselabel .= html_writer::tag('span', ' '.$coursetext);

                        $mycoursesmenu->add($courselabel, new moodle_url('/course/view.php?id='.$course->id), format_string($course->shortname));
                    }
                }
                // MNET
                if (!empty($rcourses)) {
                    // at the IDP, we know of all the remote courses
                    foreach ($rcourses as $course) {
                        $url = new moodle_url('/auth/mnet/jump.php', array(
                            'hostid' => $course->hostid,
                            'wantsurl' => '/course/view.php?id='. $course->remoteid
                        ));
                        $tooltip = format_string($course->hostname).' : '.format_string($course->cat_name).' : '.format_string($course->shortname);

                        $coursetext = format_string($course->fullname);
                        if ($this->page->theme->settings->fontawesome) {
                            $courselabel = html_writer::tag('i', '', array('class' => 'fa fa-'.$courseicons[$course->remoteid % 5])); // 5 is the courseicons array length.
                        } else {
                            $courselabel = html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-'.$courseicons[$course->remoteid % 5]));
                        }
                        $courselabel .= html_writer::tag('span', ' '.$coursetext);

                        $mycoursesmenu->add($courselabel, $url, $tooltip);
                    }
                }
                if (!empty($rhosts)) {
                    // non-IDP, we know of all the remote servers, but not courses
                    foreach ($rhosts as $host) {
                        $coursetext = format_string($course->fullname);
                        if ($this->page->theme->settings->fontawesome) {
                            $courselabel = html_writer::tag('i', '', array('class' => 'fa fa-'.$courseicons[0]));
                        } else {
                            $courselabel = html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-'.$courseicons[0]));
                        }
                        $courselabel .= html_writer::tag('span', ' '.$coursetext);

                        $mycoursesmenu->add($courselabel, html_writer::link($host['url'], s($host['name']), array('title' => s($host['name']))), $host['count'] . ' ' . get_string('courses'));
                    }
                }
             } else {
                $noenrolments = get_string('noenrolments', 'theme_shoehorn');
                $mycoursesmenu->add('<em>'.$noenrolments.'</em>', new moodle_url('/'), $noenrolments);
             }
        }

        $langs = get_string_manager()->get_list_of_translations();
        if (count($langs) < 2
        or empty($CFG->langmenu)
        or ($this->page->course != SITEID and !empty($this->page->course->lang))) {
            $addlangmenu = false;
        }

        if ($addlangmenu) {
            $languagetext = get_string('language');
            if ($this->page->theme->settings->fontawesome) {
                $langhtml = html_writer::tag('i', '', array('class' => 'fa fa-language'));
            } else {
                $langhtml = html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-book'));
            }
            $langhtml .= html_writer::tag('span', ' '.$languagetext);
            $language = $menu->add($langhtml, new moodle_url('#'), $languagetext, 10000);
            foreach ($langs as $langtype => $langname) {
                $language->add($langname, new moodle_url($this->page->url, array('lang' => $langtype)), $langname);
            }
        }

        if (($this->page->pagelayout == 'course') || ($this->page->pagelayout == 'incourse')){
            if (!isguestuser()) {
                if (isset($this->page->course->id) && $this->page->course->id > 1) {
                    $branchtitle = get_string('thiscourse', 'theme_shoehorn');
                    if ($this->page->theme->settings->fontawesome) {
                        $branchlabel = '<i class="fa fa-book"></i>';
                    } else {
                        $branchlabel = '<span class="glyphicon glyphicon-book"></span>';
                    }
                    $branchlabel .= html_writer::tag('span', ' '.$branchtitle);
                    $branchurl = new moodle_url('#');
                    $activitystreammenu = $menu->add($branchlabel, $branchurl, $branchtitle, 10001);
                    $branchtitle = get_string('people', 'theme_shoehorn');
                    if ($this->page->theme->settings->fontawesome) {
                        $branchlabel = '<i class="fa fa-users"></i>';
                    } else {
                        $branchlabel = '<span class="glyphicon glyphicon-user"></span>';
                    }
                    $branchlabel .= html_writer::tag('span', ' '.$branchtitle);
                    $branchurl = new moodle_url('/user/index.php', array('id' => $this->page->course->id));
                    $activitystreammenu->add($branchlabel, $branchurl, $branchtitle, 100003);
                    $branchtitle = get_string('grades');
                    if ($this->page->theme->settings->fontawesome) {
                        $branchlabel = '<i class="fa fa-list-alt icon"></i>';
                    } else {
                        $branchlabel = '<span class="glyphicon glyphicon-list"></span>';
                    }
                    $branchlabel .= html_writer::tag('span', ' '.$branchtitle);
                    $branchurl = new moodle_url('/grade/report/index.php', array('id' => $this->page->course->id));
                    $activitystreammenu->add($branchlabel, $branchurl, $branchtitle, 100004);

                    $data = $this->get_course_activities();
                    foreach ($data as $modname => $modfullname) {
                        if ($modname === 'resources') {
                            $icon = $this->pix_icon('icon', '', 'mod_page', array('class' => 'icon'));
                            $activitystreammenu->add($icon.$modfullname, new moodle_url('/course/resources.php', array('id' => $this->page->course->id)));
                        } else {
                            $icon = '<img src="'.$this->pix_url('icon', $modname) . '" class="icon" alt="" />';
                            $activitystreammenu->add($icon.$modfullname, new moodle_url('/mod/'.$modname.'/index.php', array('id' => $this->page->course->id)));
                        }
                    }
                }
            }
        }

        if (($this->page->pagelayout == 'course') || ($this->page->pagelayout == 'incourse') || ($this->page->pagelayout == 'admin')) { // Go to bottom.
            if ($this->page->theme->settings->fontawesome) {
                $gotobottom = html_writer::tag('i', '', array('class' => 'fa fa-arrow-circle-o-down'));
            } else {
                $gotobottom = html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-circle-arrow-down'));
            }
            $menu->add($gotobottom, new moodle_url('#region-main-shoehorn-shadow'), get_string('gotobottom', 'theme_shoehorn'), 10002);
        }

        if ($addusermenu) {
            if (isloggedin()) {
                $usertext = fullname($USER);
                if ($this->page->theme->settings->fontawesome) {
                    $userhtml = html_writer::tag('i', '', array('class' => 'fa fa-user'));
                } else {
                    $userhtml = html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-user'));
                }
                $userhtml .= html_writer::tag('span', ' '.$usertext);

                $usermenu = $menu->add($userhtml, new moodle_url('#'), $usertext, 10003);

                $logouttext = get_string('logout');
                if ($this->page->theme->settings->fontawesome) {
                    $logout = html_writer::tag('i', '', array('class' => 'fa fa-power-off'));
                } else {
                    $logout = html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-off'));
                }
                $logout .= html_writer::tag('span', $logouttext);
                $usermenu->add(
                    $logout,
                    new moodle_url('/login/logout.php', array('sesskey' => sesskey(), 'alt' => 'logout')),
                    $logouttext
                );

                $viewprofiletext = get_string('viewprofile');
                if ($this->page->theme->settings->fontawesome) {
                    $viewprofile = html_writer::tag('i', '', array('class' => 'fa fa-user'));
                } else {
                    $viewprofile = html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-user'));
                }
                $viewprofile .= html_writer::tag('span', $viewprofiletext);
                $usermenu->add(
                    $viewprofile,
                    new moodle_url('/user/profile.php', array('id' => $USER->id)),
                    $viewprofiletext
                );

                $editmyprofiletext = get_string('editmyprofile');
                if ($this->page->theme->settings->fontawesome) {
                    $editmyprofile = html_writer::tag('i', '', array('class' => 'fa fa-suitcase'));
                } else {
                    $editmyprofile = html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-cog'));
                }
                $editmyprofile .= html_writer::tag('span', $editmyprofiletext);
                $usermenu->add(
                    $editmyprofile,
                    new moodle_url('/user/edit.php', array('id' => $USER->id)),
                    $editmyprofiletext
                );
            } elseif ($this->page->pagelayout != 'login') {
                $usermenu = $menu->add(get_string('login'), new moodle_url('/login/index.php'), get_string('login'), 10003);
            }
        }

        $content = html_writer::start_tag('ul', array('class' => 'nav navbar-nav navbar-right'));
        foreach ($menu->get_children() as $item) {
            $content .= $this->render_custom_menu_item($item, 1);
        }
        $content .= html_writer::end_tag('ul');

        return $content;
    }

    private function get_course_activities() {
        // A copy of block_activity_modules.
        $course = $this->page->course;
        $content = new stdClass();
        $modinfo = get_fast_modinfo($course);
        $modfullnames = array();
        $archetypes = array();
        foreach ($modinfo->cms as $cm) {
            // Exclude activities which are not visible or have no link (=label).
            if (!$cm->uservisible or !$cm->has_view()) {
                continue;
            }
            if (array_key_exists($cm->modname, $modfullnames)) {
                continue;
            }
            if (!array_key_exists($cm->modname, $archetypes)) {
                $archetypes[$cm->modname] = plugin_supports('mod', $cm->modname, FEATURE_MOD_ARCHETYPE, MOD_ARCHETYPE_OTHER);
            }
            if ($archetypes[$cm->modname] == MOD_ARCHETYPE_RESOURCE) {
                if (!array_key_exists('resources', $modfullnames)) {
                    $modfullnames['resources'] = get_string('resources');
                }
            } else {
                $modfullnames[$cm->modname] = $cm->modplural;
            }
        }
        core_collator::asort($modfullnames);

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
        $displaymycourses = (empty($this->page->theme->settings->displaymycourses)) ? false : $this->page->theme->settings->displaymycourses;
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
                // sort courses the same as in navigation menu
                $sortorder = 'visible DESC,'. $CFG->navsortmycoursessort.' ASC';
            } else {
                $sortorder = 'visible DESC,sortorder ASC';
            }
            $this->enrolledcourses = enrol_get_my_courses('summary, summaryformat', $sortorder);
        }
        return $this->enrolledcourses;
    }

    protected function process_user_messages() {
        $messagelist = array();

        foreach ($usermessages as $message) {
            $cleanmsg = new stdClass();
            $cleanmsg->from = fullname($message);
            $cleanmsg->msguserid = $message->id;

            $userpicture = new user_picture($message);
            $userpicture->link = false;
            $picture = $this->render($userpicture);

            $cleanmsg->text = $picture . ' ' . $cleanmsg->text;

            $messagelist[] = $cleanmsg;
        }

        return $messagelist;
    }

    protected function get_user_messages() {
        global $USER, $DB;
        $messagelist = array();

        $newmessagesql = "SELECT id, smallmessage, useridfrom, useridto, timecreated, fullmessageformat, notification
                            FROM {message}
                           WHERE useridto = :userid";

        $newmessages = $DB->get_records_sql($newmessagesql, array('userid' => $USER->id));

        foreach ($newmessages as $message) {
            $messagelist[] = $this->shoehorn_process_message($message);
        }

        $showoldmessages = (empty($this->page->theme->settings->showoldmessages)) ? false : $this->page->theme->settings->showoldmessages;
        if ($showoldmessages == 2) {
            $maxmessages = 5;
            $readmessagesql = "SELECT id, smallmessage, useridfrom, useridto, timecreated, fullmessageformat, notification
                                 FROM {message_read}
                                WHERE useridto = :userid
                             ORDER BY timecreated DESC
                                LIMIT $maxmessages";

            $readmessages = $DB->get_records_sql($readmessagesql, array('userid' => $USER->id));

            foreach ($readmessages as $message) {
                $messagelist[] = $this->shoehorn_process_message($message);
            }
        }

        return $messagelist;

    }

    protected function shoehorn_process_message($message) {
        global $DB;
        $messagecontent = new stdClass();

        if ($message->notification) {
            $messagecontent->text = get_string('unreadnewnotification', 'theme_shoehorn');
        } else {
            if ($message->fullmessageformat == FORMAT_HTML) {
                $message->smallmessage = html_to_text($message->smallmessage);
            }
            if (core_text::strlen($message->smallmessage) > 15) {
                $messagecontent->text = core_text::substr($message->smallmessage, 0, 15).'...';
            } else {
                $messagecontent->text = $message->smallmessage;
            }
        }

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
        switch($this->page->pagelayout) {
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
        if (!empty($this->page->theme->settings->footermenu)) {
            $lang = current_language();
            $lines = explode("\n", $this->page->theme->settings->footermenu);

            foreach ($lines as $line) {
                $line = trim($line);
                $bits = explode('|', $line, 4); // name|url|title|lang
                if ((!empty($bits[3]) or (array_key_exists(3, $bits)))) {
                    if ($bits[3] !== $lang) {
                        continue;
                    }
                }
                $title = '';
                if ((!empty($bits[2]) or (array_key_exists(2, $bits)))) {
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
        if (($this->syntaxhighlighterenabled) || 
            ((!empty($this->page->theme->settings->syntaxhighlight)) && ($this->page->theme->settings->syntaxhighlight == 2) && ($this->page->user_is_editing()))) {
            $url = new moodle_url('/theme/shoehorn/pages/syntaxhighlight.php');
            $url = preg_replace('|^https?://|i', '//', $url->out(false));
            $items[] = html_writer::tag('a', get_string('syntaxhighlightpage', 'theme_shoehorn'), array('href' => $url, 'target' => '_blank'));
        }

        // Site page setting.
        $pages = shoehorn_shown_sitepages(); // lib.php.
        foreach($pages as $pageid => $status) {
            if ($status == 2) {
                $url = new moodle_url('/theme/shoehorn/pages/sitepage.php');
                $url->param('pageid', $pageid);
                if ($loggedin) {
                    $url->param('sesskey', $sesskey);
                }
                $url = preg_replace('|^https?://|i', '//', $url->out(false));
                $sitepagetitle = 'sitepagetitle'.$pageid;
                $items[] = html_writer::tag('a', $this->page->theme->settings->$sitepagetitle, array('href' => $url, 'class' => 'sitepagelink'));
            }
        }

        // Copyright setting.
        if (!empty($this->page->theme->settings->copyright)) {
            $items[] = html_writer::tag('span', ' '.$this->page->theme->settings->copyright.' '.userdate(time(), '%Y'), array('class' => 'copyright'));
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

    // Page bottom block region.
    /**
     * Get the HTML for blocks for region page-bottom.
     *
     * @return string HTML.
     */
    public function shoehorn_pagebottom_block() {
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

            $blocksperrow = $this->page->theme->settings->numpagebottomblocks;
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
                                // Should not happen but a fail safe - block will be small so good for screen shots when this happens.
                                $col = 1;
                            }
                        }
                    }

                    if ($currentrow < $currentrequiredrow) {
                        $currentrow = $currentrequiredrow;
                    }
                }

                $output .= html_writer::start_tag('div', array('class' => 'col-sm-'.$col.' col-md-'.$col.' col-lg-'.$col));
                if ($bc instanceof block_contents) {
                    $output .= $this->block($bc, $region);
                    $lastblock = $bc->title;
                } else if ($bc instanceof block_move_target) {
                    $output .= $this->block_move_target($bc, $zones, $lastblock);
                } else {
                    throw new coding_exception('Unexpected type of thing (' . get_class($bc) . ') found in list of block contents.');
                }
                $output .= html_writer::end_tag('div');
            }
        }

        $output .= html_writer::end_tag('div'); // row.
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
        $accordionblocks = (empty($this->page->theme->settings->accordion)) ? false : $this->page->theme->settings->accordion;
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
     * Get the HTML for blocks in the given region.
     *
     * @since Moodle 2.5.1 2.6
     * @param string $region The region to get HTML for.
     * @return string HTML.
     */
    public function collapse_blocks($region, $classes = array(), $tag = 'aside') {
        $displayregion = $this->page->apply_theme_region_manipulations($region);
        $classes = (array)$classes;
        $classes[] = 'block-region';
        $classes[] = 'panel-group';
        $classes[] = 'collapse-blocks';
        $regionid = preg_replace('#[^a-zA-Z0-9_\-]+#', '-', $displayregion);
        $attributes = array(
            'id' => 'block-region-'.$regionid,
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

        foreach ($blockcontents as $bc) {
            if ($bc instanceof block_contents) {
                $bc->attributes['regionid'] = $regionid;
                $bc->attributes['editing'] = $editing;
                $output .= $this->collapse_block($bc, $region);
                $lastblock = $bc->title;
            } else if ($bc instanceof block_move_target) {
                $output .= $this->block_move_target($bc, $zones, $lastblock, $region);
            } else {
                throw new coding_exception('Unexpected type of thing (' . get_class($bc) . ') found in list of block contents.');
            }
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
            $bc->attributes['aria-labelledby'] = 'instance-'.$bc->blockinstanceid.'-header';
        } else if (!empty($bc->arialabel)) {
            $bc->attributes['aria-label'] = $bc->arialabel;
        }
        /*if ($bc->dockable) {
            $bc->attributes['data-dockable'] = 1;
        }
        if ($bc->collapsible == block_contents::HIDDEN) {
            $bc->add_class('hidden');
        }
        if (!empty($bc->controls)) {
            $bc->add_class('block_with_controls');
        }*/
        $bc->add_class('panel');
        $bc->add_class('panel-default');


        $output = '';
        /*if (empty($skiptitle)) {
            $output = '';
            $skipdest = '';
        } else {
            $output = html_writer::tag('a', get_string('skipa', 'access', $skiptitle), array('href' => '#sb-' . $bc->skipid, 'class' => 'skip-block'));
            $skipdest = html_writer::tag('span', '', array('id' => 'sb-' . $bc->skipid, 'class' => 'skip-block-to'));
        }*/

        $output .= html_writer::start_tag('div', $bc->attributes);

        $output .= $this->collapse_block_header($bc);
        $output .= $this->collapse_block_content($bc);

        $output .= html_writer::end_tag('div');

        $output .= $this->block_annotation($bc);

        //$output .= $skipdest;

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
            $attributes['id'] = 'instance-'.$bc->blockinstanceid.'-header';
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

        $headerattributes = array('class' => 'header panel-heading', 'data-parent' => '#block-region-'.$bc->attributes['regionid']);
        if (!$this->block_has_class($bc, 'block_fake')) {
            //$output = html_writer::tag('a', html_writer::tag('div', $title, array('class' => 'title panel-title')),
            //    array('class' => 'header panel-heading', 'data-toggle' => 'collapse', 'data-parent' => '#block-region-'.$bc->attributes['regionid'], 'href' => '#collapse-'.$bc->blockinstanceid));
            $headerattributes['data-toggle'] = 'collapse';
            $headerattributes['href'] = '#collapse-'.$bc->blockinstanceid;
        }
        $output = html_writer::tag('a', html_writer::tag('div', $title, array('class' => 'title panel-title')), $headerattributes);

        if ($controlshtml) {
            $output .= html_writer::tag('div', html_writer::tag('div', $controlshtml, array('class' => 'title')), array('class' => 'header controlshtml'));
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
            $blockattributes['id'] = 'collapse-'.$bc->blockinstanceid;
        }
        $output = html_writer::start_tag('div', $blockattributes);
        /*if (!$bc->title && !$this->block_controls($bc->controls)) {
            $output .= html_writer::tag('div', '', array('class'=>'block_action notitle'));
        }*/
        $output .= $bc->content;
        $output .= $this->block_footer($bc);
        $output .= html_writer::end_tag('div');

        return $output;
    }

    private function block_has_class(block_contents $bc, $class) {
        return strpos($bc->attributes['class'], $class ) !== false;
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
        if ((!empty($this->page->theme->settings->syntaxhighlight)) && ($this->page->theme->settings->syntaxhighlight == 2)) {
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
        $output = parent::standard_end_of_body_html();

        if ($this->syntaxhighlighterenabled) {
            $syscontext = context_system::instance();
            $itemid = theme_get_revision();
            $url = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/$syscontext->id/theme_shoehorn/syntaxhighlighter/$itemid/");
            $url = preg_replace('|^https?://|i', '//', $url->out(false));

            $script = "$('document').ready(function(){";  // Can use jQuery as included on every page.
			$script .= "SyntaxHighlighter.autoloader(";
            $script .= "[ 'applescript', '".$url."shBrushAppleScript.js' ],";
            $script .= "[ 'actionscript3', 'as3', '".$url."shBrushAS3.js' ],";
            $script .= "[ 'bash', 'shell', '".$url."shBrushBash.js' ],";
            $script .= "[ 'coldfusion', 'cf', '".$url."shBrushColdFusion.js' ],";
            $script .= "[ 'cpp', 'c', '".$url."shBrushCpp.js' ],";
            $script .= "[ 'c#', 'c-sharp', 'csharp', '".$url."shBrushCSharp.js' ],";
            $script .= "[ 'css', '".$url."shBrushCss.js' ],";
            $script .= "[ 'delphi', 'pascal', '".$url."shBrushDelphi.js' ],";
            $script .= "[ 'diff', 'patch', 'pas', '".$url."shBrushDiff.js' ],";
            $script .= "[ 'erl', 'erlang', '".$url."shBrushErlang.js' ],";
            $script .= "[ 'groovy', '".$url."shBrushGroovy.js' ],";
            $script .= "[ 'haxe hx', '".$url."shBrushHaxe.js', ],";
            $script .= "[ 'java', '".$url."shBrushJava.js' ],";
            $script .= "[ 'jfx', 'javafx', '".$url."shBrushJavaFX.js' ],";
            $script .= "[ 'js', 'jscript', 'javascript', '".$url."shBrushJScript.js' ],";
            $script .= "[ 'perl', 'pl', '".$url."shBrushPerl.js' ],";
            $script .= "[ 'php', '".$url."shBrushPhp.js' ],";
            $script .= "[ 'text', 'plain', '".$url."shBrushPlain.js' ],";
            $script .= "[ 'py', 'python', '".$url."shBrushPython.js' ],";
            $script .= "[ 'ruby', 'rails', 'ror', 'rb', '".$url."shBrushRuby.js' ],";
            $script .= "[ 'scala', '".$url."shBrushScala.js' ],";
            $script .= "[ 'sql', '".$url."shBrushSql.js' ],";
            $script .= "[ 'vb', 'vbnet', '".$url."shBrushVb.js' ],";
            $script .= "[ 'xml', 'xhtml', 'xslt', 'html', '".$url."shBrushXml.js' ]";
            $script .= ');';
            $script .= 'SyntaxHighlighter.all(); console.log("Syntax Highlighter Init");';
            $script .= '});';
            $output .= html_writer::script($script);
        }

        return $output;
    }

    public function anti_gravity() {
        if ($this->page->theme->settings->fontawesome) {
            $icon = html_writer::start_tag('i', array('class' => 'fa fa-arrow-circle-o-up')) . html_writer::end_tag('i');
        } else {
            $icon = html_writer::start_tag('span', array('class' => 'glyphicon glyphicon-upload')) . html_writer::end_tag('span');
        }
        $anti_gravity = html_writer::tag('a', $icon, array('class' => 'antiGravity', 'title' => get_string('antigravity', 'theme_shoehorn')));

        return $anti_gravity;
    }

    // Moodle CSS file serving.
    public function get_csswww() {
        global $CFG;

        if (right_to_left()) {
            $moodlecss = 'moodle-rtl.css';
        } else {
            $moodlecss = 'moodle.css';
        }

        $syscontext = context_system::instance();
        $itemid = theme_get_revision();
        $url = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/$syscontext->id/theme_shoehorn/style/$itemid/$moodlecss");
        $url = preg_replace('|^https?://|i', '//', $url->out(false));
        return $url;
    }
}
