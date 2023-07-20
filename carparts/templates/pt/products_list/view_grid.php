<? VerifyAccess_x('ProductListGrid.templ'); ?>
<div class="cm_gridView">
    <div class="wrapCard halo-column halo-column-product">
        <? foreach ($aRes['PRODUCTS'] as $PKEY => $aProd) { ?>
            <div class="halo-item">
                <div class="product-card layout-1" data-product-card="" data-product-id="product-4356682154059" data-id="4356682154059">
                    <div class="product-image">
                        <!-- <a class="product_wishlist wishlist " aria-label="wishlist" data-icon-wishlist="" href="<?= $aProd['Link'] ?>" data-product-handle="lobortis-maxim-tesque-lobortis-acuinon-efficitur-dapinica" data-id="4356682154059">
                        <svg class="icon"><use xlink:href="#icon-heart"></use></svg>
                    </a> -->
                        <div class="product_badges">
                        </div>
                        <a class="product-link image-swap" href="<?= $aProd['Link'] ?>" aria-label="link">
                            <img class="image-one lazyautosizes lazyloaded" src="<?= $aProd['Image'] ?>" data-sizes="auto" alt="<?= $aProd['Brand'] . ' ' . $aProd['ArtNum'] . ' - ' . $aProd['Name'] . ' ' . $_SERVER['SERVER_NAME'] ?>" data-image="" sizes="206px">
                            <img class="image-two lazyautosizes lazyloaded" src="<?= $aProd['Image'] ?>" data-sizes="auto" alt="<?= $aProd['Brand'] . ' ' . $aProd['ArtNum'] . ' - ' . $aProd['Name'] . ' ' . $_SERVER['SERVER_NAME'] ?>" data-image="" sizes="206px">
                        </a>
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
                    </div>
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
                    <div class="product-content">
                        <div class="product-detail">
                            <div class="product-vendor">
                                <a href="<?= $aProd['Link'] ?>" title="<?= $aProd['Name'] ?>"><?= $aProd['Name'] ?></a>
                            </div>
                            <!-- <h4 class="product-title">
                            <a href="https://spark-theme-automotive.myshopify.com/collections/interior/products/lobortis-maxim-tesque-lobortis-acuinon-efficitur-dapinica" aria-label="title">Lobortis maxim tesque lobortis acuinon efficitur dapinica</a>
                        </h4> -->
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
                                    <? if ($aProd['PRICES'][0]['PRICE_FORVIEW']) { ?>
                                        <span class="money" data-currency-usd="<?= $aProd['PRICES'][0]['PRICE_CURRENCY'] ?><?= $aProd['PRICES'][0]['PRICE_FORVIEW'] ?>">
                                            € <?= $aProd['PRICES'][0]['PRICE_FORVIEW'] ?>
                                        </span>
                                    <? } ?>
                                </span>
                                <? if ($aProd['PRICES'][0]['PRICE_DISCOUNTED']) { ?>
                                    <span class="price-item price-item--sale" data-sale-price="<?= $aProd['PRICES'][0]['PRICE_CURRENCY'] ?><?= $aProd['PRICES'][0]['PRICE_DISCOUNTED'] ?>">
                                        €<?= $aProd['PRICES'][0]['PRICE_DISCOUNTED'] ?>
                                    </span>
                                <? } ?>
                            </div>
                            <!-- <div class="product-description">
                            Nam tempus turpis at metus scelerisque placerat nulla deumantos solicitud felis. Pellentesque diam dolor, elementum etos lobortis des mollis ut risus. Sedcus faucibus an...
                        </div> -->
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
                        </div>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
</div>
<? //aprint_x($aRes,'ares');
?>