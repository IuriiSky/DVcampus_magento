define([
    'jquery',
    'Magento_Ui/js/modal/alert',

], function ($, alert) {
    'use strict';

    /**
     * @param {Object} payload
     * @param {String} url
     */

    return function (payload, url) {
        return $.ajax({
            url: url,
            data: payload,
            type: 'post',
            dataType: 'json',

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
                            $(document).trigger('iuriis_chatbox_clearTextarea');
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
    };
});
