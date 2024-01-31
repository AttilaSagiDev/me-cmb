/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*jshint browser:true jquery:true*/
define([
    "jquery",
    "mage/validation",
    'Magento_Ui/js/modal/alert'
], function($, validation, alert){
    "use strict";

    $.widget('mage.cmbAction', {
        options: {
            messageContent: '.me-cmb message',
            fadeTime: 500
        },
        _create: function () {
            $(this.options.formId).on('submit', $.proxy(this._updateContent, this));
        },
        _updateContent: function(event) {
            event.preventDefault();
            if ($(this.options.formId).validation() && $(this.options.formId).validation('isValid')) {
                var data = $(this.options.formId).serialize();
                var url = this.options.url;
                this._ajax(url, data);
            }
        },
        _ajax: function(url, data) {

            $.ajax({
                    url: url,
                    data: data,
                    type: 'post',
                    dataType: 'json',
                    context: this,
                    beforeSend: function() {
                        this._showFields();
                    },
                    complete: function() {
                        this._hideFields();
                    }
                })
                .done(function(response) {
                    if (response.success) {
                        this._showMessage(response);
                    } else {
                        var msg = response.content;
                        if (msg) {
                            alert({
                                content: $.mage.__(msg)
                            });
                            window.location.reload();
                        }
                    }
                })
                .fail(function(error) {
                    console.log(JSON.stringify(error));
                });

        },
        _showMessage: function(response) {
            $(this.options.formId).hide();
            $(this.options.messageContent).html(this._messageHtml(response.content));
            $(this.options.messageContent).fadeIn(this.options.fadeTime);
            this._delay(function () {
                $(this.options.messageContent).fadeOut(this.options.fadeTime);
            }, this.options.hideDelay);
            this._delay(function () {
                $(this.options.formId).show();
            }, this.options.fadeTime + this.options.hideDelay + 100);
            this._clearFields();
        },
        _messageHtml: function(content) {
            return '<div class="message message-success success"><div>'
                + content
                + '</div></div>';
        },
        _showFields: function() {
            $(this.options.formId + ' :input').prop('disabled', true);
        },
        _hideFields: function() {
            $(this.options.formId + ' :input').prop('disabled', false);
        },
        _clearFields: function()
        {
            $(this.options.formId).trigger('reset');
        }
    });

    return $.mage.cmbAction;
});