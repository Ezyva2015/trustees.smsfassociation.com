<?php
/**
 * Template Name: Corp Seat Allocation
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
 get_header(); ?>
	<div id="content" <?php Avada()->layout->add_style( 'content_style' ); ?>>
		<?php
		while( have_posts() ): the_post();
		?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php echo avada_render_rich_snippets_for_pages(); ?>
			<?php if( ! post_password_required($post->ID) ): // 1 ?>
			<?php if(!Avada()->settings->get( 'featured_images_pages' ) ): // 2 ?>
			<?php
			if( avada_number_of_featured_images() > 0 || get_post_meta( $post->ID, 'pyre_video', true ) ): // 3
			?>
			<div class="fusion-flexslider flexslider post-slideshow">
				<ul class="slides">
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li>
						<div class="full-video">
							<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
						</div>
					</li>
					<?php endif; ?>
					<?php if( has_post_thumbnail() && get_post_meta( $post->ID, 'pyre_show_first_featured_image', true ) != 'yes' ): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>" data-title="<?php echo get_post_field('post_title', get_post_thumbnail_id()); ?>" data-caption="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" /></a>
					</li>
					<?php endif; ?>
					<?php
					$i = 2;
					while($i <= Avada()->settings->get( 'posts_slideshow_number' )):
					$attachment_new_id = kd_mfi_get_featured_image_id('featured-image-'.$i, 'page');
					if($attachment_new_id):
					?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment_new_id, 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment_new_id, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment_new_id); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', $attachment_new_id); ?>" data-title="<?php echo get_post_field( 'post_title', $attachment_new_id ); ?>" data-caption="<?php echo get_post_field('post_excerpt', $attachment_new_id ); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta($attachment_new_id, '_wp_attachment_image_alt', true); ?>" /></a>
					</li>
					<?php endif; $i++; endwhile; ?>
				</ul>
			</div>
			<?php endif; // 3 ?>
			<?php endif; // 2 ?>
			<?php endif; // 1 password check ?>
			<div class="post-content">
				<?php 
				
				$current_user = wp_get_current_user();

require_once $_SERVER['DOCUMENT_ROOT'].'/ifs/Services/Infusionsoft/isdk.enhanced.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ifs/Services/Logger/Logger.php';

Logger::$path = dirname(__FILE__) . '/log.txt';


$infusionsoft = new iSDK_enhanced($contact_id);

if ( ! $infusionsoft->connect('tl270'))
{
    Logger::write('Failed to connect to Infusionsoft');
    echo "Damn!  No connection to IFS.";
    exit();
}

$email = $current_user->user_email;

//2.dsQuery with the query looking in Contact table where emailAdress = that from 1. and returning contact Id
//3.Based on the returned contact, we want to get the value of _seatsPurchased
$returnfields = array('ID', 'Firstname', 'Lastname', '_SeatsPurchased','_SeatAllocatedBy');
$data = $infusionsoft->findbyemail($email, $returnfields);
$ID = $data[0]['ID'];
$FirstName = $data[0]['Firstname'];
$SeatAllocatedBy = $data[0]['_SeatAllocatedBy'];
$intSeatsPurchasedCount = $data[0]['_SeatsPurchased'];

$returnFields = array('Firstname', 'Lastname', 'Email');
$query = array('_SeatAllocatedBy' => $ID);
$contacts = $infusionsoft->dsQuery("Contact",999,0,$query,$returnFields);


if(count($contacts) > 0){
	$intSeatsAllocatedCount = count($contacts);
}
else {
	$intSeatsAllocatedCount = 0;
}

if($intSeatsPurchasedCount < 1) {
	$intSeatsPurchasedCount = 0;
}




if($intSeatsPurchasedCount > 0) {
echo "Email: ".$email;
echo '<br/>Purchased Seats: '.$intSeatsPurchasedCount.'<br/>';
echo 'Allocated Seats: '.$intSeatsAllocatedCount.'<br/>';
//Write Table Header
    echo '<table border="1">  <br>';
    echo "<tr>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "<th>Email</th>";
    echo "<th>Action</th>";
    echo "</tr>";



//Write Table Rows
For ($intLoopCounter=0;$intLoopCounter<$intSeatsPurchasedCount;$intLoopCounter++) {
    // If row is allocated, show person in row.
    if ($intLoopCounter<$intSeatsAllocatedCount) {
        echo '<tr>';
        //disbled input boxes?  Or just text?
        echo '<td>'. $contacts[$intLoopCounter]['Firstname'] .'</td>';
        echo '<td>'. $contacts[$intLoopCounter]['Lastname'] .'</td>';
        echo '<td>'. $contacts[$intLoopCounter]['Email'] .'</td>';
        echo '<td></td>';
        echo '</tr>';

    } else {
        // If row unallocated, make data-enterable row.
        echo "<tr>";
        echo '<td><form name="form_'.$intLoopCounter.'" action="/ifs/Scripts/allocate_seats.php" method="post"><input name="fname" type="text" value=""></td>';
        echo '<td><input name="lname" type="text" value=""></td>';
        echo '<td><input name="email" type="text" value=""></td>';
        echo '<td><input type="submit" value="Allocate Seat"></form></td>';
        echo "</tr>";
    }
}

// Finish table footer.
echo "</table>";

} 
else {
	echo '<p>No corporate seats are available to be allocated on your account. Please purchase seats and then come back to this page to allocate them.</p>';
}
				
				
				
				
				
				?>
				<?php avada_link_pages(); ?>
			</div>
			<?php if( ! post_password_required($post->ID) ): ?>
			<?php if(class_exists('WooCommerce')): ?>
			<?php
			$woo_thanks_page_id = get_option('woocommerce_thanks_page_id');
			if( ! get_option('woocommerce_thanks_page_id') ) {
				$is_woo_thanks_page = false;
			} else {
				$is_woo_thanks_page = is_page( get_option( 'woocommerce_thanks_page_id' ) );
			}
			?>
			<?php if(Avada()->settings->get( 'comments_pages' ) && !is_cart() && !is_checkout() && !is_account_page() && ! $is_woo_thanks_page ): ?>
				<?php
				wp_reset_query();
				comments_template();
				?>
			<?php endif; ?>
			<?php else: ?>
			<?php if(Avada()->settings->get( 'comments_pages' )): ?>
				<?php
				wp_reset_query();
				comments_template();
				?>
			<?php endif; ?>
			<?php endif; ?>
			<?php endif; // password check ?>
		</div>
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
	</div>
	<?php do_action( 'fusion_after_content' ); ?>
<?php get_footer();

// Omit closing PHP tag to avoid "Headers already sent" issues.
