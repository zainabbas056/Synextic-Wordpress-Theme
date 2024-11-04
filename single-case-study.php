<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package synextic
 */

get_header('black');
?>

    <?php
    while ( have_posts() ) :
        the_post();

        if( have_rows('case_study_content') ): // Replace 'flexible_content_field_name' with your ACF field name

            while( have_rows('case_study_content') ) : the_row();
				
                // Check the current row layout
                if( get_row_layout() == 'subtitle_and_key_points' ):

					$subtitle=get_sub_field('subtitle');
					$key_points=get_sub_field('key_points');


					$html ='	<div class="case-header ">
									<div class="container-17">
											<div class="row">
												<div class="col-12">
													<div class="shadow--img">

														<img src="'.wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())).'" class="img-fluid">
													</div>

												</div>

												<div class="col-12">
													<div class="case-title">
														<span>'.$subtitle.'</span>
														<h3>'.get_the_title().'</h3>
													</div>

													<div class="more-meta grid-5">';
														if(!empty($key_points)){
															foreach($key_points as $data){
					$html .='											
																<div class="grid-meta">
																	<span>'.$data['title'].'</span>
																	<div class="m-tags">
																		'.$data['description'].'
																	</div>
																</div>';
															}
														}
													
					$html .='									
													</div>
												</div>
											</div>
									</div>
								</div>';
					echo $html;
                elseif( get_row_layout() == 'introchallengessolutions' ):

					$heading = get_sub_field('heading');
					$subheading = get_sub_field('subheading');
					$direction_type = get_sub_field('direction_type');
					$main_title = get_sub_field('main_title');
					$description = get_sub_field('description');
					$image = get_sub_field('image');

					if(empty($direction_type)){
						$direction_type = "LTR";
					}
                    $html= '<section>
								<div class="container-17">
									<div class="row">
										<div class="col-12 col-xl-6 mx-auto">
											<div class="section_heading text-center">
												<h3>'.$heading.'</h3>
												<p>'.$subheading.'</p>
											</div>
										</div>
									</div>

									<div class="row pt-60 align-items-center rv-flex">';
										if(isset($direction_type) && $direction_type == "LTR"){
					$html.= '						
											<div class="col-12 col-lg-7">
												<div class="simple-text pr-d-80">
													<h4>'.$main_title.'</h4>
													<p>'.$description.'</p>
												</div>
											</div>


											<div class="col-12 col-lg-5">
												<div class="shadow--img">
													<img src="'.$image['url'].'" alt="'.$image['title'].'" class="img-fluid">
												</div>

											</div>';
										}else{
					$html.= '				
												<div class="col-12 col-lg-5">
													<div class="shadow--img">
														<img src="'.$image['url'].'" alt="'.$image['title'].'" class="img-fluid">
													</div>

												</div>
												<div class="col-12 col-lg-7">
													<div class="simple-text pl-d-80">
														<h4>'.$main_title.'</h4>
														<p>'.$description.'</p>
													</div>
												</div>';
										}
					$html.= '					
									</div>
								</div>
							</section>';
					echo $html;
	
				elseif( get_row_layout() == 'key_features' ):
					
					$title = get_sub_field('title');
					$description = get_sub_field('description');					
					$service_intro_columns = get_sub_field('key_features_columns');

	
	
					$html= '<section class="about-section-first bg_lightgray">
								 <div class="container-17">
										<div class="row">
										<div class="col-12 col-xl-5 mx-auto">
												<div class="section__heading text-center">
													<h3>'.$title.'</h3>
													<p>'.$description.'</p>
												</div>
											</div>
									 </div>


									<div class="row pt-60">';     
										if(!empty($service_intro_columns)){
											foreach($service_intro_columns as $data){
					$html.= '							
												<div class="col-12 col-xl-4 col-lg-4">
													<div class="grid-col ser_page">
														<div class="base">
															<div class="icon">
																<img src="'.$data['icon']['url'].'" alt="'.$data['icon']['title'].'">
															</div>
															<h5>'.$data['title'].'</h5>
															<p>'.$data['description'].'</p>
														</div>

													</div>
												</div>';
											}
										}
					$html.= '					
										
									</div>
								</div>
							</section>';
					echo $html;
	
				elseif(get_row_layout() == 'counter_section'):
					$featured_image=get_sub_field('featured_image');
					$counter_block=get_sub_field('counter_block');

					$html = '<section class="bg_lightgray">
								<div class="container-17">
									<div class="row align-items-center">
										<div class="col-12">
											 <div class="shadow--img">

											<img src="'.$featured_image['url'].'" class="img-fluid" width="100%   ">
											</div>
										</div>

										<div class="counter_area col-12">
											<div class="counetr_row case-counter">';
												if(!empty($counter_block)){
													foreach($counter_block as $data){
					$html .= '									
														<div class="counter-container ">
															<div class="counter___ ">
																'.$data['symbol_before'].'<div class="counter" data-target="'.$data['number'].'">'.$data['number'].'</div>'.$data['symbol_after'].'
															</div> 
															<span>'.$data['description'].'</span>
														</div>';
													}
												}
					$html .= '							
											</div>
										</div>
									</div>
								</div>
							</section>';
					echo  $html;
				elseif(get_row_layout() == 'other_case_studies'):
	
					$title=get_sub_field('title');
					$description=get_sub_field('description');
					
					$html= '<section class="about-section-first bg_lightgray portfolio_page pb-40">
								<div class="container-17">

									<div class="row">
										<div class="col-12 col-xl-6 mx-auto">
											<div class="section_heading text-center">

												<h3 >'.$title.'</h3>
												<p >'.$description.'</p>
											</div>
										</div>
									</div>';
									$args = array(
										'post_type'      => 'case-study', // or your custom post type
										'posts_per_page' => 2, // Number of posts to display
										'post__not_in'   => array( get_the_ID() ), // Exclude current post
										'orderby'        => 'date',
										'order'          => 'DESC',
									);

									$query = new WP_Query( $args );
					$html .= '
									<div class="row pt-60">';
										if ( $query->have_posts() ) :
                        					while ( $query->have_posts() ) : $query->the_post();
												if(function_exists('get_field')){
													$image= get_field('post_image',get_the_ID());											
												}

												if (isset($image['ID'])) {
													$post_image = wp_get_attachment_url($image['ID']);
												} 

												if(empty($post_image)){
													$post_image = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
												}
			
					$html .= '					<div class="col-12 col-lg-6 col-xl-6">
													<div class="work_item w-700">

													   <div class="work_image">
														   <a href="' . get_permalink() . '">
														   <img src="'.$post_image.'" class="img-fluid" alt="">
															   </a>
													   </div>


													   <div class="work-meta">
														   <div class="meta-name d-flex">
															   <h5>' . get_the_title() . '</h5>
														   </div>

														   <p>' . get_the_excerpt() . '</p>

															<a href="' . get_permalink() . '">Explore more<span><i class="las la-long-arrow-alt-right"></i></span></a>
													   </div>
													</div>
												</div>';
											endwhile;
                        					wp_reset_postdata();
                    					endif;
					$html .= '
									</div>
								</div>
							</section>';					
					echo  $html;
				elseif(get_row_layout() == 'talk_to_us'):
	
					$title=get_sub_field('title');
					$description=get_sub_field('description');
					$button_1=get_sub_field('button_1');
					$button_2=get_sub_field('button_2');
					$image=get_sub_field('image');

					$html = '<section class="dark_bg cta_section pb-0 pt-0"> 
								<div class="container-17">
									<div class="row align-items-center">
										<div class="col-12 col-xxl-7 col-xl-7 col-lg-7">
											<div class="warrning__ pb-95 pt-95">
												<h3 >'.$title.'</h3>
												<p >'.$description.'</p>
												<div class="action mx-auto" >';
													if(!empty($button_1)){
					$html .= '							<a href="'.$button_1['url'].'" class="btn btn-mint-outline-green">'.$button_1['title'].'</a>';
													}
													if(!empty($button_2)){
					$html .= '	                		<a href="'.$button_2['url'].'" class="btn btn-light-green">'.$button_2['title'].'</a>';
													}
					$html .= '	            	</div>
											</div>
										</div>

										 <div class="col-12 col-xxl-5 col-xl-5">';
											if(!empty($image)){
					$html .= '					<img src="'.$image['link'].'" alt="'.$image['title'].'" class="img-fluid cta_img">';
											}
					$html .= '	    	</div>
									</div>
								</div>
							</section>';
					echo $html;
	
                endif;

            endwhile;
	
        else :
            echo '<p>No content found</p>';
        endif;

    endwhile;
    ?>

<?php
get_footer();
