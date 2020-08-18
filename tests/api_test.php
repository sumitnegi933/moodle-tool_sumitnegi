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
 *  API Unit tests.
 *
 * @package   tool_sumitnegi
 * @copyright 2020, Sumit Negi
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use tool_sumitnegi\api;

defined('MOODLE_INTERNAL') || die();
global $CFG;

/**
 * Class tool_sumitnegi_api_testcase
 */
class tool_sumitnegi_api_testcase extends advanced_testcase
{
    /**
     * Test add of entry
     *
     * @return void
     */
    public function test_add_entry() {
        $this->resetAfterTest(true);
        $course = $this->getDataGenerator()->create_course();
        $data = new stdClass();
        $data->name = "Test Entry 001";
        $data->courseid = $course->id;
        $data->timecreated = time();
        $data->timemodified = time();
        $data->completed = 0;
        $entryid = tool_sumitnegi\api::add($data);
        $entryobj = tool_sumitnegi\api::get($entryid);
        $this->assertNotEmpty($entryobj, "Empty entry data");
        $this->assertEquals($course->id, $entryobj->courseid, 'Course id not matched');
        $this->assertEquals("Test Entry 001", $entryobj->name, 'Name is not matched');
        $this->assertEquals(0, $entryobj->completed, 'Completion is not matched');
    }

    /**
     * Test update of entry
     *
     * @return void
     */
    public function test_edit_entry() {
        $this->resetAfterTest(true);
        $entryid = $this->create_entry();
        $entrydata = tool_sumitnegi\api::get($entryid);
        $entrydata->completed = 1;
        $entrydata->name = "Test Entry 001 V.1";
        $entrydata->timemodified = time();
        tool_sumitnegi\api::update($entrydata);
        $updatedentry = tool_sumitnegi\api::get($entrydata->id);
        $this->assertEquals('Test Entry 001 V.1', $updatedentry->name, 'Name is not updated');
        $this->assertEquals(1, $updatedentry->completed, 'Completion is not updated');
        $this->assertEquals($entrydata->timemodified, $updatedentry->timemodified, 'Entry modification time is not updated');
    }
    /**
     * Test deletion of entry
     *
     * @return void
     */
    public function test_delete_entry() {
        $this->resetAfterTest(true);
        $entryid = $this->create_entry();
        tool_sumitnegi\api::remove($entryid);
        $entry = tool_sumitnegi\api::get($entryid);
        $this->assertEmpty($entry, 'Got data for entryid');
    }

    /**
     * Create a new entry
     *
     * @return int entry id
     */
    protected function create_entry() {
        $course = $this->getDataGenerator()->create_course();
        $data = new stdClass();
        $data->name = "Test Entry 001";
        $data->courseid = $course->id;
        $data->timecreated = time();
        $data->timemodified = time();
        $data->completed = 0;
        return tool_sumitnegi\api::add($data);
    }
}