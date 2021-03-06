<?php
/**
 * Install default data
 */
$home_locale = fusion_get_locale('', LOCALE.LOCALESET."setup.php");
// Page
$cpData = array(
    'page_id' => 0,
    'page_cat' => 0,
    'page_link_cat' => 0,
    'page_title' => $home_locale['homeSetup_0100'],
    'page_access' => 0,
    'page_content' => '',
    'page_keywords' => $home_locale['homeSetup_0100'],
    'page_status' => 1,
    'page_user' => 1,
    'page_datestamp' => time(),
    'page_language' => LANGUAGE,
    'page_grid_id' => 0,
    'page_content_id' => 0,
    'page_left_panel' => 1,
    'page_right_panel' => 0,
    'page_top_panel' => 0,
    'page_header_panel' => 0,
    'page_bottom_panel' => 0,
    'page_footer_panel' => 0,
);
$page_id = dbquery_insert(DB_CUSTOM_PAGES, $cpData, 'save');
// Build the grid for content
$cgData = array(
    'page_grid_id' => 0,
    'page_id' => $page_id,
    'page_grid_container' => 1,
    'page_grid_column_count' => 1,
    'page_grid_html_id' => 'content',
    'page_grid_class' => '',
    'page_grid_order' => 7,
);
$grid_id = dbquery_insert(DB_CUSTOM_PAGES_GRID, $cgData, 'save');
// Build the column for content
$clData = array(
    'page_id' => $page_id,
    'page_grid_id' => $grid_id,
    'page_content_id' => 0,
    'page_content_type' => 'Content',
    'page_content' => '',
    'page_options' => '',
    'page_content_order' => 1,
    'page_widget' => ''
);
$col_id = dbquery_insert(DB_CUSTOM_PAGES_CONTENT, $clData, 'save');
// update
dbquery("UPDATE ".DB_CUSTOM_PAGES." SET page_grid_id='$grid_id', page_content_id='$col_id' WHERE page_id='$page_id'");

// Carousel Data
$rowData[1] = array(
    'page_grid_id' => 0,
    'page_id' => $page_id,
    'page_grid_container' => 0,
    'page_grid_column_count' => 1,
    'page_grid_html_id' => 'carousel_wrapper',
    'page_grid_class' => '',
    'page_grid_order' => 1,
);

// block and latest
$rowData[2] = array(
    'page_grid_id' => 0,
    'page_id' => $page_id,
    'page_grid_container' => 1,
    'page_grid_column_count' => 1,
    'page_grid_html_id' => 'latest',
    'page_grid_class' => '',
    'page_grid_order' => 2,
);

// theme
$rowData[3] = array(
    'page_grid_id' => 0,
    'page_id' => $page_id,
    'page_grid_container' => 0,
    'page_grid_column_count' => 1,
    'page_grid_html_id' => 'showcase',
    'page_grid_class' => 'container',
    'page_grid_order' => 3,
);

$rowData[4] = array(
    'page_grid_id' => 0,
    'page_id' => $page_id,
    'page_grid_container' => 1,
    'page_grid_column_count' => 1,
    'page_grid_html_id' => 'home_feature',
    'page_grid_class' => '',
    'page_grid_order' => 4,
);

$rowData[5] = array(
    'page_grid_id' => 0,
    'page_id' => $page_id,
    'page_grid_container' => 1,
    'page_grid_column_count' => 1,
    'page_grid_html_id' => 'support',
    'page_grid_class' => '',
    'page_grid_order' => 5,
);

$rowData[6] = array(
    'page_grid_id' => 0,
    'page_id' => $page_id,
    'page_grid_container' => 0,
    'page_grid_column_count' => 1,
    'page_grid_html_id' => 'home_parallax',
    'page_grid_class' => '',
    'page_grid_order' => 6,
);

foreach ($rowData as $rowKeys => $rowArray) {
    $row_id[$rowKeys] = dbquery_insert(DB_CUSTOM_PAGES_GRID, $rowArray, 'save');
}

/**
 * End of row insertion
 */

// Carousel - OK
$sliderDesc = str_replace(array("[b]", "[/b]", "[i]", "[/i]"), array("<strong>", "</strong>", "<i>", "</i>"), $home_locale['homeSetup_0102']);
$sliderDesc .= "\n";
$sliderDesc .= str_replace(array("[b]", "[/b]", "[i]", "[/i]"), array("<strong>", "</strong>", "<i>", "</i>"), $home_locale['homeSetup_0103']);
$sliderDesc .= "\n";
$sliderDesc .= "<div class='logo'><img src='images/php-fusion-icon.png'></div>";
$slider_array[0] = array(
    'slider_title' => $home_locale['homeSetup_0101'],
    'slider_description' => form_sanitizer($sliderDesc),
    'slider_link' => '',
    'slider_order' => 1,
    'slider_caption_offset' => '120',
    'slider_caption_align' => 'text-left',
    'slider_title_size' => 50,
    'slider_desc_size' => 35,
    'slider_btn_size' => '',
    'slider_image_src' => 'default-carousel.jpg'
);
$slider_options = array(
    'slider_id' => 'home_carousel',
    'slider_path' => 'carousel',
    'slider_height' => 1400,
    'slider_navigation' => 0,
    'slider_indicator' => 0,
);
$colData[1] = array(
    'page_id' => $page_id,
    'page_grid_id' => $row_id[1],
    'page_content_id' => 0,
    'page_content_type' => $home_locale['homeSetup_0104'],
    'page_content' => \defender::serialize($slider_array),
    'page_options' => \defender::serialize($slider_options),
    'page_content_order' => 1,
    'page_widget' => 'slider'
);

// Latest block
$colData[2] = array(
    'page_id' => $page_id,
    'page_grid_id' => $row_id[2],
    'page_content_id' => 0,
    'page_content_type' => $home_locale['homeSetup_0106'],
    'page_content' => \defender::serialize(
        array(
            'block_title' => $home_locale['homeSetup_0110'],
            'block_description' => $home_locale['homeSetup_0111'],
            'block_align' => 'text-left',
            'block_class' => '',
            'block_margin' => '35px 0',
            'block_padding' => '',
        )
    ),
    'page_options' => '',
    'page_content_order' => 1,
    'page_widget' => 'block'
);

$colData[3] = array(
    'page_id' => $page_id,
    'page_grid_id' => $row_id[2],
    'page_content_id' => 0,
    'page_content_type' => $home_locale['homeSetup_0106'],
    'page_content' => \defender::serialize(
        array(
            'panel_include' => 'home_panel'
        )
    ),
    'page_options' => '',
    'page_content_order' => 2,
    'page_widget' => 'panel'
);

// Theme
$colData[4] = array(
    'page_id' => $page_id,
    'page_grid_id' => $row_id[3],
    'page_content_id' => 0,
    'page_content_type' => $home_locale['homeSetup_0107'],
    'page_content' => \defender::serialize(
        array(
            'block_title' => $home_locale['homeSetup_0112'],
            'block_description' => $home_locale['homeSetup_0113'],
            'block_align' => 'text-left',
            'block_class' => '',
            'block_margin' => '150px 0',
            'block_padding' => ''
        )
    ),
    'page_options' => '',
    'page_content_order' => 1,
    'page_widget' => 'block'
);

// Why you'll love PHP-Fusion
$colData[5] = array(
    'page_id' => $page_id,
    'page_grid_id' => $row_id[4],
    'page_content_id' => 0,
    'page_content_type' => $home_locale['homeSetup_0107'],
    'page_content' => \defender::serialize(
        array(
            'block_title' => $home_locale['homeSetup_0114'],
            'block_description' => $home_locale['homeSetup_0115'],
            'block_align' => 'text-center',
            'block_class' => '',
            'block_margin' => '70px 0',
            'block_padding' => ''
        )
    ),
    'page_options' => '',
    'page_content_order' => 1,
    'page_widget' => 'block'
);

// PFDN
$content = str_replace(array("[h4]", "[/h4]", "[p]", "[/p]"), array("<h4>", "</h4>", "<p>", "</p>"), $home_locale['homeSetup_0117']);
$content .= str_replace(array("[h4]", "[/h4]", "[p]", "[/p]"), array("<h4>", "</h4>", "<p>", "</p>"), $home_locale['homeSetup_0118']);
$colData[6] = array(
    'page_id' => $page_id,
    'page_grid_id' => $row_id[5],
    'page_content_id' => 0,
    'page_content_type' => $home_locale['homeSetup_0107'],
    'page_content' => \defender::serialize(
        array(
            'block_title' => $home_locale['homeSetup_0116'],
            'block_description' => form_sanitizer($content),
            'block_align' => '',
            'block_class' => 'support',
            'block_margin' => '95px 0 0',
            'block_padding' => '30px'
        )
    ),
    'page_options' => '',
    'page_content_order' => 1,
    'page_widget' => 'block'
);
unset($content);


$colData[7] = array(
    'page_id' => $page_id,
    'page_grid_id' => $row_id[6],
    'page_content_id' => 0,
    'page_content_type' => $home_locale['homeSetup_0107'],
    'page_content' => \defender::serialize(
        array(
            'block_title' => $home_locale['homeSetup_0119'],
            'block_description' => $home_locale['homeSetup_0120'],
            'block_align' => 'text-center',
            'block_class' => '',
            'block_margin' => '30px 0',
            'block_padding' => '60px'
        )
    ),
    'page_options' => '',
    'page_content_order' => 1,
    'page_widget' => 'block'
);

foreach ($colData as $row_Keys => $colArray) {
    dbquery_insert(DB_CUSTOM_PAGES_CONTENT, $colArray, 'save');
}

unset($colData);
unset($home_locale);