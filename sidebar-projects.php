<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage Rotary
 * @since Rotary 1.0
 * sidebar used on blog and interior pages
 */
?>

	<aside id="projects-sidebar" role="complementary">
		<ul>
			<li>
				<ul>
					<li>
						<img class="aligncenter project-calendar" src="<?php echo get_template_directory_uri() ?>/rotary-sass/images/project-calendar.png" alt="project calendar image" />
					</li>
				</ul>
				<ul>
					<li>
						<?php $date = DateTime::createFromFormat('Ymd', get_field( 'rotary_project_date' ) ); ?>
						<div class="project-date">
							<p class="dayweek"><?php echo $date->format('l'); ?></p>
							<span class="day"><?php echo $date->format('dS'); ?></span>
							<span class="month"><?php echo $date->format('F'); ?></span>
							<span class="year"><?php echo $date->format('Y'); ?></span>
                	     </div>
					</li>
				</ul>
				<ul>
				<li>
					<?php $location = get_field('rotary_project_location');
 
					if( !empty($location) ) { ?>
						<div class="location">
							<p class="meetingsite">Address</p>
							<?php $address = preg_replace('/,/', '<br />', $location["address"], 1);  ?>
							<?php echo $address; ?>
							<p class="instructions"><a href="http://maps.google.com/maps?daddr=<?php echo $location['address'] ?>" target="_blank">Larger Map</a></p>
						</div>
						<div class="acf-map">
							<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>" data-address="<?php echo $location['address']; ?>">
							</div>
						</div>
					<?php } ?>
					
				</li>
				</ul>
				<h3><?php _e( 'Categories', 'Rotary' ); ?></h3>
				<ul>
					<?php $terms = wp_get_post_terms( get_the_id(), 'rotary_project_cat' ); ?>
						<?php if ($terms) : ?>
						<?php foreach ($terms as $term) : ?>
						 <?php    
							 $taxonomy = get_taxonomy('rotary_project_cat'); ?>					 							
						 <li class="cat-item"><a href="<?php echo trailingslashit(site_url() .'/'. $taxonomy->rewrite['slug'] .'/'.$term->slug); ?>"><?php echo $term->name; ?></a></li>				
				<?php endforeach; ?>
		    <?php endif; ?>
				</ul>
				<h3><?php _e( 'Photographs', 'Rotary' ); ?></h3>
				<ul class="clearfix" >
					<?php if(get_field('rotary_project_picture_gallery')): ?>
						<li class="speakerthumbs">
						<?php while(has_sub_field('rotary_project_picture_gallery')): ?>
						<?php $image = wp_get_attachment_image_src( get_sub_field('rotary_project_picture'), 'full' ); ?>
						<a class="fancybox" rel="gallery1" href="<?php echo  $image[0]?>" title="">
							<?php $image = wp_get_attachment_image_src( get_sub_field('rotary_project_picture'), 'thumbnail' ); ?>
							<img class="alignleft" src="<?php echo  $image[0]?>" alt="" title=""/></a>
						<?php endwhile; ?>
						</li>
					<?php endif; ?>
				</ul>
				<h3><?php _e( 'Tags', 'Rotary' ); ?></h3>
				<ul class="tagcloud">
					<?php $terms = wp_get_post_terms( get_the_id(), 'rotary_project_tag' ); ?>
						<?php if ($terms) : ?>
						<?php foreach ($terms as $term) : ?>
							<li class="cat-item"><a href="<?php echo trailingslashit(site_url() .'/rotary_project_tag/'.  $term->slug); ?>"><?php echo $term->name; ?></a></li>				
				<?php endforeach; ?>
		    <?php endif; ?>

				</ul>
			</li>
		</ul>
	</aside>