/*global jQuery*/
/*global acf*/
import SubmenuBlocks from './components/SubmenuBlock'

const add_new_block = function($parent)
{
    let length = window.submenuBlocks.length;

    let filtered = window.submenuBlocks.filter(function(submenuBlock) {

        let $submenuBlock = jQuery( submenuBlock );

        return $submenuBlock.data('id') !== $parent.data('id')
    }).length;

    return ! length || length === filtered;
}

jQuery(function(){

    window.submenuBlocks = [];

    let selectors = [
        '.acf-field-column-one-keysubmenu-menu',
        '.acf-field-column-two-keysubmenu-menu',
        '.acf-field-column-three-keysubmenu-menu',
        '.acf-field-column-four-keysubmenu-menu',
    ];

    let $submenuBlocks = jQuery( selectors.join(', ') );

    if( $submenuBlocks.length ) {

        $submenuBlocks.each(function() {

            let $parent = jQuery( this ).closest('[data-layout="submenu_block"]');

            if( $parent.data('id') && ! $parent.is('.acf-clone') && add_new_block( $parent ) ) {

                window.submenuBlocks.push(
                    new SubmenuBlocks({
                        parent: $parent
                    })
                )
            }
        })
    }

    if( typeof acf !== 'undefined' ) {

        acf.add_action('append', function( $el ){

            let $submenuBlocks = jQuery( selectors.join(', ') );

            if( $submenuBlocks.length ) {

                $submenuBlocks.each(function() {

                    let $parent = jQuery( this ).closest('[data-layout="submenu_block"]');

                    if( $parent.data('id') && ! $parent.is('.acf-clone') && add_new_block( $parent ) ) {

                        window.submenuBlocks.push(
                            new SubmenuBlocks({
                                parent: $parent
                            })
                        )
                    }
                });
            }
        });
    }
});