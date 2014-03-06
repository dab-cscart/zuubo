<?php /* Smarty version Smarty-3.1.15, created on 2014-03-06 21:02:54
         compiled from "/var/www/html/zuubo/design/backend/templates/common/loading_box.tpl" */ ?>
<?php /*%%SmartyHeaderCode:528714515318aa3e1a74c3-18739070%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e244123d498a4b268b432b9131f7068f66ab18db' => 
    array (
      0 => '/var/www/html/zuubo/design/backend/templates/common/loading_box.tpl',
      1 => 1390826990,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '528714515318aa3e1a74c3-18739070',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5318aa3e1e5e08_72248414',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5318aa3e1e5e08_72248414')) {function content_5318aa3e1e5e08_72248414($_smarty_tpl) {?><?php
fn_preload_lang_vars(array('loading'));
?>
<div id="ajax_overlay" class="ajax-overlay"></div>
<div id="ajax_loading_box" class="hidden ajax-loading-box">
    <strong><?php echo $_smarty_tpl->__("loading");?>
</strong>
</div>
<?php }} ?>
