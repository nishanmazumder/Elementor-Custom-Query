<?php
add_action( 'elementor/query/display_related_product_by_category', function( $query ) {
	
	$queried_object = get_queried_object();
	
	if (isset($queried_object->ID) && $queried_object->post_type == 'product') {
        $post_id = $queried_object->ID;
        $categories = get_the_terms($post_id, 'product_category');

        $category_ids = array();
        foreach ($categories as $category) {
            $category_ids[] = $category->term_id;
        }
		
		$tax_query = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_category',
                    'field' => 'id',
                    'terms' => $category_ids,
                    'operator' => 'IN'
                )
            ),
            'post__not_in' => array($post_id)
        );
		
		 $query->set( 'tax_query', $tax_query );
	}
		
} );

// usage Query ID -> display_related_product_by_category
