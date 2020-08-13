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
 * tool_sumitnegi capabilities.
 *
 * @package   tool_sumitnegi
 * @copyright 2020, Sumit Negi
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/**
 * Upgrade plugin function
 *
 * @param [type] $oldversion
 * @return void
 */
defined('MOODLE_INTERNAL') || die();
$capabilities = array(
    'tool/sumitnegi:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
    ),
    'tool/sumitnegi:edit' => array(
        'riskbitmask' => RISK_SPAM,
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
    ),
 );