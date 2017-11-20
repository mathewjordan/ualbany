<?php

namespace VS\PageBuilder\Modules\ACF;


class SubmenuNav
{
    public static function run()
    {
        add_action( 'wp_ajax_acf_submenu_item_list', [ __CLASS__, 'get_item_list' ] );
    }

    /**
     * @see wp-content/plugins/advanced-custom-fields-nav-menu-field/nav-menu-v5.php
     */
    public static function get_nav_menus( $allow_null = false )
    {
        $navs = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

        $nav_menus = array();

        if ( $allow_null ) {
            $nav_menus[''] = ' - Select - ';
        }

        foreach ( $navs as $nav ) {
            $nav_menus[ $nav->term_id ] = $nav->name;
        }

        return $nav_menus;
    }

    public static function get_item_list()
    {
        if( empty( $_GET['menu_id'] ) ) {

            echo json_encode( [
                'success'   => false,
                'error'    => 'menu_id is required!'
            ] );

            wp_die();
        }

        echo json_encode( [
            'success'   => true,
            'result'    => self::extract_option_data( wp_get_nav_menu_items( $_GET['menu_id'] ) )
        ] );

        wp_die();
    }

    /**
     * @see https://wordpress.stackexchange.com/questions/170033/convert-output-of-nav-menu-items-into-a-tree-like-multidimensional-array
     *
     * @param array $elements
     * @param int $parentId
     * @param int $level
     * @return array
     */
    public static function extract_option_data(array &$elements, $parentId = 0, $level = 0)
    {
        $branch = [];

        foreach ( $elements as &$element )
        {
            if ( $element->menu_item_parent == $parentId )
            {
                $children = self::extract_option_data( $elements, $element->ID, $level + 1 );

                $temp_level = $level * 2;
                $branch[$element->ID] = str_repeat('&nbsp;', $temp_level) . $element->title;

                if( $children )
                {
                    foreach ( $children as $post_id => $title )
                    {
                        $branch[ $post_id ] = $title;
                    }
                }

                unset( $element );
            }
        }

        return $branch;
    }

    /**
     * @param $menu_id
     * @param $parent_nav_item
     * @return array
     */
    public static function get_child_links($menu_id, $parent_nav_item)
    {
        $menu_items     = wp_get_nav_menu_items($menu_id);
        $child_links    = [];

        foreach( $menu_items as $item ) {

            if( $item->menu_item_parent == $parent_nav_item )
                $child_links[] = $item;
        }

        return $child_links;
    }
}