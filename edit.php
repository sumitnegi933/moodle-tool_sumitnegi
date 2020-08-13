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

use tool_sumitnegi\form;

global $DB, $PAGE, $OUTPUT;
$id = optional_param('id', 0, PARAM_INT);
if (!$id) {
    $courseid = required_param('courseid', PARAM_INT);
}
if (empty($courseid)) { // Courseid is not defined, get course info with the help of record id.
    $record = $DB->get_record('tool_sumitnegi', array('id' => $id), '*', MUST_EXIST);
    $courseid = $record->courseid;
}
require_login();
$coursecontext = context_course::instance($courseid);
require_capability('tool/sumitnegi:edit', $coursecontext);
$url = new moodle_url('/admin/tool/sumitnegi/edit.php', ['courseid' => $courseid]);
$PAGE->set_context($coursecontext);
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title(get_string('title', 'tool_sumitnegi'));
$PAGE->set_heading(get_string('pluginname', 'tool_sumitnegi'));
$course = get_course($courseid);
$editform = new tool_sumitnegi\form\edit_form('', ['courseid' => $course->id, 'id' => $id]);
if (!empty($record)) {
    $editform->set_data($record);
}
if ($editform->is_cancelled()) {
    redirect(new moodle_url('/admin/tool/sumitnegi/index.php', array('courseid' => $courseid)));
}
if ($formdata = $editform->get_data()) {
    $data = new stdClass();
    $data->name = $formdata->name;
    $data->completed = $formdata->completed ?? 0;
    $data->courseid = $course->id;
    // Insert new record into table.
    if (!$formdata->id) {
        $data->timecreated = time();
        $data->timemodified = time();
        if ($insertid = $DB->insert_record('tool_sumitnegi', $data)) {
            redirect(new moodle_url('/admin/tool/sumitnegi/index.php',
                ['courseid' => $course->id]), get_string('insertsuccess', 'tool_sumitnegi'), null, 'success');
        }
    } else { // Update record into table.
        $data->id = $formdata->id;
        $data->timemodified = time();
        $DB->update_record('tool_sumitnegi', $data);
        redirect(new moodle_url('/admin/tool/sumitnegi/index.php',
                ['courseid' => $course->id]), get_string('updatesuccess', 'tool_sumitnegi'),
                null, 'success');
    }
}
echo $OUTPUT->header();
$editform->display();
echo $OUTPUT->footer();
