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
 *  tool_sumitnegi.
 *
 * @package   tool_sumitnegi
 * @copyright 2020, Sumit Negi
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../../config.php');
global $DB, $PAGE, $OUTPUT;
$id = optional_param('id', SITEID, PARAM_INT);
require_login();
$url = new moodle_url('/admin/tool/sumitnegi/index.php', ['id' => $id]);
$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title(get_string('title', 'tool_sumitnegi'));
$PAGE->set_heading(get_string('pluginname', 'tool_sumitnegi'));
echo $OUTPUT->header();
// Total registered users in the system.
$totalregisteredusersql = 'SELECT COUNT(*) FROM {user} WHERE deleted = :deleted AND id <> :guest';
$totalregisteredusers = $DB->count_records_sql($totalregisteredusersql, ['deleted' => 0, 'guest' => 1]);
// Total active users in the system.
$totalactiveuserssql = 'SELECT COUNT(*) FROM {user} WHERE deleted = :deleted AND id <> :guest AND suspended = :suspended';
$totalactiveusers = $DB->count_records_sql($totalactiveuserssql, ['deleted' => 0, 'guest' => 1, 'suspended' => 0]);
// Total inactive users in the system.
$totalinactiveuserssql = 'SELECT COUNT(*) FROM {user} WHERE deleted = :deleted AND id <> :guest AND suspended = :suspended';
$totalinactiveusers = $DB->count_records_sql($totalinactiveuserssql , ['deleted' => 0, 'guest' => 1, 'suspended' => 1]);
// Display total registered users.
echo html_writer::start_div('regiseredusers');
echo get_string('totalregisteredusers', 'tool_sumitnegi', $totalregisteredusers);
echo html_writer::end_div();
// Display total active users.
echo html_writer::start_div('activeusers');
echo get_string('totalactiveusers', 'tool_sumitnegi', $totalactiveusers);
echo html_writer::end_div();
// Display total inactive users.
echo html_writer::start_div('inactiveusers');
echo get_string('totalinactiveusers', 'tool_sumitnegi', $totalinactiveusers);
echo html_writer::end_div();
// Display course info.
$course = get_course($id);
echo html_writer::start_div('courseinfo'); // Start course info.
echo html_writer::tag('strong', get_string('courseinfo', 'tool_sumitnegi'));
// Display course fullname.
echo html_writer::start_div();
echo $course->fullname;
echo html_writer::end_div();
// Display course shortname.
echo html_writer::start_div();
echo $course->shortname;
echo html_writer::end_div();
// Display course summary.
echo html_writer::start_div();
echo format_text($course->summary);
echo html_writer::end_div();
echo html_writer::end_div(); // End course info.
echo $OUTPUT->footer();