<div id="cf-modal-donate">
	<h3><?php _e('Congratulations!') ?></h3>
	<div class="content">
		<?php print wpautop(file_get_contents(dirname(__FILE__).'/modal-donate-text.txt')) ?>
	</div>
	<div class="donate">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" id="donate-form">
			<input type="hidden" name="cmd" value="_donations">
			<input type="hidden" name="business" value="support@siteorigin.com">
			<input type="hidden" name="lc" value="US">
			<input type="hidden" name="item_name" value="SiteOrigin">
			<input type="hidden" name="no_note" value="0">
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
		</form>

		<a href="#" class="paypal">Donate with PayPal</a>
		<a href="#" class="close">No Thanks</a>
	</div>
</div>

<div id="cf-modal-donate-overlay">
	
</div>