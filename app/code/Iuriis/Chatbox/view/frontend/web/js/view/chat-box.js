define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'iuriis_chatbox_form',
    'mage/translate'
], function ($, ko, Component, customerData, saveMessage, getAdminMessage) {
    'use strict';

    return Component.extend({

        chatBoxClass: ko.observable(''),
        message: ko.observable(''),
        messagesList: customerData.get('customer-chat-messages'),
        adminMessages: ko.observableArray([]),
        allMessages: ko.observableArray([]),

        initialize: function () {
            this._super();
            $(document).on('iuriis_chatbox_openChat.iuriis_chatbox', $.proxy(this.openChat, this));
            $(document).on('iuriis_chatbox_clearTextarea.iurii_chatbox', $.proxy(this.clearTextarea, this));
            $(document).on('iuriis_chatbox_concatenateArrays.iuriis_chatbox', $.proxy(this.concatenateArrays, this));

            return this;
        },

        /**
         * Merge the customer message array with the admin message array,
         * sort the date the message was written, and leave the last ten messages.
         */
        concatenateArrays: function () {
            var customerMessages = this.messagesList().messages;  // array with customer messages
            var adminMessages = this.adminMessages().adminMessages; // array with admin messages
            var concatMessages = customerMessages.concat(adminMessages); // merge arrays
            concatMessages.sort((a, b) => (a.created_at > b.created_at) ? -1 : 1); // sort array for create date messages
            concatMessages.splice(10, concatMessages.length); // leave last 10 messages
            concatMessages.reverse(); // reverse array for show the last message in down
            this.allMessages(concatMessages);
            this.changeHtmlClass();
        },

        /**
         * Modifies the HTML class on the message element
         */
        changeHtmlClass: function () {
            $('span.author_type').each(function () {
                var author = $(this);
                $(author).data().bind;
                if ($(author).val() === 'admin') {
                    $(author).parent().removeClass('customer-message').addClass('admin-message');
                }
            });
        },

        /**
         * Open chat box
         */
        openChat: function () {
            this.chatBoxClass('active')
            this.getAdminMessage();
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
            saveMessage(payload, this.url);
        },

        /**
         * Get admin messages via AJAX request.
         */
        getAdminMessage: function () {
          $.ajax({
                type: 'GET',
                url: this.action,
                dataType: 'json',
              timeout: 5000,
                context: this,
                async: true,

                /** @inheritdoc */
                beforeSend: function () {
                    $('body').trigger('processStart');
                },

                /** @inheritdoc */
                success: function (result) {
                    $('body').trigger('processStop');
                    this.adminMessages(result);
                    this.concatenateArrays();
                    this.reloadAdminMessages();
                },

                /** @inheritdoc */
                error: function () {
                    $('body').trigger('processStop');
                }
            })
        },

        reloadAdminMessages: function() {
            setInterval(this.getAdminMessage, 10000)
            // this.getAdminMessage();
        },
    });
});
