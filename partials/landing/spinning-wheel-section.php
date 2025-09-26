<section class="spinning-wheel-section">
    <div class="container spinning-wheel-container">
        <aside class="header-page-title-section">
            <div class="row">
                <div class="col-12 title-headerRental">
                    <small>WEBSITE DESIGN</small>
                    <h2>طراحی سایت</h2>
                </div>
                <?php custom_breadcrumb(); ?>
                <div class="col-12 content-title-text">
                    <p id="main-text" class="main-text">
                        <?php
                        $header_text = get_the_content();
                        if (!empty($header_text)) {
                            echo $header_text;
                        }
                        ?>
                    </p>
                </div>
                <div class="col-12 buttons">
                    <div class="blue-button main-btn-blue">
                        <a  href="
													   <?php
            $page = get_page_by_path('contact');
            if ($page) {
                $contact_url = get_permalink($page->ID);
                echo $contact_url;
            }
            ?>">مشاوره رایگان</a>
                    </div>
                    <div class="normal-button main-btn-get-blue">
                        <a  href="
														   <?php
            $page = get_page_by_path('portfolio');
            if ($page) {
                $portfolio_url = get_permalink($page->ID);
                echo $portfolio_url;
            }
            ?>">نمونه کارها</a>
                    </div>
                </div>
            </div>
        </aside>
        <aside class="wheel-container">
            <canvas id="wheel" width="420" height="420"></canvas>
            <div class="pointer">
                <svg class="main-pointer" 
                    width="50px" height="60px">
                    <image x="0px" y="0px" width="50px" height="60px"
                        xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAA8CAMAAAAT6xnzAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAB5lBMVEX/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD/1AD////2B/ZoAAAAoHRSTlMABTwjHpHiSAlhzvtYOa35cBWA54MGUcmaBCycrgsRdN3BFkq//dIhIJTz4wxk1zQ9/j8fiepQB1rQYi+mcntOxY4qmfUQbtyoQ7m0j+5fyDf80RyC2MzfpPblEnPm6QO97SmX8vDh8ZJGbSiV+OA299oIVxqB7zuywGi2JapHniug9AFPF/pTXc1Ci+w+tS1q29TEGAJLvrENE6KHhrNMbz804QAAAAFiS0dEoSnUjjYAAAAHdElNRQfpCQEWGRzfmc9rAAACCklEQVRIx5XW51cTQRTG4YsCKokgoEQCEjWEGkBQrIhRioqNIipIAMUANtBgFyxgwYpdrLx/qgvBJFtm5s7v+3PO7rkzd5dIq5QVK/UApaalr9ICq9dkwOXWEWszswCs44PsnFwstp4LNuR5EGtjPk94C7KWBQo3cUCRbzPibdnKEP7iQEKgpFQJysorkFylVwGCVdUwV1EjF9sKYa22Tga276iHvZ1isGv3Hji1Vyj2NbgcBfYLQHZjJQTlOIsDIQg76AQONTWLBQrsoKX1MGQdsYmjbZB3zAJKj59QCBSbR3GyWgWAU8miPbNDLdCZAF2ncxkA6I4L9xkWAM4uA++5HqZA7xI43xfmAqDfAAP+QT4ALhBdHLqkIxAh37AWAEZolDMLM6HLbQEtEjFev+hKt+brG129dp1P6mOTzPeH2KQ3frEaudMcSxzL8YYbLHIz6exHJzwcUmK6Yrdu31ETj+Ui373nUpH71m0RfaC6yw/tS2lyVP50Uw6bb+CRdC89dtyvwdYxMUlz3sn05Om0iAg//DPPQgLiI2HPBUeoiiS1T71wIC9lhKKzr+zkNclLffPWInrGSdW792YSnlMSCn74mEw+sf4UJ4dGEuTzFw6hr9++x8n8DxYh+ulL/3/EUpiEaO5XbAv9Zgvj6SaWhtSnQYx7/ieMwKwWMf57/0YWNAm1uL30D4gjo40WIEBNAAAAAElFTkSuQmCC" />
                </svg>
                <svg class="right-pointer" 
                    width="17px" height="70px">
                    <image x="0px" y="0px" width="17px" height="70px"
                        xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAABEAAABGCAMAAAAdOI+HAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAABcVBMVEWNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQCNdQD////xx0CZAAAAeXRSTlMABxEGGItlGRXF/O+7bCkQDZvHfUQgd9JnKwFW37x/Njn+8R0LCAW2Ap2G+W/1WvDsM+f64iXr3tka0BTCDrUJqaCZkYmBenVwaGZuc4iPmJ6nsxPAzR/bJOkq9zBAV7HOCur9NFHz5C9x8tO0QwyX1qZ5SqKvPyIDROBwYQAAAAFiS0dEejjVhWoAAAAHdElNRQfpCQEWGgWQ3zRoAAABOklEQVQ4y53U2TdCURQG8EMpJIrSgEu4V8g8JEOZMhUhZJ7neeb8985dsu49335p+d6+38sZ9lqbFRVbmBxric0uS2lZuaPCWVlliMvN9VTXeLx5sdTyfHxuf0CXYB03Ut+gNDLWFOLmNDPWIgtnrNWBovpQtDaUcLsEIXF+hySdQiKSdAnplqRHiEeSXiF9kvQLCQyYZVDI0LBZokK8UbOMCImNooyNo0zEURKTKNoUSngahc0QmSWSJDJHZJ7IQgESIbJIxEZkiYifSOpf90kX8FKFyDKRFfLzGTKdVRR1DcW1jpLdQLFvomzlULZ3UHb3UPY5ygGRQyJOIkmUYAZFO0JRj1FOTlGsZyjn8k7IMXZhtMurePqaaTe/7fbuXnlI6KN5fBL1+eX1Lfa3o7LvH6nPr29jaf0AYCuh5rTBvBoAAAAASUVORK5CYII=" />
                </svg>
            </div>
            <div class="base">
                <svg class="top-base"
                    width="238px" height="283px">
                    <image x="0px" y="0px" width="238px" height="283px"
                        xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAO4AAAEbCAMAAADqGEgOAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAC9FBMVEUADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEsADEv///884s5vAAAA+nRSTlMAYRv7H4eGB+vuW2DIzjI5nqUT9vkYdHwC2+MESFSz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" />
                </svg>
                <svg class="bott-base"
                    width="272px" height="15px">
                    <path fill-rule="evenodd" fill="rgb(20, 44, 175)"
                        d="M7.500,-0.000 L264.500,-0.000 C268.642,-0.000 272.000,3.358 272.000,7.500 L272.000,15.000 L-0.000,15.000 L-0.000,7.500 C-0.000,3.358 3.358,-0.000 7.500,-0.000 Z" />
                </svg>
            </div>
            <div class="carrousel-voice-field">
                <div class="carrousel-player">
                    <div class="border-frame"></div>
                    <div class="progress-border"></div>
                    <button>
                        <div class="inside">
                            <svg id="play-icon" viewBox="0 0 330 330">
                                <path d="M37.728,328.12c2.266,1.256,4.77,1.88,7.272,1.88c2.763,0,5.522-0.763,7.95-2.28l240-149.999
                                          c4.386-2.741,7.05-7.548,7.05-12.72c0-5.172-2.664-9.979-7.05-12.72L52.95,2.28c-4.625-2.891-10.453-3.043-15.222-0.4
                                          C32.959,4.524,30,9.547,30,15v300C30,320.453,32.959,325.476,37.728,328.12z"
                                    fill="var(--background-color)"></path>
                            </svg>
                        </div>
                    </button>
                    <audio id="result-audio" preload="auto"></audio>
                </div>
            </div>
            <button id="spin">بچرخان!</button>
            <div id="result">نتیجه: —</div>
        </aside>
    </div>
</section>