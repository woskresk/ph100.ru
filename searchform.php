<div class="search gensearch__wrapper">
	<form id="searchform" class="gensearch__form" action="<?php echo home_url( '/' ); ?>" method="get">
		<input id="s" name="s" value="<?php echo get_search_query() ?>" class="inputbox gensearch__input" type="text" placeholder="<?php esc_attr_e('SEARCH ...','zn_framework'); ?>" />
		<button type="submit" id="searchsubmit" value="go" class="gensearch__submit glyphicon glyphicon-search"></button>
	</form>
</div>