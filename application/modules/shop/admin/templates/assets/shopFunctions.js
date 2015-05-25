
var shop_url = base_url + 'admin/components/run/shop/';
var admin_theme_url = base_url + 'application/modules/shop/admin/templates/assets/';
var shopAdminMenuCache = false;
var shopAdminLoaded = false;

// TODO: Put all css code to css file.
window.addEvent('domready', function() {
    // Create switcher html code
    var shopSwitcher = new Element('div', {
        id: 'shopSwitcher',
        style: 'float:right;'
    });
    var switcherCode = '<a href="" id="linkAdminShop" onClick="javascript:loadShopInterface(); return false;">' + langs.manageShop  + ' →</a>' +
            '<a href="" style="display:none;" id="linkAdminSystem" onClick="javascript:restoreAdminInterface(); return false;">← ' + langs.backToTheSystem  + '</a>' +
            '<div></div>';
    shopSwitcher.set('html', switcherCode);
    shopSwitcher.inject($('spinner2'), 'after');

    // Create shopAdminPage block where we'll load content.
    var shopAdminPage = new Element('div', {
        id: 'shopAdminPage',
        style: 'display:none;background-color:#F8F8F8;overflow-x:auto;overflow-y:auto;height:100%;'
    });

    // Inject shop navigation
    var shopNaviBlock = new Element('div', {
        id: 'shopTopNav',
        style: 'position: absolute;left: 250px;top: 0;color: #b2b2b2;text-align: center;padding: 11px 0px 0 0;'
    });
    var shopNaviCode = '<ul class="menu-right">' +
            '<li>' +
            '    <img src="/templates/administrator/images/left.png" style="cursor:pointer" onclick="ShopHistory_back();">' +
            '	<img src="/templates/administrator/images/right.png" style="cursor:pointer" onclick="ShopHistory_forward();">' +
            '	<img src="/templates/administrator/images/refresh.png" class="refresh" style="cursor:pointer" onclick="ShopHistory_refresh();">' +
            '</li>' +
            '</ul>';
    shopNaviBlock.set('html', shopNaviCode);
    shopNaviBlock.inject($('topNav'), 'after');

    var shopInfoButtonsBlock = new Element('div', {
        id: 'topInfoButtons'
    });
    shopInfoButtonsBlock.inject($('shopTopNav'), 'after');

    // Inject it after main "page" block
    shopAdminPage.inject($('page'), 'after');

    loadShopInterface();
});

function ajaxShopDiv(url) {
    ajax_div('shopAdminPage', shop_url + url);
}
/**
 * Load shop main menu and sidebar categories list. 
 * 
 * @access public
 * @return void
 */
function loadShopInterface()
{
    $('cmsLogo').removeEvents('click');
    $('cmsLogo').addEvent('click', function() {
        ajaxShop('orders/index');
    });

    // Hide system menu
    var mainSystemMenu = $('desktopNavbar').getFirst('ul');
    mainSystemMenu.setStyle('display', 'none');

    // Hide system navigation (prev,next,refresh)
    $('topNav').setStyle('display', 'none');
    $('shopTopNav').setStyle('display', 'block');

    $('topInfoButtons').setStyle('display', 'block');

    // Load and set shop menu
    if (shopAdminMenuCache == false)
    {
        var shopAdminMainMenu = new Element('div', {
            id: 'shopAdminMainMenu',
            style: 'display:block;'
        });
        shopAdminMainMenu.load('/application/modules/shop/admin/templates/shopMainMenu.html');
//        shopAdminMainMenu.inject('desktopNavbar');
        shopAdminMainMenu.inject('mainAdminMenu');
        shopAdminMenuCache = true;
    } else {
        $('shopAdminMainMenu').setStyle('display', 'block');
    }

    updateNotificationsTotal();

    // Hide linkAdminShop 
    $('linkAdminShop').setStyle('display', 'none');
    // Show linkAdminSystem
    $('linkAdminSystem').setStyle('display', 'block');

    // Hide "page" block
    $('page').setStyle('display', 'none');

    // Show shopAdminPage
    $('shopAdminPage').setStyle('display', 'block');

    // Load in sidebar shop categories list
    // Load shop dashboard

    // Load admin dashboard only first time,
    if (shopAdminLoaded == false)
    {
        // Load orders list.
        ajaxShop('orders/index');
        shopAdminLoaded = true;
    }

    loadShopSidebarCats();
}

function updateNotificationsTotal()
{
    //get total number of new notifications
    ajax_get_info('topInfoButtons', '/admin/components/run/shop/notifications/getAvailableNotification');
    setTimeout('updateNotificationsTotal()', 1000 * 60);
}

/**
 * restoreAdminInterface 
 * 
 * @access public
 * @return void
 */
function restoreAdminInterface()
{
    $('cmsLogo').removeEvents('click');

    // Show system navigation (prev,next,refresh)
    $('topNav').setStyle('display', 'block');
    $('shopTopNav').setStyle('display', 'none');

    $('topInfoButtons').setStyle('display', 'none');

    // Show linkAdminShop 
    $('linkAdminShop').setStyle('display', 'block');
    // Hide linkAdminSystem
    $('linkAdminSystem').setStyle('display', 'none');

    // Show "page" block
    $('page').setStyle('display', 'block');

    // Hide shopAdminPage
    $('shopAdminPage').setStyle('display', 'none');

    // Show system menu
    var mainSystemMenu = $('desktopNavbar').getFirst('ul');
    mainSystemMenu.setStyle('display', 'block');

    // Hide shop menu
    $('shopAdminMainMenu').setStyle('display', 'none');

    // Load system categories
    ajax_div('categories', base_url + 'admin/categories/update_block/');
}

/**
 * Save categories positions. (category list view)
 */
function SaveCategoriesPositions()
{
    var item_pos = new Array();

    var items = $('ShopCatsHtmlTable').getElements('input');
    items.each(function(el, i) {
        if (el.hasClass('SCategoryPos'))
        {
            id = el.id;
            val = el.value;
            new_pos = id + '_' + val;
            item_pos.include(new_pos);
        }
    });

    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'categories/save_positions',
        onRequest: function() {
        },
        onComplete: function(response) {
            // Update list
            ajaxShop('categories/index');
        }
    }).post({
        'positions': item_pos
    });
}

/**
 * Save categories positions. (category list view)
 */
function SavePropertiesPositions()
{
    var item_pos = new Array();

    var items = $('ShopProductsPropertiesHtmlTable').getElements('input');
    items.each(function(el, i) {
        if (el.hasClass('SPropertyPos'))
        {
            id = el.id;
            val = el.value;
            new_pos = id + '_' + val;
            item_pos.include(new_pos);
        }
    });

    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'properties/savePositions',
        onRequest: function() {
        },
        onComplete: function(response) {
            // Update list
            ajaxShop('properties/index');
        }
    }).post({
        'positions': item_pos
    });
}

/**
 * Load shop categories into sidebar.
 */
function loadShopSidebarCats()
{
    ajax_div('categories', shop_url + 'ajaxCategoriesTree');
}

function ajaxShop(url)
{
    ShopHistory('shopAdminPage', shop_url + url);
    ajax_div('shopAdminPage', shop_url + url);
}

/**
 * Submit form from one of footer buttons.
 */
function ajaxShopForm(button, updateBlockId)
{
    var form = button.form;

    if (button.name)
    {
        var hiddenElement = new Element('input', {
            type: 'hidden',
            name: button.name,
            value: 1
        });
        hiddenElement.inject($(form));
    }

    $(form).addEvent('submit', function(event) {
        event.stop();

        $(form).getElements('input[type=submit]').each(function(number) {
            number.disabled = true;
        });

        if (!updateBlockId)
        {
            var req = new Request.HTML({
                method: $(form).get('method'),
                url: $(form).get('action'),
                onRequest: function() {
                    start_ajax();
                },
                onFailure: function() {
                },
                onSuccess: function() {
                },
                onComplete: function(response) {
                    my_alert(form);
                }
            }).send($(form));
        } else {
            var req = new Request.HTML({
                method: $(form).get('method'),
                url: $(form).get('action'),
                update: $(updateBlockId),
                onRequest: function() {
                    start_ajax();
                },
                onFailure: function() {
                },
                onSuccess: function() {
                },
                onComplete: function(response) {
                    my_alert(form);
                }
            }).send($(form));
        }

        if (button.name)
        {
            hiddenElement.destroy();
        }
    });
}

function preview_shop_image(image_name)
{
    $('imagePreviewBox').setStyle('display', 'block');
    $('imagePreviewBoxImage').set('src', '/uploads/shop/' + image_name + '?' + Math.floor(Math.random() * 9999));
}

function nl2br(text) {
    text = escape(text);
    if (text.indexOf('%0D%0A') > -1) {
        re_nlchar = /%0D%0A/g;
    } else if (text.indexOf('%0A') > -1) {
        re_nlchar = /%0A/g;
    } else if (text.indexOf('%0D') > -1) {
        re_nlchar = /%0D/g;
    }

    try {
        text = text.replace(re_nlchar, '<br />');
    } catch (cobj) {
        console.warn(langs.convertionError  + cobj);
    }

    return unescape(text);
}

function shopLoadProperiesByCategory(selectBox, productId)
{
    if (productId > 0) {
        var productId = '/' + productId;
    } else {
        var productId = '';
    }

    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'properties/renderForm/' + selectBox.value + productId,
        update: 'productPropertiesContainer',
        onRequest: function() {
            start_ajax();
        },
        onFailure: function() {
        },
        onSuccess: function() {
        },
        onComplete: function(response) {
            stop_ajax();
        }
    }).send();
}

function shopLoadProperiesByCategoryInSearch(selectBox)
{
    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'search/renderCustomFields/' + selectBox.value,
        update: 'productPropertiesContainer',
        onRequest: function() {
            start_ajax();
        },
        onFailure: function() {
        },
        onSuccess: function() {
        },
        onComplete: function(response) {
            stop_ajax();
        }
    }).send();
}

function filterPropertiesByCategory(selectBox)
{
    ajaxShop('properties/index/' + selectBox.value);
}

function confirm_shop_delete_property(id)
{
    alertBox.confirm('<h1>' + del + wf + jid + id + '? </h1>', {
        onComplete:
                function(returnvalue) {
                    if (returnvalue)
                    {
                        $('prop' + id).setStyle('border', '2px solid #D95353');
                        start_ajax();
                        var req = new Request.HTML({
                            method: 'post',
                            url: shop_url + 'properties/delete',
                            evalResponse: true,
                            onComplete: function(response) {
                                $('prop' + id).dispose();

                                if ($$('#ShopProductsPropertiesHtmlTable tbody tr').length == 0)
                                {
                                    ajaxShop('properties/index');
                                }
                                stop_ajax();
                            }
                        }).post({
                            'id': id
                        });
                    }
                }
    });
}

/***** Orders list functions *****/
function confirm_delete_order(id, status)
{
    if (!status)
    {
        status = 0;
    }

    alertBox.confirm('<h1>' + del + wf + jid + id + '? </h1>', {
        onComplete:
                function(returnvalue) {
                    if (returnvalue)
                    {
                        $('orderRow' + id).setStyle('border', '2px solid #D95353');
                        start_ajax();
                        var req = new Request.HTML({
                            method: 'post',
                            url: shop_url + 'orders/delete',
                            evalResponse: true,
                            onComplete: function(response) {
                                $('orderRow' + id).dispose();

                                if ($$('.row').length == 0)
                                {
                                    ajaxShop('orders/index?status=' + status);
                                }
                                stop_ajax();
                            }
                        }).post({
                            'orderId': id
                        });
                    }
                }
    });
}

function moveToInProgress(id)
{
    $('productRow' + id).setStyle('border', '2px solid #B0D736');
    start_ajax();
    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'orders/changeStatus',
        evalResponse: true,
        onComplete: function(response) {
            $('productRow' + id).dispose();
            stop_ajax();
            if ($$('.row').length == 0)
            {
                ajaxShop('orders/index');
            }
        }
    }).post({
        'orderId': id,
        'status': 'progress'
    });

}

function moveToCompleted(id)
{
    $('productRow' + id).setStyle('border', '2px solid #B0D736');
    start_ajax();
    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'orders/changeStatus',
        evalResponse: true,
        onComplete: function(response) {
            $('productRow' + id).dispose();
            stop_ajax();
            if ($$('.row').length == 0)
            {
                ajaxShop('orders/index?status=1');
            }
        }
    }).post({
        'orderId': id,
        'status': 'completed'
    });
}

/**
 * change paid status on orders list
 */
function changePaid(el, id)
{
    start_ajax();
    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'orders/changePaid',
        onComplete: function(responseTree, responseElements, responseHTML, responseJavaScript) {
            if (responseHTML == 1)
            {
                el.src = '/application/modules/shop/admin/templates/assets/images/credit-card.png';
            } else {
                el.src = '/application/modules/shop/admin/templates/assets/images/credit-card-silver.png';
            }
            stop_ajax();
        }
    }).post({
        'orderId': id
    });
}

/**
 * notify by email on notifications list
 */
function NotifyByEmail(el, id, notified)
{
    if (notified == 1) {
        alertText = '<h1>' + remail + '</h1>';
    } else
    {
        alertText = '<h1>' + mail_product + '</h1>';
    }
    alertBox.confirm(alertText, {
        onComplete:
                function(returnvalue) {
                    if (returnvalue)
                    {
                        start_ajax();
                        var req = new Request.HTML({
                            method: 'post',
                            url: shop_url + 'notifications/notifyByEmail',
                            onComplete: function(responseTree, responseElements, responseHTML, responseJavaScript) {
                                if (responseHTML == 1)
                                {
                                    el.src = '/application/modules/shop/admin/templates/assets/images/mail_sent.png';
                                    $('notificationRow' + id).removeClass('row_available');
                                    $('notificationRow' + id).removeClass('row');
                                    $('notificationRow' + id).addClass('row_notified');
                                } else {
                                    el.src = '/application/modules/shop/admin/templates/assets/images/mail_send.png';
                                }
                                stop_ajax();
                            }
                        }).post({
                            'notificationId': id
                        });
                    }
                }
    });
}

function NotifyByEmail_WhenEdit(el, id, notified)
{
    if (notified == 1) {
        alertText = '<h1>' + langs.userAlreadyNotifiedViaEmail  + '</h1>';
    } else
    {
        alertText = '<h1>' + langs.notifyUserViaEmailUponAvailability  + '</h1>';
    }
    alertBox.confirm(alertText, {
        onComplete:
                function(returnvalue) {
                    if (returnvalue)
                    {
                        start_ajax();
                        var req = new Request.HTML({
                            method: 'post',
                            url: shop_url + 'notifications/notifyByEmail',
                            onComplete: function(responseTree, responseElements, responseHTML, responseJavaScript) {
                                if (responseHTML == 1)
                                {
                                    el.src = '/application/modules/shop/admin/templates/assets/images/mail_sent.png';
                                } else {
                                    el.src = '/application/modules/shop/admin/templates/assets/images/mail_send.png';
                                }
                                stop_ajax();
                            }
                        }).post({
                            'notificationId': id
                        });
                    }
                }
    });
}

function confirm_delete_notification(id, status)
{
    if (!status)
    {
        status = 1;
    }

    alertBox.confirm('<h1>' + del + wf + jid + id + '? </h1>', {
        onComplete:
                function(returnvalue) {
                    if (returnvalue)
                    {
                        $('notificationRow' + id).setStyle('border', '2px solid #D95353');
                        start_ajax();
                        var req = new Request.HTML({
                            method: 'post',
                            url: shop_url + 'notifications/delete',
                            evalResponse: true,
                            onComplete: function(response) {
                                $('notificationRow' + id).dispose();

                                if ($$('.row').length == 0 && $$('.row_notified').length == 0)
                                {
                                    ajaxShop('notifications/index?status=' + status);
                                }
                                stop_ajax();
                            }
                        }).post({
                            'notificationId': id
                        });
                    }
                }
    });
}

/*** Edit/create product functions ***/
function load_table_sorter()
{
    var sorter = new Sortables('#variantsTable tbody', {
        handle: 'img.drager',
        onStart: function(el) {
            el.setStyle('background', '#add8e6');
        },
        onComplete: function(el) {
            el.setStyle('background', '#EBEBEB');
        }
    });

    sorter.removeItems($('mainVariant'));
}

/**
 * Insert new variant row in variants table. create/edit products
 */
function cloneVariant()
{
    var newVariant = $('productVariant').clone();

    newVariantId = newVariantId + 1;
    var randomId = Math.random();
    var fullId = 'productVariantRow_' + newVariantId;

    newVariant.set('id', fullId);
    newVariant.inject('variantsBlock', 'bottom');

    $$('#' + fullId + ' .random_id')[0].set('value', randomId);

    $$("#" + fullId + ' .mainPhoto').each(function(el) {
        $(el).set('name', 'variants[mainPhoto][' + randomId + ']');
    });
    $$("#" + fullId + ' .smallPhoto').each(function(el) {
        $(el).set('name', 'variants[smallPhoto][' + randomId + ']');
    });

    var result = $$('#' + fullId + ' img.deleter');
    result.addEvent('click', function() {
        deleteVariant(fullId);
    });

    // Reload Sortable
    load_table_sorter();
}


// Clone warehouse row at product edit/create tpl
function cloneWarehouseVariant()
{
    var newWVariant = $('warehouse_line').clone();
    var fullWId = 'warehouseRow_' + Math.random();
    newWVariant.set('id', fullWId);
    newWVariant.inject('warehouses_container', 'bottom');
    newWVariant.inject('warehouses_container', 'bottom');
}

// Delete product variant row.
function deleteVariant(id)
{
    if ($$('.variantsList tbody tr').length == 1)
    {
        showMessage(' ', langs.failureToRemoveVariant );
        return false;
    }
    $(id).dispose();
}

// Callback function to post form
function uploadCallback()
{
    var imgIFrame = document.getElementById('upload_target');
    var data = imgIFrame.contentWindow.document.body.innerHTML;

    var result_arr = JSON.decode(data);

    if (result_arr.error)
    {
        showMessage(error, nl2br(result_arr.error));
    }
    if (result_arr.ok)
    {
        showMessage(message, edit_save);
        var redirect_url = result_arr.redirect_url;
        ajaxShop(redirect_url.replace(/\&amp\;/g, '&'));
    }

    $$("input[type=file]").each(function(item, index) {
        $(item).set('disabled', '');
    });
}

// Callback function to post form
function translatingUploadCallback()
{
    var imgIFrame = document.getElementById('upload_target');
    var data = imgIFrame.contentWindow.document.body.innerHTML;

    var result_arr = JSON.decode(data);

    if (result_arr.error)
    {
        showMessage(error, nl2br(result_arr.error));
    }
    if (result_arr.ok)
    {
        showMessage(message, edit_save);
        var redirect_url = result_arr.redirect_url;
        ajax_div('translate_list_item_Window_content', shop_url + redirect_url.replace(/\&amp\;/g, '&'));
    }
}

function deleteAdditionalImage(position)
{
    var injector = new Element('input', {
        type: 'hidden',
        name: 'imagesForDelete[]',
        value: position
    });
    injector.inject($('image_upload_form'));
    $('additionalImagePrevLink' + position).destroy();
}

// Begin products list functions
function showVariantsWindow(vid)
{
    content = $(vid).clone();

    new MochaUI.Window({
        id: 'viewVariantsWindow',
        title: variant,
        loadMethod: 'html',
        content: content,
        minimizable: false,
        maximizable: false,
        width: 490,
        height: 190
    });
}

// Show confirm message
function confirm_delete_product(id, category_id)
{
    alertBox.confirm('<h1>' + del + wf + jid + id + '? </h1>', {
        onComplete:
                function(returnvalue) {
                    if (returnvalue)
                    {
                        $('productRow' + id).setStyle('background-color', '#D95353');

                        var req = new Request.HTML({
                            method: 'post',
                            url: shop_url + 'products/delete',
                            evalResponse: true,
                            onComplete: function(response) {
                                $('productRow' + id).dispose();
                                if ($$('#ShopProductsHtmlTable tbody tr').length == 0)
                                {
                                    ajaxShop('products/index/' + category_id);
                                }
                            }
                        }).post({
                            'productId': id
                        });
                    }
                }
    });
}

// Check or uncheck all product in the list.
function ShopSwitchChecks(el)
{
    if (el.checked == true) {
        productsListcheck_all();
    } else {
        productsListuncheck_all();
    }

    productsListcheckForChecked();
}

// Show footer actions panel if some products selected.
function productsListcheckForChecked()
{
    var selected = 0;
    var items = $$('#ShopProductsHtmlTable input');
    items.each(function(el, i) {
        if (el.hasClass('chbx') && el.checked == true)
        {
            selected = selected + 1;
        }
    });

    if (selected > 0)
    {
        $('productsListFooter').setStyle('display', 'block');
    } else {
        $('productsListFooter').setStyle('display', 'none');
    }
}

// Check all products in the list
function productsListcheck_all()
{
    var items = $('ShopProductsHtmlTable').getElements('input');
    items.each(function(el, i) {
        if (el.hasClass('chbx'))
        {
            el.checked = true;
        }
    });
}

// Uncheck all products in the list
function productsListuncheck_all()
{
    var items = $('ShopProductsHtmlTable').getElements('input');
    items.each(function(el, i) {
        if (el.hasClass('chbx'))
        {
            el.checked = false;
        }
    });
}

// Change active status for one product in the list.
function shopChangeProductActive(el, productId)
{
    var currentActiveStatus = el.get('rel');

    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'products/ajaxChangeActive/' + productId,
        onRequest: function() {
            start_ajax();
        },
        onFailure: function() {
        },
        onSuccess: function() {
            if (currentActiveStatus == 'true')
            {
                el.set('src', admin_theme_url + 'images/tick_16_empty.png');
                el.set('rel', 'false');
                $('editProductLink' + productId).addClass('productNotActivated');
            } else {
                el.set('src', admin_theme_url + 'images/tick_16.png');
                el.set('rel', 'true');
                $('editProductLink' + productId).removeClass('productNotActivated');
            }

        },
        onComplete: function(response) {
            stop_ajax();
        }
    }).send();
}

function shopChangeGiftActive(el, productId)
{
    var currentActiveStatus = el.get('rel');

    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'gifts/ChangeActive/' + productId,
        onRequest: function() {
            start_ajax();
        },
        onFailure: function() {
        },
        onSuccess: function() {
            if (currentActiveStatus == 'true')
            {
                el.set('src', admin_theme_url + 'images/tick_16_empty.png');
                el.set('rel', 'false');
                // $('editProductLink' + productId).addClass('productNotActivated');
            } else {
                el.set('src', admin_theme_url + 'images/tick_16.png');
                el.set('rel', 'true');
                //$('editProductLink' + productId).removeClass('productNotActivated');
            }
        },
        onComplete: function(response) {
            stop_ajax();
        }
    }).send();
}

// Change hit status for one product in the list.
function shopChangeProductHit(el, productId)
{
    var currentHitStatus = el.get('rel');

    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'products/ajaxChangeHit/' + productId,
        onRequest: function() {
            start_ajax();
        },
        onFailure: function() {
        },
        onSuccess: function() {
            if (currentHitStatus == 'true')
            {
                el.set('src', admin_theme_url + 'images/star_16_empty.png');
                el.set('rel', 'false');
            } else {
                el.set('src', admin_theme_url + 'images/star_16.png');
                el.set('rel', 'true');
            }
        },
        onComplete: function(response) {
            stop_ajax();
        }
    }).send();
}

// Change hot status for one product in the list.
function shopChangeProductHot(el, productId)
{
    var currentHotStatus = el.get('rel');

    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'products/ajaxChangeHot/' + productId,
        onRequest: function() {
            start_ajax();
        },
        onFailure: function() {
        },
        onSuccess: function() {
            if (currentHotStatus == 'true')
            {
                el.set('src', admin_theme_url + 'images/hot_16_empty.png');
                el.set('rel', 'false');
            } else {
                el.set('src', admin_theme_url + 'images/hot_16.png');
                el.set('rel', 'true');
            }
        },
        onComplete: function(response) {
            stop_ajax();
        }
    }).send();
}

// Change action status for one product in the list.
function shopChangeProductAction(el, productId)
{
    var currentActionStatus = el.get('rel');

    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'products/ajaxChangeAction/' + productId,
        onRequest: function() {
            start_ajax();
        },
        onFailure: function() {
        },
        onSuccess: function() {
            if (currentActionStatus == 'true')
            {
                el.set('src', admin_theme_url + 'images/action_16_empty.png');
                el.set('rel', 'false');
            } else {
                el.set('src', admin_theme_url + 'images/action_16.png');
                el.set('rel', 'true');
            }
        },
        onComplete: function(response) {
            stop_ajax();
        }
    }).send();
}

// Get ids of selected products
function shopProductsList_GetSelectedIds()
{
    var items = $$('#ShopProductsHtmlTable input');
    var ids = new Array;
    items.each(function(el, i) {
        if (el.hasClass('chbx') && el.checked == true)
        {
            var pId = el.get('rel');
            ids[pId] = pId;
        }
    });

    return ids;
}

// Collect selected products and change activr status.
function shopProductsList_changeActive(redirectBackUrl)
{
    var ids = shopProductsList_GetSelectedIds();
    start_ajax();
    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'products/ajaxChangeActive',
        onComplete: function(response) {
            stop_ajax();
            shopProductList_redirectBackAndReselect(ids, redirectBackUrl)
        }
    }).post({
        'ids': ids
    });
}

// Collect selected products and change hit status.
function shopProductsList_changeHit(redirectBackUrl)
{
    var ids = shopProductsList_GetSelectedIds();
    start_ajax();
    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'products/ajaxChangeHit',
        onComplete: function(response) {
            stop_ajax();
            shopProductList_redirectBackAndReselect(ids, redirectBackUrl)
        }
    }).post({
        'ids': ids
    });
}

// Collect selected products and change hot status.
function shopProductsList_changeHot(redirectBackUrl)
{
    var ids = shopProductsList_GetSelectedIds();
    start_ajax();
    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'products/ajaxChangeHot',
        onComplete: function(response) {
            stop_ajax();
            shopProductList_redirectBackAndReselect(ids, redirectBackUrl)
        }
    }).post({
        'ids': ids
    });
}

// Collect selected products and change action status.
function shopProductsList_changeAction(redirectBackUrl)
{
    var ids = shopProductsList_GetSelectedIds();
    start_ajax();
    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'products/ajaxChangeAction',
        onComplete: function(response) {
            stop_ajax();
            shopProductList_redirectBackAndReselect(ids, redirectBackUrl)
        }
    }).post({
        'ids': ids
    });
}

function shopProductList_redirectBackAndReselect(ids, url)
{
    // Update block and select back checkboxes.
    var req2 = new Request.HTML({
        method: 'get',
        update: 'shopAdminPage',
        url: url,
        onComplete: function(response) {
            var items = $$('#ShopProductsHtmlTable input');
            items.each(function(el, i) {
                if (el.hasClass('chbx') && ids.contains(el.get('rel')))
                {
                    el.set('checked', true);
                }
            });

            productsListcheckForChecked();
        }
    }).send();
}

function shopProductsList_Delete(categoryId)
{
    alertBox.confirm('<h1>' + del + whislist + wf + '</h1>', {
        onComplete:
                function(returnvalue) {
                    if (returnvalue)
                    {
                        var ids = shopProductsList_GetSelectedIds();
                        start_ajax();
                        var req = new Request.HTML({
                            method: 'post',
                            url: shop_url + 'products/ajaxDeleteProducts',
                            onComplete: function(response) {
                                stop_ajax();
                                ajaxShop('products/index/' + categoryId);
                            }
                        }).post({
                            'ids': ids
                        });
                    }
                }
    });
}

function shopProductsList_Clone(categoryId)
{
    alertBox.confirm('<h1>' + copy_product + '</h1>', {
        onComplete:
                function(returnvalue) {
                    if (returnvalue)
                    {
                        var ids = shopProductsList_GetSelectedIds();
                        start_ajax();
                        var req = new Request.HTML({
                            method: 'post',
                            url: shop_url + 'products/ajaxCloneProducts',
                            onComplete: function(response) {
                                stop_ajax();
                                ajaxShop('products/index/' + categoryId);
                            }
                        }).post({
                            'ids': ids
                        });
                    }
                }
    });
}

function shopProductsList_showMoveWindow(categoryId)
{
    new MochaUI.Window({
        id: 'productsListMoveWindow',
        title: remove_product,
        type: 'modal',
        loadMethod: 'xhr',
        contentURL: shop_url + 'products/ajaxMoveWindow/' + categoryId,
        minimizable: 'false',
        maximizable: 'false',
        resizable: 'true',
        closable: 'false',
        draggable: 'true',
        width: '500'
    });
}
// End of product list function

/** Begin history functions **/
var ShopCurPos = 0;
var ShopHSteps = 0;
var ShopHistoryArr = new Array();
var ShopRefreshUrl = false;

function ShopHistory_refresh()
{
    if (ShopRefreshUrl != false)
    {
        start_ajax();
        var req = new Request.HTML({
            method: 'post',
            url: ShopRefreshUrl,
            update: 'shopAdminPage',
            evalResponse: true,
            onComplete: function(response) {
                stop_ajax();
            }
        }).send();
    }
}

// History for page div
function ShopHistory(div, url)
{
    if (div == 'shopAdminPage')
    {
        ShopRefreshUrl = url;
        ShopHSteps = ShopHSteps + 1;
        ShopHistoryArr[ShopHSteps] = url;
    }
}

//go back
function ShopHistory_back()
{
    if (ShopCurPos > ShopHSteps)
    {
        //do something
    } else {
        ShopCurPos = ShopCurPos + 1;
        start_ajax();
        upd = ShopHSteps - ShopCurPos;
        ShopRefreshUrl = ShopHistoryArr[upd];
        var req = new Request.HTML({
            method: 'post',
            url: ShopHistoryArr[upd],
            update: 'shopAdminPage',
            evalResponse: true,
            onComplete: function(response) {
                stop_ajax();
            }
        }).send();
    }
}

//go forward
function ShopHistory_forward()
{
    if (ShopCurPos != 0)
    {
        ShopCurPos = ShopCurPos - 1;
        upd = ShopHSteps - ShopCurPos;
        ShopRefreshUrl = ShopHistoryArr[upd];
        start_ajax();
        var req = new Request.HTML({
            method: 'post',
            url: ShopHistoryArr[upd],
            update: 'shopAdminPage',
            evalResponse: true,
            onComplete: function(response) {
                stop_ajax();
            }
        }).send();
    }
}

// Check or uncheck all elements in the list.
function multiShopSwitchChecks(el, table, footer)
{
    if (el.checked == true) {
        multiListcheck_all(table);
    } else {
        multiListuncheck_all(table);
    }

    multiListcheckForChecked(table, footer);
}

// Check all elements in the list
function multiListcheck_all(table)
{
    var items = $(table).getElements('input');
    items.each(function(el) {
        if (el.hasClass('chbx'))
        {
            el.checked = true;
        }
    });
}

// Uncheck all elements in the list
function multiListuncheck_all(table)
{
    var items = $(table).getElements('input');
    items.each(function(el) {
        if (el.hasClass('chbx'))
        {
            el.checked = false;
        }
    });
}

// Show footer actions panel if some element selected.
function multiListcheckForChecked(table, footer)
{
    var selected = 0;
    var items = $$('#' + table + ' input');
    items.each(function(el) {
        if (el.hasClass('chbx') && el.checked == true)
        {
            selected = selected + 1;
        }
    });

    if (selected > 0)
    {
        $(footer).setStyle('display', 'block');
    } else {
        $(footer).setStyle('display', 'none');
    }
}

function shopOrdersList_Delete(status, table)
{
    alertBox.confirm('<h1>' + langs.removeSelectedOrders  + '</h1>', {
        onComplete:
                function(returnvalue) {
                    if (returnvalue)
                    {
                        var ids = multiList_GetSelectedIds(table);
                        start_ajax();
                        var req = new Request.HTML({
                            method: 'post',
                            url: shop_url + 'orders/ajaxDeleteOrders',
                            onComplete: function(response) {
                                stop_ajax();
                                ajaxShop('orders/index/' + status);
                            }
                        }).post({
                            'ids': ids
                        });
                    }
                }
    });
}

function shopNotificationsList_Delete(status, table)
{
    alertBox.confirm('<h1>' + langs.removeSelectedNotifications  + '</h1>', {
        onComplete:
                function(returnvalue) {
                    if (returnvalue)
                    {
                        var ids = multiList_GetSelectedIds(table);
                        start_ajax();
                        var req = new Request.HTML({
                            method: 'post',
                            url: shop_url + 'notifications/ajaxDeleteNotifications',
                            onComplete: function(response) {
                                stop_ajax();
                                ajaxShop('notifications/index/' + status);
                            }
                        }).post({
                            'ids': ids
                        });
                    }
                }
    });
}

function shopOrdersList_Delete(status, table)
{
    alertBox.confirm('<h1>' + order_delete + '</h1>', {
        onComplete:
                function(returnvalue) {
                    if (returnvalue)
                    {
                        var ids = multiList_GetSelectedIds(table);
                        start_ajax();
                        var req = new Request.HTML({
                            method: 'post',
                            url: shop_url + 'orders/ajaxDeleteOrders',
                            onComplete: function(response) {
                                stop_ajax();
                                ajaxShop('orders/index/' + status);
                            }
                        }).post({
                            'ids': ids
                        });
                    }
                }
    });
}

// Get ids of selected items
function multiList_GetSelectedIds(table)
{
    var items = $$('#' + table + ' input');
    var ids = new Array;
    items.each(function(el, i) {
        if (el.hasClass('chbx') && el.checked == true)
        {
            var pId = el.get('rel');
            ids[pId] = pId;
        }
    });

    return ids;
}

function shopOrdersList_ChangeStatus(status, table, oldStatus)
{
    var statusText = change_status_order;

    alertBox.confirm('<h1>' + statusText + '</h1>', {
        onComplete:
                function(returnvalue) {
                    if (returnvalue)
                    {
                        var ids = multiList_GetSelectedIds(table);
                        start_ajax();
                        var req = new Request.HTML({
                            method: 'post',
                            url: shop_url + 'orders/ajaxChangeOrdersStatus/' + status,
                            onComplete: function(response) {
                                stop_ajax();
                                ajaxShop('orders/index/' + oldStatus);
                            }
                        }).post({
                            'ids': ids
                        });
                    } else
                        $('OrderStatus-select').set('value', oldStatus);
                }
    });
}

function shopNotificationsList_ChangeStatus(status, table, oldStatus)
{
    var statusText = status_notice;

    alertBox.confirm('<h1>' + statusText + '</h1>', {
        onComplete:
                function(returnvalue) {
                    if (returnvalue)
                    {
                        var ids = multiList_GetSelectedIds(table);
                        start_ajax();
                        var req = new Request.HTML({
                            method: 'post',
                            url: shop_url + 'notifications/ajaxChangeNotificationsStatus/' + status,
                            onComplete: function(response) {
                                stop_ajax();
                                ajaxShop('notifications/index/' + oldStatus);
                            }
                        }).post({
                            'ids': ids
                        });
                    } else
                        $('NotificationStatus-select').set('value', oldStatus);
                }
    });
}

// Collect selected products and change action status.
function shopOrdersList_ChangePaid(redirectBackUrl, table, footer)
{
    var ids = multiList_GetSelectedIds(table);
    start_ajax();
    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'orders/ajaxChangeOrdersPaid',
        onComplete: function(response) {
            stop_ajax();
            shopOrdersList_redirectBackAndReselect(ids, redirectBackUrl, table, footer)
        }
    }).post({
        'ids': ids
    });
}

function shopOrdersList_redirectBackAndReselect(ids, url, table, footer)
{
    // Update block and select back checkboxes.
    var req2 = new Request.HTML({
        method: 'get',
        update: 'shopAdminPage',
        url: url,
        onComplete: function(response) {
            var items = $$('#' + table + ' input');
            items.each(function(el) {
                if (el.hasClass('chbx') && ids.contains(el.get('rel')))
                {
                    el.set('checked', true);
                }
            });

            multiListcheckForChecked(table, footer);
        }
    }).send();
}

function shopNotificationsList_redirectBackAndReselect(ids, url, table, footer)
{
    // Update block and select back checkboxes.
    var req2 = new Request.HTML({
        method: 'get',
        update: 'shopAdminPage',
        url: url,
        onComplete: function(response) {
            var items = $$('#' + table + ' input');
            items.each(function(el) {
                if (el.hasClass('chbx') && ids.contains(el.get('rel')))
                {
                    el.set('checked', true);
                }
            });

            multiListcheckForChecked(table, footer);
        }
    }).send();
}

function ChangeStatusTo(id, statusId, oldStatusId)
{
    $('orderRow' + id).setStyle('border', '2px solid #B0D736');
    start_ajax();
    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'orders/changeStatus',
        evalResponse: true,
        onComplete: function(response) {
            $('orderRow' + id).dispose();
            stop_ajax();
            if ($$('.row').length == 0)
            {
                ajaxShop('orders/index?=' + oldStatusId);
            }
        }
    }).post({
        'OrderId': id,
        'StatusId': statusId
    });

}

function ChangeNotificationStatusTo(id, statusId, oldStatusId)
{
    $('notificationRow' + id).setStyle('border', '2px solid #B0D736');
    start_ajax();
    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'notifications/changeStatus',
        evalResponse: true,
        onComplete: function(response) {
            $('notificationRow' + id).dispose();
            stop_ajax();
            if ($$('.row').length == 0 && $$('.row_notified').length == 0)
            {
                ajaxShop('notifications/index?=' + oldStatusId);
            }
        }
    }).post({
        'NotificationId': id,
        'StatusId': statusId
    });

}

function ChangeCallbackStatusTo(id, statusId, oldStatusId)
{
    $('callbackRow' + id).setStyle('border', '2px solid #B0D736');
    start_ajax();
    var req = new Request.HTML({
        method: 'post',
        url: shop_url + 'callbacks/changeStatus',
        evalResponse: true,
        onComplete: function(response) {
            $('callbackRow' + id).dispose();
            stop_ajax();
            if ($$('.row').length == 0)
            {
                ajaxShop('callbacks/index?=' + oldStatusId);
            }
        }
    }).post({
        'CallbackId': id,
        'StatusId': statusId
    });

}

function shopOrdersStatusesList_ShowDeleteWindow(statusId)
{
    new MochaUI.Window({
        id: 'OrdersStatusesDeleteWindow',
        title: status_notice,
        type: 'modal',
        loadMethod: 'xhr',
        contentURL: shop_url + 'orderstatuses/ajaxDeleteWindow/' + statusId,
        minimizable: 'false',
        maximizable: 'false',
        resizable: 'true',
        closable: 'false',
        draggable: 'true',
        width: 500,
        height: 210
    });

}

function confirm_delete_order_from_user_edit(id)
{

    alertBox.confirm('<h1>' + langs.removeOrderId  + id + '? </h1>', {
        onComplete:
                function(returnvalue) {
                    if (returnvalue)
                    {
                        $$('#productRow' + id).setStyle('border', '2px solid #D95353');
                        start_ajax();
                        var req = new Request.HTML({
                            method: 'post',
                            url: shop_url + 'orders/delete',
                            evalResponse: true,
                            onComplete: function(response) {
                                $$('#productRow' + id).dispose();
                                stop_ajax();
                            }
                        }).post({
                            'orderId': id
                        });
                        ajax_div('shopEditUserOrders', '/admin/components/run/shop/users/edit/1/offset/true')
                    }
                }
    });
}
/** End history functions **/

function shopOrderCartEdit_showEditWindow(Id)
{
    new MochaUI.Window({
        id: 'productsListMoveWindow',
        title: langs.changeProduct ,
        type: 'modal',
        loadMethod: 'xhr',
        contentURL: shop_url + 'orders/ajaxEditWindow/' + Id,
        minimizable: 'false',
        maximizable: 'false',
        resizable: 'true',
        closable: 'false',
        draggable: 'true',
        width: 590,
        height: 290,
        onContentLoaded: function() {
            autocomleter = new Meio.Autocomplete.Select('product_name', shop_url + 'orders/ajaxGetProductList/', {
                syncName: false,
                cacheLength: 0,
                //valueField: $('product_variant_name'),
                valueFilter: function(data) {
                    return data.identifier;
                },
                filter: {
                    type: 'contains',
                    path: 'value'
                },
                onSelect: function(elements, value) {
                    document.getElementById('product_variant_name').options.length = 0;
                    for (var key in value.identifier.variants) {
                        var val = value.identifier.variants[key];
                        var NewOption = new Option(val.name + ' ' + val.price + ' ' + value.identifier.cs, key);
                        NewOption.inject($('product_variant_name'));
                    }
                    $('product_id').value = value.identifier.id;
                },
                requestOptions: {
                    formatResponse: function(jsonResponse) {
                        return jsonResponse;
                    },
                    noCache: true
                },
                urlOptions: {
                    extraParams: [{
                            'name': 'categoryId',
                            'value': function() {
                                return $('Categories').value;
                            }
                        }]
                },
                cacheLength: 0
            });
        },
        onClose: function() {
            autocomleter = null;
            $$('div.ma-container').destroy();

        }
    });
}


function shopOrderCartEditAddToCart_showEditWindow(orderId)
{
    new MochaUI.Window({
        id: 'productsListMoveWindow',
        title: add_product,
        type: 'modal',
        loadMethod: 'xhr',
        contentURL: shop_url + 'orders/ajaxEditAddToCartWindow/' + orderId,
        minimizable: 'false',
        maximizable: 'false',
        resizable: 'true',
        closable: 'false',
        draggable: 'true',
        width: 590,
        height: 290,
        onContentLoaded: function() {
            autocomleter = new Meio.Autocomplete.Select('product_name', shop_url + 'orders/ajaxGetProductList/', {
                syncName: false,
                cacheLength: 0,
                //valueField: $('product_variant_name'),
                valueFilter: function(data) {
                    return data.identifier;
                },
                filter: {
                    type: 'contains',
                    path: 'value'
                },
                onSelect: function(elements, value) {
                    document.getElementById('product_variant_name').options.length = 0;
                    for (var key in value.identifier.variants) {
                        var val = value.identifier.variants[key];
                        var NewOption = new Option(val.name + ' ' + val.price + ' ' + value.identifier.cs, key);
                        NewOption.inject($('product_variant_name'));
                    }
                    $('product_id').value = value.identifier.id;
                },
                requestOptions: {
                    formatResponse: function(jsonResponse) {
                        return jsonResponse;
                    },
                    noCache: true
                },
                urlOptions: {
                    extraParams: [{
                            'name': 'categoryId',
                            'value': function() {
                                return $('Categories').value;
                            }
                        }]
                },
                cacheLength: 0
            });
        },
        onClose: function() {
            autocomleter = null;
            $$('div.ma-container').destroy();

        }
    });
}

function confirm_delete_ordered_product(Id, orderId)
{
    alertBox.confirm('<h1>' + delete_product_order + '</h1>', {
        onComplete:
                function(returnvalue) {
                    if (returnvalue)
                    {
                        var req = new Request.HTML({
                            method: 'post',
                            url: shop_url + 'orders/ajaxDeleteProduct/' + Id,
                            evalResponse: true,
                            onComplete: function(response) {
                                ajax_div('shopUserCart', shop_url + 'orders/ajaxGetOrderCart/' + orderId)
                            }
                        }).post();
                    }
                }
    });
}
;

function initRelatedProductsAutocompleter()
{
    // Manage related products
    autocomleter = new Meio.Autocomplete.Select('RelatedProducts', shop_url + 'orders/ajaxGetProductList/', {
        syncName: false,
        cacheLength: 0,
        valueFilter: function(data) {
            return data.identifier;
        },
        filter: {
            type: 'contains',
            path: 'value'
        },
        onSelect: function(elements, value) {
            var pid = value.identifier.id;
            var html = '<a href="#" style="display:block;" onclick="$(this).dispose();return false;"><img align="left" src="/templates/administrator/images/delete.png" title="' + del + '"><input type="hidden" name="RelatedProducts[]" value="' + pid + '">' + value.value + '</a>';
            $('relatedProductsNames').adopt(new Element('div', {
                'html': html
            }));
            $('RelatedProducts').set('value', '');
        },
        requestOptions: {
            formatResponse: function(jsonResponse) {
                return jsonResponse;
            },
            noCache: true
        },
        cacheLength: 0
    });
}