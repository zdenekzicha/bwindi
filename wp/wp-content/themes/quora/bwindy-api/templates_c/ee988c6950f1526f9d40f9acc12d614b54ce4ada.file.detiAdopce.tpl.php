<?php /* Smarty version Smarty-3.1.14, created on 2014-01-06 16:20:29
         compiled from "/home/www/petrsiller.cz/www/bwindiweb.petrsiller.cz/wp-content/themes/quora/bwindy-api/templates/detiAdopce.tpl" */ ?>
<?php /*%%SmartyHeaderCode:30329803152360d6e90d9b3-08439554%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee988c6950f1526f9d40f9acc12d614b54ce4ada' => 
    array (
      0 => '/home/www/petrsiller.cz/www/bwindiweb.petrsiller.cz/wp-content/themes/quora/bwindy-api/templates/detiAdopce.tpl',
      1 => 1380622753,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30329803152360d6e90d9b3-08439554',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52360d6e98fd59_09288614',
  'variables' => 
  array (
    'data' => 0,
    'value' => 0,
    'i' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52360d6e98fd59_09288614')) {function content_52360d6e98fd59_09288614($_smarty_tpl) {?><h1>Děti k adobci</h1>
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
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["kids"]['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
 $_smarty_tpl->tpl_vars['myId']->value = $_smarty_tpl->tpl_vars['i']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["kids"]['index']++;
?> 
  				<div class="children <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['kids']['index']>11){?>noShow<?php }?>">
					<div class="bubble">
						<a href="?page_id=48&idDite=<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
&s=profil">
							<?php if ($_smarty_tpl->tpl_vars['i']->value['fotka']){?>
								<img src="<?php echo $_smarty_tpl->tpl_vars['i']->value['fotka'];?>
" alt="" />
							<?php }else{ ?>
								<img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/portrait.jpg" alt="" />
							<?php }?>
						</a>
					</div>
					<span><?php echo $_smarty_tpl->tpl_vars['i']->value['jmeno'];?>
</span>
				</div>


			<?php } ?>

			<?php if (count($_smarty_tpl->tpl_vars['value']->value)>10){?>
				<a href="#" class="showMoreChildren">Další děti</a>
				<script>					
					jQuery( document ).ready(function() {
						jQuery("#childrens .showMoreChildren").click(function(e) {
							e.preventDefault();
							
						    var childrens = jQuery("#childrens .noShow");
							console.log(childrens);

							for(var i = 0; i < childrens.length; i++) {
								childrens.eq(i).removeClass('noShow');
								if(i == 11) {
									break;
								}
							}

							if(jQuery("#childrens .noShow").length == 0) {
								jQuery(this).remove();
							}
						});
					});				
				</script>
			<?php }?> 

			<?php if (empty($_smarty_tpl->tpl_vars['value']->value)){?>
				<h3>Momentálně mají všechny děti svého sponzora</h3>
			<?php }?>
		<?php } ?>
		

		<?php if (count($_smarty_tpl->tpl_vars['data']->value)>10){?>
			
		<?php }?>



</div>
<?php }} ?>