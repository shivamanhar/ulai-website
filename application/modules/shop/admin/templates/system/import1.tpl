{literal}<style>.attrnameHolder{line-height: 15px;width: 130px;display: inline-block; white-space: nowrap; text-align: left;overflow: hidden;text-overflow:ellipsis;}</style>{/literal}
<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">Автоматизация</span>
        </div>
    </div>
    <div class="clearfix">
        <div class="btn-group myTab m-t_20 pull-left" data-toggle="buttons-radio">
            <a href="#importcsv" class="btn btn-small active">Импорт</a>
            <a href="#exportcsv" class="btn btn-small">Экспорт</a>
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
                            <div class="importProcess">
                                <!-- Start. Choose file and load to server on checked slot  -->
                                <div class="fortextblock inside_padd span9">
                                    <form action="{$ADMIN_URL}system/import" method="post" enctype="multipart/form-data">
                                        <div class="control-group form-horizontal">
                                            <label class="control-label"></label>
                                            <div class="controls">
                                                <span class="btn btn-small p_r pull-left">
                                                    <i class="icon-folder-open"></i>&nbsp;&nbsp;Выбрать файл на диске
                                                    <input type="file" id="importcsvfile" name="userfile[]" class="btn-small btn" />
                                                </span>
                                            </div>
                                            {form_csrf()}
                                        </div>
                                    </form>
                                </div>
                                <!-- End. Choose file and load to server on checked slot  -->

                                <!-- Start. Choose file and load to server on checked slot  -->
                                <form action="{$ADMIN_URL}system/import" method="post" enctype="multipart/form-data" id="makeImportForm">
                                    <div class="inside_padd span9 form-horizontal row-fluid">

                                        <!-- Start. First of tree slots markup -->
                                        <div class="control-group">
                                            <span class="control-label">
                                                <span data-title="&lt;b&gt;CSV/XLS/XLSX&lt;/b&gt;" class="popover_ref" data-original-title="">
                                                    <i class="icon-info-sign"></i>
                                                </span>
                                                <div class="d_n">Выберите файл в удобном для Вас формате</div>&nbsp;Файлы
                                            </span>
                                            <div class="controls">
                                                <label class="btn-mini btn">
                                                    <input checked="checked" type="radio" value="1" id="csv" name="csvfile" />
                                                    <span>CSV/XLS/XLSX File slot #1</span>
                                                </label>&nbsp;
                                                <span class="help-inline fileCreateTime" data-file="product_csv_1csv">{$filesInfo.product_csv_1csv}</span>
                                            </div>
                                        </div>
                                        <!-- End. First of tree slots markup -->

                                        <!-- Start. Second of tree slots markup -->
                                        <div class="control-group">
                                            <span class="control-label"></span>
                                            <div class="controls">
                                                <label class="btn-mini btn">
                                                    <input type="radio" value="2" id="csv" name="csvfile" />
                                                    <span>CSV/XLS/XLSX File slot #2</span>
                                                </label>&nbsp;
                                                <span class="help-inline fileCreateTime" data-file="product_csv_2csv">{$filesInfo.product_csv_2csv}</span>
                                            </div>
                                        </div>
                                        <!-- End. First of tree slots markup -->

                                        <!-- Start. third of tree slots markup -->
                                        <div class="control-group">
                                            <span class="control-label"></span>
                                            <div class="controls">
                                                <label class="btn-mini btn">
                                                    <input type="radio" value="3" id="csv" name="csvfile" />
                                                    <span>CSV/XLS/XLSX File slot #3</span>
                                                </label>&nbsp;
                                                <span class="help-inline fileCreateTime" data-file="product_csv_3csv">{$filesInfo.product_csv_3csv}</span>
                                            </div>
                                        </div>
                                        <!-- End. third of tree slots markup -->

                                        <!-- Start. Wrap for file attributes showing -->
                                        <div class="attrHandler">
                                            {include_tpl('import_attributes')}
                                        </div>
                                        <!-- End. Wrap for file attributes showing -->

                                        <!-- Start. Let's go Button ;) -->
                                        <span class="controls span10">
                                            <span data-title="&lt;b&gt;Backup&lt;/b&gt;" class="popover_ref" data-original-title="">
                                                <i class="icon-info-sign"></i>
                                            </span>
                                            <div class="d_n">Данные вашей базы будут сохранены в папку /application/backups</div>
                                            <label class="" style="display: inline;">
                                                <input class="btn btn-small action_on" type="checkbox" {if $withBackup}checked="checked"{/if} value="true" name="withBackup">
                                                <span>Сделать снимок базы данных перед началом</span>
                                            </label>
                                        </span>

                                        <span class="controls span10">
                                            <span data-title="&lt;b&gt;Ресайз&lt;/b&gt;" class="popover_ref" data-original-title="">
                                                <i class="icon-info-sign"></i>
                                            </span>
                                            <div class="d_n">
                                                Для импортированых фотографий будет произведен ресайз и созданы варианты <br>
                                                Может занять больше времени
                                            </div>
                                            <label class="" style="display: inline;">
                                                <input class="btn btn-small action_on" type="checkbox" value="true" name="withResize">
                                                <span>Запустить ресайз фотографий после завершения импорта</span>
                                            </label>
                                        </span>

                                        <span class="controls span10">
                                            <span data-title="&lt;b&gt;Проверка цен&lt;/b&gt;" class="popover_ref" data-original-title="">
                                                <i class="icon-info-sign"></i>
                                            </span>
                                            <div class="d_n">
                                                Будет произведен перещет цен товаров в соответствии к валюте по умолчанию
                                            </div>
                                            <label class="" style="display: inline;">
                                                <input class="btn btn-small action_on" type="checkbox" value="true" name="withCurUpdate">
                                                <span>Обновить цены после импорта</span>
                                            </label>
                                        </span>

                                        <!--<div class="control-group">
                                            <label class="control-label">Язык импорта:</label>
                                            <div class="controls">
                                                <select name="language">
                                        {foreach $languages as $language}
                                            <option value="$language->identif" {if $language->default == 1}selected="selected"{/if}>{echo $language->lang_name}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>-->

                                        <div class="control-group">
                                            <span class="controls span2">
                                                <input class="attributes" type="hidden" name="attributes" value="" />
                                                <input class="btn btn-small disable action_on" type="submit" value="Начать импорт">
                                            </span>
                                        </div>
                                        <!-- End. Let's go Button ;) -->
                                    </div>
                                    <input type="hidden" value=";" name="delimiter" />
                                    <input type="hidden" value="&#34;" name="enclosure"/>
                                    <input type="hidden" value="utf-8" name="encoding"/>
                                    <input type="hidden" value="ProductsImport" name="import_type"/>
                                    <input type="hidden" value="{echo $languages[0]->identif}" name="language"/>
                                    <input type="hidden" value="{echo $currencies[0]->id}" name="currency"/>
                                    {form_csrf()}
                                </form>
                                <!-- End. Choose file and load to server on checked slot  -->
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="tab-pane" id="exportcsv">{include_tpl('./export')}</div>
    </div>
</section>
