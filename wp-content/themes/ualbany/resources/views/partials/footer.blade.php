<footer class="footer container-fluid" role="contentinfo">
  <div class="region region-footer">
    
    @php(dynamic_sidebar('sidebar-footer'))
  </div>
</footer>

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>

<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

<script>
    $(document).ready(function(){

        $('#menu-item-1062').hover(function() {
            var locationHeight = $('#menu-item-1062 > .dropdown-menu').height();
            var locationHeightInner = $('.ualbany-custom-dropdown-locations').height();
            if (locationHeightInner > locationHeight) {
              $('#menu-item-1062 > .dropdown-menu .more-button').addClass('show');
            } else {
              $('#menu-item-1062 > .dropdown-menu .more-button').addClass('hide');
            }
        });

        $('#menu-item-1062 > .dropdown-menu .more-button').click(function() {
            $('#menu-item-1062 > .dropdown-menu').css('max-height', '100vh');
            $(this).remove();
        });



        $('#menu-item-1061').hover(function() {
            $('#menu-item-1061 > .dropdown-menu .more-button').addClass('show');
            var subjectHeight = $('#menu-item-1061 > .dropdown-menu').height();
            var subjectHeightInner = $('.ualbany-custom-dropdown-subjects').height();
            if (subjectHeightInner > subjectHeight) {
                $('#menu-item-1061 > .dropdown-menu .more-button').addClass('show');
            } else {
                $('#menu-item-1061 > .dropdown-menu .more-button').removeClass('show');
            }
        });

        $('#menu-item-1061 > .dropdown-menu .more-button').click(function() {
            $('#menu-item-1061 > .dropdown-menu').css('max-height', '100vh');
            $(this).removeClass('show');
        });

        $('.myths-slick').slick({
            centerMode: true,
            centerPadding: '60px',
            slidesToShow: 3,
            autoplay: true,
            autoplaySpeed: 5000,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                }
            ]
        });

        $('#table-programs').DataTable( {
          "dom": 'frti',
          //"paging": false,
          //"lengthChange": false,
          //"bLengthChange": false,
          "columnDefs": [
            {
                "targets": [ 8 ],
                "visible": false,
            },
            {
                "targets": [ 7 ],
                "visible": false,
            },
            {
                "targets": [ 6 ],
                "visible": false,
            },
          ]
        });
    });
</script>
