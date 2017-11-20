/*global jQuery*/

export default class SubmenuBlock
{
    options = {
        parent: null
    }

    constructor(options)
    {
        this.options = Object.assign({}, this.options, options);
        this.events();
    }

    events()
    {
        jQuery('select:eq(0)', this.options.parent).on('change', ev => {

            let menu_id = jQuery( ev.currentTarget ).val();

            if( menu_id ) {

                SubmenuBlock.get_item_list( menu_id ).then((data) => {
                    let json = JSON.parse( data );

                    if( json.success ) {

                        this.build_list_options( json.result );

                    }else
                        console.error(json);
                })
            }

        });
    }

    build_list_options(menu_items)
    {

        if( Object.keys( menu_items ).length ) {

            let $menu_item_select = jQuery('select:eq(1)', this.options.parent);

            $menu_item_select
                .find('option')
                .remove()
                .end()
                .append('<option value="">Select Menu Item</option>');

            Object.keys( menu_items ).forEach((key) => {

                $menu_item_select
                    .append(`<option value="${key}">${menu_items[ key ]}</option>`)
            })
        }

    }

    static get_item_list(menu_id)
    {
        return jQuery.get( ajaxurl, {
            action: 'acf_submenu_item_list',
            menu_id: menu_id
        } )
    }
}
