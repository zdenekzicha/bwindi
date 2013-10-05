<?php /* Smarty version Smarty-3.1.14, created on 2013-09-15 14:01:39
         compiled from "/home/www/petrsiller.cz/www/bwindiweb.petrsiller.cz/wp-content/themes/quora/bwindy-api/templates/detiAdobce.tpl" */ ?>
<?php /*%%SmartyHeaderCode:159008314652358b61d7bb50-52024346%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5593b138fa15d34e075ec930ebb3430c7200498d' => 
    array (
      0 => '/home/www/petrsiller.cz/www/bwindiweb.petrsiller.cz/wp-content/themes/quora/bwindy-api/templates/detiAdobce.tpl',
      1 => 1379253696,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '159008314652358b61d7bb50-52024346',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52358b61e0c661_53252430',
  'variables' => 
  array (
    'data' => 0,
    'value' => 0,
    'i' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52358b61e0c661_53252430')) {function content_52358b61e0c661_53252430($_smarty_tpl) {?><h1>Děti k adobci</h1>
<div id="childrens" class="group">
	<p>
		„Adoptovat“ děti, znamená financovat jejich vzdělání a podílet se na celkovém zlepšení jejich životní situace. Na podpoře jednoho dítěte se může podílet kolektivy, rodiny nebo skupiny přátel.
	</p>

		<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['myId'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['myId']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
			<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_smarty_tpl->tpl_vars['myId'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['value']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
 $_smarty_tpl->tpl_vars['myId']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
  				<div class="children">
					<div class="bubble">
						<a href="?page_id=48&idDite=<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
&s=profil"><img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/portrait.jpg" alt="" />
					</div>
					<span><?php echo $_smarty_tpl->tpl_vars['i']->value['jmeno'];?>
</span></a>
				</div>
			<?php } ?>
		<?php } ?>

</div>
<?php }} ?>