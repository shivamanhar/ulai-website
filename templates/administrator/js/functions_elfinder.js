var editorsEnabled = false;
/**
 * Getting/Setting caret position
 * @param node domObject
 * @param int begin
 * @param int end
 *
 */
function caret(domObject, begin, end) {
    var range;

    if (typeof begin == 'number') {
        end = (typeof end === 'number') ? end : begin;
        return $(domObject).each(function() {
            if (domObject.setSelectionRange) {
                domObject.setSelectionRange(begin, end);
            } else if (domObject.createTextRange) {
                range = domObject.createTextRange();
                range.collapse(true);
                range.moveEnd('character', end);
                range.moveStart('character', begin);
                range.select();
            }
        });
    } else {
        if (domObject[0].setSelectionRange) {
            begin = domObject[0].selectionStart;
            end = domObject[0].selectionEnd;
        } else if (document.selection && document.selection.createRange) {
            range = document.selection.createRange();
            begin = 0 - range.duplicate().moveStart('character', -100000);
            end = begin + range.text.length;
        }
        return {begin: begin, end: end};
    }
}
// read cookie by name
function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0)
            return c.substring(nameEQ.length, c.length);
    }
    return null;
}
function setCookie(name, value, expires, path, domain, secure)
{
    var today = new Date();
    today.setTime(today.getTime());
    if (expires)
    {
        expires = expires * 1000 * 60 * 60 * 24;
    }
    var expiresDate = new Date(today.getTime() + (expires));
    document.cookie = name + "=" + encodeURIComponent(value) +
            ((expires) ? ";expires=" + expiresDate.toGMTString() : "") + ((path) ? ";path=" + path : "") +
            ((domain) ? ";domain=" + domain : "") +
            ((secure) ? ";secure" : "");
}

// expand categories tree to show last visited category
function expandCategories(button) {
    var fullPathIds = JSON.parse(decodeURIComponent(readCookie('category_full_path_ids')));
    for (var cat in fullPathIds) {
        if (!$('.cat' + fullPathIds[cat]).hasClass('clicked')) {
            $('.cat' + fullPathIds[cat]).trigger('click');
            $('.cat' + fullPathIds[cat]).addClass('clicked')
            $('.cat' + fullPathIds[cat]).css('display', 'none')
            $('.cat' + fullPathIds[cat]).prev().css('display', 'inline-block')
        }
        if ($(button).hasClass('.cat' + fullPathIds[cat]) && !$(button).hasClass('clicked')) {
            $(button).trigger('click');
            $(button).addClass('clicked');
            $(button).css('display', 'none');
            $(button).prev().css('display', 'inline-block');
        }
    }
}

$(document).ready(function() {
    // run function expandCategories in categoriest list view
    if (window.location.pathname == '/admin/components/run/shop/categories/index') {
        expandCategories();
    }
});

function ajaxLoadChildCategory(el, id) {

    var container = $(el).closest('.row-category');

    if (container.next().attr('class') != 'frame_level sortable ui-sortable')
        $.post('/admin/components/run/shop/categories/ajax_load_parent', {id: id}, function(data) {
            $(data).insertAfter(container);
//            expandCategories($(data).find('.expandButton'))
            initNiceCheck();
            share_alt_init();
            sortInit();
        })


}

function changeDefaultValute(id) {

    $.post('/admin/components/run/shop/currencies/makeCurrencyDefault', {id: id})

}
function changeMainValute(id, curElement) {
    $('.btn-danger').removeAttr('disabled');

    $(curElement).closest('tr').find('.btn-danger').attr('disabled', 'disabled');

    var additionalCurrency = $(curElement).closest('tr').find('.prod-on_off ');
    if (!$(additionalCurrency).hasClass('disable_tovar')) {
        $('.prod-on_off').addClass('disable_tovar').css('left', '-28px');

        $.ajax({
            type: "post",
            data: {id: id, showOnSite: 0},
            url: '/admin/components/run/shop/currencies/showOnSite',
            success: function(data) {
                //alert(data)
            },
            error: function() {

            }
        });
    }

    $.post('/admin/components/run/shop/currencies/makeCurrencyMain', {id: id})


}
function ChangeMenuItemActive(obj, id) {
    $.post('/admin/components/cp/menu/chose_hidden', {status: $(obj).attr('rel'), id: id}, function() {
        if ($(obj).attr('rel') == 'true')
            $(obj).addClass('disable_tovar').attr('rel', false);
        else
            $(obj).removeClass('disable_tovar').attr('rel', true);
    })

}


function ChangeBannerActive(el, bannerId)
{
    var currentActiveStatus = $(el).attr('rel');

    $.post('/admin/components/run/shop/banners/changeActive/', {
        bannerId: bannerId,
        status: currentActiveStatus
    }, function(data) {
        $('.notifications').append(data)
        if (currentActiveStatus == 'true')
        {
            $(el).addClass('disable_tovar').attr('rel', false);

        } else {
            $(el).removeClass('disable_tovar').attr('rel', true);
        }

    });
}
// on/of sorting method
function ChangeSortActive(el, sortId)
{
    var currentActiveStatus = $(el).attr('rel');

    $.post('/admin/components/run/shop/settings/changeSortActive/', {
        sortId: sortId,
        status: currentActiveStatus
    }, function(data) {

        $('.notifications').append(data)
        if (currentActiveStatus == 'true')
        {
            $(el).addClass('disable_tovar').attr('rel', false);

        } else {
            $(el).removeClass('disable_tovar').attr('rel', true);
        }
        $(el).closest('tr').find('.orderMethodsEdit').removeClass('disabled')
        $(el).closest('tr').find('.orderMethodsEdit').removeAttr('disabled')
    });
}

var shopAdminMenuCache = false;

function showMessage(title, text, messageType)
{
    text = '<h4>' + title + '</h4>' + text;
    messageType = typeof messageType !== 'undefined' ? messageType : 'success';
    if (messageType == 'r')
        messageType = 'error';
    $('.notifications').notify({
        message: {
            html: text
        },
        type: messageType
    }).show();
}

function translite_title(from, to)
{
    var url = base_url + 'admin/pages/ajax_translit/';
    $.post(
            url, {
                'str': $(from).val()
            }, function(data)

    {
        $(to).val(data);
    }
    );
}

function create_description(from, to)
{
    if ($('.workzone textarea.elRTE').length)
        $('.workzone textarea.elRTE').elrte('updateSource');

    $.post(
            base_url + 'admin/pages/ajax_create_description/', {
                'text': $(from).val()
            },
    function(data) {
        $(to).val(data);
    }
    );
}

function retrive_keywords(from, to)
{
    if ($('.workzone textarea.elRTE').length)
        $('.workzone textarea.elRTE').elrte('updateSource');

    $.post(base_url + 'admin/pages/ajax_create_keywords/', {
        'keys': $(from).val()
    },
    function(data) {
        $(to).html(data);
    }
    );
}

function ajax_div(target, url)
{
    $.ajax(url, {
        headers: {
            'X-PJAX': 'X-PJAX'
        },
        success: function(data) {
            $('#' + target).append(data);
        }
    });
}

//submit form
$('form input[type="submit"], form button[type="submit"]').off('click.validate').on('click.validate', function(e) {
    var form = $(this).closest('form');

    form.validate();
    if (!form.valid())
        e.preventDefault();
});

function handleFormSubmit() {
    //        collectMCEData();
    //update content in textareas with elRTE
    var $this = $(this);

    if ($('.workzone textarea.elRTE').length)
        $('.workzone textarea.elRTE').elrte('updateSource');

    var selector = $this.attr('data-form'),
            action = $this.data('action'),
            data = $this.data('adddata'),
            form = $(selector);


    form.validate()
    if (form.valid())
    {
        showLoading();
        var options = {
            data: $.extend({
                "action": action
            }, eval('(' + data + ')')),
            success: function(data) {
                hideLoading();
                var resp = document.createElement('div');
                resp.innerHTML = data;
                $(resp).find('p').remove();
                $('.notifications').append(resp);
                $this.removeClass('disabled').attr('disabled', false);
                return true;
            }
        };
        form.ajaxSubmit(options);
    }
    else
        $this.removeClass('disabled').attr('disabled', false);
    return false;
}
$('body').off('click.validate').on('click.validate', '.formSubmit', handleFormSubmit);

function loadShopInterface()
{
    if ($.browser.opera == true)
    {
        window.location = '/admin/components/run/shop/dashboard';
    }
    if ($('#baseSearch'))
    {
        $('#baseSearch').val('');
        $('#baseSearch').attr('id', 'shopSearch');
        $('#adminAdvancedSearch').attr('action', '/admin/components/run/shop/search/advanced');
        initShopSearch();
    }
    // Switch menu
    $('#baseAdminMenu').hide();
    $('#shopAdminMenu').show();

    $('li').removeClass('active');
    $('#shopAdminMenu li.homeAnchor').addClass('active');

    $.pjax({
        url: '/admin/components/run/shop/dashboard',
        container: '#mainContent',
        timeout: 3000
    });
    isShop = true;
    $('a.logo').attr('href', '/admin/components/run/shop/dashboard');
    return false;
}

function loadBaseInterface()
{
    if ($.browser.opera == true)
    {
        window.location = '/admin';
    }

    if ($('#shopSearch'))
    {
        $('#shopSearch').val('');
        $('#shopSearch').attr('id', 'baseSearch');
        $('#adminAdvancedSearch').attr('action', '/admin/admin_search');
        initBaseSearch();
    }
    // Switch menu
    $('#shopAdminMenu').hide();
    $('#baseAdminMenu').show();

    $('li').removeClass('active');
    $('#baseAdminMenu li.homeAnchor').addClass('active');

    $.pjax({
        url: '/admin/dashboard',
        container: '#mainContent',
        timeout: 3000
    });
    isShop = false;
    $('a.logo').attr('href', '/admin/dashboard');
    return false;
}

function initBaseSearch() {
    $.get('/admin/admin_search/autocomplete', function(data) {
        baseAutocompleteData = JSON.parse(data);
        $('#baseSearch').autocomplete({
            source: baseAutocompleteData
        });
    });
}

function initShopSearch() {

    $('#shopSearch').autocomplete({
        source: '/admin/components/run/shop/search/autocomplete'
    });
}

function initTinyMCE()
{
    var opts = {
        //mode : "textareas",
        // Location of TinyMCE script
        height: 300,
        language: locale.substr(0, 2),
        script_url: '/js/tiny_mce/tiny_mce.js',
        // General options
        theme: "advanced",
        //skin: "o2k7",
        skin: 'bootstrap',
        //skin_variant: "silver",
        plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
        // Theme options
        theme_advanced_buttons1: /*"save"+*/"newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,|,cut,copy,paste,pastetext,pasteword, |, search,replace",
        theme_advanced_buttons2: "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,",
        theme_advanced_buttons3: "visualchars,nonbreaking,template,pagebreak,|,tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        //            theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,
        // Example content CSS (should be your site CSS)
        content_css: "css/content.css",
        // Drop lists for link/image/media/template dialogs
        template_external_list_url: "lists/template_list.js",
        external_link_list_url: "lists/link_list.js",
        // external_image_list_url : "lists/image_list.js",
        media_external_list_url: "lists/media_list.js",
        // Replace values for the template plugin
        template_replace_values: {
            //username: "Some User",
            //staffid: "991234"
        },
        mode: "exact",
        elements: 'nourlconvert',
        //relative_urls : true, // Default value
        //document_base_url : 'http://img.loc/',
        convert_urls: false,
        file_browser_callback: function(field_name, url, type, win) {
            $('<div/>').dialogelfinder({
                url: '/admin/elfinder_init',
                lang: locale.substr(0, 2),
                dialog: {
                    width: 900,
                    modal: true,
                    title: 'Files',
                    zIndex: 900001
                },
                getFileCallback: function(file) {
                    file.path = file.path.replace(/\134/g, '/');
                    file.path = '/' + file.path;

                    var field = win.document.forms[0].elements[field_name];
                    field.value = file.path;
                    var cmsT = win.document.forms[0].elements['cms_token'];
                    cmsT.value = $('input[name=cms_token]').val();


                    $(win.document.forms[0], 'input#insert').on('click', function(el) {
                        //if (el.srcElement == 'input#insert') {
                        sPost();
                        //}
                    });
                    //                 
                    }

                    $(field).change();
                },
                commandsOptions: {
                    getfile: {
                        oncomplete: 'destroy' // close/hide elFinder
                    }
                },
                customData: {
                    cms_token: elfToken,
                }
            });
        }
    };

    $('textarea.elRTE.focusOnClick').each(function() {
        $(this).on('focus', function() {
            $(this).tinymce(opts);
        });
    });

    $('textarea.elRTE').not('.focusOnClick').each(function() {
        var $this = $(this);
        var id = $this.attr('id');
        if (!$this.hasClass('inited')) {
            opts.selector = id;
            if ($this.hasClass('smallTextarea')) {
                opts.theme_advanced_buttons1 = undefined;
                opts.theme_advanced_buttons2 = undefined;
                opts.theme_advanced_buttons3 = undefined;
            }
            $this.addClass('inited').tinymce(opts);
        }
    });
}

function initTextEditor(name) {
    if (typeof (name) != 'undefined' && name.length != 0 && name != 'none')
        ({
            'tinymce': initTinyMCE
        }[name]())
}

var dlg = false;
function elFinderPopup(type, id, path, onlyMimes)
{
    fId = id;
    if (typeof path == 'undefined')
        path = '';
    if (typeof onlyMimes == 'undefined')
        onlyMimes = [];
    //todo: create diferent browsers (check 'type' variable)
    if (!dlg)
    {
        dlg = $('#elFinder').dialogelfinder({
            url: '/admin/elfinder_init',
            lang: locale.substr(0, 2),
            commands: [
                'open', 'reload', 'home', 'up', 'back', 'forward', 'getfile', 'quicklook',
                'download', 'rm', 'rename', 'mkdir', 'mkfile', 'upload', 'edit', 'preview', 'extract', 'archive', 'search', 'info', 'view', 'help', 'sort'
            ],
            uiOptions: {
                // toolbar configuration
                toolbar: [
                    ['back', 'forward'],
                    ['reload'],
                    ['home', 'up'],
                    ['mkdir', 'mkfile', 'upload'],
                    //        		['mkfile', 'upload'],
                    //        		['open', 'download', 'getfile'],
                    ['download'],
                    ['info'],
                    ['quicklook'],
                    ['rm'],
                    //        		['duplicate', 'rename', 'edit', 'resize'],
                    ['duplicate', 'rename', 'edit'],
                    ['extract', 'archive'],
                    ['view', 'sort'],
                    ['help'],
                    ['search']
                ],
                // directories tree options
                tree: {
                    // expand current root on init
                    openRootOnLoad: true,
                    // auto load current dir parents
                    syncTree: true
                },
            },
            commandsOptions: {
                getfile: {
                    oncomplete: 'close' // close/hide elFinder
                },
            },
            getFileCallback: function(file) {
                if (path != '')
                {
                    var str = file.path;
                    var m = str.match('[\\\\ /]');
                    file.path = file.path.substr(m.index + 1);
                    if (path[0] != '/')
                        path = '/' + path;
                }
                file.path = file.path.replace(/\134/g, '/');
                $('#' + fId).val(path + '/' + file.path);

                if (type == 'image' && $('#' + fId + '-preview').length)
                {
                    var img = document.createElement('img');
                    img.src = $('#' + fId).val();
                    img.className = "img-polaroid";
                    $('#' + fId + '-preview').html(img);
                }
            },
            contextmenu: {
                // navbarfolder menu
                //        	navbar : ['open', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|', 'info'],

                // current directory menu
                //        	cwd    : ['reload', 'back', '|', 'upload', 'mkdir', 'mkfile', 'paste', '|', 'info'],

                // current directory file menu
                files: [
                    'edit', 'rename', '|', 'download', '|',
                    'rm', '|', 'archive', 'extract', '|', 'info'
                ]
            },
            customData: {
                cms_token: elfToken,
                path: path
            },
            onlyMimes: [onlyMimes]
        });
    }
    else
        dlg.show();
    return false;
}

function elFinderTPLEd()
{
    //todo: create diferent browsers (check 'type' variable)
    eD = $('#elFinderTPLEd').elfinder({
        url: '/admin/elfinder_init/1',
        height: $(window).height() * 0.6,
        lang: locale.substr(0, 2),
        commands: [
            'open', 'reload', 'home', 'up', 'back', 'forward', 'getfile', 'quicklook',
            'download', 'rm', 'rename', 'mkdir', 'mkfile', 'upload', 'edit', 'preview', 'extract', 'archive', 'search', 'info', 'view', 'help', 'sort'
        ],
        commandsOptions: {
        },
        uiOptions: {
            // toolbar configuration
            toolbar: [
                ['back', 'forward'],
                ['reload'],
                ['home', 'up'],
                ['mkdir', 'mkfile', 'upload'],
                //        		['mkfile', 'upload'],
                //        		['open', 'download', 'getfile'],
                ['download'],
                ['info'],
                //        		['quicklook'],
                ['rm'],
                //        		['duplicate', 'rename', 'edit', 'resize'],
                ['rename', 'edit'],
                ['extract', 'archive'],
                ['view', 'sort'],
                ['help'],
                ['search']
            ],
            // directories tree options
            tree: {
                // expand current root on init
                openRootOnLoad: true,
                // auto load current dir parents
                syncTree: true
            },
        },
        editors: {
            editor: {
                load: function() {
                },
                save: function() {
                },
                mimes: []
            }
        },
        getFileCallback: function(e, ev, c) {
            //self.fm.select($(this), true);
            eD.exec('edit');
            return  false;

            //self.ui.exec(self.ui.isCmdAllowed('open') ? 'open' : 'select');
        },
        contextmenu: {
            // navbarfolder menu
            //        	navbar : ['open', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|', 'info'],

            // current directory menu
            //        	cwd    : ['reload', 'back', '|', 'upload', 'mkdir', 'mkfile', 'paste', '|', 'info'],

            // current directory file menu
            files: [
                'edit', 'rename', '|', 'download', '|', 'copy', 'cut', 'paste', '|',
                'rm', '|', 'archive', 'extract', '|', 'info'
            ]
        },
        customData: {
            cms_token: elfToken
        }
        //onlyMimes: ['text'],
    }).elfinder('instance');

    eD.bind('get', function(v) {
        $('textarea.elfinder-file-edit').closest('div.ui-dialog').css({
            'width': '90%',
            'left': '5%'
        });
    });
}

var orders = new Object({
    chOrderStatus: function(status) {
        var ids = new Array();
        $('input[name=ids]:checked').each(function() {
            ids.push($(this).val());
        });
        $.post('/admin/components/run/shop/orders/ajaxChangeOrdersStatus/' + status, {
            ids: ids
        }, function(data) {
            $('#mainContent').after(data);
            $.pjax({
                url: window.location.href,
                container: '#mainContent',
                timeout: 3000
            });
        });
        return true;
    },
    fixAddressA: function()
    {
        $('#postAddressBtn').attr('href', "http://maps.google.com/?q=" + $('#postAddress').val());
        return true;
    },
    chOrderPaid: function(paid) {
        var ids = new Array();
        $('input[name=ids]:checked').each(function() {
            ids.push($(this).val());
        });
        $.post('/admin/components/run/shop/orders/ajaxChangeOrdersPaid/' + paid, {
            ids: ids
        }, function(data) {
            $('#mainContent').after(data);
            $.pjax({
                url: window.location.href,
                container: '#mainContent',
                timeout: 3000
            });
        });
        return true;
    },
    deleteOrders: function() {
        $('.modal').modal();
    },
    deleteOrdersConfirm: function()
    {
        var ids = new Array();
        $('input[name=ids]:checked').each(function() {
            ids.push($(this).val());
        });
        $.post('/admin/components/run/shop/orders/ajaxDeleteOrders/', {
            ids: ids
        }, function(data) {
            $('#mainContent').after(data);
            $.pjax({
                url: window.location.pathname,
                container: '#mainContent',
                timeout: 3000
            });
        });
        $('.modal').modal('hide');
        return true;
    },
    addProduct: function(modelId)
    {
        productName = '';
        variants = '';
        pNumber = ''
        $('.modal .modal-body').load('/admin/components/run/shop/orders/ajaxEditAddToCartWindow/' + modelId, function() {
            $('#product_name').autocomplete({
                source: '/admin/components/run/shop/orders/ajaxGetProductList/?categoryId=' + $('#Categories').val(),
                select: function(event, ui) {
                    productName = ui.item.label;
                    $('#product_id').val(ui.item.value);
                    vKeys = Object.keys(ui.item.variants);

                    $('#product_variant_name').html('');
                    for (var i = 0; i < vKeys.length; i++)
                        $('#product_variant_name').append(new Option(ui.item.variants[ vKeys[i] ].name + ' - ' + ui.item.variants[ vKeys[i] ].price + " " + ui.item.cs, vKeys[i], true, true));
                },
                close: function() {
                    $('#product_name').val(productName);
                }
            });

            if ($.exists('#productNumber')) {
                $('#productNumber').autocomplete({
                    minChars: 1,
                    source: function(request, callback) {
                        var data = {
                            term: request.term,
                            noids: (function() {
                                var productIds = [];
                                $('#productsInCart tbody tr td:first-child a').each(function() {
                                    var pid = $(this).attr('href').split('/').pop();
                                    if (!isNaN(pid))
                                        productIds.push(pid);
                                });
                                return productIds;
                            })()
                        };
                        $.get('/admin/components/run/shop/orders/ajaxGetProductList/number', data, function(response) {
                            callback(response);
                        }, 'json');
                    },
                    select: function(event, ui) {
                        productName = ui.item.name;
                        pNumber = ui.item.number;

                        $('#product_id').val(ui.item.value);
                        vKeys = Object.keys(ui.item.variants);

                        $('#product_variant_name').html('');
                        for (var i = 0; i < vKeys.length; i++)
                            $('#product_variant_name').append(new Option(ui.item.variants[ vKeys[i] ].name + ' - ' + ui.item.variants[ vKeys[i] ].price + "  " + ui.item.cs, vKeys[i], true, true));
                    },
                    close: function() {
                        $('#product_name').val(productName);

                        $('#productNumber').val(pNumber);
                    }



                });
            }

            $('#Categories').change(function() {
                $('#product_name').autocomplete({
                    source: '/admin/components/run/shop/orders/ajaxGetProductList/?categoryId=' + $('#Categories').val(),
                    select: function(event, ui) {
                        productName = ui.item.label;
                        $('#product_id').val(ui.item.value);
                        vKeys = Object.keys(ui.item.variants);

                        for (var i = 0; i < vKeys.length; i++)
                            $('#product_variant_name').append(new Option(ui.item.variants[ vKeys[i] ].name + ' ' + ui.item.variants[ vKeys[i] ].price + "  " + ui.item.cs, vKeys[i], true, true));
                    },
                    close: function() {
                        $('#product_name').val(productName);

                    }
                });
                $('#product_name').val('');
                $('#product_variant_name').empty();
                $('#product_quantity').val('');
            });
        });
        $('.modal').modal('show');
        $('#addToCartConfirm').on('click', function() {
            if ($('.modal form').valid())
                $('.modal').modal('hide');
        });
        return false;
    },
    deleteProduct: function(id) {
        $('.notifications').load('/admin/components/run/shop/orders/ajaxDeleteProduct/' + id);
    },
    refreshTotalPrice: function(dmId)
    {
        var deliveryPrice = deliveryPrices[dmId];
        if (deliveryPrice === undefined)
            deliveryPrice = 0;
        var totalPrice = deliveryPrice + productsAmount - giftPrice;

        $('.totalOrderPrice').html(totalPrice);
    },
    updateOrderItem: function(id, btn, order)
    {
        var data = {};
        if ($(btn).data('update') == 'price')
            //    		alert($(btn).closest('td').find('input').val());
            data.newPrice = $(btn).closest('td').find('input').val();
        if ($(btn).data('update') == 'count')
            data.newQuantity = $(btn).closest('td').find('input').val();

//        $.post('/admin/components/run/shop/orders/ajaxEditOrderCart/' + id, data, function(data) {
//            $('.notifications').append(data);
//        });
        $.post('/admin/components/run/shop/orders/ajaxEditOrderCartNew/' + id, data, function(data) {
            $('.notifications').append(data);
        });
    },
    getProductsInCategory: function(categoryId) {
        $('.variantInfoBlock').hide();
        $.ajax({
            url: '/admin/components/run/shop/orders/ajaxGetProductsInCategory/',
            type: "post",
            data: 'categoryId=' + categoryId,
            async: false,
            success: function(data) {
                var products = JSON.parse(data)
                $(".variantsForOrders").empty();
                $(".productsForOrders").empty().each(function() {
                    if (products.length > 0)
                        for (var i = 0; i < products.length; i++)
                            $(this).append($('<option data-product-name=\'' + products[i]['name'] + '\' value=' + products[i]['id'] + '>' + products[i]['name'] + '</option>'));
                    else
                        $('<option>', {
                            text: langs.notFound,
                            disabled: 'disabled'
                        }).appendTo($(this));
                });
            }
        });
    },
    getProductVariantsByProduct: function(productId, productName) {
        $('.variantInfoBlock').hide();
        $.ajax({
            url: '/admin/components/run/shop/orders/ajaxGetProductVariants/',
            type: "post",
            data: 'productId=' + productId,
            complete: function(data) {
//                console.log(data);
//                return;
                var productVariants = JSON.parse(data.responseText),
                        separate = '';
                $(".variantsForOrders").empty().each(function() {
                    for (var i = 0; i < productVariants.length; i++) {
                        var $this = $(this),
                                variantName = '';
                        if (productVariants[i]['name'] != '') {
                            variantName = productVariants[i]['name'];
                            separate = ' - '
                        }
                        var price = parseFloat(productVariants[i]['price']).toFixed(2);
                        $this.append($('<option data-number=\'' + productVariants[i]['number'] + '\' data-stock=\'' + productVariants[i]['stock'] + '\' data-price=\'' + price + '\' data-variantName=\'' + variantName +
                                '\' data-product-id=' + productId + ' data-product-name=\'' + productName + '\' data-productCurrency=' + curr + ' data-variantId=' + productVariants[i]['id'] +
                                ' value=' + productVariants[i]['id'] + ' data-orig_price="' + productVariants[i]['origPrice'] + '">' + variantName + separate + price + ' ' + curr + '</option>'));

                        $($this.find('option')[0]).trigger('click');
                        $this.trigger('change');
                        $(".chosen-container").each(function(){
                            $this.trigger("chosen:updated");
                        });
                    }
                });
            }
        });
    },
//    getProductVariantsByProduct: function(productId, productName) {
//        $('.variantInfoBlock').hide();
//        $.ajax({
//            url: '/admin/components/run/shop/orders/ajaxGetProductVariants/',
//            type: "post",
//            data: 'productId=' + productId,
//            complete: function(data) {
//                var productVariants = JSON.parse(data.responseText),
//                        separate = '';
//                $(".variantsForOrders").empty().each(function() {
//                    for (var i = 0; i < productVariants.length; i++) {
//                        var $this = $(this),
//                                variantName = '';
//                        if (productVariants[i]['name'] != '') {
//                            variantName = productVariants[i]['name'];
//                            separate = ' - '
//                        }
//                        var price = parseFloat(productVariants[i]['price']).toFixed(2);
//                        $this.append($('<option data-number=\'' + productVariants[i]['number'] + '\' data-stock=\'' + productVariants[i]['stock'] + '\' data-price=\'' + price + '\' data-variantName=\'' + variantName +
//                                '\' data-product-id=' + productId + ' data-product-name=\'' + productName + '\' data-productCurrency=' + curr + ' data-variantId=' + productVariants[i]['id'] +
//                                ' value=' + productVariants[i]['id'] + ' data-orig_price="' + productVariants[i]['origPrice'] + '">' + variantName + separate + price + ' ' + curr + '</option>'));
//
//                        $($this.find('option')[0]).trigger('click');
//                        $this.trigger('change');
//                    }
//                });
//            }
//        });
//    },
    //Add product to cart in admin
    addToCartAdmin: function(element) {
        var clonedElement = $('.addNewProductBlock').clone(true).removeClass('addNewProductBlock'),
                data = element.data(),
                variantName = '-';

        if (data.variantname != 'noName') {
            variantName = data.variantname;
            if (!data.variantname) {
                variantName = '-';
            }

        }
//        console.log(data)
        clonedElement.find('.variantCartNumber').html(data.number);
        clonedElement.find('.variantCartName').html(variantName);
        clonedElement.find('.productCartName').html('<a target="_blank" href="/admin/components/run/shop/products/edit/' + data.productId + '">' + data.productName + '</a>');
        clonedElement.find('.productCartPrice').html(parseFloat(data.price).toFixed(2));
        clonedElement.find('.productCartPriceSymbol').html(data.productcurrency);

        //Input values
        clonedElement.find('.inputProductId').val(data.productId);
        clonedElement.find('.inputProductName').val(data.productName);
        clonedElement.find('.inputVariantId').val(data.variantid);
        clonedElement.find('.inputVariantName').val(variantName);
        clonedElement.find('.inputPrice').val(data.price);
        clonedElement.find('.inputQuantity').val(1);


        $('#insertHere').append(clonedElement);

        var inputUpdatePrice = clonedElement.find('.productCartQuantity');
        inputUpdatePrice.data('stock', data.stock);
        orders.updateQuantityAdmin(inputUpdatePrice);

    },
    deleteCartProduct: function(element) {
        var tr = $(element).closest('tr');
        tr.remove();
        orders.updateTotalCartSum();
        if ($('.addVariantToCart').data('productId') == tr.find('.inputProductId').val())
            $('.addVariantToCart').removeClass('btn-primary').removeAttr('disabled').addClass('btn-success').removeClass('btn-danger disabled').html(langs.addToCart);
    },
    updateQuantityAdmin: function(element) {
        var stock = $(element).data('stock');
        var row = $(element).closest('tr');
        var quantity = $(element).val();
        var price = row.find('.productCartPrice').html();

//Условие убрано в связи с заданием ICMS-1518
//        if (checkProdStock == 1 && quantity > stock) {
//            $(element).val(stock);
//            quantity = stock;
//        }
        total = price * quantity;
        row.find('.productCartTotal').html(total.toFixed(2));

        orders.updateTotalCartSum();

    },
    updateTotalCartSum: function() {
        var total = parseFloat(0);
        allPrices = $('#insertHere').find('.productCartTotal')
        allPrices.each(function(i, element) {
            total = total + parseFloat($(element).html());
        })
        $('#totalCartSum').html(parseFloat(total).toFixed(2));
    },
    isInCart: function(variantId) {
        var productBlocksInCart = $('#insertHere').find('.inputVariantId');
        var countProductsInCart = productBlocksInCart.length;
        var checkResult = 'false';

        if (countProductsInCart > 0) {
            productBlocksInCart.each(function(index, el) {
                if (variantId == el.value) {
                    checkResult = 'true';
                    return false;
                }
            });
        }
        return checkResult;

    }
});

var orderStatuses = new Object({
    reorderPositions: function() {
        var i = 1;
        $('.sortable tr').each(function() {
            $(this).find('input').val(i);
            i++;
        });
        $('#orderStatusesList').ajaxSubmit({
            target: '.notifications'
        });
        return true;
    },
    deleteOne: function(id) {
        $('.modal .modal-body').load('/admin/components/run/shop/orderstatuses/ajaxDeleteWindow/' + id, function() {
            return true;
        });
        $('.modal').modal('show');
    }
});

var callbacks = new Object({
    deleteOne: function(id) {
        $.post('/admin/components/run/shop/callbacks/deleteCallback', {
            id: id
        }, function(data) {
            $('.notifications').append(data);
        });
    },
    deleteMany: function() {
        var id = new Array();
        $('input[name=ids]:checked').each(function() {
            id.push($(this).val());
        });

        this.deleteOne(id);
        $('.modal').modal('hide');
        return true;
    },
    changeStatus: function(id, statusId)
    {
        $.post('/admin/components/run/shop/callbacks/changeStatus', {
            CallbackId: id,
            StatusId: statusId
        }, function(data) {
            $('.notifications').append(data);
        });
        $('#callback_' + id).closest('tr').data('status', statusId);
        this.reorderList(id);
    },
    reorderList: function(id)
    {
        var stId = $(' #callback_' + id).data('status');
        $('#callbacks_' + stId + ' table tbody').append($('#callback_' + id));
    },
    changeTheme: function(id, themeId)
    {
        $.post('/admin/components/run/shop/callbacks/changeTheme', {
            CallbackId: id,
            ThemeId: themeId
        }, function(data) {
            $('.notifications').append(data);
        });
    },
    setDefaultStatus: function(id, element)
    {
        $('.btn-danger').removeAttr('disabled');
        $('.prod-on_off').addClass('disable_tovar').css('left', '-28px');
        if ($(element).hasClass('disable_tovar')) {
            $(element).closest('tr').find('.btn-danger').attr('disabled', 'disabled');
            $(element).closest('tr').find('.prod-on_off').css('left', '0');
        }


        $.post('/admin/components/run/shop/callbacks/setDefaultStatus', {
            id: id
        }, function(data) {
            $('.notifications').append(data);
        });

        return true;
    },
    deleteStatus: function(id, curElement)
    {
        if (!$(curElement).closest('tr').find('.disable_tovar').length) {
            return false;
        }
        $.post('/admin/components/run/shop/callbacks/deleteStatus', {
            id: id
        }, function(data) {
            $('.notifications').append(data);
        });
    },
    deleteTheme: function(id)
    {
        $.post('/admin/components/run/shop/callbacks/deleteTheme', {
            id: id
        }, function(data) {
            $('.notifications').append(data);
        });
    },
    reorderThemes: function()
    {
        var positions = new Array();
        $('.sortable tr').each(function() {
            positions.push($(this).data('id'));
        });

        $.post('/admin/components/run/shop/callbacks/reorderThemes', {
            positions: positions
        }, function(data) {
            $('.notifications').append(data);
        });
        return true;
    }
});

var shopCategories = new Object({
    deleteCategories: function() {
        $('.modal').modal();
    },
    deleteCategoriesConfirm: function(simple)
    {
        var ids = new Array();
        if (simple == undefined) {
            $('input[name=ids]:checked').each(function() {
                ids.push($(this).val());
            });
        }
        else
            ids.push(simple);

        var url = '/admin/components/run/shop/categories/delete';
        if ($('[data-url-delete]').length > 0)
            url = $('[data-url-delete]').data('url-delete');
        $.post(url, {
            id: ids
        }, function(data) {
            $('#mainContent').after(data);
            $.pjax({
                url: window.location.pathname,
                container: '#mainContent',
                timeout: 3000
            });
        });
        $('.modal').modal('hide');
        return true;
    }
});

var GalleryCategories = new Object({
    deleteCategories: function() {
        $('.modal').modal();
    },
    deleteCategoriesConfirm: function()
    {
        var ids = new Array();
        $('input[name=ids]:checked').each(function() {
            ids.push($(this).val());
        });
        $.post('/admin/components/cp/gallery/delete_category', {
            id: ids
        }, function(data) {
            $('#mainContent').after(data);
            $.pjax({
                url: window.location.pathname,
                container: '#mainContent',
                timeout: 3000
            });
        });
        $('.modal').modal('hide');
        return false;
    }
});
var GalleryAlbums = new Object({
    whatDelete: function(el) {
        var el = el;

        var closest_tr = $(el).closest('tr');
        var mini_layout = $(el).closest('.mini-layout');

        if (closest_tr[0] != undefined) {
            this.id = $(el).closest('table').find("[type = hidden]").val();
        }
        else if (mini_layout[0] != undefined) {
            this.id = mini_layout.find('[name = album_id]').val();
        }
    },
    deleteCategoriesConfirm: function()
    {
        if (mini_layout[0] != undefined) {
            url = '/admin/components/cp/gallery/category/' + mini_layout.find('[name = category_id]').val();
        }
        else
            url = window.location.pathname;

        $.post('/admin/components/cp/gallery/delete_album', {
            album_id: this.id
        }, function(data) {
            $.pjax({
                url: url,
                container: '#mainContent',
                timeout: 3000
            });
        });
        $('.modal').modal('hide');
        return false;
    }
});

function clone_object() {
    btn_temp = $('[data-remove="example"]');
    $('[data-frame]').each(function() {
        cloneObject($(this))
    })
    function cloneObject(data) {
        var data = data;
        var add_variants = {
            cloneObjectVariant: data.find('[data-rel="add_new_clone"]'),
            frameSetClone: data.find('tbody'),
            frameClone: function() {
                var variant_row = this.frameSetClone.find('tr:first').clone();
                return this.frameSetClone.find('tr:first').clone().find('input').val('').parents('tr')
            },
            addNewVariant: function() {
                btn_temp = btn_temp.clone().show();
                return this.frameClone().find('td:last').append(btn_temp).parents('tr');
            }
        }
        add_variants.cloneObjectVariant.on('click', function() {
            add_variants.frameSetClone.append(add_variants.addNewVariant());
        })
        $('[data-remove]').live('click', function() {
            $(this).closest('tr').remove();
        })
    }
}
var variantInfo = new Object({
    getImage: function(variantId) {
        var imageName = '';
        $.ajax({
            url: "/admin/components/run/shop/orders/getImageName",
            async: false,
            type: "post",
            data: 'variantId=' + variantId,
            success: function(data) {
                imageName = data;
            }
        });
        return imageName;
    }
})

window.onload = clone_object();