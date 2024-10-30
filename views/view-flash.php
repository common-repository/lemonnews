<?php if (isset($_SESSION['flash'])): ?>

	<div class="alert <?php echo $_SESSION['flash-class'] ? 'alert-' . $_SESSION['flash-class'] : ''; ?>">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<?php echo $_SESSION['flash-message'] ? $_SESSION['flash-message'] : __("No message sent.", "LemonNewsDomain")?>
	</div>

<?php endif ?>