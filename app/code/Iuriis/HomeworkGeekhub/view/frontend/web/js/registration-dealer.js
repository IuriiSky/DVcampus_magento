define([
    'jquery',
    'jquery/ui',
    'Magento_Ui/js/modal/alert',
    'mage/translate'
], function ($) {
    'use strict';
    $.widget('iuriisHomework.registrationDealer', {

        /**
         * @private
         */
        _create: function () {
            $(this.element).on('click.iuriis_homework', $.proxy(this.openModal, this));
        },

        _destroy: function () {
            $(this.element).off('click.iuriis_homework');
        },

        openModal: function () {
            alert('Hello!');
        }
    });
return $.iuriisHomework.registrationDealer;
});
