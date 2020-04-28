define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/modal',
    'jquery/ui',
    'mage/translate'
], function ($) {
    'use strict';

    $.widget('iuriisAskAboutThisProduct.askAboutProduct', {

        /**
         * @private
         */
        _create: function () {
            $(document).on('click.iuriis_askaboutthisproduct', $.proxy(this.openModalWindow, this));
            this.modal = $(this.element);
        },

        _destroy: function () {
            $(document).off('click.iuriis_askaboutthisproduct');
        },

        openModalWindow: function () {
            $('#ask-about-product').on('click', function () {
                $('#ask-form').modal({
                    buttons: [],
                }).modal('openModal');
            })
        },
    });
    return $.iuriisAskAboutThisProduct.askAboutProduct;
});
