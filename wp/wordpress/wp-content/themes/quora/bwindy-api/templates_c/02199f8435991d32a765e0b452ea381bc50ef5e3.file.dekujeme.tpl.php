<?php /* Smarty version Smarty-3.1.14, created on 2013-10-28 08:30:01
         compiled from "/home/www/petrsiller.cz/www/bwindiweb.petrsiller.cz/wp-content/themes/quora/bwindy-api/templates/dekujeme.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1891094918526d16e56d6a53-74491424%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '02199f8435991d32a765e0b452ea381bc50ef5e3' => 
    array (
      0 => '/home/www/petrsiller.cz/www/bwindiweb.petrsiller.cz/wp-content/themes/quora/bwindy-api/templates/dekujeme.tpl',
      1 => 1382948948,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1891094918526d16e56d6a53-74491424',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_526d16e571c489_52093636',
  'variables' => 
  array (
    'data' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_526d16e571c489_52093636')) {function content_526d16e571c489_52093636($_smarty_tpl) {?>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['myId'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['myId']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
	<div id="thanksForAdoption">
		<div class="photo bubble">
			<?php if ($_smarty_tpl->tpl_vars['item']->value['fotka']){?>
				<img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['fotka'];?>
" alt="" />
			<?php }else{ ?>
				<img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/portrait.jpg" alt="" />
			<?php }?>
		</div>
		<h1>Děkujeme</h1>
		<p>Moc vám děkujeme za snahu pomoci dětěm z Bwindi orphans. Během následujících dnů vás kontaktujeme přes email <span><?php echo $_smarty_tpl->tpl_vars['item']->value['email'];?>
</span> a zdělíme vám všechny informace potřebné k adopci.</p>
		<i>Tým bwindi orphans a <?php echo $_smarty_tpl->tpl_vars['item']->value['jmeno'];?>
</i>
	</div>
<?php } ?>
<?php }} ?>