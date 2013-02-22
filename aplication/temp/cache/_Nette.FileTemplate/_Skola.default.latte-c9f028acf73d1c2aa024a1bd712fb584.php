<?php //netteCache[01]000352a:2:{s:4:"time";s:21:"0.66461900 1361569176";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:63:"C:\wamp\www\bwindi\aplication\app\templates\Skola\default.latte";i:2;i:1361568883;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"b7f6732 released on 2013-01-01";}}}?><?php

// source file: C:\wamp\www\bwindi\aplication\app\templates\Skola\default.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '7ft9v7ufo3')
;
// prolog NUIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lb3cc6ab6899_title')) { function _lb3cc6ab6899_title($_l, $_args) { extract($_args)
?> Školy<?php
}}

//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb442e118ff4_content')) { function _lb442e118ff4_content($_l, $_args) { extract($_args)
?>	<section id="page">
		<h1>Školy</h1>
		<table class="table table-striped">
			<tr>
				<th>Název školy</th>
				<th>Částka na rok</th>
				<th></th>
			</tr>
<?php $iterations = 0; foreach ($skoly as $skola): ?>
			<tr>
				<td><?php echo NTemplateHelpers::escapeHtml($skola->nazev, ENT_NOQUOTES) ?></td>
				<td><?php echo NTemplateHelpers::escapeHtml($skola->castka, ENT_NOQUOTES) ?></td>
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