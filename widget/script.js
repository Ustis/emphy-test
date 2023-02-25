define(['jquery', 'underscore', 'twigjs'], function ($, _, Twig) {
    var CustomWidget = function () {
        var self = this;

        this.callbacks = {
            render: function () {
                if (self.system().area === 'lcard') {
                    let $widgets_block = $('#widgets_block');

                    if ($widgets_block.find('#show_products_button').length === 0) {
                        let stylePath = self.params.path + '/style.css';
                        $('head').append('<link href="' + stylePath + '" rel="stylesheet">');

                        $widgets_block.append(
                            self.render({ref: '/tmpl/controls/button.twig'}, {
                                id: 'show_products_button',
                                text: 'Товары',
                            })
                        );
                    }
                }

                self.productsTableHtml = '';

                let productRows = '';

                self.crm_post(
                    'http://5.188.203.28:80/api/leadLinkedProducts',
                    { 'id': AMOCRM.data.current_card.id },
                    function (products) {
                        if (products.length === 0) {
                            productRows += '<tr><td colspan="2">Товаров нет</td></tr>';
                        } else {
                            for (let product of products) {
                                productRows += '<tr><td>' + product.name + '</td><td>' +
                                    product.quantity + '</td><td>' +
                                    price + '</td></tr>';
                            }
                            let thead = '<thead><tr><th>Название</th>' +
                                '<th>Количество</th>' +
                                '<th>Цена за 1 штуку</th></tr></thead>';
                            let tbody = '<tbody>' + productRows + '</tbody>';

                            self.productsTableHtml = '<table>' + thead + tbody + '</table>';
                        }
                    },
                    'json',
                    function (msg) {
                        console.log(msg)
                    }
                )

                return true;
            },
            init: function () {
                console.log('init');

                return true;
            },
            bind_actions: function () {
                console.log('bind_actions');

                $('#widgets_block #show_products_button').on('click', function () {
                    var modal = new Modal({
                        class_name: 'products-modal-window',
                        init: function ($modal_body) {
                            $modal_body
                                .trigger('modal:loaded')
                                .html(self.productsTableHtml)
                                .trigger('modal:centrify');
                        },
                        destroy: function () {
                        }
                    });
                });

                return true;
            },

            settings: function () {
                console.log('settings');
                return true;
            },

            onSave: function () {
                console.log('onSave');
                return true;
            },

            destroy: function () {
                console.log('destroy');
            },
            contacts: {
                selected: function () {
                    console.log('contacts');
                }
            },
            leads: {
                selected: function () {
                    console.log('leads');
                }
            },
            tasks: {
                selected: function () {
                    console.log('tasks');
                }
            }
        };

        return this;
    };

    return CustomWidget;
});
