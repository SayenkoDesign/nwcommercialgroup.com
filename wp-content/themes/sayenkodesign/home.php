<?php
require_once __DIR__ . '/bootstrap.php';

$twig = $container->get("twig.environment");
global $wp_query;

$blogs = [];
while(have_posts()) {
    the_post();
    $blogs[] = $twig->render('partials/blog.html.twig', []);
}
wp_reset_postdata();
the_post();

echo $twig->render('pages/blogs.html.twig', [
    'title' => get_the_title(get_option('page_for_posts')),
    'current_page' => get_query_var('paged') ?: 1,
    'max_pages' => $wp_query->max_num_pages,
    'dropdown_menu_walker' => new \App\WordPress\DropDownMenuWalker(),
    'accordion_menu_walker' => new \App\WordPress\AccordionMenuWalker(),
    'blogs' => $blogs
]);