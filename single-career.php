<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package synextic
 */


if ( function_exists('get_field') ) {
	$careers_form_submission_email=	get_field('careers_form_submission_email','options');
}

if (isset($_POST['submit_career_form'])) {
    // Sanitize and validate input fields
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $city = sanitize_text_field($_POST['city']);
    $current_company = sanitize_text_field($_POST['current_company']);
    $current_ctc = sanitize_text_field($_POST['current_ctc']);
    $experience = sanitize_text_field($_POST['experience']);
    $cover_letter = sanitize_textarea_field($_POST['cover_letter']);
    $resume = $_FILES['resume'];

    // Check for errors with the file upload
    if ($resume['error'] === UPLOAD_ERR_OK) {
		
		require_once(ABSPATH . 'wp-admin/includes/file.php');

        // Handle the file upload
       $file = array(
        'name'     => $resume['name'],
        'type'     => $resume['type'],
        'tmp_name' => $resume['tmp_name'],
        'error'    => $resume['error'],
        'size'     => $resume['size']
    );

    // Set upload overrides - do not test for mime types here
    $upload_overrides = array('test_form' => false);

    // Handle the file upload
    $movefile = wp_handle_upload($file, $upload_overrides);

    if ($movefile && !isset($movefile['error'])) {
        // File is uploaded successfully
        	$upload_url = $movefile['url'];
            // Prepare the email content
            $to = $careers_form_submission_email;
            $subject = 'New Career Application from ' . $name;
            $body = "Name: $name\n";
            $body .= "Email: $email\n";
            $body .= "Phone: $phone\n";
            $body .= "City: $city\n";
            $body .= "Current Company: $current_company\n";
            $body .= "Current CTC: $current_ctc\n";
            $body .= "Experience: $experience\n\n";
            $body .= "Cover Letter:\n$cover_letter\n\n";
            $body .= "Resume: $upload_url\n"; // Include link to the uploaded resume

            $headers = array('Content-Type: text/plain; charset=UTF-8', 'From: ' . $name . ' <' . $email . '>');

            // Send the email using wp_mail()
            if (wp_mail($to, $subject, $body, $headers)) {
                // Redirect to the same page with a success parameter to prevent form resubmission
                header('Location: ' . esc_url($_SERVER['REQUEST_URI']) . '?success=1');
                exit;
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">There was an error uploading your resume. Please try again.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Please upload a valid resume.</div>';
    }
}


get_header('black');
?>

<?php
while (have_posts()) :
    the_post(); ?>
    
    <div class="career_page_header pt-80">
        <div class="container-17">
            <div class="row align-items-center">
                <div class="col-12 col-xxl-12 col-xl-12 col-lg-12">
                    <div class="career_page_header_content">
                        <h4><?= get_the_title() ?></h4>
                        <p><?= get_the_content() ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 
    if (have_rows('careers_content')) :

        echo '<section class="bg_lightgray">
				<div class="container-17">';
							if (isset($_GET['success'])) {
								echo '<div class="alert alert-success" role="alert">Thank you for applying! We will get back to you soon.</div>';
							}
    echo '
                    <div class="row">
                        <div class="col-12 col-xl-5 col-lg-5 col-md-12">
                            <div class="job_des">';

        while (have_rows('careers_content')) : the_row();

            if (get_row_layout() == 'responsibilities') :
                $title = get_sub_field('title');
                $description = get_sub_field('description');
                
                echo '<h5>'.$title.'</h5>
                      <ul>';
                
                if (!empty($description)) {
                    foreach ($description as $data) {
                        echo '<li>'.$data['data'].'</li>';
                    }
                }
                
                echo '</ul>';

            elseif (get_row_layout() == 'requirements_section') :
                $title = get_sub_field('title');
                $description = get_sub_field('descripiton');
                echo '<div class="line"></div>
                      <h5>'.$title.'</h5>
                      <ul>';
                
                if (!empty($description)) {
                    foreach ($description as $data) {
                        echo '<li>'.$data['data'].'</li>';
                    }
                }
                
                echo '</ul>';

            elseif (get_row_layout() == 'about_company__benefits') :
                $title = get_sub_field('title');
                $description = get_sub_field('description');
                
                echo '<div class="line"></div>
                      <h5>About Company / Benefits</h5>
                      <ul>';
                
                if (!empty($description)) {
                    foreach ($description as $data) {
                        echo '<li>'.$data['data'].'</li>';
                    }
                }
                
                echo '</ul>';

               elseif (get_row_layout() == 'apply_form') :
                      $script = get_sub_field('script');
                      echo '</div>
                              </div>
                             <div class="col-12 col-xl-7 col-lg-7 col-md-12">
                                  <div>' . $script . '
                                  </div>
                              </div>
                          </div>
                      </div>
                  </section>';

                 
            endif;
        endwhile;

           if (empty($script)) {
            if (function_exists('get_field')) {
                $careers_form = get_field('careers_form', 'options');
             }
                echo '</div>
                      </div>
                      <div class="col-12 col-xl-7 col-lg-7 col-md-12 ">
                         <div class= "career_form">
                           <h4>Apply Now</h4>
                            <p>Wish to connect with us? We will be happy to hear from you. Fill this form so we can learn more about your requirements.</p>
                            
                               <div class= "row">'.do_shortcode($careers_form).'</div>
                            
                         </div>
                      </div>
                  </div>
              </div>
            </section>';
        }

   
        // Now handle the 'talk_to_us' section
        while (have_rows('careers_content')) : the_row();

            if (get_row_layout() == 'talk_to_us') :

                $title = get_sub_field('title');
                $description = get_sub_field('description');
                $button_1 = get_sub_field('button_1');
                $button_2 = get_sub_field('button_2');
                $image = get_sub_field('image');

                echo '<section class="dark_bg cta_section pb-0 pt-0"> 
                        <div class="container-17">
                            <div class="row align-items-center">
                                <div class="col-12 col-xxl-7 col-xl-7 col-lg-7">
                                    <div class="warrning__ pb-95 pt-95">
                                        <h3>'.$title.'</h3>
                                        <p>'.$description.'</p>
                                        <div class="action mx-auto">';
                                        if (!empty($button_1)) {
                                            echo '<a href="'.$button_1['url'].'" class="btn btn-mint-outline-green">'.$button_1['title'].'</a>';
                                        }
                                        if (!empty($button_2)) {
                                            echo '<a href="'.$button_2['url'].'" class="btn btn-light-green">'.$button_2['title'].'</a>';
                                        }
                                        echo '</div>
                                    </div>
                                </div>
                                <div class="col-12 col-xxl-5 col-xl-5">';
                                    if (!empty($image)) {
                                        echo '<img src="'.$image['link'].'" alt="'.$image['title'].'" class="img-fluid cta_img">';
                                    }
                                echo '</div>
                            </div>
                        </div>
                    </section>';

            endif;

        endwhile;

    else :
        echo '<p>No content found</p>';
    endif;

endwhile;
?>
<?php
get_footer();
end;