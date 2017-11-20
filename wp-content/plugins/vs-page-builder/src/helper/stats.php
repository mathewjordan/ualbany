<?php

namespace VS\PageBuilder\Core;

function stats_column_sizes($stat_count)
{
    switch( $stat_count )
    {
        case 1:
            return [ 'col-sm-12' ];
            break;
        case 2:
            return [ 'col-md-6', 'col-md-6' ];
        case 3:
            return [ 'col-md-4', 'col-md-4', 'col-md-4' ];
        case 4:
            return [ 'col-md-3', 'col-md-3', 'col-md-3', 'col-md-3' ];
    }
}