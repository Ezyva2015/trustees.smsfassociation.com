<?php
/**
 * Displays a topic.
 *
 * Available Variables:
 * 
 * $course_id 		: (int) ID of the course
 * $course 		: (object) Post object of the course
 * $course_settings : (array) Settings specific to current course
 * $course_status 	: Course Status
 * $has_access 	: User has access to course or is enrolled.
 * 
 * $courses_options : Options/Settings as configured on Course Options page
 * $lessons_options : Options/Settings as configured on Lessons Options page
 * $quizzes_options : Options/Settings as configured on Quiz Options page
 * 
 * $user_id 		: (object) Current User ID
 * $logged_in 		: (true/false) User is logged in
 * $current_user 	: (object) Currently logged in user object
 * $quizzes 		: (array) Quizzes Array
 * $post 			: (object) The topic post object
 * $lesson_post 	: (object) Lesson post object in which the topic exists
 * $topics 		: (array) Array of Topics in the current lesson
 * $all_quizzes_completed : (true/false) User has completed all quizzes on the lesson Or, there are no quizzes.
 * $lesson_progression_enabled 	: (true/false)
 * $show_content	: (true/false) true if lesson progression is disabled or if previous lesson and topic is completed. 
 * $previous_lesson_completed 	: (true/false) true if previous lesson is completed
 * $previous_topic_completed	: (true/false) true if previous topic is completed
 * 
 * @since 2.1.0
 * 
 * @package LearnDash\Topic
 */
?>




<style type="text/css">
	

	.children span a{
		
		padding-left: 42px;
		
	} 
	#learndash_lesson_topics_list .children{
		display: none;
	}
	#learndash_lesson_topics_list .plus{
		display: list-item !important; 
	}

	.topic_item:hover{
		background: #dedede;
	}
	#learndash_lesson_topics_list .parent{
		display: block !important;
		float: left; 
		width: 100%;
	}
	#learndash_lesson_topics_list #parents{
		width: 93% !important;
		float: left !important;
	}

</style>

<script type="text/javascript">
	var j = jQuery.noConflict();	


	j(document).ready(function(){
			
		j('#learndash_lesson_topics_list .plus').click(function(){
			var id = j(this).attr('id');			

				j('#learndash_lesson_topics_list ul .children'+id).slideToggle( "slow" );
		});



		var disId = j('#learndash_lesson_topics_list li.active').children("a.plus").attr('id');
		j('#learndash_lesson_topics_list ul .children'+disId).show();

	});
</script>

<?php
/**
 * Topic Dots
 */
?>


<?php if ( ! empty( $topics ) ) : ?>
	<!--<div id='learndash_topic_dots-<?php echo esc_attr( $lesson_id ); ?>' class="learndash_topic_dots type-dots">

		<b><?php _e( 'Topic Progress:', 'learndash' ); ?></b>

		<?php foreach ( $topics as $key => $topic ) : ?>
			<?php $completed_class = empty( $topic->completed ) ? 'topic-notcompleted' : 'topic-completed'; ?>
			<a class='<?php echo esc_attr( $completed_class ); ?>' href='<?php echo get_permalink( esc_attr( $topic->ID ) ); ?>' title='<?php echo esc_attr( $topic->post_title ); ?>'>
				<span title='<?php echo esc_attr( $topic->post_title ); ?>'></span>
			</a>
		<?php endforeach; ?>

	</div>-->
<?php endif; ?>

<div id="learndash_back_to_lesson"><a href='<?php echo esc_attr( get_permalink( $lesson_id) ); ?>'>&larr; <?php _e( 'Back to Lesson', 'learndash' ); ?></a></div>

<?php if ( $lesson_progression_enabled && ! $previous_topic_completed ) : ?>

	<span id="learndash_complete_prev_topic"><?php  _e( 'Please go back and complete the previous topic.', 'learndash' ); ?></span>
		<br />

<?php elseif ( $lesson_progression_enabled && ! $previous_lesson_completed ) : ?>

	<span id="learndash_complete_prev_lesson"><?php _e( 'Please go back and complete the previous lesson.', 'learndash' ); ?></span>
		<br />
<?php endif; ?>
<?php if ( $show_content ) : ?>
<?php  if ( is_user_logged_in() || !is_user_logged_in() || get_the_lessontopic($post->ID,854)==1 ) { ?>


			<div id="learndash_lesson_topics_list" style="float:left; position:relative !important;">

			<?php if ( ! empty( $topics ) ) : ?>
				<div id='learndash_topic_dots-<?php echo esc_attr( $post->ID ); ?>' class="learndash_topic_dots type-list">
					<div style="border:none;" >
						<div style="display:none; text-align: left; background-color: #5AA0E5; color: white; padding: 10px;" > Knowledge Test </div>
							<br>
							<strong><?php _e( 'Knowledge Topics', 'learndash'); ?></strong>
						<ul>
							<?php $odd_class = ''; ?>

								<?php foreach ( $topics as $key => $topic ) : ?>
								<?php

								if($topic->post_parent!=0){
									$child = 'children children'.$topic->post_parent;
									$id = $topic->ID;

								}else{
									$child = 'parent parent'.$topic->ID;
									$id = $topic->ID;
									$span="<a href='javascript:void(0);' class='plus' id='".$topic->ID."'>+</a>";
								}


								$children = get_posts(array(
									'post_parent' =>$topic->ID,
									'post_type'   => 'sfwd-topic'
									));


								if($topic->ID == $post->ID){

									$showblock = '<style>#learndash_lesson_topics_list .children'.$topic->post_parent.'{display:block;}</style>';


								}


								?>
								<?php $odd_class = empty( $odd_class ) ? 'nth-of-type-odd ' : ''; ?>
								<?php $completed_class = empty( $topic->completed ) ? 'topic-notcompleted' : 'topic-completed'; ?>

								<li class='<?php echo esc_attr( $odd_class ); ?><?php echo $child; ?>'>
									<span id="parents" class="topic_item" <?php if($post->ID==$topic->ID){ echo "style='background:#ddd'"; } ?>>
										<a class='<?php echo esc_attr( $completed_class ); ?>' href='<?php echo esc_attr( get_permalink( $topic->ID ) ); ?>' title='<?php echo esc_attr( $topic->post_title ); ?>'>
											<span>
											<?php

											if($topic->post_parent!=0){

											echo "-	";

											}

											?>
											<?php echo $topic->post_title; ?></span>
										</a>
									</span>
									<?php if($children){ ?>
									<?php echo $span; ?>
									<?php } ?>
								</li>

							<?php endforeach; ?>
						</ul>
					</div>
					<?php echo $showblock; ?>
				</div>
			<?php endif; ?>

			<!-- Test your knowledge -->
				<?php
				$quizids="";
				$swtopicinfo = get_post_meta($post->ID,'_sfwd-topic', true);
				$quizlist = get_posts('post_type=sfwd-quiz');


				// print_r($quizlist);


				foreach($quizlist as $quizindex=>$quizdata) {

					// echo "<pre>";
					// print_r($quizlesson);
					// echo "</pre>";
 
					$quizlesson = get_post_meta($quizdata->ID,'_sfwd-quiz', true);

					// echo  $quizlesson['sfwd-quiz_lesson'] . "  == " . $swtopicinfo['sfwd-topic_lesson'] . '<br><br><br>';

					if($quizlesson['sfwd-quiz_lesson']==$swtopicinfo['sfwd-topic_lesson']) {
						$quizids[]=$quizdata->ID;
					}
					
				}
				$quizzes="";

				// echo "<pre>";
				// 	echo "Below are the list of the quiz <br><br>";
			 //  		print_r($quizids); 
			 //  	echo "</pre>";

				foreach($quizids as $quizid) {

				// echo " quizid = $quizid <br>";

				$quizzes = get_post( $quizid );
				?>


				<?php if ( ! empty( $quizzes ) ) : ?>
					<div class="clear"></div>
					<div id="learndash_quizzes" style="">
						<div id="quiz_heading"><span><?php _e( 'Knowledge Test', 'learndash' ); ?></span></div>
						<div id="quiz_list">
							<div id='post-<?php echo esc_attr( $quizzes->post_id ); ?>'>
								<h4>
									<a class='<?php echo esc_attr( $quiz['status'] ); ?>' href='<?php echo esc_attr( $quizzes->guid ); ?>'><?php echo $quizzes->post_title; ?></a>
								</h4>
							</div>
						</div>
					</div>
				<?php endif; } ?>
			</div>


			<div class="fplearndash-content" style="float:right">
				<?php echo $content; ?>
			</div>



	<?php if ( lesson_hasassignments( $post ) ) : ?>

		<?php $assignments = learndash_get_user_assignments( $post->ID, $user_id ); ?>

		<div id="learndash_uploaded_assignments">
			<h2><?php _e( 'Files you have uploaded', 'learndash' ); ?></h2>
			<table>

				<?php if ( ! empty( $assignments ) ) : ?>
					<?php foreach( $assignments as $assignment ) : ?>
							<tr>
								<td><a href='<?php echo esc_attr( get_post_meta( $assignment->ID, 'file_link', true ) ); ?>' target="_blank"><?php echo __( 'Download', 'learndash' ) . ' ' . get_post_meta( $assignment->ID, 'file_name', true ); ?></a></td>
								<td><a href='<?php echo esc_attr( get_permalink( $assignment->ID) ); ?>'><?php _e( 'Comments', 'learndash' ); ?></a></td>
							</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</table>
		</div>

	<?php endif; ?>
	
<?php } //user is logged in end ?>	
	

	<?php
		/**
		 * Show Mark Complete Button
		 */
		?>
	<?php if ( $all_quizzes_completed ) : ?>
		<?php //echo '<br />' . learndash_mark_complete( $post ); ?>
	<?php endif; ?>

<?php endif; ?>
<div style="clear:both;"></div>
<!--<p id="learndash_next_prev_link"><?php echo learndash_previous_post_link(); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo learndash_next_post_link(); ?></p>-->

