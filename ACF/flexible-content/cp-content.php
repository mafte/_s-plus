<?php
//Get fields with $cp array or get_sub_field()
// var_dump($cp);

?>

<!--  CP-CONTENT ************************** -->

<section <?php echo $atts_globals; ?> class="cp-content <?php echo esc_attr( $cp->class_css ); ?>">

	<div class="container">
		<div class="row">
			<div class="col">
				<?php echo $cp->content; ?>
			</div>
		</div>
	</div>

</section>

<!-- ************************** CP-CONTENT  -->
