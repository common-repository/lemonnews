<style type="text/css">
	#debug {
		width: 100%;
		border: 1px solid #000;
		background: #CCC;
		border-radius: 0 0 10px 10px;
		position: relative;
		z-index: 10000000;
		top: 0;
		left: 0;
		padding: 5px;
	}

	#debug pre {
		padding: 0;
		text-align: left;
		font-size: 14px;
	}
</style>
<div id="debug">
	<pre>
		<?php var_dump($value); ?>
	</pre>
</div> 