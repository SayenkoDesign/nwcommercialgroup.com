<?php
require_once __DIR__ . '/bootstrap.php';

wp_title();exit;

$twig = $container->get("twig.environment");
echo $twig->render('base.html.twig', [
    'dropdown_menu_walker' => new \App\WordPress\DropDownMenuWalker(),
    'accordion_menu_walker' => new \App\WordPress\AccordionMenuWalker(),
]);