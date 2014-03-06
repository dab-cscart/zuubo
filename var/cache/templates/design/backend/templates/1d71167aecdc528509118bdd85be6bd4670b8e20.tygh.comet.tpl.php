<?php /* Smarty version Smarty-3.1.15, created on 2014-03-06 21:02:55
         compiled from "/var/www/html/zuubo/design/backend/templates/common/comet.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14516464935318aa3f973958-54450236%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d71167aecdc528509118bdd85be6bd4670b8e20' => 
    array (
      0 => '/var/www/html/zuubo/design/backend/templates/common/comet.tpl',
      1 => 1390826990,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '14516464935318aa3f973958-54450236',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5318aa3f97caf4_42614499',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5318aa3f97caf4_42614499')) {function content_5318aa3f97caf4_42614499($_smarty_tpl) {?><?php
fn_preload_lang_vars(array('processing'));
?>
<a id="comet_container_controller" data-backdrop="static" data-keyboard="false" href="#comet_control" data-toggle="modal" class="hide"></a>

<div class="modal hide fade" id="comet_control" tabindex="-1" role="dialog" aria-labelledby="comet_title" aria-hidden="true">
    <div class="modal-header">
        <h3 id="comet_title"><?php echo $_smarty_tpl->__("processing");?>
</h3>
    </div>
    <div class="modal-body">
        <p></p>
        <div class="progress progress-striped active">
            
            <div class="bar" style="width: 0%;"></div>
        </div>
    </div>
</div><?php }} ?>
