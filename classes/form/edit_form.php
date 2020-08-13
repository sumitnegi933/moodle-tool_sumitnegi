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
namespace tool_sumitnegi\form;
defined('MOODLE_INTERNAL') || die();
// Moodleform is defined in formslib.php.
require_once("$CFG->libdir/formslib.php");
/**
 *  Edit form class.
 *
 * @package   tool_sumitnegi
 * @copyright 2020, Sumit Negi
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class edit_form extends \moodleform {
    // Add elements to form.
    /**
     * form elements definition
     *
     * @return void
     */
    public function definition() {
        global $CFG;
        $mform = $this->_form;
        // Define hidden element for id.
        $id = $this->_customdata['id'];
        $mform->addElement('hidden', 'id', $id);
        $mform->setType('id', PARAM_INT);

        // Define hidden element for course id.
        $courseid = $this->_customdata['courseid'];
        $mform->addElement('hidden', 'courseid', $courseid);
        $mform->setType('courseid', PARAM_INT);
        // Text element to hold name data.
        $mform->addElement('text', 'name', get_string('name', 'tool_sumitnegi'));
        $mform->setType('name', PARAM_TEXT);
        // Checkbox to set completion for the record.
        $mform->addElement('checkbox', 'completed', get_string('completed', 'tool_sumitnegi'));
        $this->add_action_buttons();
    }
    /**
     * Data Validation
     *
     * @param [type] $data
     * @param [type] $files
     * @return array error messages if any else blank array;
     */
    public function validation($data, $files) {
        global $DB;
        $error = [];
        if (!$data['name']) {

            $error['name'] = get_string('required');
        }
        $record = $DB->get_record('tool_sumitnegi', ['name' => $data['name'], 'courseid' => $data['courseid']]);
        if ($data['name'] && ($record && $record->id != $data['id'])) {
            $error['name'] = get_string('namealreadyexist', 'tool_sumitnegi');
        }
        return $error;
    }
}
