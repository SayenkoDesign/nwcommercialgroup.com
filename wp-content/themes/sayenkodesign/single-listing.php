<?php
require_once __DIR__ . '/bootstrap.php';

$prev_post = get_previous_post();
$next_post = get_next_post();

$prev_link = $prev_post ? get_permalink($prev_post->ID) : false;
$next_link = $next_post ? get_permalink($next_post->ID) : false;

$twig = $container->get("twig.environment");
echo $twig->render('pages/listing.html.twig', [
    'prev_link' => $prev_link,
    'next_link' => $next_link,
    'dropdown_menu_walker' => new \App\WordPress\DropDownMenuWalker(),
    'accordion_menu_walker' => new \App\WordPress\AccordionMenuWalker(),
]);