<?php /* Smarty version Smarty-3.1.14, created on 2014-01-11 15:37:17
         compiled from "/home/www/petrsiller.cz/www/bwindiweb.petrsiller.cz/wp-content/themes/quora/bwindy-api/templates/diteProfil.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14216871055235b792141278-83308971%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b7f6aa04dd086bd56faf4c87df7f5d518695ae5c' => 
    array (
      0 => '/home/www/petrsiller.cz/www/bwindiweb.petrsiller.cz/wp-content/themes/quora/bwindy-api/templates/diteProfil.tpl',
      1 => 1389454633,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14216871055235b792141278-83308971',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5235b7921bf8c9_05589097',
  'variables' => 
  array (
    'data' => 0,
    'dite' => 0,
    'timeline' => 0,
    'item' => 0,
    'item1' => 0,
    'item2' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5235b7921bf8c9_05589097')) {function content_5235b7921bf8c9_05589097($_smarty_tpl) {?>
<?php  $_smarty_tpl->tpl_vars['dite'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dite']->_loop = false;
 $_smarty_tpl->tpl_vars['myId'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dite']->key => $_smarty_tpl->tpl_vars['dite']->value){
$_smarty_tpl->tpl_vars['dite']->_loop = true;
 $_smarty_tpl->tpl_vars['myId']->value = $_smarty_tpl->tpl_vars['dite']->key;
?>
	<div id="profile" class="twoColumnsLayout group">
		<div id="left">
	<div class="photo bubble">
		<?php if ($_smarty_tpl->tpl_vars['dite']->value['fotka']){?>
			<img src="<?php echo $_smarty_tpl->tpl_vars['dite']->value['fotka'];?>
" alt="" />
		<?php }else{ ?>
			<img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/portrait.jpg" alt="" />
		<?php }?>
	</div>
	<?php if ($_smarty_tpl->tpl_vars['dite']->value['sponzor']){?>
		<div id="helpMe" class="disable">Už mám sponzora</div>
	<?php }else{ ?>
		<a href="/?page_id=119&idDite=<?php echo $_smarty_tpl->tpl_vars['dite']->value['id'];?>
" id="helpMe">Pomůžeš mi?</a>
	<?php }?>
	<!--
		<h4>Co potřebuji</h4>
		<table>
		<tr><th>Školné</th><td>8 500 Kč</td></tr>
		<tr><th>Boty</th><td>300 Kč</td></tr>
		<tr><th>Koza</th><td>1 200 Kč</td></tr>
		<tr><th>Lucerna</th><td>200 Kč</td></tr>
		</table>

		<h4>Co už mám</h4>
		<table>
		<tr><th>Matrace</th><td></td></tr>
		</table>
	-->
	</div>
		<div id="right">
			<h1><?php echo $_smarty_tpl->tpl_vars['dite']->value['jmeno'];?>
</h1>
			<p class="perex">Chodím do <?php echo $_smarty_tpl->tpl_vars['dite']->value['skola'];?>
, <?php if ($_smarty_tpl->tpl_vars['dite']->value['rocnik']!=''){?><?php echo $_smarty_tpl->tpl_vars['dite']->value['rocnik'];?>
 ročník<?php }?> <?php if ($_smarty_tpl->tpl_vars['dite']->value['vek']!=0){?> je mi <?php echo $_smarty_tpl->tpl_vars['dite']->value['vek'];?>
 let<?php }?></p>
			<p><?php echo $_smarty_tpl->tpl_vars['dite']->value['bio'];?>
</p>

			<div id="timeline">
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['timeline']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<?php  $_smarty_tpl->tpl_vars['item1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item1']->_loop = false;
 $_smarty_tpl->tpl_vars['key1'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['item1']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['item1']->key => $_smarty_tpl->tpl_vars['item1']->value){
$_smarty_tpl->tpl_vars['item1']->_loop = true;
 $_smarty_tpl->tpl_vars['key1']->value = $_smarty_tpl->tpl_vars['item1']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['item1']['index']++;
?>
		   				<div <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['item1']['index']!=0){?>class="noShow"<?php }?>>
			   				<?php  $_smarty_tpl->tpl_vars['item2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item2']->_loop = false;
 $_smarty_tpl->tpl_vars['key2'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item1']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['item2']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['item2']->key => $_smarty_tpl->tpl_vars['item2']->value){
$_smarty_tpl->tpl_vars['item2']->_loop = true;
 $_smarty_tpl->tpl_vars['key2']->value = $_smarty_tpl->tpl_vars['item2']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['item2']['index']++;
?>		   				
				   				<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['item2']['index']==0){?>
									<div class="start"><?php echo $_smarty_tpl->tpl_vars['item2']->value['rok'];?>
</div>
				   				<?php }?>
								<div class="note">
									<?php if ($_smarty_tpl->tpl_vars['item2']->value['foto']!=''){?><img src="<?php echo $_smarty_tpl->tpl_vars['item2']->value['foto'];?>
"><?php }?> 
									<?php if ($_smarty_tpl->tpl_vars['item2']->value['text']!=''){?><p><?php echo $_smarty_tpl->tpl_vars['item2']->value['text'];?>
</p><?php }?>
								</div>
							<?php } ?>
						</div>
					<?php } ?>

					<a href="#" class="showMore">Předchozí rok</a>
					<script>					
						jQuery( document ).ready(function() {
							jQuery("#timeline .showMore").click(function(e) {
								e.preventDefault();
								
							    var part = jQuery("#timeline .noShow");

								for(var i = 0; i < part.length; i++) {
									part.eq(i).removeClass('noShow');
									window.scrollBy(0,50);
									break;
								}

								if(jQuery("#timeline .noShow").length == 0) {
									jQuery(this).remove();
								}
							});
						});				
					</script>

				<?php } ?>		
			</div>
		</div>
	</div>
<?php } ?>
<?php }} ?>