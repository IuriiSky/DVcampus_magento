define([
    'jquery',
    'jquery/ui',
    'mage/translate'
],function ($) {
    'use strict';

    $.widget('iuriisChatbox.openButton', {
        options: {
            hideButton: true
        },

        /**
         * @private
         */
        _create: function () {
            $(this.element).on('click.iuriis_chatbox', $.proxy(this.openChat, this));
            this.hash = Math.random().toString(36).substr(2, 9);
            $(document).on('iuriis_chatbox_close_chatbox.' + this.hash, $.proxy(this.closeChat, this));

            // $(document).on('iuriis_chatbox_close_chatbox.iuriis_chatbox', $.proxy(this.closeChat, this));
        },

        /**
         * jQuery(jQuery('.iuriis-chat-open-button').get(0)).data('iuriisChatboxOpenButton').destroy()
         * @private
         */
        _destroy: function () {
            $(this.element).off('click.iuriis_chatbox');
            // $(this.element).off('iuriis_chatbox_close_chat.iuriis_chatbox');
            $(this.element).off('iuriis_chatbox_close_chat.' + this.hash);
        },

        openChat: function () {
            $(document).trigger('iuriis_chatbox_openChat');

            if (this.options.hideButton) {
                $(this.element).removeClass('active');
            }
        },

        closeChat: function () {
            $(this.element).addClass('active');
        }
    });

    return $.iuriisChatbox.openButton;
});
