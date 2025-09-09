<!--************************* start header information *************************-->
<?php
$theme_options = get_option('cyberisho_main_option', []);
$home_options = $theme_options['home'];

?>
<section class="header-home-information-section">
    <div class="container header-home-information-container">
        <div class="text-wrapper">
            <h1 class="title"><?php
            echo $home_options['home_header_title'];
            ?></h1>
            <p>
                <?php
                echo $home_options['home_header_title_content'];
                ?>
            </p>
            <a href=" <?php
            $page = get_page_by_path('portfolio');
            if ($page) {
                $portfolio_url = get_permalink($page->ID);
                echo $portfolio_url;
            }
            ?>
        ">نمونه کارها</a>
        </div>
        <div class="image-wrapper">
            <div class="icons">
                <div class="icon icon-1">
                    <svg>
                        <image x="0px" y="0px"
                            xlink:href="data:img/png;base64,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" />
                    </svg>
                </div>
                <div class="icon icon-2">
                    <svg>
                        <image x="0px" y="0px"
                            xlink:href="data:img/png;base64,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" />
                    </svg>
                </div>
                <div class="icon icon-3">
                    <svg>
                        <image x="0px" y="0px"
                            xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAACIAAAAiCAYAAAA6RwvCAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAABmJLR0QA/wD/AP+gvaeTAAAAB3RJTUUH6QgPDAMogg65IAAABs5JREFUWMONmM2PZVUVxX9rn3urqz9IN0oLIhAICiSaGBAGtEpIjIkTMMSRiXHmyKHxf3GgzmSoJOrEYIgkxAEB7YE0IEJQvu3w0Q1017v37OXgnPs+qmnwJlWv6tU7566z1tpr71v6+c9e42qXBCAiIKK9liKGMWIYFOMYGvekvb1gGMPjqBxG5TiEo/R1RYRAobZn39uA+7c0DHzGJbXVEkWhI1F0vBSdLINODaNODGOMwyiPoy4Poy6OQ7xfBl0ogz6K0BwiFSBpDWIDxGChTwOysAEUoeMSN0bojgjdFYUvD4NuLkXXDUX7wxAeBl0ch3hnGPVqFL1Yis5F8K+QziMuSbjt2+DYBoTNpwPpKPYlbpa4T6EHIziDdFut7E9zQ2nAgnRnLnAZ9EEpek7iSYm/SDoLnAemzUG1PrDtqwIRcEri64iHFTyU6VtXBwwqphRRE2qF0Q1ETZb3VKtPzUc4c3Rf90ToAeC3En8CXgIubd/IbqCGq4D4PPAg8GOsB1Yrn0wLCVShFCgJ1ZA0IA2MqSmmCkcS5pn9/SM+c/SobgFuAx4FzgIfdzI7I1dKI+Ba4Dugn9bq+2qyX+uyCqKYwU3bhqyJn4i0yIRa3dgaIStkctPRo/pRBMeBXwHPdjBreQ4DOQbcD/ykVt87zezPs7v+jZHi5n4FqJoIUwWSYc1OUBMyTaZIG5uTx47pkQguAR8C/9j2zDaQAtwB/DDT964mHZ3mRrcXWdQsrhSqEKX5Qtk8Q90UZybYIvt6MBInjx/XQ8C/u3lfXyTaBnIt8D3g26uJk9Nk5rn5AIOimdTuQYRauSw79fftZmKAed4GIUImCjcd3dfDwHPAe8BHALHFzF3Ad6fZX5wnmGeY66KxcbIF4kpjbVeBTfdK88s0wzSZgxUcHMA8++5eDDcsGBYgJ4Bv2tw+z4xz3Rgus3nEXf+d0mtc4IWVqwIy0wSryaxWZrViHzjTDz9uA/kCcG+tPt1u3rR3M1nb0Ls3aPG89ItdaQ4DWfarc2N6miCTO4GvAtcsQAbgFuDmTPbboo0U6U1zWoPYAdQB77Cxy0/2CqrZJZ/NNPkU8JWeWRq2gJyqiTLBuQAwRusTsryX7mwtP6v/3Py76Se7Ui1+q0uVwZc6kIiu0fU2x7dPvKY3t6l2p9trytO+wsxr6TgkFRupsu172uaUTYmeH9fY3vO26/pNN1R30+Y2GK9pb6beZmsXTOYhUO33E8BRIJYcKTtVuM0KrU27g8jYunE1GSYFGUYVWu6aKEthLztpx7wdlGzH0msSuMxWLu6s7z5ZU74wUE0No5pIsY74tl20EIvWRyK0Zmk5XTbPrAwr2x6AGXhX0iWpL6YbbqGWLonaabRUwbwBIWVrQB2MEeFlRDShQ4HYAu99w0Wnc6A1ntclLkRgqbOrTYveZaU1slqN1MJKaxYSHBsfBKhPYrn8eQEjPFfexLyb6Tp0SV4FzpegRjBELKPidop2j3TdtNZyVxK7sxHtqxQhjCPIPqOCcbKaJ16xfd5JLh55DXi+FO6O4HMlRI1Nw8rcsMK6hLuX6sIGmOyZEkSBUtrRJZE1u0ljyZ03psnnbD7IuhkV3wOeitC3xsGnaiXKptbXEtmGFHlFZ2monA2EMynu3dkmFLh0rVrq1WmlZzN9zubjzA2QA+Bp4G/DwK1D5WRmmyXoM0UeDqeeJetydxsh7cRFjc0+RLWS759L4eTtg4N80uZlJ3UbiGlDyu8jdOc4+BtO9pxaO4vtkPJuOa7T2MalOx0hRauWkpDCjeKPVwd63OYpm/eb+XcHo0vAU8Ad46jTtm9LU1r5GKq20rLbfivDnb2yFkWisdOuXuJoqrOeqbMfs3nRZqYze3hm/S/wO+D6vT39AHyjRNEs5mjziVPr7qs+eUkm2H6kbFUVNH+ETMCEObda+TeYvwIfbvelw0ASeJk2aWtvTw9JvinEXoSogupNg2tstddW8iYChoDSn5MjTAl/DHp+tfKvJf0ReMe9ES1gPum5ZgJeAH4BnB9Hfb8U3zlNHJ8LUavW1bTd5pcoL2UBAcPgOg56D3h6nv0o8Gfht+lz1tpjefUnvQn4J/BL4IUIPXLkCPeM6RvmyomslPQukOitIQoeCtMwcCFCrzn9RE0ekzgLXFisxaEK/LRn3wq8BfwB+Dtwf4Qe2Au+xsh1Nsf66FA6I3MElyV9CLxp80ymnwDOSrwDTBxK620wn/lviV5NLwH/AR6nTXO3S9wi6TRtnjBwEXjL9isSLwNv2HwAmg9Nkp94/T9AFuyXgTc6S88Ae3196Z+Zu6SzTaUZf3Psz7j+Bx0371wAFou/AAAAAElFTkSuQmCC" />
                    </svg>
                </div>
            </div>
            <div class="main-image">
                <img src="<?php echo $home_options['home_header_image_content']; ?>" alt="" />
            </div>
            <div class="text-field">
                <p>
                    <?php
                    echo $home_options['home_header_side_text'];
                    ?>
                </p>
            </div>
        </div>
    </div>
</section>
<!--************************* end header information *************************-->