define([
    'jquery',
    'iuriis_chatbox_form',
    'mage/translate'
], function ($) {
    'use strict';

    $.widget('iuriisChatbox.chatBox', {
        options: {
            chatOpenButton: '.iuriis-chat-open-button',
            closeChat: '#iuriis-chat-close-chat-button',
            submitButton: '#iuriis-chat-send-ask'
        },

        /**
         * @private
         */
        _create: function () {
            $(document).on('iuriis_chatbox_openChat.iuriis_chatbox', $.proxy(this.openChat, this));
            $(this.options.closeChat).on('click.iuriis_chatbox', $.proxy(this.closeChat, this));
            $(this.options.submitButton).on('click.iuriis_chatbox', $.proxy(this.submitMessage, this));
            $(document).on('iuriis_chatbox_add_message.iurii_chatbox', $.proxy(this.addMessage, this));

            // make the hidden form visible after the styles are initialized
            $(this.element).show();
        },

        _destroy: function () {
            $(document).off('iuriis_chatbox_openChat.iuriis_chatbox');
            $(this.options.closeChat).off('click.iuriis_chatbox');
            $(this.options.submitButton).off('click.iuriis_chatbox');
            $(document).off('iuriis_chatbox_add_message.iurii_chatbox');
        },

        openChat: function () {
            $(this.element).addClass('active');
        },

        closeChat: function () {
            $(this.element).removeClass('active');
            $(this.options.chatOpenButton).trigger('iuriis_chatbox_close_chatbox');
        },

        submitMessage: function () {
            $(document).trigger('iuriis_chatbox_saveMessage');
        },

        formatDate: function (d) {
            const date = new Date();

            var dd = date.getDate();
            if (dd < 10) dd = '0' + dd;

            var mm = date.getMonth() + 1;
            if (mm < 10) mm = '0' + mm;

            var yy = date.getFullYear() % 100;
            if (yy < 10) yy = '0' + yy;

            var hours = date.getHours();
            var minutes = date.getMinutes();
            if (minutes < 10) minutes = '0' + minutes;

            return dd + '.' + mm + '.' + yy + ' ' + hours + '.' + minutes;
        },

        addMessage: function () {
            var currentDate = new Date();
            var dateMessage = this.formatDate(currentDate);

            var message = $('#user-message-question').val();

            $('.chat-message-list').append('<li class="chat-message"></li>');
            $('.chat-message-list > li:last-child').append('<span class="date-time"></span>');
            $('.chat-message-list > li:last-child').append('<span class="message"></span>');
            $('.chat-message-list > li:last-child > span:first-child').text(dateMessage);
            $('.chat-message-list > li:last-child > span:last-child').text(message);
            $('#user-message-question').val('');

        }

    });

    return $.iuriisChatbox.chatBox;
});
