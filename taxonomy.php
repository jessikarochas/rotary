<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Rotary
 * @since Rotary 1.0
 */

get_header(); ?>

	<?php if ( 'rotary_projects' ==  get_post_type() ) : ?>
		<h1 class="pagetitle"><span><?php echo __( 'Projects' ); ?></span></h1>				
	<?php else: ?>
		<h1 class="pagetitle"><span><?php echo __( 'Speaker Program' ); ?></span></h1>
	<?php endif; ?>
				
	<div id="page" class="blog">
         <h2 class="pagesubtitle"><?php
               if ( is_tax('tax-rotary_speaker_tag') ){
	               printf( __( 'Tag Archives: %s', 'Rotary' ), '<span>' . single_cat_title( '', false ) . '</span>' );
               }
               else {
				printf( __( 'Category Archives: %s', 'Rotary' ), '<span>' . single_cat_title( '', false ) . '</span>' );
			}
		?></h2>
		<?php
			$category_description = category_description();
			if ( ! empty( $category_description ) )
				echo '' . $category_description . '';
		?>
                <div id="content" role="main"> 
				<?php get_template_part( 'loop', 'category' );
		?>
		</div>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>