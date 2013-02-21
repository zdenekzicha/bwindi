<?php //netteCache[01]000364a:2:{s:4:"time";s:21:"0.94144400 1361481506";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:75:"/Users/me/Work/php/bwindy/git/aplication/app/templates/platba/default.latte";i:2;i:1361476529;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"b7f6732 released on 2013-01-01";}}}?><?php

// source file: /Users/me/Work/php/bwindy/git/aplication/app/templates/platba/default.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '77aybi1cfg')
;
// prolog NUIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lb6bf5ba5bbd_title')) { function _lb6bf5ba5bbd_title($_l, $_args) { extract($_args)
?> Platby<?php
}}

//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbdcb281cef2_content')) { function _lbdcb281cef2_content($_l, $_args) { extract($_args)
?>	<section id="page">
		<h1>Platby</h1>
		<form class="form-search">
			<p>
				<select>
	  				<option>Vs</option>
	  				<option>Ss</option>
	  				<option>Číslo účtu</option>	 
	 				<option>Sponzor</option>
				</select>
	  			<input type="text" class="input-xlarge" />
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
		  	</div>
		</form>
		<table class="table table-striped">
			<tr>
				<th>id</th>
				<th>Datum</th>
				<th>Typ platby</th>
				<th>Rok</th>
				<th>Částka</th>			
				<th>VS</th>
				<th>SS</th>
				<th>Číslo účtu</th>
				<th>Sponzor</th>
				<th>Poznámka</th>
				<th></th>
			</tr>
<?php $iterations = 0; foreach ($platby as $platba): ?>
				<tr>
					<td><?php echo NTemplateHelpers::escapeHtml($platba->idPlatba, ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($platba->date, ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($platba->benefitNazev, ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($platba->rok, ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($platba->castka, ENT_NOQUOTES) ?> Kč</td>	
					<td><?php echo NTemplateHelpers::escapeHtml($platba->diteVsym, ENT_NOQUOTES) ?></td>		
					<td><?php echo NTemplateHelpers::escapeHtml($platba->sponzorVsym, ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($platba->ucet, ENT_NOQUOTES) ?></td>
					<td><a href="#"><?php echo NTemplateHelpers::escapeHtml($platba->sponzorJmeno, ENT_NOQUOTES) ?></a></td>
					<td><?php echo NTemplateHelpers::escapeHtml($platba->poznamka, ENT_NOQUOTES) ?></td>
					<td><a href="#" title="detail"><i class="icon-pencil"></i></a></td>
				</tr>
<?php $iterations++; endforeach ?>
		</table>
		<button type="submit" class="btn btn-success">Přidat platbu</button>
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