<div id="lemon-news-wrapper">
	<p class="lemon-news-help"><?php echo isset($userHelp) ? $userHelp : ""; ?></p>
	<p class="lemon-news-feedback"></p>
	<form action="" class="lemon-news">
		<input type="email" class="lemon-news-email" placeholder="E-mail" />
		<button class="lemon-news-send" type="submit"><?php echo __("Send", "LemonNewsDomain") ?></button>
		<input type="hidden" class="lemon-news-nonce" value="<?php echo isset($nonce) ? $nonce : ""; ?>" />
	</form>
</div>