<?php
use Carbon_Fields\Block;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
    Container::make( 'theme_options', __( 'Custom Code', 'crb' ) )
        ->add_fields( array(
            Field::make( 'textarea', 'mos_additional_coding', 'Additional Coding' ),
        ));
    /*Container::make( 'post_meta', 'Custom Data' )
        ->where( 'post_type', '=', 'page' )
        ->add_fields( array(
            Field::make( 'map', 'crb_location' )
                ->set_position( 37.423156, -122.084917, 14 ),
            Field::make( 'sidebar', 'crb_custom_sidebar' ),
            Field::make( 'image', 'crb_photo' ),
        ));*/
    Block::make( __( 'Mos Product Block' ) )
    ->add_fields( array(
        Field::make( 'select', 'mos-media-source', __( 'Product' ) )
            ->set_options( mos_get_posts ('product')),
        Field::make( 'text', 'mos-media-btn-title', __( 'Button' ) ),
        Field::make( 'select', 'mos-media-layout', __( 'Layout' ) )
            ->set_options( array(
                'custom' => 'Custom Layout',
                'one' => 'Layout One',
                'two' => 'Two',
                'three' => 'Three',
            ))
            ->set_default_value( ['one'] ),
        Field::make( 'multiselect', 'mos-media-block-one', __( 'Block One' ) )
            ->set_options( array(
                'image' => 'Image',
                'heading' => 'Heading',
                'content' => 'Content',
                'button' => 'Button',
                'price' => 'Price'
            ))
            ->set_default_value( ['image','heading','content','button'] ),
        Field::make( 'multiselect', 'mos-media-block-two', __( 'Block Two' ) )
            ->set_options( array(
                'image' => 'Image',
                'heading' => 'Heading',
                'content' => 'Content',
                'button' => 'Button',
                'price' => 'Price'
            )),
        Field::make( 'select', 'mos-media-alignment', __( 'Content Alignment' ) )
            ->set_options( array(
                'left' => 'Left',
                'right' => 'Right',
                'center' => 'Center',
            )),
    ))
    ->set_icon( 'id-alt' )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        ?>
        <div class="mos-media-block-wrapper <?php echo (@$attributes['className'])?$attributes['className']:'' ?>">
            <?php if (@$fields['mos-media-source']) : ?>
                <?php 
                $product = wc_get_product($fields['mos-media-source']);

                ?>
                <div class="mos-media-block position-relative text-<?php echo esc_html( $fields['mos-media-alignment'] ) ?>">    
                    <?php if (sizeof($fields['mos-media-block-one'])) : ?>
                    <div class="part-one">  
                        <?php foreach($fields['mos-media-block-one'] as $part_1) : ?>
                            <?php if ($part_1 == 'image' && $product->get_image_id()) : ?>
                                <div class="img-part"><?php echo wp_get_attachment_image( $product->get_image_id(), 'full' ); ?></div>
                            <?php elseif ($part_1 == 'heading' && $product->get_title()) : ?>
                                <h4 class="title-part"><?php echo $product->get_title() ?></h4>
                            <?php elseif ($part_1 == 'price' && $product->get_price_html()) : ?>
                                <div class="price-part"><?php echo $product->get_price_html(); ?></div>
                            <?php elseif ($part_1 == 'content' && $product->get_short_description()) :?>
                                <div class="desc"><?php echo $product->get_short_description(); ?></div> 
                            <?php elseif ($part_1 == 'button' && $fields['mos-media-btn-title']) :?>   
                                <div class="wp-block-buttons"><div class="wp-block-button"><span class="wp-block-button__link"><?php echo do_shortcode( $fields['mos-media-btn-title'] ); ?></span></div></div> 
                            <?php endif;?>
                        <?php endforeach;?>              
                    </div>
                    <?php endif?>
                    <?php if (sizeof($fields['mos-media-block-two'])) : ?>
                    <div class="part-two">
                        <?php foreach($fields['mos-media-block-two'] as $part_2) : ?>
                            <?php if ($part_2 == 'image' && $product->get_image_id()) : ?>
                                <div class="img-part"><?php echo wp_get_attachment_image( $product->get_image_id(), 'full' ); ?></div>
                            <?php elseif ($part_2 == 'heading' && $product->get_title()) : ?>
                                <h4 class="title-part"><?php echo $product->get_title() ?></h4>
                            <?php elseif ($part_2 == 'price' && $product->get_price_html()) : ?>
                                <div class="price-part"><?php echo $product->get_price_html(); ?></div>
                            <?php elseif ($part_2 == 'content' && $product->get_short_description()) :?>
                                <div class="desc"><?php echo $product->get_short_description(); ?></div> 
                            <?php elseif ($part_2 == 'button' && $fields['mos-media-btn-title']) :?>   
                                <div class="wp-block-buttons"><div class="wp-block-button"><span class="wp-block-button__link"><?php echo do_shortcode( $fields['mos-media-btn-title'] ); ?></span></div></div> 
                            <?php endif;?>
                        <?php endforeach;?>               
                    </div>                        
                        <a href="<?php echo get_the_permalink($fields['mos-media-source']) ?>" class="hidden-link">Read More</a>                        
                    <?php endif?>
                </div>
            <?php endif?>
        </div>
        <?php
    });
    Block::make( __( 'Mos Product Category Block' ) )
    ->add_fields( array(
        Field::make( 'select', 'mos-media-source', __( 'Category' ) )
            ->set_options(mos_get_terms ('product_cat', 'small')),
        Field::make( 'text', 'mos-media-btn-title', __( 'Button' ) ),
        Field::make( 'select', 'mos-media-layout', __( 'Layout' ) )
            ->set_options( array(
                'custom' => 'Custom Layout',
                'one' => 'Layout One',
                'two' => 'Two',
                'three' => 'Three',
            ))
            ->set_default_value( ['one'] ),
        Field::make( 'multiselect', 'mos-media-block-one', __( 'Block One' ) )
            ->set_options( array(
                'image' => 'Image',
                'heading' => 'Heading',
                'content' => 'Content',
                'button' => 'Button',
            ))
            ->set_default_value( ['image','heading','content','button'] ),
        Field::make( 'multiselect', 'mos-media-block-two', __( 'Block Two' ) )
            ->set_options( array(
                'image' => 'Image',
                'heading' => 'Heading',
                'content' => 'Content',
                'button' => 'Button',
            )),
        Field::make( 'select', 'mos-media-alignment', __( 'Content Alignment' ) )
            ->set_options( array(
                'left' => 'Left',
                'right' => 'Right',
                'center' => 'Center',
            )),
    ))
    ->set_icon( 'id-alt' )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        ?>
        <div class="mos-media-block-wrapper <?php echo (@$attributes['className'])?$attributes['className']:'' ?>">
            <?php if (@$fields['mos-media-source']) : ?>
                <?php
                //var_dump(intval($fields['mos-media-source']));
                $term = get_term($fields['mos-media-source'], 'product_cat');
                $thumbnail_id = get_woocommerce_term_meta( $fields['mos-media-source'], 'thumbnail_id', true );
                ?>
                <div class="mos-media-block position-relative text-<?php echo esc_html( $fields['mos-media-alignment'] ) ?>">    
                    <?php if (sizeof($fields['mos-media-block-one'])) : ?>
                    <div class="part-one">  
                        <?php foreach($fields['mos-media-block-one'] as $part_1) : ?>
                            <?php if ($part_1 == 'image' && $thumbnail_id) : ?>
                                <div class="img-part"><?php echo wp_get_attachment_image( $thumbnail_id, 'full' ); ?></div>
                            <?php elseif ($part_1 == 'heading' && $term->name) : ?>
                                <h4 class="title-part"><?php echo $term->name; ?></h4>
                            <?php elseif ($part_1 == 'content' && $term->description) :?>
                                <div class="desc"><?php echo $term->description; ?></div> 
                            <?php elseif ($part_1 == 'button' && $fields['mos-media-btn-title']) :?>   
                                <div class="wp-block-buttons"><div class="wp-block-button"><span class="wp-block-button__link"><?php echo do_shortcode( $fields['mos-media-btn-title'] ); ?></span></div></div> 
                            <?php endif;?>
                        <?php endforeach;?>              
                    </div>
                    <?php endif?>
                    <?php if (sizeof($fields['mos-media-block-two'])) : ?>
                    <div class="part-two">
                        <?php foreach($fields['mos-media-block-two'] as $part_2) : ?>
                            <?php if ($part_2 == 'image' && $thumbnail_id) : ?>
                                <div class="img-part"><?php echo wp_get_attachment_image( $thumbnail_id, 'full' ); ?></div>
                            <?php elseif ($part_2 == 'heading' && $term->name) : ?>
                                <h4 class="title-part"><?php echo $term->name; ?></h4>
                            <?php elseif ($part_2 == 'content' && $term->description) :?>
                                <div class="desc"><?php echo $term->description; ?></div> 
                            <?php elseif ($part_2 == 'button' && $fields['mos-media-btn-title']) :?>   
                                <div class="wp-block-buttons"><div class="wp-block-button"><span class="wp-block-button__link"><?php echo do_shortcode( $fields['mos-media-btn-title'] ); ?></span></div></div> 
                            <?php endif;?>
                        <?php endforeach;?>               
                    </div>
                        
                        <a href="<?php echo get_term_link( intval($fields['mos-media-source']), 'product_cat' ); ?>" class="hidden-link">Read More</a>
                        
                    <?php endif?>
                </div>
            <?php endif?>
        </div>
        <?php
    });
    Block::make( __( 'Mos Media Block' ) )
    ->add_fields( array(
        Field::make( 'image', 'mos-media-image', __( 'Image' ) ),
        Field::make( 'text', 'mos-media-icon-class', __( 'Icon Class' ) ),
        Field::make( 'textarea', 'mos-media-svg', __( 'SVG Code' ) ),
        Field::make( 'text', 'mos-media-heading', __( 'Heading' ) ),
        Field::make( 'rich_text', 'mos-media-content', __( 'Content' ) ),
        Field::make( 'text', 'mos-media-btn-title', __( 'Button' ) ),
        Field::make( 'text', 'mos-media-btn-url', __( 'URL' ) ),
        Field::make( 'select', 'mos-media-layout', __( 'Layout' ) )
            ->set_options( array(
                'custom' => 'Custom Layout',
                'one' => 'Layout One',
                'two' => 'Two',
                'three' => 'Three',
            ))
            ->set_default_value( ['one'] ),
        Field::make( 'multiselect', 'mos-media-block-one', __( 'Block One' ) )
            ->set_options( array(
                'image' => 'Image',
                'icon' => 'Icon',
                'svg' => 'SVG',
                'heading' => 'Heading',
                'content' => 'Content',
                'button' => 'Button',
            ))
            ->set_default_value( ['image','icon','svg','heading','content','button'] ),
        Field::make( 'multiselect', 'mos-media-block-two', __( 'Block Two' ) )
            ->set_options( array(
                'image' => 'Image',
                'icon' => 'Icon',
                'svg' => 'SVG',
                'heading' => 'Heading',
                'content' => 'Content',
                'button' => 'Button',
            )),
        Field::make( 'select', 'mos-media-alignment', __( 'Content Alignment' ) )
            ->set_options( array(
                'left' => 'Left',
                'right' => 'Right',
                'center' => 'Center',
            )),
    ))
    ->set_icon( 'id-alt' )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        ?>
        <div class="mos-media-block-wrapper <?php echo (@$attributes['className'])?$attributes['className']:'' ?>">
            <div class="mos-media-block position-relative text-<?php echo esc_html( $fields['mos-media-alignment'] ) ?>">    
                <?php if (sizeof($fields['mos-media-block-one'])) : ?>
                <div class="part-one">  
                    <?php foreach($fields['mos-media-block-one'] as $part_1) : ?>
                        <?php if ($part_1 == 'image' && $fields['mos-media-image']) : ?>
                            <div class="img-part"><?php echo wp_get_attachment_image( $fields['mos-media-image'], 'full' ); ?></div>
                        <?php elseif ($part_1 == 'icon' && $fields['mos-media-icon-class']) : ?>
                            <span class="icon-part"><i class="<?php echo esc_html( $fields['mos-media-icon-class'] ); ?>"></i></span>
                        <?php elseif ($part_1 == 'svg' && $fields['mos-media-svg']) : ?>
                            <span class="svg-part"><?php echo $fields['mos-media-svg']; ?></span>
                        <?php elseif ($part_1 == 'heading' && $fields['mos-media-heading']) : ?>
                            <h4 class="title-part"><?php echo esc_html( $fields['mos-media-heading'] ); ?></h4>
                        <?php elseif ($part_1 == 'content' && $fields['mos-media-content']) :?>
                            <div class="desc"><?php echo apply_filters( 'the_content', $fields['mos-media-content'] ); ?></div> 
                        <?php elseif ($part_1 == 'button' && $fields['mos-media-btn-title']) :?>   
                            <div class="wp-block-buttons"><div class="wp-block-button"><span class="wp-block-button__link"><?php echo do_shortcode( $fields['mos-media-btn-title'] ); ?></span></div></div> 
                        <?php endif;?>
                    <?php endforeach;?>              
                </div>
                <?php endif?>
                <?php if (sizeof($fields['mos-media-block-two'])) : ?>
                <div class="part-two">
                    <?php foreach($fields['mos-media-block-two'] as $part_2) : ?>
                        <?php if ($part_2 == 'image' && $fields['mos-media-image']) : ?>
                            <div class="img-part"><?php echo wp_get_attachment_image( $fields['mos-media-image'], 'full' ); ?></div>
                        <?php elseif ($part_2 == 'icon' && $fields['mos-media-icon-class']) : ?>
                            <span class="icon-part"><i class="<?php echo esc_html( $fields['mos-media-icon-class'] ); ?>"></i></span>
                        <?php elseif ($part_2 == 'svg' && $fields['mos-media-svg']) : ?>
                            <span class="svg-part"><?php echo $fields['mos-media-svg']; ?></span>
                        <?php elseif ($part_2 == 'heading' && $fields['mos-media-heading']) : ?>
                            <h4 class="title-part"><?php echo esc_html( $fields['mos-media-heading'] ); ?></h4>
                        <?php elseif ($part_2 == 'content' && $fields['mos-media-content']) :?>
                            <div class="desc"><?php echo apply_filters( 'the_content', $fields['mos-media-content'] ); ?></div> 
                        <?php elseif ($part_2 == 'button' && $fields['mos-media-btn-title']) :?>   
                            <div class="wp-block-buttons"><div class="wp-block-button"><span class="wp-block-button__link"><?php echo do_shortcode( $fields['mos-media-btn-title'] ); ?></span></div></div> 
                        <?php endif;?>
                    <?php endforeach;?>               
                </div>
                    <?php if ($fields['mos-media-btn-url']): ?>
                        <a href="<?php echo esc_url( $fields['mos-media-btn-url'] ); ?>" class="hidden-link">Read More</a>
                    <?php endif?>
                <?php endif?>
            </div>
        </div>
        <?php
    });
    Block::make( __( 'Mos Image Block' ) )
    ->add_fields( array(
        Field::make( 'text', 'mos-image-heading', __( 'Heading' ) ),
        Field::make( 'image', 'mos-image-media', __( 'Image' ) ),
        Field::make( 'rich_text', 'mos-image-content', __( 'Content' ) ),
        Field::make( 'text', 'mos-image-btn-title', __( 'Button' ) ),
        Field::make( 'text', 'mos-image-btn-url', __( 'URL' ) ),
        Field::make( 'select', 'mos-image-alignment', __( 'Content Alignment' ) )
            ->set_options( array(
                'left' => 'Left',
                'right' => 'Right',
                'center' => 'Center',
            ))
    ))
    ->set_icon( 'id-alt' )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        ?>
        <div class="mos-image-block-wrapper <?php echo $attributes['className'] ?>">
            <div class="mos-image-block text-<?php echo esc_html( $fields['mos-image-alignment'] ) ?>">                
                <?php if ($fields['mos-image-media']) : ?>
                    <div class="img-part"><?php echo wp_get_attachment_image( $fields['mos-image-media'], 'full' ); ?></div>
                <?php endif?>
                <div class="text-part">
                    <?php if ($fields['mos-image-heading']) : ?>
                        <h4><?php echo esc_html( $fields['mos-image-heading'] ); ?></h4>
                    <?php endif?>                 
                    <?php if ($fields['mos-image-content']) :?>
                        <div class="desc"><?php echo apply_filters( 'the_content', $fields['mos-image-content'] ); ?></div> 
                    <?php endif?>                 
                    <?php if ($fields['mos-image-btn-title'] && $fields['mos-image-btn-url']) :?>   
                        <div class="wp-block-buttons"><div class="wp-block-button"><a href="<?php echo esc_url( $fields['mos-image-btn-url'] ); ?>" title="" class="wp-block-button__link"><?php echo do_shortcode( $fields['mos-image-btn-title'] ); ?></a></div></div>  
                    <?php endif?>                 
                </div>
            </div>
        </div>
        <?php
    });
    Block::make( __( 'Mos Icon Block' ) )
    ->add_fields( array(
        Field::make( 'text', 'mos-icon-heading', __( 'Heading' ) ),
        Field::make( 'text', 'mos-icon-class', __( 'Icon Class' ) ),
        Field::make( 'color', 'mos-icon-color', __( 'Color' ) ),
        Field::make( 'rich_text', 'mos-icon-content', __( 'Content' ) ),
        Field::make( 'text', 'mos-icon-btn-title', __( 'Button' ) ),
        Field::make( 'text', 'mos-icon-btn-url', __( 'URL' ) ),
        Field::make( 'select', 'mos-icon-alignment', __( 'Content Alignment' ) )
            ->set_options( array(
                'left' => 'Left',
                'right' => 'Right',
                'center' => 'Center',
            ))
    ))
    ->set_description( __( 'Use Font Awesome in <b>Icon class</b>, you can find Fontawesome <a href="https://fontawesome.com/v4.7.0/cheatsheet/">Here</a>.' ) )
    ->set_icon( 'editor-customchar' )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        ?>
        <div class="mos-icon-block-wrapper <?php echo $attributes['className'] ?>">
            <div class="mos-icon-block text-<?php echo esc_html( $fields['mos-icon-alignment'] ) ?>">
                <?php if ($fields['mos-icon-class']) : ?>
                <div class="icon-part"><i class="fa <?php echo esc_html( $fields['mos-icon-class'] ); ?>" style="--color:<?php echo esc_html( $fields['mos-icon-color'] ); ?>"></i></div>
                <?php endif;?>
                <div class="text-part">
                    <?php if ($fields['mos-icon-heading']) : ?>
                        <h4><?php echo esc_html( $fields['mos-icon-heading'] ); ?></h4>
                    <?php endif;?>
                    <?php if ($fields['mos-icon-content']) : ?>
                        <div class="desc"><?php echo  $fields['mos-icon-content']; ?></div>                    
                    <?php endif;?>                 
                    <?php if ($fields['mos-icon-btn-title'] && $fields['mos-icon-btn-url']) :?>   
                        <div class="wp-block-buttons"><div class="wp-block-button"><a href="<?php echo esc_url( $fields['mos-icon-btn-url'] ); ?>" title="" class="wp-block-button__link"><?php echo esc_html( $fields['mos-icon-btn-title'] ); ?></a></div></div>  
                    <?php endif?> 
                </div>
            </div>
        </div>
        <?php
    });
    Block::make( __( 'Mos SVG Block' ) )
    ->add_fields( array(
        Field::make( 'text', 'mos-svg-heading', __( 'Heading' ) ),
        Field::make( 'textarea', 'mos-svg-svg', __( 'SVG Code' ) ),
        Field::make( 'rich_text', 'mos-svg-content', __( 'Content' ) ),
        Field::make( 'text', 'mos-svg-btn-title', __( 'Button' ) ),
        Field::make( 'text', 'mos-svg-btn-url', __( 'URL' ) ),
        Field::make( 'select', 'mos-svg-alignment', __( 'Content Alignment' ) )
            ->set_options( array(
                'left' => 'Left',
                'right' => 'Right',
                'center' => 'Center',
            ))
    ))
    ->set_icon( 'editor-customchar' )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        ?>
        <div class="mos-svg-block-wrapper <?php echo $attributes['className'] ?>">
            <div class="mos-svg-block text-<?php echo esc_html( $fields['mos-svg-alignment'] ) ?>">
                <?php if ($fields['mos-svg-class']) : ?>
                <div class="svg-part"><?php echo $fields['mos-svg-class']; ?></div>
                <?php endif;?>
                <div class="text-part">
                    <?php if ($fields['mos-svg-heading']) : ?>
                        <h4><?php echo esc_html( $fields['mos-svg-heading'] ); ?></h4>
                    <?php endif;?>
                    <?php if ($fields['mos-svg-content']) : ?>
                        <div class="desc"><?php echo  $fields['mos-svg-content']; ?></div>                    
                    <?php endif;?>                 
                    <?php if ($fields['mos-svg-btn-title'] && $fields['mos-svg-btn-url']) :?>   
                        <div class="wp-block-buttons"><div class="wp-block-button"><a href="<?php echo esc_url( $fields['mos-svg-btn-url'] ); ?>" title="" class="wp-block-button__link"><?php echo esc_html( $fields['mos-svg-btn-title'] ); ?></a></div></div>  
                    <?php endif?> 
                </div>
            </div>
        </div>
        <?php
    });
    Block::make( __( 'Mos Counter Block' ) )
    ->add_fields( array(
        Field::make( 'text', 'mos-counter-prefix', __( 'Prefix' ) ),
        Field::make( 'text', 'mos-counter-number', __( 'Number' ) ),
        Field::make( 'text', 'mos-counter-suffix', __( 'Suffix' ) ),
        Field::make( 'color', 'mos-counter-color', __( 'Heading Color' ) ),
        Field::make( 'color', 'mos-counter-text-color', __( 'Text Color' ) ),
        Field::make( 'textarea', 'mos-counter-content', __( 'Content' ) ),
        Field::make( 'select', 'mos-counter-alignment', __( 'Content Alignment' ) )
            ->set_options( array(
                'left' => 'Left',
                'right' => 'Right',
                'center' => 'Center',
            ))
    ))
    ->set_icon( 'clock' )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        ?>
        <div class="mos-counter-block-wrapper <?php echo $attributes['className'] ?>">
            <div class="mos-counter-block text-<?php echo esc_html( $fields['mos-counter-alignment'] ) ?>">
                <h2 style="color: <?php echo esc_html( $fields['mos-counter-color'] ); ?>"><span class="prefix"><?php echo esc_html( $fields['mos-counter-prefix'] ); ?></span><span class='numscroller counter' data-min='1' data-counterup-time="1500"><?php echo esc_html( $fields['mos-counter-number'] ); ?></span><span class="suffix"><?php echo esc_html( $fields['mos-counter-suffix'] ); ?></span></h2>
                <div class="mb-0" style="color: <?php echo esc_html( $fields['mos-counter-text-color'] ); ?>"><?php echo esc_html( $fields['mos-counter-content'] ); ?></div>
            </div>
        </div>
        <?php
    });
    Block::make( __( 'Mos Pricing Block' ) )
    ->add_fields( array(
        Field::make( 'text', 'mos-pricing-title', __( 'Heading' ) ),
        Field::make( 'text', 'mos-pricing-symbol', __( 'Symbol' ) ),
        Field::make( 'text', 'mos-pricing-amount', __( 'Amount' ) ),
        Field::make( 'text', 'mos-pricing-period', __( 'Period' ) )
            ->set_attribute( 'placeholder', 'Ex: per clean / billed weekly' ),
        Field::make( 'text', 'mos-pricing-subtitle', __( 'Sub Heading' ) ),
        Field::make( 'textarea', 'mos-pricing-desc', __( 'Desacription' ) ),
        Field::make( 'complex', 'mos-pricing-features', __( 'Features' ) )
            ->add_fields( array(
                Field::make( 'text', 'item', __( 'Feature' ) ),
            )),
        Field::make( 'text', 'mos-pricing-btn-title', __( 'Button' ) ),
        Field::make( 'text', 'mos-pricing-btn-url', __( 'URL' ) ),
        Field::make( 'select', 'mos-pricing-alignment', __( 'Content Alignment' ) )
        ->set_options( array(
            'left' => 'Left',
            'right' => 'Right',
            'center' => 'Center',
        ))
    ))
    ->set_icon( 'list-view' )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        ?>
        <div class="mos-pricing-wrapper <?php echo $attributes['className'] ?>">
            <div class="mos-pricing text-<?php echo esc_html( $fields['mos-pricing-alignment'] ) ?>">            
                <div class="title-part">
                    <h3><?php echo esc_html( $fields['mos-pricing-title'] ); ?></h3>
                </div>
                <div class="pricing-part">
                    <div class="pricing-value"> <span class="pricing-symbol"><?php echo esc_html( $fields['mos-pricing-symbol'] ); ?></span> <span class="pricing-amount"><?php echo esc_html( $fields['mos-pricing-amount'] ); ?></span> <span class="plan-period"><?php echo esc_html( $fields['mos-pricing-period'] ); ?></span>
                    </div>
                </div>
                <?php if (@$fields['mos-pricing-subtitle']) : ?>
                    <h5 class="desc-subtitle"><?php echo esc_html( $fields['mos-pricing-subtitle'] ); ?></h5>
                <?php endif?>
                <?php if (@$fields['mos-pricing-desc']) : ?>
                    <div class="desc-part"><?php echo esc_html( $fields['mos-pricing-desc'] ); ?></div>
                <?php endif?>
                <?php if (sizeof(@$fields['mos-pricing-features'])) : ?>
                <div class="features-part">
                    <ul class="pricing-features">
                        <?php foreach ($fields['mos-pricing-features'] as $value) : ?>
                            <li><?php echo $value['item'] ?></li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <?php endif?>
                <?php if(@$fields['mos-pricing-btn-title'] && @$fields['mos-pricing-btn-url']) : ?>
                <div class="wp-block-buttons"><div class="wp-block-button"><a href="<?php echo esc_html( $fields['mos-pricing-btn-url'] ); ?>" title="" class="wp-block-button__link"><?php echo esc_html( $fields['mos-pricing-btn-title'] ); ?></a></div></div>
                <?php endif;?>
            
            </div>
        </div>
        <?php
    });
    Block::make( __( 'Mos Before After Block' ) )
    ->add_fields( array(
        Field::make( 'image', 'before_image', __( 'Before Image' ) ),
        Field::make( 'image', 'after_image', __( 'After Image' ) ),
        Field::make( 'text', 'before_text', __( 'Before Text' ) ),
        Field::make( 'text', 'after_text', __( 'After Text' ) ),
    ))
    ->set_icon( 'format-gallery' )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        ?>
        <div class="mos-beforeafter-block-wrapper <?php echo $attributes['className'] ?>">
            <div class="mos-beforeafter-block">
                <?php if ($fields['before_image'] && $fields['after_image']) : ?>
                <?php
                $before_alt = get_post_meta($fields['before_image'], '_wp_attachment_image_alt', TRUE);
                $before_text = ($fields['before_text'])?$fields['before_text']:'Before';
                $after_alt = get_post_meta($fields['after_image'], '_wp_attachment_image_alt', TRUE);
                $after_text = ($fields['after_text'])?$fields['after_text']:'After';                 
                ?>
                <div  class="beer-slider" data-beer-label="<?php echo $before_text ?>" data-start="50">
                    <?php echo wp_get_attachment_image( $fields['before_image'], 'full', false, ['class'=>'before-image'] ); ?>
                    <div class="beer-reveal" data-beer-label="<?php echo $after_text ?>">                        
                        <?php echo wp_get_attachment_image( $fields['after_image'], 'full', false, ['class'=>'after-image'] ); ?>
                    </div>
                </div>
                <?php else : ?>
                <div class="text-center border rounded-3 p-10">Please add before and after images for this section</div>
                <?php endif?>
            </div>
        </div>
        <?php
    }); Block::make( __( 'Mos Carousel Block' ) )
    ->add_fields( array(
        Field::make( 'select', 'image-carousel-grid', __( 'Large Device Grid' ) )
        ->set_options( array(
            '1' => 'Single Column',
            '2' => 'Two Column',
            '3' => 'Three Column',
            '4' => 'Four Column',
            '5' => 'Five Column',
        )),
        Field::make( 'select', 'image-carousel-grid-md', __( 'Medium Device Grid' ) )
        ->set_options( array(
            '1' => 'Single Column',
            '2' => 'Two Column',
            '3' => 'Three Column',
            '4' => 'Four Column',
            '5' => 'Five Column',
        )),
        Field::make( 'select', 'image-carousel-grid-sm', __( 'Small Device Grid' ) )
        ->set_options( array(
            '1' => 'Single Column',
            '2' => 'Two Column',
            '3' => 'Three Column',
            '4' => 'Four Column',
            '5' => 'Five Column',
        )),
        Field::make( 'select', 'image-carousel-autoplay', __( 'Autoplay' ) )
        ->set_options( array(
            'true' => 'Enable',
            'false' => 'Disable'
        )),
        Field::make( 'text', 'image-carousel-autoplay-speed', __( 'Autoplay Speed' ) )
            ->set_attribute( 'placeholder', '2000' ),
        Field::make( 'complex', 'image-carousel-slider', __( 'Services' ) )
            ->add_fields( array(
                Field::make( 'text', 'title', __( 'Title' ) ),
                Field::make( 'rich_text', 'content', __( 'Content' ) ),
                Field::make( 'image', 'media', __( 'Image' ) ),
                Field::make( 'text', 'btn-text', __( 'Button Text' ) ),
                Field::make( 'text', 'btn-url', __( 'Button URL' ) ),                
                Field::make( 'select', 'alignment', __( 'Content Alignment' ) )
                ->set_options( array(
                    'left' => 'Left',
                    'right' => 'Right',
                    'center' => 'Center',
                )),
                
            )),
        
    ))
    ->set_icon( 'format-gallery' )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        ?>
        <div class="mos-image-carousel-block-wrapper <?php echo (@$attributes['className'])?$attributes['className']:'' ?>">
            <?php //var_dump($fields['image-carousel-slider']);?>
            <?php if (sizeof($fields['image-carousel-slider'])) : ?>
            <?php
            $slidesToScroll = ($fields['image-carousel-grid'])?$fields['image-carousel-grid']:1;
            $slidesToScroll_782 = ($fields['image-carousel-grid-md'])?$fields['image-carousel-grid-md']:1;
            $slidesToScroll_600 = ($fields['image-carousel-grid-sm'])?$fields['image-carousel-grid-sm']:1;
        
            $autoplay = ($fields['image-carousel-autoplay'])?$fields['image-carousel-autoplay']:true;
            $autoplaySpeed = ($fields['image-carousel-autoplay-speed'])?$fields['image-carousel-autoplay-speed']:2000;
            $cls = 'slick-slider';
            $data_slick = '{"slidesToShow": '.$slidesToScroll.',"slidesToScroll": 1,"autoplay": '.$autoplay.',"autoplaySpeed": '.$autoplaySpeed.',"dots": false,"arrows":true,"responsive": [{"breakpoint": 782,"settings": {"slidesToShow": '.$slidesToScroll_782.',"slidesToScroll": 1}},{"breakpoint": 600,"settings": {"arrows": true,"dots": false,"slidesToShow": '.$slidesToScroll_600.',"slidesToScroll": 1}}]}';
            
            ?>
            <div class="mos-image-carousel-block <?php echo $cls ?>" data-slick='<?php echo $data_slick ?>'>
                <?php foreach($fields['image-carousel-slider'] as $slide) : ?>
                    <div class="item position-relative" id="item-<?php echo $slide['_id']?>" style="background-image: url(<?php echo wp_get_attachment_url($slide['media']) ?>)">
                        <?php //if ($slide['media']) : ?>
                            <?php //echo wp_get_attachment_image($slide['media'],'full',false,array('class'=>'slick-item-img'))?>
                        <?php //endif?>
                        <div class="text-wrapper text-<?php echo esc_html( $slide['alignment'] ) ?>">
                            <?php if ($slide['title']) :?>
                                <h2 class="mos-image-carousel-title"><?php echo do_shortcode($slide['title']); ?></h2>
                            <?php endif?>
                            <?php if ($slide['content']) :?>
                                <div class="mos-image-carousel-content"><?php echo do_shortcode($slide['content']); ?></div>
                            <?php endif?>
                            <?php if ($slide['btn-text']) :?>
                                <div class="wp-block-buttons"><div class="wp-block-button"><span class="wp-block-button__link"><?php echo do_shortcode($slide['btn-text']); ?></span></div></div>
                            <?php endif?>                        
                        </div>
                        <?php if ($slide['btn-url']) :?>
                            <a href="<?php echo esc_url(do_shortcode($slide['btn-url'])); ?>" class="hidden-link"></a>
                        <?php endif?>
                    </div>
                <?php endforeach;?>
            </div>
            <?php endif;?>
        </div>
        <?php
    });
    Block::make( __( 'Mos 3 Column CTA' ) )
    ->add_fields( array(
        Field::make( 'text', 'mos-3ccta-heading', __( 'Heading' ) ),        
        Field::make( 'image', 'mos-3ccta-media', __( 'Image' ) ),
        Field::make( 'text', 'mos-3ccta-link', __( 'Link' ) ),
        Field::make( 'textarea', 'mos-3ccta-content', __( 'Content' ) ),
        Field::make( 'image', 'mos-3ccta-bgimage', __( 'Background Image' ) ),
        Field::make( 'color', 'mos-3ccta-bgcolor', __( 'Background Color' ) ),
    ))
    ->set_icon( 'phone' )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        ?>
        <div class="mos-3ccta-wrapper <?php echo $attributes['className'] ?>" style="<?php if ($fields['mos-3ccta-bgcolor']) echo 'background-color:'.esc_html($fields['mos-3ccta-bgcolor']).';' ?><?php if ($fields['mos-3ccta-bgimage']) echo 'background-image:url('.wp_get_attachment_url($fields['mos-3ccta-bgimage']).');' ?>">
            <div class="mos-3ccta">
                <div class="call-left">
                    <h3><?php echo esc_html( $fields['mos-3ccta-heading'] ); ?></h3>
                </div>
                <div class="call-center">
                    <a href="<?php echo esc_url( $fields['mos-3ccta-link'] ); ?>" class="" target="_blank"><?php echo wp_get_attachment_image( $fields['mos-3ccta-media'], 'full' ); ?></a>
                </div>
                <div class="call-right">
                    <div class="desc"><?php echo esc_html( $fields['mos-3ccta-content'] ); ?></div>
                </div>
            </div>
        </div>
        <?php
    });
}
add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    require_once( 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}