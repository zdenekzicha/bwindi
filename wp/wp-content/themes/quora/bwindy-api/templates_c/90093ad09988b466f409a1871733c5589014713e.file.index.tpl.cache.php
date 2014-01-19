<?php /* Smarty version Smarty-3.1.14, created on 2013-07-14 18:02:05
         compiled from "templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:182877032051e2cb7d85c4f0-18907541%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90093ad09988b466f409a1871733c5589014713e' => 
    array (
      0 => 'templates/index.tpl',
      1 => 1373798002,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '182877032051e2cb7d85c4f0-18907541',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'key' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51e2cb7d894e43_91915510',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e2cb7d894e43_91915510')) {function content_51e2cb7d894e43_91915510($_smarty_tpl) {?><ul>
	<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
		<li><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 / <?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</li>
	<?php } ?>
</ul><?php }} ?>