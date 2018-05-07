/* eslint-disable */

/*global jQuery */

const UNDERLAY_SELECTOR = '.nav-mobile-underlay'
    , TRIGGER_SELECTOR  = '.nav-master-trigger'
    , CLOSE_SELECTOR    = '.nav-mobile-close'
    , ACTIVE_CLASS      = 'mobile-nav-active'
    , WRAPPER_CLASS     = 'nav-mobile-wrapper'
    , SUBACTIVE_CLASS   = 'sub-active'
    , SUBMENU_BACK      = 'nav-submenu-back'
    , MOBILE_MENU_CLASS = 'mobile-menu-link'
    , SUBACTIVE_LEVEL_CLASS     = 'sub-active-level'
    , PARENT_CLONE_ITEM_CLASS   = 'parent-menu-item-cloned';

const level_classes = [
    'mobile-menu-link--level-one',
    'mobile-menu-link--level-two',
    'mobile-menu-link--level-three',
];

export default class MobileNav
{
    constructor()
    {
        this.$body      = jQuery('body');
        this.$wrapper   = jQuery( `.${ WRAPPER_CLASS }` );
        this.events();
    }

    events()
    {
        jQuery( TRIGGER_SELECTOR ).on('click', () => {

            let action = this.$body.is( '.mobile-nav-active' ) ? 'close' : 'open';

            this[ action ]();
        });

        jQuery( `${ UNDERLAY_SELECTOR }, ${ CLOSE_SELECTOR }` ).on('click', () => {
            this.close();
        });

        jQuery( '.menu-primary-container ul > li.menu-item-has-children > a', this.$wrapper ).on('click', (ev) => {

            ev.preventDefault();

            let $a = jQuery( ev.currentTarget );

            this.submenu( $a );
        });

        jQuery( `.${ SUBMENU_BACK }` ).on('click', (ev) => {

            ev.preventDefault();

            this.close_submenu();
        })
    }

    /**
     * Open the main master nav
     */
    open()
    {
        this.$body.addClass( ACTIVE_CLASS );

        jQuery( `a:not(.${ MOBILE_MENU_CLASS })` ).each( function() {

            let a = jQuery( this )

            if( a.tabIndex ) {
                a.data( 'original-tab-index', a.tabIndex );
            }

            a.attr( 'tabindex', '-1' );
        });
    }

    /**
     * Close the main master nav
     */
    close()
    {
        this.$body.removeClass( ACTIVE_CLASS );
        this.remove_parent_clone_items();
        jQuery( 'ul', this.$wrapper ).removeClass( SUBACTIVE_CLASS );
        this.$wrapper.removeClass( SUBACTIVE_CLASS );

        jQuery( `a:not(.${ MOBILE_MENU_CLASS })` ).each( function() {

            let a = jQuery( this ),
                originalTabIndex = a.data('originalTabIndex')

            if( originalTabIndex && originalTabIndex !== '' ) {
                a.attr( 'tabIndex', originalTabIndex );
            }else{
                a.removeAttr( 'tabIndex' );
            }
        });
    }

    /**
     * Display a sub-menu level based on the parent <a> event
     *
     * @param $a
     */
    submenu($a)
    {
        let $li         = $a.parent()
            ,$subUl     = jQuery( 'ul.dropdown-menu:first', $li )
            ,$parentLi  = jQuery( document.createElement( 'li' ) )
            ,current_level = $a.attr('class').split(' ').filter((class_name) => {
            return class_name.indexOf( '--level' ) !== -1;
        }).shift();

        console.log(current_level);

        $parentLi.addClass( PARENT_CLONE_ITEM_CLASS )
            .append( $a.clone() )
            .prependTo( $subUl );

        this.activate_wrapper_class( $li, current_level );
    }

    /**
     * Close the sub-menu
     */
    close_submenu()
    {
        let $current_active_level   = jQuery( `ul.dropdown-menu li.${ SUBACTIVE_CLASS }`, this.$wrapper )
            ,current_level          = null;

        if( ! $current_active_level.length ) {

            $current_active_level = jQuery( `ul:not(.sub-menu) li.${ SUBACTIVE_CLASS }`, this.$wrapper );
        }

        $current_active_level.removeClass( SUBACTIVE_CLASS );

        if( this.$wrapper.is('.mobile-menu-link--level-one') ) {

            this.$wrapper.removeClass('mobile-menu-link--level-one');

            current_level = level_classes[0];

        }else if( this.$wrapper.is('.mobile-menu-link--level-two') ) {

            this.$wrapper.removeClass('mobile-menu-link--level-two')
                .addClass('mobile-menu-link--level-one');

            current_level = level_classes[1];

        }else if( this.$wrapper.is('.mobile-menu-link--level-three') ) {

            this.$wrapper.removeClass('mobile-menu-link--level-three')
                .addClass('mobile-menu-link--level-two');

            current_level = level_classes[2];
        }

        this.remove_parent_clone_items( current_level );
        this.deactivate_wrapper_class();
    }

    /**
     * Remove the cloned menu item from the current active sub-menu
     */
    remove_parent_clone_items(current_level)
    {
        let parent_selector = 'ul.dropdown-menu li';

        if( current_level == 'mobile-menu-link--level-two' ) {
            parent_selector = `${ parent_selector } ul.dropdown-menu li`;
        }

        if( current_level == 'mobile-menu-link--level-three' ) {
            parent_selector = `${ parent_selector } ul.dropdown-menu li`;
        }

        jQuery( `${ parent_selector }.${ PARENT_CLONE_ITEM_CLASS }`, this.$wrapper ).remove();
    }

    /**
     * Add a class to the wrapper parent based on level of sub-menu
     *
     * @param $li
     */
    activate_wrapper_class($li, current_level)
    {
        let removeLevelClass = level_classes.filter( class_name => {
            return current_level !== class_name
        })

        this.$wrapper.addClass( SUBACTIVE_CLASS )
            .removeClass( removeLevelClass.join(' ') )
            .addClass( current_level );

        if( this.$wrapper.is( `.${ SUBACTIVE_CLASS }` ) && jQuery( 'ul.dropdown-menu:visible', this.$wrapper ).length ) {
            this.$wrapper.addClass( SUBACTIVE_LEVEL_CLASS );
        }

        $li.addClass( SUBACTIVE_CLASS );
    }

    /**
     * Deactivate a class of the wrapper based on active sub-menu level
     */
    deactivate_wrapper_class()
    {
        if( this.$wrapper.is( `.${ SUBACTIVE_LEVEL_CLASS }` ) ) {
            this.$wrapper.removeClass( SUBACTIVE_LEVEL_CLASS );
        }else{
            this.$wrapper.removeClass( SUBACTIVE_CLASS );
        }
    }
}