/**
 * confirm entry deletion code.
 *
 * @module     tool_sumitnegi/confirm_deletion
 * @class      confirm_deletion
 * @package    tool_sumitnegi
 * @copyright  2020 Sumit Negi
 */

import $ from 'jquery';
import Notification from 'core/notification';
import {get_strings as strs} from 'core/str';

const registerEvent = (selector) => {
    $(selector).on('click', function (e) {
        e.preventDefault();
        strs([
            {
                key: 'deleteconfirmtitle',
                component: 'tool_sumitnegi'
            },
            {
                key: 'deleteconfirmmessage',
                component: 'tool_sumitnegi'
            },
            {
                key: 'yes',
                component: 'moodle'
            },
            {
                key: 'no',
                component: 'moodle'
            }
        ]).then((strings) => {
            Notification.confirm(...strings, () => {
                    // eslint-disable-next-line no-console
                    console.log("Yes Clicked");
                    e.remove();
                },
                () => {
                    // eslint-disable-next-line no-console
                    console.log("Cancel Clicked");
                });

        });
    });
};

export default {
    registerEvent: registerEvent
};