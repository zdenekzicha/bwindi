<?php //netteCache[01]000383a:2:{s:4:"time";s:21:"0.66434800 1360955728";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:94:"/Users/me/Work/php/Nette-framework/examples/bwindy/aplication/app/templates/Kids/default.latte";i:2;i:1359925653;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"b7f6732 released on 2013-01-01";}}}?><?php

// source file: /Users/me/Work/php/Nette-framework/examples/bwindy/aplication/app/templates/Kids/default.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'ny6ht14hdp')
;
// prolog NUIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lbc598df85fe_title')) { function _lbc598df85fe_title($_l, $_args) { extract($_args)
?> Bwindi - děti<?php
}}

//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbca6b17d365_content')) { function _lbca6b17d365_content($_l, $_args) { extract($_args)
?>	<section id="page">
		<header>
			<a href="index.html">Děti</a> |
			<a href="platby.html">Platby</a> | 
			<a href="sponzori.html">Sponzoři</a> |
			<a href="skoly.html">Školy</a> |
			<a href="benefity.html">Benefity</a>
		</header>
		<h1>Děti</h1>
		<form class="form-search">
			<p>
				<select>
	  				<option>Jméno</option>
	  				<option>Vs</option>	 
	 				<option>Sponzor</option>
				</select>
	  			<input type="text" class="input-xlarge" />
	  			<button type="submit" class="btn">Vyhledat</button>
	  		</p>
	  		<div class="group">
		  		<div class="left">
		  			<select class="span2">
		  				<option>Škola</option>
		  				<option>Trinity college</option>
		  				<option>Kabale - seminář</option>
					</select>
		  		</div>
		  		<div class="left">
		  			<select class="span2">
		  				<option>Status</option>
		  				<option>neadoptovaný</option>
		  				<option>má zájemce</option>
		  				<option>adopotavený</option>
		  				<option>vyřezený</option>
					</select>
		  		</div>
		  		<div class="left">
		  			<select class="span2">
		  				<option>Pohlaví</option>
		  				<option>muž</option>
		  				<option>žena</option>
					</select>
		  		</div>
		  		<div class="left">
		  			<input  type="checkbox" /> <label>vystavené</label>
		  		</div>
		  		<div class="left">
		  			<input  type="checkbox" /> <label>školné zapalcané</label>
		  		</div>
		  	</div>
		</form>
		
		<table class="table table-striped">
			<tr>
				<th>VS</th>
				<th>Jméno</th>
				<th>Pohlaví</th>				
				<th>Škola</th>
				<th>Školné 2013</th>
				<th>Status</th>
				<th>Na webu</th>
				<th>Fotka</th>
				<th>Sponzor</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
<?php $iterations = 0; foreach ($kids as $kid): ?>
				<tr>
					<td><?php echo NTemplateHelpers::escapeHtml($kid->vs, ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($kid->name, ENT_NOQUOTES) ?></td>				
					<td><?php echo NTemplateHelpers::escapeHtml($kid->sex ? 'muž' : 'žena', ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($kid->school, ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($kid->paymentsPaied, ENT_NOQUOTES) ?>
/ <?php echo NTemplateHelpers::escapeHtml($kid->paymentsAll, ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($kid->status ? 'adoptované' : 'neadoptované', ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($kid->web ? 'vystavené' : 'nevystavené', ENT_NOQUOTES) ?></td>
					<td><?php echo NTemplateHelpers::escapeHtml($kid->foto ? 'foto OK' : 'Nemá foto', ENT_NOQUOTES) ?></td>
					<td><a href="sponzori.html"><?php echo NTemplateHelpers::escapeHtml($kid->sponzor, ENT_NOQUOTES) ?></a></td>
					<td><a href="skolne.html">školné</a></td>
					<td><a href="platby.html">platby</a></td>
					<td><a href="benefit.html">benefit</a></td>
					<td><a href="dite-detail.html" title="detail"><i class="icon-pencil"></i></a></td>
				</tr>
<?php $iterations++; endforeach ?>
		</table>
		<button type="submit" class="btn btn-success">Přidat dítě</button>
		<div id="notes">
			<p>vše co se týče školy se vztahuje k aktualnimu roku</p>
			<p>má smysl evidovat jestli má fotku?</p>
			<p>má smysl evidovat jestli je vystavený?</p>
		</div>
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