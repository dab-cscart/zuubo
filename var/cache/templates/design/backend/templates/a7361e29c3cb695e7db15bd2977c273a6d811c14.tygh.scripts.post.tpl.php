<?php /* Smarty version Smarty-3.1.15, created on 2014-03-06 21:02:53
         compiled from "/var/www/html/zuubo/design/backend/templates/addons/vendor_data_premoderation/hooks/index/scripts.post.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18299716075318aa3ddb7d92-37130193%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a7361e29c3cb695e7db15bd2977c273a6d811c14' => 
    array (
      0 => '/var/www/html/zuubo/design/backend/templates/addons/vendor_data_premoderation/hooks/index/scripts.post.tpl',
      1 => 1390826990,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '18299716075318aa3ddb7d92-37130193',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'vendor_pre' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5318aa3ddd0c73_75988805',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5318aa3ddd0c73_75988805')) {function content_5318aa3ddd0c73_75988805($_smarty_tpl) {?><?php if (!is_callable('smarty_function_script')) include '/var/www/html/zuubo/app/functions/smarty_plugins/function.script.php';
?><?php
fn_preload_lang_vars(array('text_vendor_profile_changes_notice'));
?>
<script type="text/javascript">
//<![CDATA[
(function(_, $) {
	_.tr({
		text_vendor_profile_changes_notice: '<?php echo strtr($_smarty_tpl->__("text_vendor_profile_changes_notice"), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
	});
	_.vendor_pre = '<?php echo htmlspecialchars(strtr($_smarty_tpl->tpl_vars['vendor_pre']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" )), ENT_QUOTES, 'UTF-8');?>
';
}(Tygh, Tygh.$));
//]]>
</script>

<?php echo smarty_function_script(array('src'=>"js/addons/vendor_data_premoderation/func.js"),$_smarty_tpl);?>


<?php }} ?>
