<?php
/**
 * Template Name: Home Page
 */
require_once __DIR__ . '/../bootstrap.php';

$twig = $container->get("twig.environment");
echo $twig->render('pages/home.html.twig', [
    'dropdown_menu_walker' => new \App\WordPress\DropDownMenuWalker(),
    'accordion_menu_walker' => new \App\WordPress\AccordionMenuWalker(),
]);