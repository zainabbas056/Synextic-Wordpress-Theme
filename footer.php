<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package synextic
 */

if ( function_exists('get_field') ) {
	$footer_logo =	get_field('footer_logo','options');
	$description=		get_field('description','options');
	$contact_informations=		get_field('contact_informations','options');
	$copyright_text=		get_field('copyright_text','options');
	$footer_second_menu_label=		get_field('footer_second_menu_label','options');
	$footer_third_menu_label=		get_field('footer_third_menu_label','options');
	$footer_fourth_menu_label=		get_field('footer_fourth_menu_label','options');	
	$social_icons=		get_field('social_icons','options');
}

?>
	</main>

	<footer>
        <div class="container-17">
            <div class="row">
            
                <div class="col-12 col-xxl-3 col-xl-3 col-md-6 col-lg-6">
                    <div class="footer_widget">
                        <div class="footer_logo">
                            <img src="<?= $footer_logo['link']?>" alt="<?= $footer_logo['title']?>" class="img-fluid">
                        </div>
                        
                        <p><?=$description ?> </p>
                        
                        <div class="footer_contect">
							<ul><?php 
								foreach($contact_informations as $information){?>
									<li> <a href="<?= $information['title']['url']?>"> <img src="<?= $information['icon']['url'] ?>"><?= $information['title']['title']?></a></li> <?php
								} ?>
							</ul>
                        </div>
                    </div>
                </div>
                
                
                
	            <div class="col-12 col-xxl-3 col-xl-3 col-md-6 col-lg-6">
	        		<div class="footer_widget">
	       				<h4><?=$footer_second_menu_label?></h4>  
						<?php
							synextic_header_menus("","footer_second_menu");
						?>
	                </div>
	            </div>
                <div class="col-12 col-xxl-3 col-xl-3 col-md-6 col-lg-6">
		            <div class="footer_widget">
		               	<h4><?=$footer_third_menu_label?></h4>
                        <?php
							synextic_header_menus("","footer_third_menu");
						?>
                    </div>
                </div>
                
                
                <div class="col-12 col-xxl-3 col-xl-3 col-md-6 col-lg-6">
                    <div class="footer_widget">
               			<h4><?=$footer_fourth_menu_label?></h4>
                        <?php
							synextic_header_menus("","footer_fourth_menu");
						?>
                    </div>
                </div>
                
                
                <div class="col-12 copyright">
                    <p><?= $copyright_text ?></p>   
                    
                    <div class="footer-social"><?php
						foreach($social_icons as $icons){ ?>
							<a href="<?= $icons['url']?>"><img src="<?= $icons['icon']['link'] ?>"></a> <?php
						} ?>
                    </div>
                </div>
                
            </div>
        </div>
    
    </footer>
   

<?php wp_footer(); ?>

</body>
</html>
