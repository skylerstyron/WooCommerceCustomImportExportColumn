<?php
// Custom Column Product Export
// Add the Slug column to the exporter and the exporter column menu.
function add_export_column( $columns ) {
	$columns['slug'] = 'Slug';

	return $columns;
}
add_filter( 'woocommerce_product_export_column_names', 'add_export_column' );
add_filter( 'woocommerce_product_export_product_default_columns', 'add_export_column' );

/*
 * Provide the data to be exported for one item in the column.
 * $value - Should be in a format that can be output into a text file (string, numeric, etc).
 */
function add_export_data( $value, $product ) {
	$value = $product->get_meta( 'slug', true, 'edit' );
	return $value;
}
// Filter you want to hook into will be: 'woocommerce_product_export_product_column_{$column_slug}'.
add_filter( 'woocommerce_product_export_product_column_custom_column', 'add_export_data', 10, 2 );

// Custom Column Product Import
// Add Slug column to CSV importer
function add_column_to_importer( $options ) {
    $options['slug'] = 'Slug';

    return $options;
}
add_filter('woocommerce_csv_product_importer_mapping_options', 'add_column_to_importer');

// Add automatic mapping to import mapping screen
function add_column_to_mapping_screen( $columns ) {
    $columns['Slug'] = 'slug';

    return $columns;
}
add_filter('woocommerce_csv_product_import_mapping_default_columns', 'add_column_to_mapping_screen');

// Process the data from the CSV file. Saves the data in meta data
function process_import( $object, $data ) {
    if (!empty($data['slug'])) {
        $object->set_slug($data['slug']);
    }

    return $object;
}
add_filter('woocommerce_product_import_pre_insert_product_object', 'process_import', 10, 2);

?>