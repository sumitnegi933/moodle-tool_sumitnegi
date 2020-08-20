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
 *  tool_sumitnegi render.
 *
 * @package   tool_sumitnegi
 * @copyright 2020, Sumit Negi
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use tool_sumitnegi\output\main;

defined('MOODLE_INTERNAL') || die();

/**
 *  tool_sumitnegi render.
 *
 * @package   tool_sumitnegi
 * @copyright 2020, Sumit Negi
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_sumitnegi_renderer extends plugin_renderer_base {
    /**
     * Main renderer
     *
     * @param main $main
     * @return bool|string
     * @throws moodle_exception
     */
    protected function render_main(tool_sumitnegi\output\main $main) {
        $context = $main->export_for_template($this);
        return $this->render_from_template('tool_sumitnegi/display', $context);
    }

}