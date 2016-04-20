<?php
require_once __DIR__ . '/bootstrap.php';

$twig = $container->get("twig.environment");
global $wp_query;

$listings = [];
while(have_posts()) {
    the_post();
    $data = [
        'title' => get_the_title(),
        'link' => get_the_permalink(),
        'images' => get_field('images'),
        'confidential_location' => get_field('confidential_location'),
        'city' => get_field('city'),
        'state' => get_field('state'),
        'price' => get_field('pricing'),
        'cap_rate' => get_field('cap_rate'),
    ];
    $listings[] = $twig->render('partials/listing.html.twig', $data);
}
wp_reset_postdata();


echo $twig->render('pages/listings.html.twig', [
    'title' => get_the_title(get_field('listings_page', 'option')->ID),
    'current_page' => get_query_var('paged') ?: 1,
    'max_pages' => $wp_query->max_num_pages,
    'dropdown_menu_walker' => new \App\WordPress\DropDownMenuWalker(),
    'accordion_menu_walker' => new \App\WordPress\AccordionMenuWalker(),
    'listings' => $listings
]);