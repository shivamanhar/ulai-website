<div id="images_modal" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>{lang('Searching for images on the Internet', 'admin')}</h3>
        <br/>
        <div>
            <input data-original-title="{lang('URL or request for search', 'admin')}" class="span5 m-b_0" type="text" id="url_image" maxlength="255" placeholder="{lang('Enter the URL of the image or the search criterion', 'admin')}">
            <button id="search_images" class="btn btn-small"><i class="icon-search"></i></button>
        </div>
    </div>
    <div id="image_search_result" class="modal-body">

    </div>
    <div class="modal-footer images_modal_footer">
        <label id="as_additional_container" class="pull-left" data-original-title="{lang('Hold down Shift to select multiple images', 'admin')}" for="as_additional">
            <input type="checkbox" name="as_additional" id="as_additional" />
            {lang('Save as additional', 'admin')}
        </label>
        <a href="#" class="btn" data-dismiss="modal">{lang('Cancel', 'admin')}</a>
        <a href="#" id="save_image" class="btn btn-primary">{lang('Save', 'admin')}</a>
    </div>
</div>
