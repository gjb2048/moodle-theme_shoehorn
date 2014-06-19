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
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// http://docs.moodle.org/dev/Page_API.
require_once('../../../config.php');
require_once('../lib.php');

$PAGE->set_context(context_system::instance());
$thispageurl = new moodle_url('/theme/shoehorn/pages/syntaxhighlight.php');
$PAGE->set_url($thispageurl, $thispageurl->params());
$PAGE->set_docs_path('');
$PAGE->set_pagelayout('page');

$html = theme_shoehorn_html_for_settings($PAGE);
$PAGE->add_body_classes($html->additionalbodyclasses);

$syntaxhighlighttitle = get_string('syntaxhighlightpage', 'theme_shoehorn');
$PAGE->set_title($syntaxhighlighttitle);
$PAGE->set_heading($syntaxhighlighttitle);

$PAGE->requires->js('/theme/shoehorn/javascript/syntaxhighlighter_3_0_83/scripts/shCore.js');
$PAGE->requires->js('/theme/shoehorn/javascript/syntaxhighlighter_3_0_83/scripts/shBrushJava.js');
$PAGE->requires->css('/theme/shoehorn/javascript/syntaxhighlighter_3_0_83/styles/shCore.css');
$PAGE->requires->css('/theme/shoehorn/javascript/syntaxhighlighter_3_0_83/styles/shThemeDefault.css');

// No edit.
$USER->editing = $edit = 0;

$PAGE->navbar->ignore_active();
$PAGE->navbar->add($PAGE->title, $thispageurl);

// Output.
echo $OUTPUT->header();
echo $OUTPUT->box_start();

echo html_writer::start_tag('div', array('class' => 'row'));
echo html_writer::start_tag('div', array('class' => 'col-md-12 lead'));
echo html_writer::tag('p', get_string('syntaxhelpone', 'theme_shoehorn', array('html' => htmlentities(get_string('syntaxsummary', 'theme_shoehorn')))));
echo html_writer::tag('p', get_string('syntaxhelptwo', 'theme_shoehorn'));
echo html_writer::start_tag('table', array('class' => 'syntax'));
echo html_writer::start_tag('thead');
echo html_writer::start_tag('tr');
echo html_writer::tag('th', get_string('syntaxhelpthree', 'theme_shoehorn'));
echo html_writer::tag('th', get_string('syntaxhelpfour', 'theme_shoehorn'));
echo html_writer::end_tag('tr');
echo html_writer::end_tag('thead');
echo html_writer::start_tag('tbody');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'ActionScript3');
echo html_writer::tag('td', 'as3, actionscript3');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'Bash/shell');
echo html_writer::tag('td', 'bash, shell');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'ColdFusion');
echo html_writer::tag('td', 'cf, coldfusion');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'C#');
echo html_writer::tag('td', 'c-sharp, csharp');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'C++');
echo html_writer::tag('td', 'cpp, c');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'CSS');
echo html_writer::tag('td', 'css');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'Delphi');
echo html_writer::tag('td', 'delphi, pas, pascal');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'Diff');
echo html_writer::tag('td', 'diff, patch');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'Erlang');
echo html_writer::tag('td', 'erl, erlang');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'Groovy');
echo html_writer::tag('td', 'groovy');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'JavaScript');
echo html_writer::tag('td', 'js, jscript, javascript');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'Java');
echo html_writer::tag('td', 'java');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'JavaFX');
echo html_writer::tag('td', 'jfx, javafx');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'Perl');
echo html_writer::tag('td', 'perl, pl');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'PHP');
echo html_writer::tag('td', 'php');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'Plain Text');
echo html_writer::tag('td', 'plain, text');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'PowerShell');
echo html_writer::tag('td', 'ps, powershell');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'Python');
echo html_writer::tag('td', 'py, python');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'Ruby');
echo html_writer::tag('td', 'rails, ror, ruby');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'Scala');
echo html_writer::tag('td', 'scala');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'SQL');
echo html_writer::tag('td', 'sql');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'Visual Basic');
echo html_writer::tag('td', 'vb, vbnet');
echo html_writer::end_tag('tr');
echo html_writer::start_tag('tr');
echo html_writer::tag('td', 'XML');
echo html_writer::tag('td', 'xml, xhtml, xslt, html, xhtml');
echo html_writer::end_tag('tr');
echo html_writer::end_tag('tbody');
echo html_writer::end_tag('table');
echo html_writer::empty_tag('br');
echo html_writer::tag('p', get_string('syntaxhelpfive', 'theme_shoehorn'));
echo html_writer::start_tag('pre');
echo htmlentities('<pre class="brush: java">').PHP_EOL;
echo 'public class Test'.PHP_EOL;
echo '{'.PHP_EOL;
echo '   private String name = "Java program";'.PHP_EOL;
echo PHP_EOL;
echo '   public static void main (String args[])'.PHP_EOL;
echo '   {'.PHP_EOL;
echo '      Test us = new Test();'.PHP_EOL;
echo '      System.out.println(us.getName());'.PHP_EOL;
echo '   }'.PHP_EOL;
echo PHP_EOL;
echo '   public String getName()'.PHP_EOL;
echo '   {'.PHP_EOL;
echo '      return name;'.PHP_EOL;
echo '   }'.PHP_EOL;
echo '}'.PHP_EOL;
echo htmlentities('</pre>');
echo html_writer::end_tag('pre');
echo html_writer::tag('p', get_string('syntaxhelpsix', 'theme_shoehorn'));
echo '<pre class="brush: java">'.PHP_EOL;
echo 'public class Test'.PHP_EOL;
echo '{'.PHP_EOL;
echo '   private String name = "Java program";'.PHP_EOL;
echo PHP_EOL;
echo '   public static void main (String args[])'.PHP_EOL;
echo '   {'.PHP_EOL;
echo '      Test us = new Test();'.PHP_EOL;
echo '      System.out.println(us.getName());'.PHP_EOL;
echo '   }'.PHP_EOL;
echo PHP_EOL;
echo '   public String getName()'.PHP_EOL;
echo '   {'.PHP_EOL;
echo '      return name;'.PHP_EOL;
echo '   }'.PHP_EOL;
echo '}'.PHP_EOL;
echo '</pre>'.PHP_EOL;
echo html_writer::tag('p', get_string('syntaxhelpseven', 'theme_shoehorn').' \''.html_writer::tag('a', 'SyntaxHighlighter', array('href' => '//alexgorbatchev.com/SyntaxHighlighter/', 'target' => '_blank')).'\'');
echo html_writer::end_tag('div');
echo html_writer::end_tag('div');
echo html_writer::start_tag('div', array('class' => 'row'));
echo html_writer::start_tag('div',  array('class' => 'col-md-12'));
echo html_writer::tag('p', html_writer::tag('a', 'SyntaxHighlighter', array('href' => '//alexgorbatchev.com/SyntaxHighlighter/', 'target' => '_blank')).' - '.html_writer::tag('span', 'Alex Gorbatchev 2004-2011', array ('class' => 'copyright')).' - LGPL v3 '.html_writer::tag('a', 'www.gnu.org/copyleft/lesser.html', array('href' => '//www.gnu.org/copyleft/lesser.html', 'target' => '_blank')), array ('class' => 'text-center col-md-12'));
echo html_writer::end_tag('div');
echo html_writer::end_tag('div');

echo $OUTPUT->box_end();

echo $OUTPUT->footer();
echo '<script type="text/javascript">SyntaxHighlighter.all();</script>';
