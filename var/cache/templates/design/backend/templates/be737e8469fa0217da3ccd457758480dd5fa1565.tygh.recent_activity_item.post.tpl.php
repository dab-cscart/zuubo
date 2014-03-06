<?php /* Smarty version Smarty-3.1.15, created on 2014-03-06 21:03:09
         compiled from "/var/www/html/zuubo/design/backend/templates/addons/news_and_emails/hooks/index/recent_activity_item.post.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14382123765318aa4d595c46-70606094%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'be737e8469fa0217da3ccd457758480dd5fa1565' => 
    array (
      0 => '/var/www/html/zuubo/design/backend/templates/addons/news_and_emails/hooks/index/recent_activity_item.post.tpl',
      1 => 1390826990,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '14382123765318aa4d595c46-70606094',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5318aa4d6281c7_78365034',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5318aa4d6281c7_78365034')) {function content_5318aa4d6281c7_78365034($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['item']->value['type']=="news") {?>
    <a href="<?php echo htmlspecialchars(fn_url("news.update?news_id=".((string)$_smarty_tpl->tpl_vars['item']->value['content']['id'])), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['content']['news'], ENT_QUOTES, 'UTF-8');?>
</a><br>                        
<?php }?><?php }} ?>
