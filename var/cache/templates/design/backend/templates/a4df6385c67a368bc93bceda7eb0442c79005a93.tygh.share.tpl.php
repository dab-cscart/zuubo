<?php /* Smarty version Smarty-3.1.15, created on 2014-03-06 21:03:09
         compiled from "/var/www/html/zuubo/design/backend/templates/common/share.tpl" */ ?>
<?php /*%%SmartyHeaderCode:145577835318aa4d6b66f2-74907684%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4df6385c67a368bc93bceda7eb0442c79005a93' => 
    array (
      0 => '/var/www/html/zuubo/design/backend/templates/common/share.tpl',
      1 => 1390826990,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '145577835318aa4d6b66f2-74907684',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mode' => 0,
    'url' => 0,
    'logos' => 0,
    'product_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5318aa4d779497_97242305',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5318aa4d779497_97242305')) {function content_5318aa4d779497_97242305($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['mode']->value=="notification") {?>
    <?php echo $_smarty_tpl->__("share.congratulations_first_order");?>

<?php }?>

<?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable(fn_url('',"C"), null, 0);?>

<ul class="inline social-share">
    <li><a href="#" class="uibutton large confirm" onclick=" window.open('https://www.facebook.com/sharer/sharer.php?s=100&p[url]=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url']->value, ENT_QUOTES, 'UTF-8');?>
&p[images][0]=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['logos']->value['theme']['image']['http_image_path'], ENT_QUOTES, 'UTF-8');?>
&p[title]=<?php if ($_smarty_tpl->tpl_vars['mode']->value=="notification") {?><?php echo $_smarty_tpl->__("share.first_order_tweet");?>
<?php } else { ?><?php echo $_smarty_tpl->__("share.installation_tweet",array('[product_name]'=>$_smarty_tpl->tpl_vars['product_name']->value));?>
<?php }?>', 'facebook-share-dialog', 'width=626,height=436'); return false;"> Share on Facebook</a></li>
    <li><a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-text="<?php if ($_smarty_tpl->tpl_vars['mode']->value=="notification") {?><?php echo $_smarty_tpl->__("share.first_order_tweet");?>
<?php } else { ?><?php echo $_smarty_tpl->__("share.installation_tweet",array('[product_name]'=>$_smarty_tpl->tpl_vars['product_name']->value));?>
<?php }?>" data-url="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url']->value, ENT_QUOTES, 'UTF-8');?>
" data-via="cscart" data-size="large">Tweet</a>
        
            <script type="text/javascript">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </li>
</ul>
<?php }} ?>
