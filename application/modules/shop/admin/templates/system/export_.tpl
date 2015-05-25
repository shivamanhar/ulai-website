<!-- Import form -->
<div class="saPageHeader">
    <h2>{lang('Products export','admin')}</h2>
</div>

<div id="errorsBox" style="padding:5px;margin-left:160px;color:#ff3300;">
</div>

<form method="post" action="{$ADMIN_URL}system/export"  style="width:100%" id="file_upload_form">
    <div style="float:left;width:500px;">
        <div class="form_text">{lang('Columns','admin')}:</div>
        <div class="form_input">
            <input type="text" name="attributes" id="attributesBox" value="cat, num, name, prc, desc" class="textbox_long" />
        </div>
        <div class="form_overflow"></div>

        <div class="form_text">{lang('Field separator','admin')}:</div>
        <div class="form_input">
            <input type="text" class="textbox_long" style="width:24px;" value=";" name="delimiter" id="delimiterText"/>
            <select onchange="$('delimiterText').set('value', this.value)">
                <option value=";">{lang('Semicolon','admin')} (;)</option>
                <option value=":">{lang('Colon','admin')} (:)</option>
                <option value=",">{lang('Comma','admin')} (,)</option>
                <option value="	">{lang('Tab','admin')} (\t)</option>
                <option value="#">{lang('Sharp','admin')} (#)</option>
            </select>
        </div>
        <div class="form_overflow"></div>

        <div class="form_text">{lang('Text separator','admin')}:</div>
        <div class="form_input">
            <input type="text" class="textbox_long" style="width:24px;" value="&#34;" name="enclosure" id="enclosureText"/>
            <select onchange="$('enclosureText').set('value', this.value)">
                <option value="&#34;">{lang('Quotes','admin')} (")</option>
                <option value="'">{lang('Single quotes','admin')} (')</option>
            </select>
        </div>
        <div class="form_overflow"></div>

        <div class="form_text">{lang('Language','admin')}:</div>
        <div class="form_input">
            <select name="language">
                {foreach $languages as $lang}
                    <option value="{echo $lang->identif}">{echo $lang->lang_name}</option>
                {/foreach}
            </select>
        </div>
        <div class="form_overflow"></div>

        <div class="form_text">{lang('Encoding','admin')}:</div>
        <div class="form_input">
            <select name="encoding">
                <option value="utf-8">UTF-8</option>
                <option value="cp1251">Windows 1251</option>
            </select>
        </div>
        <div class="form_overflow"></div>

        <div class="form_text"></div>
        <div class="form_input">
            <input type="submit" value="{lang('Export','admin')}" class="button_130"/>
        </div>
        <div class="form_overflow"></div>
    </div>

    <div style="float:left;">
        <div class="form_text"></div>
        <div class="form_input">
            <table cellpadding="1" cellspacing="3" style="font-size:11px" class="attributesTable">
                <tr><td><b>{lang('Columns','admin')}</b></td><td style="width:250px;"> </td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>name</td><td>   {lang('Products name','admin')}</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>url</td><td>    URL</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>prc</td><td>    {lang('Price','admin')}</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>oldprc</td><td>   {lang('Old price','admin')}</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>stk </td><td>   {lang('Quantity','admin')}</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>num </td><td>   {lang('Mark','admin')}</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>var </td><td>   {lang('Variant name','admin')}</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>act </td><td>   {lang('active','admin')}</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>hit </td><td>   {lang('Hit','admin')}</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>brd </td><td>   {lang('Brand','admin')}</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>cat  </td><td>  {lang('Category','admin')}</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>relp </td><td>  {lang('Related products','admin')}</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>mimg </td><td>  {lang('The main image','admin')}</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>modim </td><td>  {lang('Main picture an additional','admin')}</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>simg </td><td>  {lang('Small image','admin')}</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>modis </td><td>  {lang('Small image an additional','admin')}</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>imgs </td><td>  {lang('Additional images','admin')}</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>shdesc </td><td>{lang('Short description','admin')}</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>desc </td><td>  {lang('Full description','admin')}</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>mett </td><td>  {lang('Meta Title','admin')}</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>metd </td><td>  {lang('Meta Description','admin')}</td></tr>
                <tr class="odd" onclick="addProductColumn(this)"><td>metk </td><td>  {lang('Meta Keywords','admin')}</td></tr>
                <tr class="even" onclick="addProductColumn(this)"><td>skip </td><td>  {lang('Skip column','admin')}</td></tr>
                {if sizeof($customFields) > 0}
                    <tr><td> </td><td></td></tr>
                    <tr><td><b>{lang('Products properties','admin')}</b></td><td> </td></tr>
                    {foreach $customFields as $f}
                        <tr {counter('class="even"','class="odd"')}  onclick="addProductColumn(this)"><td>{echo $f->getCsvName()}</td><td> </td></tr>
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
                window.addEvent('domready', function() {
                    document.getElementById('file_upload_form').onsubmit = function()
                    {
                        document.getElementById('file_upload_form').target = 'upload_target';
                        document.getElementById("upload_target").onload = fileUploadCallback;
                    }
                });

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
                        showMessage('', lang('Export complete', 'admin'));
                    }
                }
    </script>
{/literal}
