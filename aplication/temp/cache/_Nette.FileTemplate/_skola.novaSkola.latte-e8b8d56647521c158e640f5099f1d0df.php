<?php //netteCache[01]000365a:2:{s:4:"time";s:21:"0.61181300 1361916753";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:76:"/Users/me/Work/php/bwindy/git/aplication/app/templates/skola/novaSkola.latte";i:2;i:1361916668;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"b7f6732 released on 2013-01-01";}}}?><?php

// source file: /Users/me/Work/php/bwindy/git/aplication/app/templates/skola/novaSkola.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'l4oecgiscx')
;
// prolog NUIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lb09cf68fef2_title')) { function _lb09cf68fef2_title($_l, $_args) { extract($_args)
?> Vytvořit novou školu<?php
}}

//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb161ab737c6_content')) { function _lb161ab737c6_content($_l, $_args) { extract($_args)
?>	<section id="page">	
		<h1>Vytvořit novou školu</h1>
<?php NFormMacros::renderFormBegin($form = $_form = (is_object("novaSkolaForm") ? "novaSkolaForm" : $_control["novaSkolaForm"]), array()) ?>
	        <div class="skola-form">
<?php if (is_object($form)) $_ctrl = $form; else $_ctrl = $_control->getComponent($form); if ($_ctrl instanceof IRenderable) $_ctrl->validateControl(); $_ctrl->render('errors') ?>
	            <?php $_input = is_object("nazev") ? "nazev" : $_form["nazev"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array())->startTag() ?>
Název:</label> <?php $_input = (is_object("nazev") ? "nazev" : $_form["nazev"]); echo $_input->getControl()->addAttributes(array('size' => 30, 'autofocus' => true)) ?>

	            <?php $_input = is_object("predpona") ? "predpona" : $_form["predpona"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array())->startTag() ?>
Typ školy:</label> <?php $_input = (is_object("predpona") ? "predpona" : $_form["predpona"]); echo $_input->getControl()->addAttributes(array('size' => 30, 'autofocus' => true)) ?>

	            <?php $_input = is_object("castka") ? "castka" : $_form["castka"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array())->startTag() ?>
Školné:</label> <?php $_input = (is_object("castka") ? "castka" : $_form["castka"]); echo $_input->getControl()->addAttributes(array('size' => 30, 'autofocus' => true)) ?>

	            <?php $_input = is_object("maxRok") ? "maxRok" : $_form["maxRok"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array())->startTag() ?>
Počet ročníků:</label> <?php $_input = (is_object("maxRok") ? "maxRok" : $_form["maxRok"]); echo $_input->getControl()->addAttributes(array('size' => 30, 'autofocus' => true)) ?>

<?php $_input = (is_object("create") ? "create" : $_form["create"]); echo $_input->getControl()->addAttributes(array()) ?>
	        </div>
<?php NFormMacros::renderFormEnd($_form) ?>
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