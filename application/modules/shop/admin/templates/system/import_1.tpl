<!-- Edit product form -->
<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">Автоматизация</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$ADMIN_URL}search/index" class="t-d_n m-r_15"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
            </div>
        </div>
    </div>
    <div class="clearfix">
        <div class="btn-group myTab m-t_20 pull-left" data-toggle="buttons-radio">
            <a href="#importcsv" class="btn btn-small active">Импорт СSV</a>
            <a href="#exportcsv" class="btn btn-small">Експорт СSV</a>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane active" id="importcsv">
            <table class="table  table-bordered table-hover table-condensed content_big_td">
                <thead>
                    <tr>
                        <th colspan="6">Импорт</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6">
                            <div class="fortextblock inside_padd span9 ">
                                <div class="control-group form-horizontal">
                                    <form action="{$ADMIN_URL}system/import" method="post" enctype="multipart/form-data"  id="csvfile_upload_form">
                                        <label for="importcsvfile" class="control-label">Файл формата CSV</label>
                                        <div class="controls">
                                            <div>
                                                <span class="btn btn-small p_r pull-right">
                                                    <i class="icon-folder-open"></i>&nbsp;&nbsp;Загрузить
                                                    <input type="file" id="importcsvfile" name="userfile[]" class="btn-small btn" />
                                                </span>
                                                <div class="o_h">
                                                    <input type="text" name="importcsvfile" value="" />
                                                </div>
                                            </div>
                                        </div>
                                        {form_csrf()}
                                    </form>
                                </div>
                            </div>

                            <form  action="{$ADMIN_URL}system/import" method="post" enctype="multipart/form-data"  id="makeImportForm">
                                <div class="inside_padd span9">
                                    <div class="form-horizontal">
                                        <div class="row-fluid">
                                            <div class="control-group" id="fileselect">
                                                <span class="control-label">
                                                    <span data-title="&lt;b&gt;CSV&lt;/b&gt;" class="popover_ref" data-original-title=""><i class="icon-info-sign"></i></span>
                                                    <div class="d_n">Экспорт CSV дает<br> на скачку файл <br>со списком всех <br>пользователей.</div>
                                                    Файлы</span>
                                                <div class="controls">
                                                    <label class="btn-mini btn">
                                                        <input checked type="radio" value="1" id="csv" name="csvfile" />
                                                        <span>product_csv_1.csv</span>
                                                    </label>
                                                    <span class="help-inline">31.10.12 17:20</span>
                                                </div>
                                            </div>
                                            <div class="control-group" id="fileselect">
                                                <span class="control-label"></span>
                                                <div class="controls">                                                        
                                                    <label class="btn-mini btn">
                                                        <input type="radio" value="2" id="csv" name="csvfile" />
                                                        <span>product_csv_2.csv</span>
                                                    </label>
                                                    <span class="help-inline">31.10.12 14:20</span><br/>
                                                </div>                                                                                
                                            </div>
                                            <div class="control-group" id="fileselect">
                                                <span class="control-label"></span>
                                                <div class="controls">                                                        
                                                    <label class="btn-mini btn">
                                                        <input type="radio" value="2" id="csv" name="csvfile" />
                                                        <span>product_csv_2.csv</span>
                                                    </label>
                                                    <span class="help-inline">31.10.12 14:20</span><br/>
                                                </div>                                                                                
                                            </div>
                                            <div>
                                            </div>
                                            <div class="control-group">
                                                <div class="control-label"></div>
                                                <label class="controls">
                                                    <input class="btn btn-small action_on" type="submit" value="Начать импорт"></button>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
            </form>
        </div>
        <div class="tab-pane" id="exportcsv">
            2
        </div>
    </div>
</section>

{/*}
<!-- Import form -->
<div class="saPageHeader">
    <h2>Импорт товаров</h2>
</div>

<div id="errorsBox" style="padding:5px;margin-left:160px;color:#ff3300;">
</div>

<form method="post" action="{$ADMIN_URL}system/import"  enctype="multipart/form-data" style="width:100%" id="file_upload_form">
    <div style="float:left;width:500px;">
        <div class="form_text">Файл:</div>
        <div class="form_input">
            <input type="file" name="userfile" />
        </div>
        <div class="form_overflow"></div>

        <div class="form_text">Колонки:</div>
        <div class="form_input">
            <input type="text" name="attributes" id="attributesBox" value="cat, num, name, prc" class="textbox_long" style="width:310px;"/>
        </div>
        <div class="form_overflow"></div>

        <div class="form_text">Разделитель полей:</div>
        <div class="form_input">
            <input type="text" class="textbox_long" style="width:24px;" value=";" name="delimiter" id="delimiterText"/>
            <select onchange="$('delimiterText').set('value', this.value)">
                <option value=";">Точка с запятой;</option>
                <option value=":">Двоеточие (:)</option>
                <option value=",">Запятая (,)</option>
                <option value="	">Табуляция (\t)</option>
                <option value="#">Решетка (#)</option>
            </select>
        </div>
        <div class="form_overflow"></div>

        <div class="form_text">Разделитель текста:</div>
        <div class="form_input">
            <input type="text" class="textbox_long" style="width:24px;" value="&#34;" name="enclosure" id="enclosureText"/>
            <select onchange="$('enclosureText').set('value', this.value)">
                <option value="&#34;">Кавычки (")</option>
                <option value="'">Одинарные кавычки (')</option>
            </select>
        </div>
        <div class="form_overflow"></div>

        <div class="form_text">Кодировка:</div>
        <div class="form_input">
            <select name="encoding">
                <option value="utf-8">UTF-8</option>
                <option value="cp1251">Windows 1251</option>
            </select>
        </div>
        <div class="form_overflow"></div>

        <div class="form_text">Язык:</div>
        <div class="form_input">
            <select name="language">
                {foreach $languages as $lang}
                    <option value="{echo $lang->identif}">{echo $lang->lang_name}</option>
                {/foreach}
            </select>
        </div>
        <div class="form_overflow"></div>

        <div class="form_text"></div>
        <div class="form_input">
            <input type="submit" value="Импорт" class="button_130"/>
        </div>
        <div class="form_overflow"></div>
    </div>

    <div style="float:left;">
        <div class="form_text"></div>
        <div class="form_input">
            <table cellpadding="1" cellspacing="3" style="font-size:11px" class="attributesTable">
                <tr class="noHover"><td><b>Колонки</b></td><td style="width:250px;"></td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>name</td><td>   Имя товара</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>url</td><td>    URL</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>prc</td><td>    Цена</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>oldprc</td><td>   Старая Цена</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>stk </td><td>   Количество</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>num </td><td>   Артикул</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>var </td><td>   Имя варианта</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>act </td><td>   Активен</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>hit </td><td>   Хит</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>brd </td><td>   Бренд</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>cat  </td><td>  Категория</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>relp </td><td>  Связанные товары</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>mimg </td><td>  Основное изображение</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>modim </td><td>  Основное изображение дополнительное</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>simg </td><td>  Маленькое изображение</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>modis </td><td>  Маленькое изображение дополнительное</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>imgs </td><td>  Дополнительные изображения</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>shdesc </td><td>Краткое описание</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>desc </td><td>  Полное описание</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>mett </td><td>  Meta Title</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>metd </td><td>  Meta Description</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>metk </td><td>  Meta Keywords</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>skip </td><td>  Пропустить колонку</td></tr>
                {if sizeof($customFields) > 0}
                    <tr><td> </td><td></td></tr>
                    <tr><td><b>Свойства товаров</b></td><td> </td></tr>
                    {foreach $customFields as $f}
                        <tr {counter('class="even"','class="odd"')}  onclick="addProductColumn(this)"><td>{echo $f->getCsvName()}</td><td>{echo $f->getName()}</td></tr>
                            {/foreach}
                        {/if}
            </table>
        </div>
        <div class="form_overflow"></div>
    </div>

    {form_csrf()}
    <iframe id="upload_target" name="upload_target" src="" style="width:0;height:0;border:0px;display:none;"></iframe>
</form>

{literal}
    <script type="text/javascript">

        function addProductColumn(el)
        {
            searchTd = el.getElements('td');
            if ($('attributesBox').get('value') == '')
            {
                var delimiter = '';
            } else {
                var delimiter = ',';
            }

            $('attributesBox').set('value', $('attributesBox').get('value') + delimiter + searchTd[0].get('text'));
        }

        window.addEvent('domready', function() {
            document.getElementById('file_upload_form').onsubmit = function()
            {
                document.getElementById('file_upload_form').target = 'upload_target';
                document.getElementById("upload_target").onload = fileUploadCallback;
            }
        });

        // Upload file callback
        function fileUploadCallback()
        {
            var iFrame = document.getElementById('upload_target');
            var data = iFrame.contentWindow.document.body.innerHTML;

            if (data != '')
            {
                $('errorsBox').set('html', data);
            } else {
                $('errorsBox').set('html', '');
                showMessage('', 'Импорт завершен');
            }
        }
    </script>
{/literal}

{*/}