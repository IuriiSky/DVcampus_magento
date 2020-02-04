define([
    'jquery',
    'ko',
    'uiComponent',
    // 'iuriis_chatbox_form',
    'Magento_Customer/js/customer-data',
    'Magento_Ui/js/modal/alert',
    'mage/translate'
], function ($, ko, Component, customerData, alert) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Iuriis_Chatbox/chat-box',
        },

        chatBoxClass: ko.observable(''),
        message: ko.observable(''),
        messagesList: customerData.get('customer-chat-messages'),

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

        saveMessage: function () {
            var payload = {
                message: this.message,
                'form_key': $.mage.cookies.get('form_key'),
                isAjax: 1
            };

            /**
             * Submit request via AJAX. Add form key to the post data.
             */
            $.ajax({
                url: this.action,
                data: payload,
                type: 'post',
                dataType: 'json',
                context: this,

                /** @inheritdoc */
                beforeSend: function () {
                    $('body').trigger('processStart');
                },

                /** @inheritdoc */
                success: function (response) {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__('Success'),
                        content: response.message,
                        buttons: [{
                            text: $.mage.__('Accept'),
                            class: 'action primary accept',
                        }]
                    });
                },

                /** @inheritdoc */
                error: function () {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__('Error'),
                        content: $.mage.__('Your message can\'t be send. Please, contact us if you see this message.')
                    });
                }
            });
        }
    });
});
