<?php /* Smarty version Smarty-3.1.14, created on 2013-09-15 07:07:36
         compiled from "/home/www/petrsiller.cz/www/bwindiweb.petrsiller.cz/wp-content/themes/quora/bwindy-api/templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9696843952355cb8de01d1-91831878%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '94111be35d5ec112a08fba1f9fc413bb5f4e9178' => 
    array (
      0 => '/home/www/petrsiller.cz/www/bwindiweb.petrsiller.cz/wp-content/themes/quora/bwindy-api/templates/index.tpl',
      1 => 1379228723,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9696843952355cb8de01d1-91831878',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'values' => 0,
    'value' => 0,
    'key1' => 0,
    'value1' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52355cb8e34289_83678516',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52355cb8e34289_83678516')) {function content_52355cb8e34289_83678516($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['values'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['values']->_loop = false;
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