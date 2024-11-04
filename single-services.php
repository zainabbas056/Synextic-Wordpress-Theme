<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package synextic
 */

get_header();
?>


    <?php
    while ( have_posts() ) :
        the_post();

        if( have_rows('services_content') ): // Replace 'flexible_content_field_name' with your ACF field name

            while( have_rows('services_content') ) : the_row();
                // Check the current row layout
                if( get_row_layout() == 'common_banner_section_with_button' ):

					$subtitle=get_sub_field('subtitle');
					$title=get_sub_field('titile');
					$button=get_sub_field('button');
					$side_image=get_sub_field('side_image');

					$html ='	<div class="page_header">
									<div class="container-17">
										<div class="row align-items-center">
											<div class="col-12 col-xxl-6 col-xl-6 col-lg-6">
												<div class="page_header_content">
													<span>'.$subtitle.'</span>
													<h4>'.$title.'</h4>
													<div class="action mx-auto">';
														if(!empty($button)){
					$html .='								<a href="'.$button['url'].'" class="btn btn-mint-outline-green">'.$button['title'].'</a>';
														}
					$html .='	            		</div>
												</div>
											</div>
											<div class="col-12 col-xxl-6 col-xl-6 col-lg-6">';
												if(!empty($side_image)){
					$html .='						<div class="page_header_image">
													   <img src="'.$side_image['link'].'" class="img-fluid">
													</div>';
												}
					$html .='	        	</div>
										</div>
									</div>
								</div>';
					echo $html;
                elseif( get_row_layout() == 'what_is_the_service' ):

					$subtitle = get_sub_field('subtitle');
					$title = get_sub_field('title');
					$description = get_sub_field('description');
				
                    $html= '<section class="about-section-first bg_lightgray    pb-0">
								<div class="container-17">
									<div class="row">
										<div class="col-12 col-xxl-3 col-xl-3 col-lg-4">
										  <div class="abt_heading">
												<span>'.$subtitle.'</span>
											  <h5>'.$title.'</h5>
											</div>
										</div>

										<div class="col-12 col-xxl-9 col-xl-9 col-lg-8">
											<div class="abt-short pb-3">
											    <p class="pb-0"></p>
										   		<p>'.$description.'</p>
											</div>
										</div>
									</div>
								</div>
							</section>';
				echo $html;
	
				elseif( get_row_layout() == 'service_full_intro' ):
					
					$title = get_sub_field('title');
					$description = get_sub_field('description');					
					$service_intro_columns = get_sub_field('service_intro_columns');

	
	
					$html= '<section class="about-section-first bg_lightgray">
								 <div class="container-17">
										<div class="row">
										<div class="col-12 col-xl-10 mx-auto">
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
	
				elseif(get_row_layout() == 'why_to_choose_synextic_for_service'):
					$icon=get_sub_field('icon');
					$subtitle=get_sub_field('subtitle');
					$title=get_sub_field('title');
					$description=get_sub_field('description');
					$achievements_block_1=get_sub_field('synextic_achievements_block_1');
					$achievements_block_2=get_sub_field('synextic_achievements_block_2');

					$html = '<section class="dark_bg page_secure">
								<div class="container-17">
									<div class="row align-items-center">
										<div class="col-12 col-xxl-6 col-xl-6">
											<div class="warrning__">
												<div class="icon" >';
													if(!empty($icon)){
					$html .= '							<img src="'.$icon['link'].'" class="img-fluid" alt="'.$icon['title'].'">';	
													}

					$html .= '	                </div>
												<h6 >'.$subtitle.'</h6>
												<h3 >'.$title.'</h3>
												<p>'.$description.'</p>
											</div>
										</div>

											<div class="col-12 col-xxl-6 col-xl-6">
													<div class="warrning_box">
														<div class="col_1">';
															if(!empty($achievements_block_1)){
																foreach($achievements_block_1 as $data){
					$html .= '										<div class="item" >
																		<div class="icon">
																			<img src="'.get_site_url().'/wp-content/uploads/2024/08/Circle_Check.svg" class="img-fluid" alt="Circle_Check">
																		</div>  
																		<p>'.$data['achievement_description'].'</p>
																	</div>';
																}
															}
					$html .= '							</div>
														<div class="col_1">';
															if(!empty($achievements_block_2)){
																foreach($achievements_block_2 as $data){
					$html .= '										<div class="item" >
																		<div class="icon">
																			<img src="'.get_site_url().'/wp-content/uploads/2024/08/Circle_Check.svg" class="img-fluid" alt="Circle_Check">
																		</div>  
																		<p>'.$data['achievement_description'].'</p>
																	</div>';
																}
															}
					$html .= '	            			</div>
												</div> 
										</div>
									</div>
								</div>
							</section>
							
							';
					echo  $html;
	
				elseif(get_row_layout() == 'technologies_expertise'):
					$title = get_sub_field('title');
					$description = get_sub_field('description');					
					$services = get_sub_field('services');

	
					$html=  ' <section>
								<div class="container-17">
									<div class="row">
										<div class="col-12 col-xl-6 mx-auto">
											<div class="section_heading text-center">
												<h3 >'.$title.'</h3>
												<p >'.$description.'</p>
											</div>
										</div>
									</div>


									<div class="pt-50 ">
										<div class="row">
											<div class="col-12">
												<ul class="tech-list">';
													if(!empty($services)){
														foreach($services as $data){
					$html.=  '										
															<li>
																<div class="left_tech">
																	<div class="tech_btn">
																		<img src="'.$data['sidebar_icon']['url'].'" alt="'.$data['sidebar_icon']['title'].'">
																		'.$data['sidebar_title'].'
																	</div>
																</div>


																<div class="right_tech">';
																	if(!empty($data['technologies_icons'])){
																		foreach($data['technologies_icons'] as $icons){
					$html.=  '															
																			<img src="'.$icons['icon']['link'].'">';
																		}
																	}

					$html.=  '											
																</div>
															</li>';
														}
													}
					$html.=  '
												</ul>
											</div>
										</div>
									</div>
								</div>
							</section>';
					echo $html;
				elseif(get_row_layout() == 'solutions_block'):
	
					$title = get_sub_field('title');
					$subtitle = get_sub_field('subtitle');
					$business_solutions = get_sub_field('business_solutions');
					$image = get_sub_field('image');
	
					$html = '<section class="bg_lightgray">
								<div class="container-17">
									<div class="row">
										<div class="col-12">
											<div class=" abt_tabContent_v2">
												<div class="row">
													<div class="col-12 col-xxl-4 col-xl-6">
														<div class="abt____image">
															<img src="'.$image['link'].'" class="img-fluid" alt="'.$image['title'].'">
														</div>
													</div>


													<div class="col-12 col-xxl-8 col-xl-6">
														<div class="about__content">
															 <div class="abt_heading">
																<span>'.$subtitle.'</span>
																<h5>'.$title.'</h5>
															</div>
														</div>

													   <ul class="check">';
															if(!empty($business_solutions)){
																foreach($business_solutions as $data){
					$html .= '												
																	<li>'.$data['description'].'</li>';

																}
															}
					$html .= '
														</ul>

													</div>

												</div>                        
											</div>  
										</div>
									</div>
								</div>
							</section>';
					echo $html;
				elseif(get_row_layout() == 'industries_we_serve_slider'):
	
					$title = get_sub_field('title');
					$industries_slider_block = get_sub_field('industries_slider_block');

					$html = '<section class="bg_lightgray pt-60 pb-60">
								<div class="container-fluid">
								  <div class="row">

									<div class="col-12 col-xl-6 mx-auto">
										<div class="section_heading text-center">
											<h3>'.$title.'</h3>
										</div>
									</div>


									<div class="swiper about_slide pb-3 pt-4">
										<div class="swiper-wrapper">';
											if(!empty($industries_slider_block)){
												foreach($industries_slider_block as $data){
					$html .= '						<div class="swiper-slide">
														<div class="only_box_abt">
															<span><img src="'.$data['industry_icon']['link'].'" alt="'.$data['industry_icon']['title'].'"></span>
															<span>'.$data['industry_title'].'</span>
														</div>
													</div>';
												}
											}
					$html .= '
										</div>
									</div>
								  </div>
								</div>
							</section>';
					echo $html;
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
