<?php /* Smarty version Smarty-3.1.14, created on 2014-01-01 20:40:12
         compiled from "/home/www/petrsiller.cz/www/bwindiweb.petrsiller.cz/wp-content/themes/quora/bwindy-api/templates/adoptovaneDeti.tpl" */ ?>
<?php /*%%SmartyHeaderCode:53031325652360abe8a2a01-70303225%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06f97d55c5f6ec8faeca31bd26f5cf57752d79e3' => 
    array (
      0 => '/home/www/petrsiller.cz/www/bwindiweb.petrsiller.cz/wp-content/themes/quora/bwindy-api/templates/adoptovaneDeti.tpl',
      1 => 1388608341,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '53031325652360abe8a2a01-70303225',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52360abe97d313_22086052',
  'variables' => 
  array (
    'data' => 0,
    'value' => 0,
    'i' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52360abe97d313_22086052')) {function content_52360abe97d313_22086052($_smarty_tpl) {?><h1>Adoptované děti</h1>
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
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['kids']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
 $_smarty_tpl->tpl_vars['myId']->value = $_smarty_tpl->tpl_vars['i']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['kids']['index']++;
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
</span></a>
				</div>
			<?php } ?>

			<?php if (count($_smarty_tpl->tpl_vars['value']->value)>11){?>
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

</div>
<?php }} ?>