<?php //netteCache[01]000365a:2:{s:4:"time";s:21:"0.72901000 1361482410";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:76:"/Users/me/Work/php/bwindy/git/aplication/app/templates/sponzor/default.latte";i:2;i:1361482407;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"b7f6732 released on 2013-01-01";}}}?><?php

// source file: /Users/me/Work/php/bwindy/git/aplication/app/templates/sponzor/default.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'pkasre5rrm')
;
// prolog NUIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lb02b507d885_title')) { function _lb02b507d885_title($_l, $_args) { extract($_args)
?> Sponzoři<?php
}}

//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb121ca15489_content')) { function _lb121ca15489_content($_l, $_args) { extract($_args)
?>	<section id="page">
		<h1>Sponzoři</h1>
		<form class="form-search">
			<p>
				<select name="filtrSelect">
	  				<option value="ssym" <?php if ($filtrSelect == 'ssym'): ?>selected="selected"<?php endif ?>>Ss</option> 
	 				<option value="jmeno" <?php if ($filtrSelect == 'jmeno'): ?>selected="selected"<?php endif ?>>Sponzor</option>
	 				<option value="mail" <?php if ($filtrSelect == 'mail'): ?>selected="selected"<?php endif ?>>Email</option>
				</select>
	  			<input type="text" name="filtrText" value="<?php echo htmlSpecialChars($filtrText) ?>" class="input-xlarge" />
	  			<button type="submit" class="btn">Vyhledat</button>
	  		</p>
	  		<div class="group">
		  		<div class="left">
		  			<select class="span2">
		  				<option>Typ platby</option>
		  				<option>Školné</option>
		  				<option>Koza</option>
		  				<option>Matrace</option>
		  				<option>Solární lampa</option>
					</select>
		  		</div>
		  		<div class="left">
		  			<select class="span2">
		  				<option>Rok</option>
		  				<option>2013</option>
		  				<option>2012</option>
		  				<option>2011</option>
					</select>
		  		</div>
		  		<div class="left">
		  			<input type="checkbox" /> má dítě
		  		</div>
		  	</div>
		</form>
		<table class="table table-striped">
			<tr>
				<th>Id</th>
				<th>SS</th>
				<th>Jméno</th>
				<th>Ulice a č.p.:</th>
				<th>PSČ</th>
				<th>Město</th>			
				<th>Email</th>
				<th>Telefon</th>
				<th>Sponzoruje</th>
				<th>Poznámka</th>
				<th>Platby</th>
				<th></th>
			</tr>
<?php $iterations = 0; foreach ($sponzori as $sponzor): ?>
				<tr>
					<td><?php echo NTemplateHelpers::escapeHtml($sponzor->idSponzor, ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($sponzor->ssym, ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($sponzor->jmeno, ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($sponzor->ulice, ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($sponzor->psc, ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($sponzor->mesto, ENT_NOQUOTES) ?></td>	
					<td><?php echo NTemplateHelpers::escapeHtml($sponzor->mail, ENT_NOQUOTES) ?></td>		
					<td><?php echo NTemplateHelpers::escapeHtml($sponzor->telefon, ENT_NOQUOTES) ?></td>
					<td><a href="<?php echo htmlSpecialChars($_control->link("Homepage:default", array('filtrSelect' => 'jmeno', 'filtrText' => $sponzor->diteJmeno))) ?>
"><?php echo NTemplateHelpers::escapeHtml($sponzor->diteJmeno, ENT_NOQUOTES) ?></a></td>
					<td></td>
					<td><a href="platby.html">platby</a></td>
					<td><a href="#" title="detail"><i class="icon-pencil"></i></a></td>
				</tr>
<?php $iterations++; endforeach ?>
		</table>
		<button type="submit" class="btn btn-success">Přidat školu</button>
	</section>
<?php
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extended) && isset($_control) && $_control instanceof NPresenter ? $_control->findLayoutTemplateFile() : NULL; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($_l->extends) { ob_end_clean(); return NCoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars()) ?>
 

<?php call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 