<? VerifyAccess_x('ProductListList.templ'); ?>
<? //print_r($_REQUEST);
?>
<?
//RATING STARS FUNCTION
function renderStarRating($rating, $maxRating = 5)
{
    $fullStar = '<svg viewBox="0 0 24 24" width="22"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>';
    $halfStar = '<svg viewBox="0 0 24 24" width="22"><path d="M12 5.173l2.335 4.817 5.305.732-3.861 3.71.942 5.27-4.721-2.524v-12.005zm0-4.586l-3.668 7.568-8.332 1.151 6.064 5.828-1.48 8.279 7.416-3.967 7.416 3.966-1.48-8.279 6.064-5.827-8.332-1.15-3.668-7.569z"/></svg>';
    $emptyStar = '<svg viewBox="0 0 24 24" width="22"><path d="M12 5.173l2.335 4.817 5.305.732-3.861 3.71.942 5.27-4.721-2.524-4.721 2.525.942-5.27-3.861-3.71 5.305-.733 2.335-4.817zm0-4.586l-3.668 7.568-8.332 1.151 6.064 5.828-1.48 8.279 7.416-3.967 7.416 3.966-1.48-8.279 6.064-5.827-8.332-1.15-3.668-7.569z"/></svg>';
    $rating = $rating / 999 * 5.001;
    // $rating = $rating <= $maxRating?$rating:$maxRating;

    $fullStarCount = (int) $rating;
    $halfStarCount = round($rating) - $fullStarCount;
    $emptyStarCount = $maxRating - $fullStarCount - $halfStarCount;

    $html = str_repeat($fullStar, $fullStarCount);
    $html .= str_repeat($halfStar, $halfStarCount);
    $html .= str_repeat($emptyStar, $emptyStarCount);
    $html = '<div class="cmRatingSt_l">' . $html . '</div>';
    return $html;
}
// END RATING STARS FUNCTION

?>
<div class="cm_listView" id="main-collection-product-grid">
    <div class="main_bl halo-column halo-column-product">
        <? $index = 0; ?>
        <? foreach ($aRes['PRODUCTS'] as $PKEY => $aProd) {
            $bColor = mb_strlen($aProd['BColor']) == 3 ? str_repeat($aProd['BColor'], 2) : $aProd['BColor']; ?>
            <div class="halo-item e">
                <div class="product-card layout-1" data-product-card="" data-product-id="product-4356682154059" data-id="4356682154059">
                    <div class="product-image">
                        <div class="product_badges"></div>
                        <a class="product-link image-swap" href="<?= $aProd['Link'] ?>" aria-label="link">
                            <? if (($aProd['Schema_src'] && $aProd['Schema_src'] != '') || ($aProd['Image'] && $aProd['Image'] != '')) {
                                if ($aProd['Schema_src'] || $aProd['Image']) { ?>
                                    <? if ($aProd['Schema_src'] && $aProd['Schema_src'] != '') { ?>
                                        <img class="image-one lazyautosizes lazyloaded" src="<?= $aProd['Schema_src'] ?>" data-src="<?= $aProd['Schema_src'] ?>" data-sizes="auto" alt="<?= $aProd['Brand'] . ' ' . $aProd['ArtNum'] . ' - ' . $aProd['Name'] . ' ' . $_SERVER['SERVER_NAME'] ?>" data-image="" sizes="280px">
                                        <img class="image-two lazyautosizes lazyloaded" src="<?= $aProd['Schema_src'] ?>" data-src="<?= $aProd['Schema_src'] ?>" data-sizes="auto" alt="<?= $aProd['Brand'] . ' ' . $aProd['ArtNum'] . ' - ' . $aProd['Name'] . ' ' . $_SERVER['SERVER_NAME'] ?>" data-image="" sizes="280px">
                                    <? } else if ($aProd['Image'] && $aProd['Image'] != '') { ?>
                                        <img class="image-one lazyautosizes lazyloaded" src="<?= $aProd['Image'] ?>" data-src="<?= $aProd['Image'] ?>" data-sizes="auto" alt="<?= $aProd['Brand'] . ' ' . $aProd['ArtNum'] . ' - ' . $aProd['Name'] . ' ' . $_SERVER['SERVER_NAME'] ?>" data-image="" sizes="280px">
                                        <img class="image-two lazyautosizes lazyloaded" src="<?= $aProd['Image'] ?>" data-src="<?= $aProd['Image'] ?>" data-sizes="auto" alt="<?= $aProd['Brand'] . ' ' . $aProd['ArtNum'] . ' - ' . $aProd['Name'] . ' ' . $_SERVER['SERVER_NAME'] ?>" data-image="" sizes="280px">
                                    <? } ?>
                                <? }
                            } else { ?>
                                <div class="CmNoFotoImg">
                                    <?= $aListSVG['CmNoFotoImg'] ?>
                                </div>
                            <? } ?>
                        </a>
                        <div class="product-action">
                            <form action="" method="post" class="variants" enctype="multipart/form-data">
                                <a class="btn product-btn" href="<?= $aProd['Link'] ?>" aria-label="button">
                                    Choose options
                                </a>
                            </form>
                        </div>
                    </div>
                    <div class="product-content">
                        <div class="product-detail">
                            <div>
                                <div class="product-vendor">
                                    <a href="<?= $aProd['Link'] ?>" title="<?= $aProd['Name'] ?>">
                                        <?= $aProd['Name'] ?>
                                    </a>
                                </div>
                                <h4 class="product-title">
                                    <a href="<?= $aProd['Link'] ?>" aria-label="title"><b><?= $aProd['Brand'] ?></b> <?= $aProd['ArtNum'] ?></a>
                                </h4>
                                <!-- <div class="product-reviews">
                                    <span class="spr-badge" data-id="4356682154059" id="spr_badge_4356682154059" data-rating=""><i class="spr-icon spr-icon-star-empty"></i><i class="spr-icon spr-icon-star-empty"></i><i class="spr-icon spr-icon-star-empty"></i><i class="spr-icon spr-icon-star-empty"></i><i class="spr-icon spr-icon-star-empty"></i></span>
                                    <div class="product-compare-btn " data-icon-compare="" data-compare-product-handle="lobortis-maxim-tesque-lobortis-acuinon-efficitur-dapinica" data-id="4356682154059">
                                        <input id="compare_4356682154059" class="compare" type="checkbox" name="compare">
                                        <label for="compare_4356682154059">
                                            <span>compare</span>
                                        </label>
                                    </div>
                                </div> -->
                                <div class="product-price " data-price="">
                                    <span class="price-item price-item--regular" <? if ($aProd['PRICES'][0]['PRICE_DISCOUNTED']) { ?>style="text-decoration: line-through;" <? } ?> data-regular-price="">
                                        <span class="money" data-currency-usd="<?= $aProd['PRICES'][0]['PRICE_CURRENCY'] ?><?= $aProd['PRICES'][0]['PRICE_FORVIEW'] ?>">
                                            €<?= $aProd['PRICES'][0]['PRICE_FORVIEW'] ?>
                                        </span>
                                    </span>
                                    <? if ($aProd['PRICES'][0]['PRICE_DISCOUNTED']) { ?>
                                        <span class="price-item price-item--sale" data-sale-price="<?= $aProd['PRICES'][0]['PRICE_CURRENCY'] ?><?= $aProd['PRICES'][0]['PRICE_DISCOUNTED'] ?>">
                                            €<?= $aProd['PRICES'][0]['PRICE_DISCOUNTED'] ?>
                                        </span>
                                    <? } ?>
                                </div>
                            </div>
                            <div class="hide">
                                <div class="sku-product">
                                    <span class="value">IN00F-1</span>
                                </div>
                                <div class="collection-product">
                                    <span class="value">Accéssorius</span>
                                    <span class="value">all</span>
                                    <span class="value">Comodianos</span>
                                    <span class="value">Dincidunteros</span>
                                    <span class="value">Gravidas</span>
                                    <span class="value">Hendrer Dulamcos</span>
                                    <span class="value">Interior</span>
                                    <span class="value">Loremous Comodous</span>
                                    <span class="value">Nor Loremirus</span>
                                    <span class="value">Pellentes Habitanto</span>
                                    <span class="value">Scelerisque Dapboe</span>
                                    <span class="value">Sustoproine</span>
                                </div>
                            </div>
                            <div class="product-description">
                                <? if ($aProd['PROPERTIES']) {
                                    $i = 0; ?>
                                    <div class="CmPropsWrapBl CmColorOu" <? if (count($aProd['PROPERTIES']) > 4) { ?>data-props="Y" <? } ?>>
                                        <? foreach ($aProd['PROPERTIES'] as $propN => $propV) {
                                            $i++;
                                            //if($i<=4){
                                        ?>
                                            <div class="CmPropsListItem CmListProps">
                                                <div class="CmPropsInnerBlock">
                                                    <span class="CmPropDesc"><?= $propN ?></span>
                                                    <? if (mb_strlen(strip_tags($propV)) > 25) { ?>
                                                        <br>
                                                    <? } ?>
                                                    <? if ($propV != '') { ?>
                                                        <span class="CmPropVal" data-str="<?= mb_strlen(strip_tags($propV)) ?>"><b><?= $propV ?></b></span>
                                                    <? } ?>
                                                </div>
                                            </div>
                                            <!-- <div class="CmPropsListItem CmListProps">
                                                    <span class="CmPropDesc"><?= $propN ?></span>
                                                    <? if (mb_strlen(strip_tags($propV)) > 25) { ?>
                                                        <br>
                                                    <? } ?>
                                                    <? if ($propV != '') { ?>
                                                        <span class="CmPropVal" data-str="<?= mb_strlen(strip_tags($propV)) ?>"><b><?= $propV ?></b></span>
                                                    <? } ?>
                                                </div>-->
                                            <? //continue;}
                                            ?>
                                            <!-- <div class="CmPropsListItem CmListProps_2">
                                                <span class="CmPropDesc"><?= $propN ?></span>
                                                <? if (mb_strlen(strip_tags($propV)) > 25) { ?>
                                                    <br>
                                                <? } ?>
                                                <? if ($propV != '') { ?>
                                                    <span class="CmPropVal" data-str="<?= mb_strlen(strip_tags($propV)) ?>"><b><?= $propV ?></b></span>
                                                <? } ?>
                                            </div> -->
                                            <? //}
                                            ?>
                                            <? //if(count($aProd['PROPERTIES'])>4){
                                            ?>
                                            <!-- <div class="CmHideOverBl"></div> -->
                                        <? } ?>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                        <div class="product-actions">
                            <div class="product-action">
                                <form class="variants" enctype="multipart/form-data">
                                    <a class="btn product-btn <? if (!isset($aProd['PRICES'][0]['PriceID'])) {
                                                                    echo ('disable');
                                                                } ?>" aria-label="button">
                                        <div class="o CmTablePrToCart <? if (isset($aProd['PRICES'][0]['PriceID'])) {
                                                                            echo ('CmAddToCart');
                                                                        } ?>" data-furl="<?= $aProd['Link'] ?>" data-priceid="<?= $aProd['PRICES'][0]['PriceID'] ?>">
                                            <? if (!isset($aProd['PRICES'][0]['PriceID'])) {
                                                echo ('Out of stock');
                                            } else {
                                                echo ('Add to cart');
                                            } ?>
                                        </div>
                                    </a>
                                </form>
                            </div>
                            <!-- <button class="wishlist btn btn--secondary " data-icon-wishlist="" data-product-handle="lobortis-maxim-tesque-lobortis-acuinon-efficitur-dapinica" data-id="4356682154059">
                                <span class="add">Add to Wish List</span>
                                <span class="remove">Remove Wish List</span>
                            </button> -->
                            <? if (!isset($aProd['PRICES'][0]['PriceID'])) { ?>
                                <div class="cmNoInStockForm" action="index.php?route=product/product/notify" method="post">
                                    <label>Notify me when available</label>
                                    <input type="text" name="email" placeholder="Input your e-main" required>
                                    <button id="cmNoInStockFormBtn<?= $index ?>" data-product-id="<?= $aProd['PKey'] ?>">Notify me</button>
                                </div>
                                <script>
                                    (() => {
                                        const btn = document.querySelector('#cmNoInStockFormBtn<?= $index ?>');
                                        btn.addEventListener('click', function() {
                                            const productId = this.dataset.productId;
                                            const email = this.previousElementSibling.value;

                                            const url = 'index.php?route=product/notify/notify';

                                            const data = {
                                                product_id: productId,
                                                email: email
                                            };

                                            if (email != '') {
                                                fetch(url, {
                                                        method: 'POST',
                                                        body: JSON.stringify(data),
                                                        headers: {
                                                            'Content-Type': 'application/json'
                                                        }
                                                    })
                                                    .then(function(response) {
                                                        if (response.ok) {
                                                            return response.json();
                                                        }
                                                        throw new Error('Network response was not ok.');
                                                    })
                                                    .then(function(responseData) {
                                                        alert(responseData.message);
                                                    })
                                                    .catch(function(error) {
                                                        console.log('Fetch error:', error);
                                                    });
                                            } else {
                                                alert("Please input your email")
                                            }
                                        })
                                    })()
                                </script>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
            <? $index++; ?>
        <? } ?>
    </div>
</div>