/**
 * MageINIC
 * Copyright (C) 2023 MageINIC <support@mageinic.com>
 *
 * NOTICE OF LICENSE
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see https://opensource.org/licenses/gpl-3.0.html.
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category MageINIC
 * @package MageINIC_SpeakSearch
 * @copyright Copyright (c) 2023 MageINIC (https://www.mageinic.com/)
 * @license https://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author MageINIC <support@mageinic.com>
 */

define([
    'jquery',
    'domReady!',
    'mage/translate'
], function ($) {
    'use strict';

    var $voiceSearchTrigger = $("#voice-search-trigger");
    var $miniSearchForm = $("#search_mini_form");
    var $searchInput = $("#search");
    window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    function _parseTranscript(e) {
        return Array.from(e.results).map(result => result[0]).map(result => result.transcript).join('')
    }

    /**
     *
     * @param e
     * @private
     */
    function _transcriptHandler(e) {
        $searchInput.val(_parseTranscript(e));
        if (e.results[0].isFinal) {
            $miniSearchForm.submit();
        }
    }

    if (window.SpeechRecognition) {
        $voiceSearchTrigger.show();
        var recognition = new SpeechRecognition();
        recognition.interimResults = true;
        recognition.addEventListener('result', _transcriptHandler);
    } else {

        $('#search').addClass('speak');
    }

    /**
     *
     * @param e
     */
    function startListening(e) {
        $searchInput.attr("placeholder", $.mage.__('Listening...'));
        recognition.start();
    }

    return function () {
        $voiceSearchTrigger.on('click touch', startListening);
    }
});
