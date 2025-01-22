<?php
//Create the rating interface.
add_action( 'comment_form_logged_in_after', 'bedemo_comment_rating_rating_field' );
add_action( 'comment_form_after_fields', 'bedemo_comment_rating_rating_field' );
function bedemo_comment_rating_rating_field () {
	if(get_post_type() == 'service') {
		?>
	  <div class="bt-form-rating">
	    <label class="bt-form-rating__label"  for="rating"><?php echo esc_html__('Rating', 'bedemo'); ?> <span class="required">*</span></label>
	  	<fieldset class="bt-form-rating__field">
	  		<span class="bt-form-rating__list">
	  			<?php for( $i = 5; $i >= 1; $i-- ) { ?>
	  				<input type="radio" id="rating-<?php echo esc_attr( $i ); ?>" name="rating" value="<?php echo esc_attr( $i ); ?>" />
	          <label for="rating-<?php echo esc_attr( $i ); ?>">
	            <?php echo esc_html( $i ); ?>
							<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
								<path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
							</svg>
	          </label>
	  			<?php } ?>
	  		</span>
	  	</fieldset>
	  </div>
		<?php
	}
}

//Save the rating submitted by the user.
add_action( 'comment_post', 'bedemo_comment_rating_save_comment_rating' );
function bedemo_comment_rating_save_comment_rating( $comment_id ) {
	if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) ) {
		$rating = intval( $_POST['rating'] );
		add_comment_meta( $comment_id, 'rating', $rating );
	}
}

//Display the rating on a submitted comment.
add_filter( 'comment_text', 'bedemo_comment_rating_display_rating');
function bedemo_comment_rating_display_rating( $comment_text ){
	if ( $rating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
		$stars = '<p class="bt-comment-stars">';

		for( $i = 1; $i <= 5; $i++ ) {
			if($i <= $rating) {
				$stars .= '<span class="bt-filled"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
										<path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
									</svg></span>';
			} else {
				$stars .= '<span><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
										<path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
									</svg></span>';
			}
		}
		$stars .= '</p>';

		if (class_exists('Woocommerce')) {
			if ( !is_product() ) {
				$comment_text = $comment_text . $stars;
			}
		} else {
			$comment_text = $comment_text . $stars;
		}

		return $comment_text;
	} else {
		return $comment_text;
	}
}

//Get the average rating of a post.
function bedemo_comment_rating_get_average_ratings( $id ) {
	$comments = get_approved_comments( $id );

	if ( $comments ) {
		$i = 0;
		$total = 0;
		foreach( $comments as $comment ){
			$rate = get_comment_meta( $comment->comment_ID, 'rating', true );
			if( isset( $rate ) && '' !== $rate ) {
				$i++;
				$total += $rate;
			}
		}

		if ( 0 === $i ) {
			return false;
		} else {
			return round( $total / $i, 1 );
		}
	} else {
		return false;
	}
}
