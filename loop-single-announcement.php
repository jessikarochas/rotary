<?php
/**
 * The loop that displays an announcement.
 *
 * @package WordPress
 * @subpackage Rotary
 * @since Rotary HTML5 3.2
 */
?> 
<?php

	// Get all the data and metadata for the comment, ready to display.
	$id = $announcement->comment_ID;
	$posted_in_id = $announcement->comment_post_ID;
	
	$call_to_action = get_comment_meta( $id, 'call_to_action' ); //TODO: add call to action metadata field
	$announcement_title = get_comment_meta( $id, 'announcement_title', true );
	
	if( !get_comment_meta( $id, 'announcement_expiry_date', true ) ) :
		$expiry_date = new DateTime;
		$expiry_date->add(new DateInterval( 'P7D' ) ) ;
		$announcement_expiry_date = $expiry_date->format( 'Y-m-d' );
		update_comment_meta( $comment_id, 'announcement_expiry_date', $announcement_expiry_date );
	endif;
	
	$request_replies = get_comment_meta( $id, 'request_replies', true );
	$announcement_expiry_date = new DateTime( get_comment_meta( $id, 'announcement_expiry_date', true ));
	$announcement_text = apply_filters ("the_content", $announcement->comment_content);
	$announced_by = $announcement->comment_author;
	$call_to_action = get_comment_meta( $id, 'call_to_action', true );

	$date = new DateTime( $announcement->comment_date );
	
	$user_can_edit = ( current_user_can( 'edit_others_announcements' ) || get_current_user_id() == $announcement->user_id || current_user_can( 'manage_options' ));
	$user_can_delete = ( current_user_can( 'delete_others_announcements' ) || get_current_user_id() == $announcement->user_id || current_user_can( 'manage_options' ));
	
	
	if ( $context ) $extra_classes[] =  $context . '-announcement';
	if ( ('carousel' == $context  && $announcementsDisplayed > 1 ) || 'slideshow' == $context )  $extra_classes[] =  'hide';
	if ( 'slideshow' == $context )  $extra_classes[] =  'slidemargins';
	
	?>
			
			<?php switch ( $context ) { 
				case 'email':
					if ( $context ) $extra_classes[] =  'announcement-table';
					?>
					<table id="comment-<?php echo $id ?>" <?php comment_class( $extra_classes ); ?>>
						<tr class="announcement-header-row">
							<td>	
							<?php echo rotary_announcement_header( $posted_in_id, $announcement_title, 'email' );?>
							</td>
						</tr>
						<tr class="announcement-buttons">
							<td>
								<table class="announcement-buttons-table">
									<tr class="annoucement-buttons-row">
										<td class="announcement-buttons" <?php echo $call_to_action ? '' : ' colspan="2"' ;?>">
											<p class="announced-by clearleft"><?php echo sprintf( __('By %s', 'Rotary'), $announced_by); ?></p>
											<?php if ( $request_replies ) :
												$userdata = get_userdata( $announcement->user_id );
											?>
												<a class="rotarybutton-smallblue" href="mailto:<?php echo $userdata->user_email;?>?subject=Re: <?php echo htmlentities( $announcement_title );?>" ><?php echo sprintf( __ ('Reply to %s'), htmlentities( $announced_by )); ?></a>
											<?php endif; ?>
										</td>
										<?php if( $call_to_action ) : ?>
										<td class="calltoactioncontainer"><?php echo $call_to_action; ?></td>
										<?php endif;?>
									</tr>
								</table>
							</td>
						</tr>
						<tr class="announcement-body-row">
							<td class="announcement-body">
								<?php echo $announcement_text; ?>			
							</td>
						</tr>
						<tr class="announcement-date-row">
							<td>
							<?php if (!$hide_expiry ) {?>
								<table class="announcement-date-table">
									<tr  class="announcement-date-row">
										<td class="announcement-date">
											<span class="day"><?php echo strftime( '%e %b %G', $date ); //$date->format( 'd M Y') ; ?></span>
										</td>
										<td class="announcement-expiry-date  announcement-date">
											<span class="day"><?php echo sprintf( __( 'Expires %s' ), strftime( '%e %b %G', $announcement_expiry_date->getTimestamp() ));//$announcement_expiry_date->format( 'd M Y')); ?></span>
										</td>
									</tr>
								</table>
								<?php } else { ?>&nbsp;<?php  } ?>
							</td>
						</tr>
					</table>
				<?php 
					break; 
			 case 'shortcode':
			 case 'carousel':
			 case 'speaker':  ?>
				<article id="comment-<?php echo $id ?>" <?php comment_class( $extra_classes, $id ); ?>>
				<?php echo rotary_announcement_header( $posted_in_id, $announcement_title );?>
				<div class="announcement-buttons">
					<h6 class="announced-by"><?php echo sprintf( __( 'By %s', 'Rotary' ), $announced_by ); ?></h6>
					<?php if ( $request_replies ) :
						$userdata = get_userdata( $announcement->user_id );	?>
						<div class="request-replies-container">
							<a class="rotarybutton-smallblue" href="mailto:<?php echo $userdata->user_email;?>?subject=Re: <?php echo htmlentities( $announcement_title );?>" ><?php echo sprintf( __ ('Reply to %s'), htmlentities( $announced_by )); ?></a>
						</div>
					<?php endif; ?>
					<?php if( $this->allowedits && $user_can_edit) :?>
					 <div class="editannouncementbutton-container">
					 	<a href="javascript:void(null)" data-comment-id="<?php echo $id; ?>" class="rotarybutton-smallwhite editannouncementbutton"><?php echo __( 'Edit Announcement' ); ?></a>
					 	<?php if( $user_can_delete ) :?>
					 		<a href="javascript:void(null)" data-comment-id="<?php echo $id; ?>" class="rotarybutton-smallred deleteannouncementbutton"><?php echo __( 'Delete' ); ?></a>
					 	<?php endif;?>
					 </div>
					<?php  endif; ?>
					<?php if( $call_to_action ) : ?>
						<div class="call-to-action-container"><?php echo $call_to_action; ?></div>
					<?php endif;?>
				</div>
				
				
				<div class="announcement-body">
					<?php echo $announcement_text; ?>	
				</div>
				
			<?php if( 'shortcode' == $context ) : ?>
				<div class="announcement-footer">
						<div class="announcement-date">
							<span class="day"><?php echo strftime( '%e %b %G', $date->getTimestamp() ) ; //$date->format( 'd M Y') ; ?></span>
						</div>
						<div class="announcement-expiry-date announcement-date">
							<span class="day"><?php echo sprintf( __( 'Expires %s' ), strftime( '%e %b %G', $announcement_expiry_date->getTimestamp() )); //$announcement_expiry_date->format( 'd M Y')); ?></span>
						</div>		
				</div>
			<?php endif;?>			
			</article>
			<?php 
				break; 
				case 'slideshow':  ?>
					<article id="comment-<?php echo $id ?>" <?php comment_class( $extra_classes, $id ); ?>>
						<?php echo rotary_announcement_header( $posted_in_id, $announcement_title, $context='slideshow' );?>
						<div class="announcement-buttons">
							<p class="announced-by clearleft"><?php echo $announced_by; ?></p>
						</div>
						<div class="announcement-body">
							<?php echo $announcement_text; ?>	
						</div>
						<div class="announcement-footer">				
						</div>
					</article>
				<?php 
				break; 
			case 'project': 
			case 'committee':
			default: ?>
				<article id="comment-<?php echo $id ?>" <?php comment_class( $extra_classes, $id ); ?>">
				<div class="announcement-date">
					<span class="day"><?php echo strftime( '%e', $date->getTimestamp() ); //$date->format( 'd') ; ?></span>
					<span class="month"><?php  echo strftime( '%B', $date->getTimestamp() ); //$date->format( 'M' ); ?></span>
					<span class="year"><?php echo strftime( '%G', $date->getTimestamp() ); //$date->format( 'Y' ); ?></span>
				</div>
				<div class="announcement-expiry-date">
					<span class="day"><?php echo strftime( '%e %b %G', $announcement_expiry_date->getTimestamp() ); //$announcement_expiry_date->format( 'd M Y') ; ?></span>
				</div>
				<div class="announcement-content">
					<div class="announcement-header">
						<h3><?php echo ( $announcement_title ) ? $announcement_title : __( 'New Announcement!', 'Rotary' ); ?></h3>
						<p class="announced-by"><?php 
						if ( $request_replies ) :
							$userdata = get_userdata( $announcement->user_id );
						?>
							<a class="rotarybutton-smallblue" href="mailto:<?php echo $userdata->user_email;?>?subject=Re: <?php echo htmlentities( $announcement_title);?>" ><?php echo sprintf( __ ('Reply to %s'), htmlentities( $announced_by )); ?></a>
						<?php 
						else:
							echo sprintf( 'by ' );
							?><span><?php echo $announced_by; ?></span><?php  
						endif;
						?></p>
					</div>							
					<div class="announcement-body">
						<?php echo $announcement_text; ?>			
					</div>
				</div>	
			</article>	
			<?php }