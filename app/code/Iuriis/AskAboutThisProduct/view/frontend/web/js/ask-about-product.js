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
            $(this.element).on('click.iuriis_askaboutthisproduct', $.proxy(this.openModalWindow, this));
            $(document).on('iuriis_askaboutthisproduct_close_modal', $.proxy(this.closeModalWindow, this));
            this.modal = $(this.element);
        },

        _destroy: function () {
            $(this.element).off('click.iuriis_askaboutthisproduct');
            $(document).off('iuriis_askaboutthisproduct_close_modal');
        },

        openModalWindow: function () {
            $('#ask-about-product').on('click', function () {
                $('#ask-form').modal({
                    buttons: [],
                }).modal('openModal');
            })
        },

        closeModalWindow: function () {
            $('#ask-form').modal({
                buttons: [],
            }).modal('closeModal');
        }
    });
    return $.iuriisAskAboutThisProduct.askAboutProduct;
});
