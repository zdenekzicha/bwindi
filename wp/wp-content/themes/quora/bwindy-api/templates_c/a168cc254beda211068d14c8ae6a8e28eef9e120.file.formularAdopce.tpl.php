<?php /* Smarty version Smarty-3.1.14, created on 2013-10-27 14:57:07
         compiled from "/home/www/petrsiller.cz/www/bwindiweb.petrsiller.cz/wp-content/themes/quora/bwindy-api/templates/formularAdopce.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2147402516526ce36cc1c130-96577260%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a168cc254beda211068d14c8ae6a8e28eef9e120' => 
    array (
      0 => '/home/www/petrsiller.cz/www/bwindiweb.petrsiller.cz/wp-content/themes/quora/bwindy-api/templates/formularAdopce.tpl',
      1 => 1382885824,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2147402516526ce36cc1c130-96577260',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_526ce36cd5f591_46809381',
  'variables' => 
  array (
    'data' => 0,
    'dite' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_526ce36cd5f591_46809381')) {function content_526ce36cd5f591_46809381($_smarty_tpl) {?>
<?php  $_smarty_tpl->tpl_vars['dite'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dite']->_loop = false;
 $_smarty_tpl->tpl_vars['myId'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dite']->key => $_smarty_tpl->tpl_vars['dite']->value){
$_smarty_tpl->tpl_vars['dite']->_loop = true;
 $_smarty_tpl->tpl_vars['myId']->value = $_smarty_tpl->tpl_vars['dite']->key;
?>
	<div id="formAdoption" class="twoColumnsLayout group">
		<h1>Adoptovat <?php echo $_smarty_tpl->tpl_vars['dite']->value['jmeno'];?>
</h1>
		<div id="left">
			<div class="photo bubble">
				<?php if ($_smarty_tpl->tpl_vars['dite']->value['fotka']){?>
					<img src="<?php echo $_smarty_tpl->tpl_vars['dite']->value['fotka'];?>
" alt="" />
				<?php }else{ ?>
					<img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/portrait.jpg" alt="" />
				<?php }?>
			</div>
			<h3>Jak adoptovat?</h3>
			<p>Vyplňte prosím krátký formulář a na váš email vám pošleme číslo účtu a potřebné informace k provedení platby.</p>
			<p>Pokud se rozdhodnete pro adopci předem děkujeme.</p>
		</div>
		<div id="right">
			<form method="get" action="/">
				<fieldset>
					<p>
						<label for="sponsorName">Jméno a příjmení:</label>
						<input type="text" name="sponsor" id="sponsorName" class="text" /> <span class="require" title="nutné vyplnit">*</span>
						<span class="errorMsg">Vyplňte prosím vaše jméno a příjmení, aby jsme věděli ským jednáme.</span>
					</p>
					<p>
						<label for="sponsorEmail">E-mail:</label>
						<input type="text" name="email" id="sponsorEmail" class="text" /> <span class="require" title="nutné vyplnit">*</span>
						<span class="errorMsg">Vyplňte prosím váš email, aby jsem vám mohli poslat podrobnější informace.</span>
					</p>
					<p>
						<label for="sponsorPhone">Telefon:</label>
						<input type="text" name="phone" id="sponsorPhone" class="text" />
					</p>
					<p>
						<label for="sponsorNote">Poznámka:</label>
						<textarea name="note" id="sponsorNote"></textarea>
					</p>
					<p>
						<input type="hidden" name="page_id" value="122" />
						<input type="hidden" name="idDite" value="<?php echo $_smarty_tpl->tpl_vars['dite']->value['id'];?>
" />
						<input type="submit" value="Adoptovat" id="send" />
					</p>
				</fieldset>
			</form>
		</div>
	</div>

	<script type="text/javascript">
		/* jednouducha kontrola formulare pred odeslanim */
		var sponsorName = jQuery('form #sponsorName');
		var sponsorEmail = jQuery('form #sponsorEmail');

		jQuery("form").submit(function(e) {		
			if(sponsorName.attr('value') == '') {
				sponsorName.parent().addClass('error');
				e.preventDefault();			
			}
			else {
				sponsorName.parent().removeClass('error');	
			}

			if(sponsorEmail.attr('value') == '') {
				sponsorEmail.parent().addClass('error');
				e.preventDefault();	
			}
			else {
				sponsorEmail.parent().removeClass('error');	
			}
		});

	</script>
<?php } ?>
<?php }} ?>