<? VerifyAccess_x('main.templ');
//$aRes - is incoming data array from controllers 
//$aSets - Page Settings array (defined at admin side: settings)
//TEMPLATE_PAGE_DIR - RELATIVE site page template folder
//TEMPLATE_HOST_DIR - FULL HOST template path
//aprint_x($aRes['SECTIONS']);
$aNodImg = array(1 => 100019, 2 => 100005, 3 => 100002, 4 => 100013, 5 => 100006, 6 => 103099, 7 => 100011, 8 => 100016, 9 => 100050, 10 => 100008, 11 => 100001, 12 => 100010, 13 => 100239, 14 => 100240, 15 => 100018, 16 => 100014, 17 => 100214, 18 => 100012, 19 => 100007, 20 => 100004, 21 => 100733, 22 => 100243, 23 => 100241, 24 => 100400, 25 => 100343, 26 => 100254, 27 => 100685, 28 => 103202, 29 => 100417, 30 => 100341, 31 => 100335, 32 => 103168, 33 => 100339, 34 => 104152);
$SubSecView = $aSets['VIEWED_SECTIONS']; //Number of viewed subsections inside parent block
if ($SubSecView <= 0) {
	$SubSecView = 6;
}
?>
<div class="CmTopBox">
	<? if ($aSets['SHOW_MSELECT']) {
		$MSelect_Position = 'Right'; //Left
	?><div class="CmMSelectBlock CmMSelectPosition<?= $MSelect_Position ?>"><?
																				$Selector_Template = 'default';
																				include_once(PATH_x . '/add/selector/controller.php');
																				?></div><?
				}
					?>
</div>
<? //=ShowSEOText_x("TOP")
?>
<!--<div class="CmBrTitleSearchWrap CmColorBgL CmColorBr">-->
<!--    <div id="CmTitlH1Page"><h1 class="CmColorTx">--><? //=H1_x
														?><!--</h1></div>-->
<!--</div>-->
<main class="main-content js-focus-hidden" id="MainContent" role="main" tabindex="-1">
	<div>
		<div class="halo-section banner-block-1  padding-bottom-30  " data-section-id="1573726840862" data-section-type="banner block 1">
			<div class="container">
				<div class="section-header text-center">
					<div class="container" style="background-color: #f7f7f7">
						<h1 class="page-heading"><?= H1_x ?></h1>

						<!--                <a class="text-link" href="index.html#" aria-label="link">-->
						<!--                    view all-->
						<!--                </a>-->
					</div>
					<? $_SESSION['SECTIONS'] = $aRes['SECTIONS'];
					//include_once('top_first.php');
					?>

					<? //include_once('top_second.php');
					?>
					<? if ($aSets['MANUFACTURERS_IN_TOP']) {
						include('manufacturers.php');
					} ?>

					<? if (!$aSets['HIDE_SECTIONS']) { ?>
						<? if ($aSets['MAINPAGE_DESIGN']) { ?>

							<div class="halo-row halo-row-custom column-1" id="categories-grid">
								<? foreach ($aRes['SECTIONS'] as $aSct) {
									if (!isset($aSct['FURL'])) {
										continue;
									} ?>
									<div class="halo-item">
										<div class="card-text-overlay layout-1 card-text-overlay--light">
											<div class="image">
												<img class=" ls-is-cached lazyloaded" src="/<?= CM_DIR ?>/media/sections/<?= $aSct['NOD'] ?>.png" data-src="/<?= CM_DIR ?>/media/sections/<?= $aSct['NOD'] ?>.png" alt="" data-image="">
											</div>
											<div class="content">
												<p class="description">
													<a href="<?= FURL_x ?>/<?= $aSct['FURL'] ?>/" aria-label="link">
														<?= $aSct['NAME'] ?>
													</a>
												</p>
											</div>
											<a class="link" href="<?= FURL_x ?>/<?= $aSct['FURL'] ?>/" aria-label="link"></a>
										</div>
									</div>
								<? } ?>
							</div>
						<? } else { ?>
							<div class="CmSectionWrapBl">
								<? if (count($aRes['SECTIONS']) > 2) { ?>
									<div class="CmSearcSectInput">
										<div><input class="CmInputSect CmColorBr CmColorTx" data-lng="<?= $aLngCode ?>" type="text" placeholder="<?= Lng_x('Find product section', 0) ?>.."></div>
										<div class="clearButt CmColorBgh">
											<svg class="material-icon" viewBox="0 4 24 24">
												<path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
											</svg>
										</div>
									</div>
								<? } ?>
								<div class="boxSections_x">
									<div class="non_res">No result</div>
									<? foreach ($aRes['SECTIONS'] as $aSect) {
										$ctnSect++;
										$ChCnt = 0;
										$ShowMoreSub = false;
										$ChCount = count($aSect['CHILDS']); ?>
										<div class="boxSect_x f_box boxSel_x CmColorBrh" style="<? if ($ctnSect > $aSets['VISIBLE_SECTIONS_COUNT'] && $ctnSect > 6) { ?>display:none<? } ?>">
											<div class="boxOverLSect">
												<div class="CmListSectBl">
													<div class="nameSect_x CmColorTx f_title" data-fil="<?= $ctnSect ?>"><?= $aSect['NAME'] ?></div>
													<ul class="CmListSect">
														<? foreach ($aSect['CHILDS'] as $aChild) {
															$ChCnt++; ?>
															<li class="CmColorTxh sh_list f_list no_a_list" title="<?= $aChild['NAME'] ?>">
																<a class="" href="<?= FURL_x ?>/<?= $aChild['FURL'] ?>/"><?= $aChild['NAME'] ?></a>
															</li>
															<? if ($ChCnt == $SubSecView and $ChCount > ($SubSecView + 1)) {
															?><li class="showAllSect" showLNext="sectL<?= $ctnSect; ?>"><?= Lng_x('All_sections') ?> <span>&#9660;</span></li><?
																																																	$ShowMoreSub = true;
																																																	break;
																																																} ?>
														<? } ?>
													</ul>
												</div>
												<? if ($ShowMoreSub) { ?>
													<div id="sectL<?= $ctnSect ?>" class="CmListNSectBl CmColorBr" style="display:none;">
														<ul><? $ctnC = 0;
															foreach ($aSect['CHILDS'] as $aChild) {
																$ctnC++; ?>
																<? if ($ctnC > $SubSecView) { ?>
																	<li class="CmColorTxh hi_list f_Hlist" title="<?= $aChild['NAME'] ?>">
																		<a class="" href="<?= FURL_x ?>/<?= $aChild['FURL'] ?>/"><?= $aChild['NAME'] ?></a>
																	</li>
																<? } ?>
															<? } ?>
														</ul>
														<div class="hideAllSect CmColorTxh">&#9650;</div>
													</div>
												<? } ?>
											</div>
											<div class="CmSectImgBL CmSec_<?= $aNodImg[$aSect['NOD']] ?>"></div>
										</div>
									<? //if($ctnSect>5){break;}
									} ?>
								</div>
								<? if ((count($aRes['SECTIONS']) > 6 && $aSets['VISIBLE_SECTIONS_COUNT'] < count($aRes['SECTIONS']))) { ?>
									<div class="butAllSec c_TxHov"><?= Lng_x('More_sections') ?> <span>&#9660;</span></div>
								<? } ?>
							</div>
						<? } ?>
					<? } ?>
					<? if (!$aSets['MANUFACTURERS_IN_TOP']) {
						include('manufacturers.php');
					} ?>
					<br />
					<? aprint_x($aSect, '$aSect'); ?>
					<?= ShowSEOText_x("BOT") ?>