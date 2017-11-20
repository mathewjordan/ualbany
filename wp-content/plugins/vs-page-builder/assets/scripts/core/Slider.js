/*global jQuery*/

const SHOW_PREV = 'prev', SHOW_NEXT = 'next';

export default class Slider {

    constructor(options = {})
    {
        this.options    = Object.assign({}, Slider.defaultOptions( options ), options);
        this._slides    = jQuery([]);
        this._thumbnails= jQuery([]);
        this._autoSlide = false;
        this.events();
        this.autoSlide();
    }

    static defaultOptions(options)
    {
        let { parent, prevSelector, nextSelector, thumbnailSelector  } = options
            ,customOptions = {};

        if( ! parent ) {
            this.error( "Parent element is required when creating a new VC Page Builder Slider.", options );
        }

        if( typeof parent == 'string' )
            parent = jQuery( parent );

        if( parent && parent.length ) {

            customOptions.targets = {
                prev: jQuery( prevSelector ? prevSelector : '.vc-pb-slider-prev', parent ),
                next: jQuery( nextSelector ? nextSelector : '.vc-pb-slider-next', parent ),
                thumbnail: jQuery( thumbnailSelector ? thumbnailSelector : '.vc-pb-slider-thumbnail', parent )
            }
        }

        return Object.assign({}, {
            parent: null,
            targets: {
                prev: null,
                next: null
            },
            slideSelector: 'vc-pb-slide-item',
            autoSlide: true,
            autoSlideDelay: 10000
        }, customOptions);
    }

    error(message, options = false)
    {
        console.error( message );
        console.warn( "Options:", options ? options : this.options );
    }

    slides()
    {
        if( ! this._slides.length && this.options.parent )
            this._slides = jQuery( this.options.slideSelector, this.options.parent );

        return this._slides;
    }

    thumbnails()
    {
        if( ! this._thumbnails.length && this.options.parent
            && this.options.targets.thumbnail.length ) {
            this._thumbnails = this.options.targets.thumbnail;
        }

        return this._thumbnails;
    }

    events()
    {
        //@todo Not needed right now, could be used in future component
        // if( this.options.targets.prev && this.options.targets.prev.length )
        //     this.options.targets.prev.on('click', (ev) => {
        //         ev.preventDefault();
        //         this.move( SHOW_PREV );
        //     });
        //
        // if( this.options.targets.next && this.options.targets.next.length )
        //     this.options.targets.next.on('click', (ev) => {
        //         ev.preventDefault();
        //         this.move( SHOW_NEXT );
        //     });

        if( this.options.targets.thumbnail && this.options.targets.thumbnail.length )
            this.options.targets.thumbnail.on('click', (ev) => {
                ev.preventDefault();

                let $thumbnail = jQuery( ev.currentTarget );

                this.jump_to( $thumbnail );
            });

        if( this.options.parent ) {

            this.options.parent.on('mouseover', () => {
                clearInterval( this._autoSlide );
                this._autoSlide = false;
            });

            this.options.parent.on('mouseout', () => {

                if( this._autoSlide === false && this.options.autoSlide )
                    this.autoSlide();
            });
        }
    }

    //@todo Not needed right now, could be used in future component
    // move(direction = SHOW_NEXT)
    // {
    //     switch ( direction )
    //     {
    //         case SHOW_NEXT:
    //             console.log("next");
    //             break;
    //         case SHOW_PREV:
    //             console.log("prev");
    //             break;
    //     }
    // }

    jump_to($thumbnail)
    {
        let index       = this.thumbnails().index( $thumbnail )
            ,tempSlides = this.slides();

        tempSlides.filter('.current');
        tempSlides.removeClass('current');

        jQuery( this.slides()[ index ] ).addClass('current');

        this.thumbnails().removeClass('current');
        $thumbnail.addClass('current');
    }

    autoSlide()
    {
        if( this.options.autoSlide && this.options.autoSlideDelay ) {

            this._autoSlide = setInterval(() => {

                let currentThumbnail = this.thumbnails().filter('.current')
                    ,currentIndex    = this.thumbnails().index( currentThumbnail )
                    ,nextIndex       = currentIndex + 1;

                if( ( nextIndex + 1 ) > this.thumbnails().length )
                    nextIndex = 0;

                this.jump_to( jQuery( this.thumbnails()[ nextIndex ] ) )

            }, this.options.autoSlideDelay)
        }
    }
}