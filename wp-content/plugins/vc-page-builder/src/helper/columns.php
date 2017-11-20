<?php

namespace VC\PageBuilder\Core;

if( ! defined( 'VC_PAGE_BUILDER_COLUMN_ONE' ) )
    define( 'VC_PAGE_BUILDER_COLUMN_ONE', 'column_one_key' );

if( ! defined( 'VC_PAGE_BUILDER_COLUMN_TWO' ) )
    define( 'VC_PAGE_BUILDER_COLUMN_TWO', 'column_two_key' );

if( ! defined( 'VC_PAGE_BUILDER_COLUMN_THREE' ) )
    define( 'VC_PAGE_BUILDER_COLUMN_THREE', 'column_three_key' );

if( ! defined( 'VC_PAGE_BUILDER_COLUMN_FOUR' ) )
    define( 'VC_PAGE_BUILDER_COLUMN_FOUR', 'column_four_key' );

/**
 * Dynamic Columns
 *
 * @param $number_of_columns
 * @return array|bool
 */
function columns_names($number_of_columns)
{
    switch( $number_of_columns )
    {
        case 1;
            return [
                'key' => VC_PAGE_BUILDER_COLUMN_ONE,
                'name' => 'columns_one',
                'label' => 'Add One Column',
            ];
            break;
        case 2;
            return [
                'key' => VC_PAGE_BUILDER_COLUMN_TWO,
                'name' => 'columns_two',
                'label' => 'Add Two Columns',
            ];
            break;
        case 3;
            return [
                'key' => VC_PAGE_BUILDER_COLUMN_THREE,
                'name' => 'columns_three',
                'label' => 'Add Three Columns',
            ];
            break;
        case 4;
            return [
                'key' => VC_PAGE_BUILDER_COLUMN_FOUR,
                'name' => 'columns_four',
                'label' => 'Add Four Columns',
            ];
            break;
    }

    return false;
}

/**
 * Display sizes for grid layout options
 *
 * @param $number_of_columns
 * @return array|bool
 */
function column_grid_sizes($number_of_columns)
{
    switch( $number_of_columns )
    {
        case 1;
            return [
                100 => '100%'
            ];
            break;
        case 2;
            return [
                2575 => '25% / 75%',
                3366 => '33% / 66%',
                5050 => '50% / 50%',
                6633 => '66% / 33%',
                7525 => '75% / 25%',
            ];
            break;
        case 3;
            return [
                333333 => '33% / 33% / 33%',
                502525 => '50% / 25% / 25%',
                255025 => '25% / 50% / 25%',
                252550 => '25% / 25% / 50%'
            ];
            break;
        case 4;
            return [
                25252525 => '25% / 25% / 25% / 25%'
            ];
            break;
    }

    return false;
}

/**
 * Default Grid Display Size
 *
 * @param $number_of_columns
 * @return int|string
 */
function column_grid_default_size($number_of_columns)
{
    switch( $number_of_columns )
    {
        case 1;
            return 100;
            break;
        case 2;
            return 5050;
            break;
        case 3;
            return 333333;
            break;
        case 4;
            return 25252525;
            break;
    }

    return '';
}

/**
 * @param $field_name
 * @param $size
 * @return array|null
 */
function column_class($field_name, $size)
{
    switch( $field_name )
    {
        case 'columns_one':

            return [ 'col-sm-12' ];

            break;
        case 'columns_two':

            switch( $size )
            {
                case 2575:
                    return [ 'col-md-3', 'col-md-9' ];
                    break;
                case 3366:
                    return [ 'col-md-4', 'col-md-8' ];
                    break;
                case 5050:
                    return [ 'col-md-6', 'col-md-6' ];
                    break;
                case 6633:
                    return [ 'col-md-8', 'col-md-4' ];
                    break;
                case 7525:
                    return [ 'col-md-9', 'col-md-3' ];
                    break;

            }

            break;
        case 'columns_three':

            switch( $size )
            {
                case 333333:
                    return [ 'col-md-4', 'col-md-4', 'col-md-4' ];
                    break;
                case 502525:
                    return [ 'col-md-6', 'col-md-3', 'col-md-3' ];
                    break;
                case 255025:
                    return [ 'col-md-3', 'col-md-6', 'col-md-3' ];
                    break;
                case 252550:
                    return [ 'col-md-3', 'col-md-3', 'col-md-6' ];
                    break;
            }

            break;
        case 'columns_four':

            return [ 'col-md-3', 'col-md-3', 'col-md-3', 'col-md-3' ];

            break;
    }

    return null;
}