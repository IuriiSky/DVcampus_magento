define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'jquery/ui',
    'mage/translate'
], function ($,alert) {
    'use strict';

    $.widget('iuriisAskAboutThisProduct.sendMail', {
        actions: {
            action: ''
        },

        /**
         * @private
         */
        _create: function () {
            $(this.element).on('click.iuriis_sendMail', $.proxy(this.sendMail, this));
        },

        _destroy: function () {
            $(this.element).off('click.iuriis_sendMail');
        },

        sendMail: function () {
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
                        content: response.message,
                        buttons: [{
                            text: $.mage.__('Accept'),
                            class: 'action primary accept',
                            /**
                             * Click handler.
                             */
                            click: function () {
                                this.closeModal(true);
                                $(document).trigger('iuriis_askaboutthisproduct_close_modal');
                            }
                        }]
                    });
                },

                /** @inheritdoc */
                error: function () {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__('Error'),
                        content: $.mage.__('Your question can\'t be send. Please, contact us if you see this message.')
                    });
                }
            });
        },
    });
    return $.iuriisAskAboutThisProduct.sendMail;
});