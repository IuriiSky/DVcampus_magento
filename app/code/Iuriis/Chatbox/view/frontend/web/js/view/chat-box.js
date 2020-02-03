define([
    'jquery',
    'ko',
    'uiComponent',
    'iuriis_chatbox_form',
    'mage/translate'
], function ($, ko, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Iuriis_Chatbox/chat-box',
            action: ''
        },

        chatBoxClass: ko.observable(''),

        initialize: function () {
            this._super();
            $(document).on('iuriis_chatbox_openChat.iuriis_chatbox', $.proxy(this.openChat, this));
        },

        openChat: function () {
            this.chatBoxClass('active')
        },

        closeChat: function () {
            this.chatBoxClass('');
            $(document).trigger('iuriis_chatbox_close_chatbox');
        },

        //     initObservable: function () {
        //     this._super();
        //     return this;
        // }
    });

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

            this.messages = [{
                authorType: 'admin',
                createdAt: '2020',
                message: 'Lorem ipsum dolor sit amet'
            }, {
                authorType: 'admin',
                createdAt: '2020',
                message: 'Lorem ipsum dolor sit amet'
            }, {
                authorType: 'customer',
                createdAt: '2049',
                message: 'Test message form customer'
            }, {
                authorType: 'customer',
                createdAt: '2049',
                message: 'Test message form customer 2'
            }, {
                authorType: 'admin',
                createdAt: '2020',
                message: 'Lorem ipsum'
            }];
            this.renderMessages();
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

        renderMessages: function () {
            var messagesHtml = '';

            this.messages.forEach(function (message) {
                messagesHtml += `
                    <li class="chat-message ">
                        <span class="date-time">${message.createdAt}</span>
                         <span class="message ${message.authorType}">${message.message}</span>
                    </li>
                `;
            });

            $('.chat-message-list').html(messagesHtml);
        },

        addMessage: function () {
            var currentDate = new Date(),
                message = {
                    authorType: 'customer',
                    createdAt: this.formatDate(currentDate),
                    message: $('#user-message-question').val()
                };

            this.messages.push(message);
            this.renderMessages();
            $('#user-message-question').val('')
        }
    });
    return $.iuriisChatbox.chatBox;
});
