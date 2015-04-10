<?php
/*
Plugin Name: WooThemes Sensei Quiz Page Certificate
Plugin URI: https://github.com/easy-development/woothemes-sensei-quiz-page-certificate
Description: Display the Course Certificate on the Quiz Page if it has been earned.
Version: 1.0.0
Author: Andrei-Robert Rusu
Author URI: http://www.easy-development.com
*/


add_action( 'sensei_before_main_content', 'quizPageCertificateSenseiBeforeMainContent', 10 );

function quizPageCertificateSenseiBeforeMainContent() {
  if( !is_singular('quiz') ) return;
  global $post, $current_user;

  if(isset($post->post_parent) && $post->post_parent != 0) {
    $lessonPost = get_post($post->post_parent);

    $courseID = get_post_meta($lessonPost->ID, '_lesson_course', true);

    $availableCertificates = get_posts(array(
        'post_type' => 'certificate',
        'meta_query' => array(
            array(
                'key'   => 'course_id',
                'value' => $courseID
            ),
            array(
                'key'   => 'learner_id',
                'value' => $current_user->ID
            )
        ),
    ));

    if(!empty($availableCertificates)) {
      foreach($availableCertificates as $availableCertificate) {
        echo '<a class="sensei-certificate-link" href="' . $availableCertificate->guid . '" target="_blank">' . __("View Certificate") . '</a>';
      }
    }
  }
}