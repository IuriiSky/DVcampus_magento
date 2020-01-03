define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'mage/translate'

], function ($, alert) {
    'use strict';

    $.widget('iuriisChatbox.form', {
        options: {
            action: ''
        },

        /**
         * @private
         */
        _create: function () {
            $(document).on('iuriis_chatbox_saveMessage.iuriis_chatbox', $.proxy(this.saveMessage, this));
        },

        _destroy: function () {
            $(document).off('iuriis_chatbox_saveMessage.iuriis_chatbox');
        },

        saveMessage: function () {
            if (!this.validateForm()) {
                return;
            }

            this.ajaxSubmit();
        },

        /**
         * Validate request form
         */
        validateForm: function () {
            return $(this.element).validation().valid();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            var formData = new FormData($(this.element).get(0));

            formData.append('form_key', $.mage.cookies.get('form_key'));
            formData.append('isAjax', 1);

            $.ajax({
                url: this.options.action,
                data: formData,
                processData: false,
                contentType: false,
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
                        content: $.mage.__(response.message),
                        buttons: [{
                            text: $.mage.__('Accept'),
                            class: 'action primary accept',

                            /**
                             * Click handler.
                             */
                            click: function () {
                                this.closeModal(true);
                                this.element.trigger('iuriis_chatbox_add_message');
                            }
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

    return $.iuriisChatbox.form;
});
