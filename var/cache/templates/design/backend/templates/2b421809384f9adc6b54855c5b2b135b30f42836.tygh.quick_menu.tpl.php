<?php /* Smarty version Smarty-3.1.15, created on 2014-03-06 21:02:55
         compiled from "/var/www/html/zuubo/design/backend/templates/common/quick_menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9281756955318aa3f75a468-55351711%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2b421809384f9adc6b54855c5b2b135b30f42836' => 
    array (
      0 => '/var/www/html/zuubo/design/backend/templates/common/quick_menu.tpl',
      1 => 1390826990,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '9281756955318aa3f75a468-55351711',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'edit_quick_menu' => 0,
    'expand_quick_menu' => 0,
    'settings' => 0,
    'quick_menu' => 0,
    'sect_id' => 0,
    'sect' => 0,
    'subsect' => 0,
    'show_quick_popup' => 0,
    'languages' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5318aa3f8eaee3_50599616',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5318aa3f8eaee3_50599616')) {function content_5318aa3f8eaee3_50599616($_smarty_tpl) {?><?php
fn_preload_lang_vars(array('editing_quick_menu_section','new_section','editing_quick_menu_link','new_link','quick_menu','remove_this_item','remove_this_item','add_link','show_menu_on_mouse_over','add_section','done','edit','name','link','position','use_current_link'));
?>
<?php if (fn_check_view_permissions("tools.show_quick_menu")) {?>

<script type="text/javascript">
    //<![CDATA[
    Tygh.tr('editing_quick_menu_section', '<?php echo strtr($_smarty_tpl->__("editing_quick_menu_section"), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
');
    Tygh.tr('new_section', '<?php echo strtr($_smarty_tpl->__("new_section"), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
');
    Tygh.tr('editing_quick_menu_link', '<?php echo strtr($_smarty_tpl->__("editing_quick_menu_link"), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
');
    Tygh.tr('new_link', '<?php echo strtr($_smarty_tpl->__("new_link"), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
');
    //]]>
</script>

<div class="quick-menu-container" id="quick_menu">
    <div class="quick-menu">
        <a id="sw_quick_menu_content"
           class="<?php if ($_smarty_tpl->tpl_vars['edit_quick_menu']->value||$_smarty_tpl->tpl_vars['expand_quick_menu']->value) {?>open<?php }?> cm-combination"<?php if ($_smarty_tpl->tpl_vars['settings']->value['show_menu_mouseover']=="Y") {?> onmouseover="fn_quick_menu_mouse_action(this, true);" onmouseout="fn_quick_menu_mouse_action(this, false);"<?php }?>><?php echo $_smarty_tpl->__("quick_menu");?>
</a>
    </div>

    <div id="quick_menu_content"
         class="quick-menu-content cm-popup-box<?php if (!$_smarty_tpl->tpl_vars['edit_quick_menu']->value&&!$_smarty_tpl->tpl_vars['expand_quick_menu']->value) {?> hidden<?php }?>">
        <?php if ($_smarty_tpl->tpl_vars['edit_quick_menu']->value) {?>
            <div class="menu-container">
                <table width="100%">
                    <?php  $_smarty_tpl->tpl_vars['sect'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sect']->_loop = false;
 $_smarty_tpl->tpl_vars['sect_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['quick_menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sect']->key => $_smarty_tpl->tpl_vars['sect']->value) {
$_smarty_tpl->tpl_vars['sect']->_loop = true;
 $_smarty_tpl->tpl_vars['sect_id']->value = $_smarty_tpl->tpl_vars['sect']->key;
?>
                        <tr data-ca-qm-item="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['sect_id']->value, ENT_QUOTES, 'UTF-8');?>
" data-ca-qm-parent-id="0"
                            data-ca-qm-position="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['sect']->value['section']['position'], ENT_QUOTES, 'UTF-8');?>
">
                            <td class="nowrap section-header">
                                <strong class="cm-qm-name"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['sect']->value['section']['name'], ENT_QUOTES, 'UTF-8');?>
</strong>
                            </td>
                            <td class="hidden-tools nowrap right">
                                <i title="<?php echo $_smarty_tpl->__("remove_this_item");?>
"
                                   class="icon-trash hand valign cm-delete-section"></i>
                                <i class="icon-edit hand cm-update-item"></i>
                            </td>
                        </tr>
                        <?php  $_smarty_tpl->tpl_vars['subsect'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['subsect']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sect']->value['subsection']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['subsect']->key => $_smarty_tpl->tpl_vars['subsect']->value) {
$_smarty_tpl->tpl_vars['subsect']->_loop = true;
?>
                            <tr data-ca-qm-item="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subsect']->value['menu_id'], ENT_QUOTES, 'UTF-8');?>
" data-ca-qm-parent-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subsect']->value['parent_id'], ENT_QUOTES, 'UTF-8');?>
"
                                data-ca-qm-position="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subsect']->value['position'], ENT_QUOTES, 'UTF-8');?>
">
                                <td class="nowrap">
                                    <a class="cm-qm-name" href="<?php echo htmlspecialchars(fn_url($_smarty_tpl->tpl_vars['subsect']->value['url']), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subsect']->value['name'], ENT_QUOTES, 'UTF-8');?>
</a>
                                </td>
                                <td class="hidden-tools nowrap right">
                                    <i title="<?php echo $_smarty_tpl->__("remove_this_item");?>
"
                                       class="icon-trash hand valign cm-delete-section"></i>
                                    <i class="icon-edit hand cm-update-item"></i>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr data-ca-qm-item="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['sect_id']->value, ENT_QUOTES, 'UTF-8');?>
" data-ca-qm-parent-id="0"
                            data-ca-qm-position="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['sect']->value['section']['position'], ENT_QUOTES, 'UTF-8');?>
">
                            <td colspan="2" class="cm-add-link"><a class="edit cm-add-link"><?php echo $_smarty_tpl->__("add_link");?>
</a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <table width="100%" class="quick-menu-edit">
                <tr colspan="2">
                    <td>
                        <label class="checkbox" for="show_menu_mouseover">
                            <input class="cm-qm-show-hide" id="show_menu_mouseover" type="checkbox"
                                   name="show_menu_mouseover" value="Y"
                                   <?php if ($_smarty_tpl->tpl_vars['settings']->value['show_menu_mouseover']=="Y") {?>checked="checked"<?php }?>/><?php echo $_smarty_tpl->__("show_menu_on_mouse_over");?>

                            </label>
                    </td>
                </tr>
                <tr>
                    <td class="nowrap top">
                        <a class="edit cm-add-section"><?php echo $_smarty_tpl->__("add_section");?>
</a>
                        <a class="pull-right edit cm-ajax" data-ca-target-id="quick_menu"
                           href="<?php echo htmlspecialchars(fn_url("tools.show_quick_menu"), ENT_QUOTES, 'UTF-8');?>
"
                           data-ca-event="ce.quick_menu_content_switch_callback"><?php echo $_smarty_tpl->__("done");?>
</a>
                    </td>
                </tr>
            </table>
        <?php } else { ?>
            <?php if ($_smarty_tpl->tpl_vars['quick_menu']->value) {?>
                <div class="menu-container">
                    <ul class="unstyled">
                        <?php  $_smarty_tpl->tpl_vars['sect'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sect']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['quick_menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sect']->key => $_smarty_tpl->tpl_vars['sect']->value) {
$_smarty_tpl->tpl_vars['sect']->_loop = true;
?>
                            <li><span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['sect']->value['section']['name'], ENT_QUOTES, 'UTF-8');?>
</span></li>
                            <?php  $_smarty_tpl->tpl_vars['subsect'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['subsect']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sect']->value['subsection']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['subsect']->key => $_smarty_tpl->tpl_vars['subsect']->value) {
$_smarty_tpl->tpl_vars['subsect']->_loop = true;
?>
                                <li><a href="<?php echo htmlspecialchars(fn_url($_smarty_tpl->tpl_vars['subsect']->value['url']), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subsect']->value['name'], ENT_QUOTES, 'UTF-8');?>
</a></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            <?php }?>
            <div class="quick-menu-actions right">
                <a class="edit cm-ajax" href="<?php echo htmlspecialchars(fn_url("tools.show_quick_menu.edit"), ENT_QUOTES, 'UTF-8');?>
" data-ca-target-id="quick_menu"
                   data-ca-event="ce.quick_menu_content_switch_callback"><?php echo $_smarty_tpl->__("edit");?>
</a>
            </div>
        <?php }?>
    </div>

    <?php if ($_smarty_tpl->tpl_vars['show_quick_popup']->value) {?>
        <div id="quick_box" class="hidden quick-menu-popup">

            <div id="quick_menu_language_selector">
                <?php if (!fn_allowed_for("ULTIMATE:FREE")) {?>
                    <?php echo $_smarty_tpl->getSubTemplate ("common/select_object.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('style'=>"graphic",'link_tpl'=>fn_link_attach("tools.get_quick_menu_variant","descr_sl="),'items'=>$_smarty_tpl->tpl_vars['languages']->value,'selected_id'=>@constant('DESCR_SL'),'key_name'=>"name",'suffix'=>"quick_menu",'display_icons'=>true,'select_container_id'=>"quick_menu_language_selector"), 0);?>

                <?php }?>
            </div>

            <form class="cm-ajax form-horizontal form-edit" name="quick_menu_form" action="<?php echo htmlspecialchars(fn_url(''), ENT_QUOTES, 'UTF-8');?>
" method="post">
                <input id="qm_item_id" type="hidden" name="item[id]" value=""/>
                <input id="qm_item_parent" type="hidden" name="item[parent_id]" value="0"/>
                <input id="qm_descr_sl" type="hidden" name="descr_sl" value=""/>
                <input type="hidden" name="result_ids" value="quick_menu"/>

                <div class="control-group">
                    <label class="cm-required control-label" for="qm_item_name"><?php echo $_smarty_tpl->__("name");?>
:</label>

                    <div class="controls">
                        <input id="qm_item_name" name="item[name]" type="text" value="" size="40"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="cm-required control-label" for="qm_item_link"><?php echo $_smarty_tpl->__("link");?>
:</label>

                    <div class="controls">
                        <input id="qm_item_link" name="item[url]" class="input-text-large" type="text" value=""
                               size="40"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="qm_item_position"><?php echo $_smarty_tpl->__("position");?>
:</label>

                    <div class="controls">
                        <input id="qm_item_position" name="item[position]" type="text" value="" size="6"/>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <a id="qm_current_link"><?php echo $_smarty_tpl->__("use_current_link");?>
</a>
                    </div>
                </div>

                <div class="buttons-container">
                    <?php echo $_smarty_tpl->getSubTemplate ("buttons/save_cancel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('but_name'=>"dispatch[tools.update_quick_menu_item.edit]",'cancel_action'=>"close"), 0);?>

                </div>

            </form>
        </div>
    <?php }?>
    <!--quick_menu--></div>
<?php }?><?php }} ?>
