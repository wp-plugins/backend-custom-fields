jQuery(document).ready(function ($) {
    var BCF = {
        container: $(".bcf-repeatable-container"),
        init: function () {
            this.masonry();
            (this.container).find("[data-type='add']").on('click', this.repeatableAddFields);
            (this.container).find("[data-type='rem']").on('click', this.repeatableRemFields);
        },
        repeatableAddFields: function () {
            var self = $(this),
                container = self.closest('.bcf-repeatable-container');
            container.find('input:last').clone().val("").appendTo(container);

            container.find('input:last').focus();
        },
        repeatableRemFields: function () {
            var self = $(this),
                container = self.closest('.bcf-repeatable-container'),
                count = container.find('input').length;
            if (count > 1) {
                container.find('input:last').remove();
                container.find('input:last').focus();
            }
        },
        masonry: function () {
            $('.bcf-container').each(function () {
                $(this).masonry({
                    columnWidth: 10,
                    itemSelector: '.bcf-item'
                });
            });
        }
    };
    BCF.init();
});