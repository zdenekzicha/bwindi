<?php //netteCache[01]000366a:2:{s:4:"time";s:21:"0.36518600 1361482800";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:77:"/Users/me/Work/php/bwindy/git/aplication/app/templates/homepage/default.latte";i:2;i:1361482797;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"b7f6732 released on 2013-01-01";}}}?><?php

// source file: /Users/me/Work/php/bwindy/git/aplication/app/templates/homepage/default.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'ilofjok3gy')
;
// prolog NUIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lbac66624893_title')) { function _lbac66624893_title($_l, $_args) { extract($_args)
?> Bwindi - děti<?php
}}

//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb169fe1be20_content')) { function _lb169fe1be20_content($_l, $_args) { extract($_args)
?>	<section id="page">
		<h1>Děti</h1>
		<form action="" method="get" class="form-search">
			<p>
				<select name="filtrSelect">
	  				<option value="jmeno" <?php if ($filtrSelect == 'jmeno'): ?>selected="selected"<?php endif ?>>Jméno</option>
	  				<option value="vsym" <?php if ($filtrSelect == 'vsym'): ?>selected="selected"<?php endif ?>>Vs</option>	 
	 				<option value="jmenoSponzor" <?php if ($filtrSelect == 'jmenoSponzor'): ?>
selected="selected"<?php endif ?>>Sponzor</option>
				</select>
	  			<input type="text" name="filtrText" class="input-xlarge" value="<?php echo htmlSpecialChars($filtrText) ?>" />
	  			<button type="submit" class="btn">Vyhledat</button>
	  		</p>
	  		<div class="group">
		  		<div class="left">
		  			<select class="span2" name="filtrSkola">
		  				<option value="0">škola</option>
<?php $iterations = 0; foreach ($skoly as $skola): ?>
		  					<option value="<?php echo htmlSpecialChars($skola->idSkola) ?>" <?php if ($filtrSkola == $skola->idSkola): ?>
selected="selected"<?php endif ?> ><?php echo NTemplateHelpers::escapeHtml($skola->nazev, ENT_NOQUOTES) ?></option>
<?php $iterations++; endforeach ?>
					</select>
		  		</div>
		  		<!--
		  		<div class="left">
		  			<select class="span2">
		  				<option>status</option>
		  				<option>neadoptovaný</option>
		  				<option>má zájemce</option>
		  				<option>adopotavený</option>
		  				<option>vyřezený</option>
					</select>
		  		</div>
		  		-->
		  		<div class="left">
		  			<select class="span2" name="filtrPohlavi">
		  				<option value="">pohlaví</option>
		  				<option value="M" <?php if ($filtrPohlavi == 'M'): ?>selected="selected"<?php endif ?>>muž</option>
		  				<option value="F" <?php if ($filtrPohlavi == 'F'): ?>selected="selected"<?php endif ?>>žena</option>
					</select>
		  		</div>
		  		<div class="left">
		  			<input  type="checkbox" name="filtrWeb" value="1" <?php if ($filtrWeb): ?>
checked="checked"<?php endif ?> /> <label>vystavené</label>
		  		</div>
		  		<!--
		  		<div class="left">
		  			<input  type="checkbox" /> <label>školné zapalcané</label>
		  		</div>
		  		-->
		  	</div>
		</form>
		
<?php if (count($deti)): ?>
			<table class="table table-striped">
				<tr>
					<th>VS</th>
					<th>Jméno</th>
					<th>Pohlaví</th>				
					<th>Škola</th>
					<th>Na webu</th>
					<th>Sponzor</th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
<?php $iterations = 0; foreach ($deti as $dite): ?>
					<tr>
						<td><?php echo NTemplateHelpers::escapeHtml($dite->vsym, ENT_NOQUOTES) ?></td>
						<td><?php echo NTemplateHelpers::escapeHtml($dite->jmeno, ENT_NOQUOTES) ?></td>
<?php if ($dite->pohlavi == 'M'): ?>
							<td>muž</td>
<?php else: ?>
							<td>žena</td>
<?php endif ?>
						<td><?php echo NTemplateHelpers::escapeHtml($dite->skolaNazev, ENT_NOQUOTES) ?></td>
<?php if ($dite->vystavene): ?>
							<td>zobrazené</td>
<?php else: ?>
							<td></td>
<?php endif ;if ($dite->jmenoSponzor): ?>
							<td><a a href="<?php echo htmlSpecialChars($_control->link("Sponzor:default", array('filtrSelect' => 'jmeno', 'filtrText' => $dite->jmenoSponzor))) ?>
"><?php echo NTemplateHelpers::escapeHtml($dite->jmenoSponzor, ENT_NOQUOTES) ?></a></td>
<?php else: ?>
							<td></td>
<?php endif ?>
						<td><a href="#">školné</a></td>
						<td><a href="#">platby</a></td>
						<td><a href="#">benefit</a></td>
						<td><a href="#" title="detail"><i class="icon-pencil"></i></a></td>					
					</tr>
<?php $iterations++; endforeach ?>
			</table>
<?php else: ?>
			<div id="noResults"><strong>Bohužel, nic jsme nenašli</strong></div>
<?php endif ?>

		<button type="submit" class="btn btn-success">Přidat dítě</button>
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