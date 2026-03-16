<?php
/**
 * Plugin Name: Juan Valdez - Setup Menu
 * Description: Crea automáticamente el menú de navegación principal para la landing page.
 *              Se ejecuta una sola vez. Puedes eliminarlo después de importar el template.
 * Version: 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function jv_create_navigation_menu() {
    $menu_name = 'Menu Principal Juan Valdez';

    // Si ya existe, no hacer nada
    if ( wp_get_nav_menu_object( $menu_name ) ) {
        return;
    }

    $menu_id = wp_create_nav_menu( $menu_name );

    if ( is_wp_error( $menu_id ) ) {
        return;
    }

    $items = [
        [ 'title' => 'Inicio',     'url' => '#inicio'    ],
        [ 'title' => 'Productos',  'url' => '#productos' ],
        [ 'title' => 'Historia',   'url' => '#historia'  ],
        [ 'title' => 'Contacto',   'url' => '#contacto'  ],
    ];

    foreach ( $items as $order => $item ) {
        wp_update_nav_menu_item( $menu_id, 0, [
            'menu-item-title'       => $item['title'],
            'menu-item-url'         => $item['url'],
            'menu-item-status'      => 'publish',
            'menu-item-type'        => 'custom',
            'menu-item-position'    => $order + 1,
        ] );
    }

    // Asignar a las ubicaciones del tema si existen
    $locations = get_theme_mod( 'nav_menu_locations' );
    if ( isset( $locations['primary'] ) ) {
        $locations['primary'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
}

add_action( 'init', 'jv_create_navigation_menu' );
