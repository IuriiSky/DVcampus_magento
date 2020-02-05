define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'iuriis_chatbox_form',
    'mage/translate'
], function ($, ko, Component, customerData, saveMessage) {
    'use strict';

    return Component.extend({

        chatBoxClass: ko.observable(''),
        message: ko.observable(''),
        messagesList: customerData.get('customer-chat-messages'),

        initialize: function () {
            this._super();
            $(document).on('iuriis_chatbox_openChat.iuriis_chatbox', $.proxy(this.openChat, this));
            $(document).on('iuriis_chatbox_clearTextarea.iurii_chatbox', $.proxy(this.clearTextarea, this));
        },

        /**
         * Open chat box
         */
        openChat: function () {
            this.chatBoxClass('active')
        },

        /**
         * Close chat box
         */
        closeChat: function () {
            this.chatBoxClass('');
            $(document).trigger('iuriis_chatbox_close_chatbox');
        },

        /**
         * Clear textarea after save message
         */
        clearTextarea: function () {
            this.message('');
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        saveMessage: function () {
            var payload = {
                message: this.message,
                'form_key': $.mage.cookies.get('form_key'),
                isAjax: 1
            };

            saveMessage(payload, this.action);
        }
    });
});
