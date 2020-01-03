define([
    'jquery',
    'jquery/ui',
    'iuriis_chatbox_openButton'
], function ($) {
    'use strict';

    $.widget('iuriisChatbox.listenerWidgets', {
        /**
         * @private
         */
        _create: function () {
            $(this.element).on('click.iuriis_chatbox', $.proxy(this.toggleChatWidget, this));
        },

        /**
         * jQuery(jQuery('.toggle-widget').get(0)).data('iuriisChatboxListenerWidgets').destroy()
         * @private
         */
        _destroy: function () {
            $(this.element).off('click.iuriis_chatbox');
        },

        toggleChatWidget: function () {
            if ($($('.iuriis-chat-open-button').get(0)).data('iuriisChatboxOpenButton') === undefined) {
                $('.iuriis-chat-open-button').openButton();
                alert('Widget "openButton" enabled');
            } else {
                $($('.iuriis-chat-open-button').get(0)).data('iuriisChatboxOpenButton').destroy();
                alert('Widget "openButton" disabled');
            }
        }
    });

    return $.iuriisChatbox.listenerWidgets;

});
