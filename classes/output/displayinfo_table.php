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

namespace tool_sumitnegi\output;

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/tablelib.php');
/**
 * Display information in table
 * @package   tool_sumitnegi
 * @copyright 2020, Sumit Negi
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class displayinfo_table extends \table_sql {
    /**
     * displayinfo object contruction function
     *
     * @param [type] $uniqueid
     * @param [type] $courseid
     */
    public function __construct($uniqueid, $courseid = null) {
        parent::__construct($uniqueid);

        // Define the list of columns to show.
        $columns = ['name', 'completed', 'priority', 'timecreated', 'timemodified'];
        // Define the titles of columns to show in header.
        $headers = [
            get_string('name', 'tool_sumitnegi'),
            get_string('completed', 'tool_sumitnegi'),
            get_string('priority', 'tool_sumitnegi'),
            get_string('timecreated', 'tool_sumitnegi'),
            get_string('timemodified', 'tool_sumitnegi')
        ];
        if (\has_capability('tool/sumitnegi:edit', \context_course::instance($courseid))) {
            $columns[] = 'edit';
            $headers[] = get_string('action');
        }
        $this->define_columns($columns);
        $this->define_headers($headers);
        // Total number of records for specific course.
        $totalcountsql = "SELECT COUNT(id) FROM {tool_sumitnegi} WHERE courseid = :courseid";
        $params = array('courseid' => $courseid);
        $this->set_count_sql($totalcountsql, $params);
        // Get all records of course.
        $this->set_sql("*", '{tool_sumitnegi}', "courseid = :courseid", ['courseid' => $courseid]);
    }
    /**
     * Get name information
     *
     * @param [type] $row
     * @return string name
     */
    protected function col_name($row) {

        if (!empty($row->name)) {
            return format_text($row->name);
        }
        return '-';
    }
    /**
     * Get created time information
     *
     * @param [type] $row
     * @return string Human readable created date and time
     */
    protected function col_timecreated($row) {

        if ($row->timecreated) {
            return userdate($row->timecreated);
        }
        return '-';
    }
    /**
     * Get last updated time
     *
     * @param [type] $row
     * @return string Human readable updated date and time
     */
    protected function col_timemodified($row) {

        if ($row->timemodified) {
            return userdate($row->timemodified);
        }
        return '-';
    }
    /**
     * Get completion status
     *
     * @param [type] $row
     * @return string completion status yes/no
     */
    protected function col_completed($row) {

        if ($row->completed) {
            return get_string('yes');
        }
        return get_string('no');
    }
    /**
     * Get priority
     *
     * @param [type] $row
     * @return string priority yes/no
     */
    protected function col_priority($row) {

        if ($row->priority) {
            return get_string('yes');
        }
        return get_string('no');
    }
    /**
     * Allow edit record
     *
     * @param [type] $row
     * @return string link of for editing
     */
    protected function col_edit($row) {
        if ($row) {
            return \html_writer::link(new \moodle_url('/admin/tool/sumitnegi/edit.php', ['id' => $row->id]), get_string('edit'));
        }
        return '';
    }
}
