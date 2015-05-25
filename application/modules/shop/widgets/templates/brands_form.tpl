<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Настройки виджета')} <b>{$widget.name}</b></span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a class="t-d_n m-r_15 pjax" href="{$BASE_URL}admin/widgets_manager/index"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Вернуться')}</span></a>
                <button data-submit="" data-form="#widget_form" class="btn btn-small btn-primary formSubmit" type="button"><i class="icon-ok"></i>{lang('Сохранить')}</button>
                <button data-action="tomain" data-form="#widget_form" class="btn btn-small formSubmit" type="button"><i class="icon-check"></i>{lang('Сохранить и выйти')}</button>
            </div>
        </div>                            
    </div>
    <form class="form-horizontal m-t_10" method="post" id="widget_form" action="{$BASE_URL}admin/widgets_manager/update_widget/{$widget.id}">
        <table class="table  table-bordered table-hover table-condensed content_big_td">
            <thead>
                <tr><th>{lang('Настройки')}</th>
                </tr></thead>
            <tbody>
                <tr>
                    <td>
                        <div class="inside_padd span9">

                            <div class="control-group">
                                <label for="comcount" class="control-label">{lang('Показать')}:</label>
                                <div class="controls">
                                    <label><input type="radio" {if $widget.settings.withImages} checked="checked" {/if}  name="withImages" value="1">{lang('Только c фото')}</label>
                                    <label><input type="radio" {if !$widget.settings.withImages} checked="checked" {/if}  name="withImages" value="0">{lang('Все, в том числе без фото')}</label>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="newscount" class="control-label">{lang('Количество брендов для отображения')}:</label>
                                <div class="controls">
                                    <input type="number"  value="{$widget.settings.brandsCount}" name="brandsCount" class="numeric" min="0"> 
                                </div>            
                            </div>

                            <div class="control-group">
                                <label for="newscount" class="control-label">{lang('Заголовок виджета')}:</label>
                                <div class="controls">
                                    <input type="text"  value="{$widget.settings.title}" name="title"> 
                                </div>            
                            </div>

                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        {form_csrf()}
    </form>
</section>