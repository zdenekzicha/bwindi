
{foreach from=$data key=myId item=dite}
	<div id="formAdoption" class="twoColumnsLayout group">
		<h1>Adoptovat {$dite.jmeno}</h1>
		<div id="left">
			<div class="photo bubble">
				{if $dite.fotka}
					<img src="{$dite.fotka}" alt="" />
				{else}
					<img src="http://bwindiorphans.org/wp-content/themes/quora/images/portrait.jpg" alt="" />
				{/if}
			</div>
			<h3>Jak adoptovat?</h3>
			<p>Vyplňte prosím krátký formulář a na váš email vám pošleme číslo účtu a potřebné informace k provedení platby.</p>
			<p>Pokud se rozdhodnete pro adopci předem děkujeme.</p>
			<p><a href="http://bwindiorphans.org/?page_id=381">Postup adopce</a></p>
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
						<input type="hidden" name="page_id" value="586" />
						<input type="hidden" name="idDite" value="{$dite.id}" />
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
{/foreach}
