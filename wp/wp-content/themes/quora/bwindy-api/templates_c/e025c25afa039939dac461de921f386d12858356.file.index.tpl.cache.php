<?php /* Smarty version Smarty-3.1.14, created on 2013-07-14 17:43:39
         compiled from "/Applications/MAMP/htdocs/wp/wordpress/wp-content/themes/twentytwelve/bwindy-api/templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:183103762151e2d3378f9407-61491407%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e025c25afa039939dac461de921f386d12858356' => 
    array (
      0 => '/Applications/MAMP/htdocs/wp/wordpress/wp-content/themes/twentytwelve/bwindy-api/templates/index.tpl',
      1 => 1373823816,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '183103762151e2d3378f9407-61491407',
  'function' => 
  array (
  ),
  'cache_lifetime' => 120,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51e2d337929193_89969955',
  'variables' => 
  array (
    'data' => 0,
    'values' => 0,
    'value' => 0,
    'key1' => 0,
    'value1' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e2d337929193_89969955')) {function content_51e2d337929193_89969955($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['values'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['values']->_loop = false;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['values']->key => $_smarty_tpl->tpl_vars['values']->value){
$_smarty_tpl->tpl_vars['values']->_loop = true;
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['values']->key;
?>
	
		<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['values']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
			<ul>
			<?php  $_smarty_tpl->tpl_vars['value1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value1']->_loop = false;
 $_smarty_tpl->tpl_vars['key1'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['value']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value1']->key => $_smarty_tpl->tpl_vars['value1']->value){
$_smarty_tpl->tpl_vars['value1']->_loop = true;
 $_smarty_tpl->tpl_vars['key1']->value = $_smarty_tpl->tpl_vars['value1']->key;
?>
				<li><?php echo $_smarty_tpl->tpl_vars['key1']->value;?>
 / <?php echo $_smarty_tpl->tpl_vars['value1']->value;?>
</li>
			<?php } ?>
			</ul>
		<?php } ?>
<?php } ?><?php }} ?>