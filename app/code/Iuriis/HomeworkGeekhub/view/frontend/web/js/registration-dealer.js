define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/modal',
    'jquery/ui',
    'mage/translate'
], function ($) {
    'use strict';

    $.widget('iuriisHomework.registrationDealer', {

        /**
         * @private
         */
        _create: function () {
            $(document).on('click.iuriis_homework', $.proxy(this.openModalWindow, this));
            this.modal = $(this.element);

        },

        _destroy: function () {
            $(document).off('click.iuriis_homework');
        },

        openModalWindow: function () {
            $('#registration-dealer-btn').on('click', function () {
                $('#form-validate-dealer').modal({
                    buttons: [],
                }).modal('openModal');
            })
        },
    });
    return $.iuriisHomework.registrationDealer;
});

