<?php //netteCache[01]000385a:2:{s:4:"time";s:21:"0.52520000 1361127405";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:96:"/Users/me/Work/php/Nette-framework/examples/bwindy/aplication/app/templates/platba/default.latte";i:2;i:1361127069;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"b7f6732 released on 2013-01-01";}}}?><?php

// source file: /Users/me/Work/php/Nette-framework/examples/bwindy/aplication/app/templates/platba/default.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'cekcoea16g')
;
// prolog NUIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lb46e58f6774_title')) { function _lb46e58f6774_title($_l, $_args) { extract($_args)
?> Platby<?php
}}

//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb103d3cdc76_content')) { function _lb103d3cdc76_content($_l, $_args) { extract($_args)
?>	<section id="page">
		<h1>Platby</h1>
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