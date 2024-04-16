<?php
//=================================================
//Cron

//@package DivariCore
//@author  Divari <support@divari.com>
////@version 1.0.0
//=================================================



// function processHierarchicalCategoryXML($xmlFile, $parent_id = 0) {
//     global $wpdb;

//     $xml = simplexml_load_file($xmlFile);

//     // Process XML data
//     foreach ($xml->category as $category) {
//         $category_name = (string)$category->name;
//         $category_slug = sanitize_title($category_name);

//         // Check if the category already exists
//         $existing_category = get_term_by('slug', $category_slug, 'product_cat');

//         if ($existing_category) {
//             // Category already exists, update it if needed
//             $category_id = $existing_category->term_id;

//             // Update category properties if needed
//             // For example: update_term_meta($category_id, 'custom_field', (string)$category->custom_field);
//         } else {
//             // Category doesn't exist, insert it
//             $category_id = wp_insert_term(
//                 $category_name,
//                 'product_cat',
//                 array(
//                     'slug' => $category_slug,
//                     'parent' => $parent_id,
//                 )
//             );

//             if (is_array($category_id) && isset($category_id['term_id'])) {
//                 $category_id = $category_id['term_id'];
//             } else {
//                 // Handle category insertion error
//                 continue;
//             }
//         }

//         // Output the category ID or perform additional actions as needed
//         echo 'Category ID: ' . $category_id . ' (Parent ID: ' . $parent_id . ')<br>';

//         // Process child categories recursively
//         if (!empty($category->children)) {
//             processHierarchicalCategoryXML($category->children, $category_id);
//         }
//     }
// }

// // Example usage
// $categoryXMLFile = 'http://test.divari.lt/xml/category.xml';
// processHierarchicalCategoryXML($categoryXMLFile);
// function processXML($xmlFile) {
//     global $wpdb;
    
//     $xml = simplexml_load_file($xmlFile);
    
  
//     foreach ($xml->item as $item) {
//         $name = (string)$item->name_lt;
//         $product_id = (string)$item->product_id;
//         $sku = (string)$item->sku;
//         $tag = (string)$item->tag_lt;
//         $manufacturer = (string)$item->manufacturer;
//         // Check if product with the Name already exists
//         $existing_product_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'product' AND post_status = 'publish' AND post_name = %s", sanitize_title($name)));
        
//         if ($existing_product_id) {
//           //  Product already exists, update it
//             $post_id = $existing_product_id;
//             update_post_meta($post_id, '_regular_price', (float)$item->price);
//             wp_set_object_terms($post_id, $tag, 'product_tag');
//             wp_set_object_terms($post_id, $manufacturer, 'product_brand');
//             // Update sale price if available
//             if ((float)$item->sale_price > 0) {
//                 update_post_meta($post_id, '_sale_price', (float)$item->sale_price);
//                 update_post_meta($post_id, '_price', (float)$item->sale_price); // Set the displayed price to the sale price
//             } else {
//                 // If there is no sale price, make sure to remove any previously set sale price
//                 delete_post_meta($post_id, '_sale_price');
//                 update_post_meta($post_id, '_price', (float)$item->price); // Set the displayed price to the regular price
//             }
//         } else {
            
//             // $model = (string)$item->model;
            
//             $description = (string)$item->description_lt;
//             $ean = (string)$item->ean; // to thhe short description
//             $quantity = (string)$item->quantity;
//             $stock_status_id = (string)$item->stock_status_id;
//             $weight = (string)$item->weight;
//             $shipping = (string)$item->shipping;
//             $price = (float)$item->price;
//             $tag = (string)$item->tag_lt;
//             $image_url = (string)$item->image;  /// image need
//             $image_urls = (array)$item->additional_images; 
//             $status = 'publish';
//             $post_type = 'product'; 
//             $product_category = (array)$item->product_category;
//             $manufacturer = (string)$item->manufacturer;
            
//             $attribute_data = (string)$item->product_attribute;
            
//             $product_permalink = 'http://test.divari.lt/shop/' . $name; 
            
            
//             $product_slug = sanitize_title($name); 
            
            
//             $wpdb->query(
//                 $wpdb->prepare(
//                     "INSERT INTO {$wpdb->posts} (post_title, post_content, post_status, post_type, post_name, guid) VALUES (%s, %s, %s, %s, %s, %s)",
//                     $name,
//                     $description,
//                     $status,
//                     $post_type,
//                     $product_slug, // Set the post_name (slug) based on the generated product slug
//                     $product_permalink // Set the guid to the product permalink
//                     )
//                 );
//                 // Get the last inserted post ID
//                 $post_id = $wpdb->insert_id;
                
//                 // wp_set_object_terms($post_id, $product_category, 'product_cat');
//                 wp_set_object_terms($post_id, $tag, 'product_tag');
//                 wp_set_object_terms($post_id, $manufacturer, 'product_brand');
//                 wp_set_object_terms($post_id, 'ltu', 'product_shipping_class');
                
//                 update_post_meta($post_id, '_tax_status', 'shipping_taxable');
                
//                 wp_set_object_terms($post_id, 'standard', 'product_tax_class');
//                 update_post_meta($post_id, '_stock_status', $stock_status_id);
//                 update_post_meta($post_id, '_stock', $quantity);
//                 // update_post_meta($post_id, '_weight', $weight);
//                 update_post_meta($post_id, '_shipping', $shipping);
//                 update_post_meta($post_id, '_sku', sanitize_text_field($ean)); // Updated this line
//                 update_post_meta($post_id, '_stock', $quantity);
//                 update_post_meta($post_id, '_manage_stock', 'yes');
//                 update_post_meta($post_id, '_product_attributes', $attribute_data); // Assuming you want to use $post_id instead of $product_id
//                 update_post_meta($post_id, '_regular_price', $price );
//                 set_post_thumbnail($post_id, $image_url);
                
//                 update_post_meta($post_id, '_product_image_gallery', implode(',', $image_urls));
//                 // echo 'Categories for ' . implode(', ', $product_category) . '<br>';
//             }
            
//         }

//      }
//     // Example usage
//     $xmlFile = 'http://test.divari.lt/xml/product.xml';
//     processXML($xmlFile);
    
    
    
    ?>