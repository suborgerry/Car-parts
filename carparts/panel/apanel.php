<?php

if (!defined("CM_PROLOG_INCLUDED") || CM_PROLOG_INCLUDED !== true) {
    exit;
}
if ($_SESSION["IsADMIN_x"] == "Y") {
    global $CPMod;
    define("CM_ADMIN_PANEL", "Y");
    if (isset($_POST["teFalse"]) && $_POST["teFalse"] != "") {
        $teLang = strtoupper($_POST["teLang"]);
        $aForReq["ReType"] = 2;
        $aForReq["ReText"]["teLink"] = trim($_POST["teLink"]);
        $aForReq["ReText"]["teLang"] = $teLang;
        $aForReq["ReText"]["teFalse"] = trim($_POST["teFalse"]);
        $aForReq["ReText"]["teTrue"] = trim($_POST["teTrue"]);
        $aForReq["ReText"] = json_encode($aForReq["ReText"], JSON_UNESCAPED_UNICODE);
        SendRequest($aForReq);
    }
    if (defined("CM_ADMIN_SIDE")) {
        echo "<div id=\"AjaxPopupLoad_x\"><div class=\"AjaxPopupLoader_x\"><svg version=\"1.1\" x=\"0px\" y=\"0px\" width=\"64px\" height=\"60px\" viewBox=\"0 0 24 30\" style=\"enable-background:new 0 0 50 50;\" xml:space=\"preserve\">\n\t\t<rect x=\"0\" y=\"10\" width=\"4\" height=\"10\" fill=\"#ffffff\" opacity=\"0.2\">\n\t\t  <animate attributeName=\"opacity\" attributeType=\"XML\" values=\"0.2; 1; .2\" begin=\"0s\" dur=\"0.6s\" repeatCount=\"indefinite\" />\n\t\t  <animate attributeName=\"height\" attributeType=\"XML\" values=\"10; 20; 10\" begin=\"0s\" dur=\"0.6s\" repeatCount=\"indefinite\" />\n\t\t  <animate attributeName=\"y\" attributeType=\"XML\" values=\"10; 5; 10\" begin=\"0s\" dur=\"0.6s\" repeatCount=\"indefinite\" />\n\t\t</rect>\n\t\t<rect x=\"8\" y=\"10\" width=\"4\" height=\"10\" fill=\"#ffffff\"  opacity=\"0.2\">\n\t\t  <animate attributeName=\"opacity\" attributeType=\"XML\" values=\"0.2; 1; .2\" begin=\"0.15s\" dur=\"0.6s\" repeatCount=\"indefinite\" />\n\t\t  <animate attributeName=\"height\" attributeType=\"XML\" values=\"10; 20; 10\" begin=\"0.15s\" dur=\"0.6s\" repeatCount=\"indefinite\" />\n\t\t  <animate attributeName=\"y\" attributeType=\"XML\" values=\"10; 5; 10\" begin=\"0.15s\" dur=\"0.6s\" repeatCount=\"indefinite\" />\n\t\t</rect>\n\t\t<rect x=\"16\" y=\"10\" width=\"4\" height=\"10\" fill=\"#ffffff\"  opacity=\"0.2\">\n\t\t  <animate attributeName=\"opacity\" attributeType=\"XML\" values=\"0.2; 1; .2\" begin=\"0.3s\" dur=\"0.6s\" repeatCount=\"indefinite\" />\n\t\t  <animate attributeName=\"height\" attributeType=\"XML\" values=\"10; 20; 10\" begin=\"0.3s\" dur=\"0.6s\" repeatCount=\"indefinite\" />\n\t\t  <animate attributeName=\"y\" attributeType=\"XML\" values=\"10; 5; 10\" begin=\"0.3s\" dur=\"0.6s\" repeatCount=\"indefinite\" />\n\t\t</rect>\n\t\t<rect x=\"24\" y=\"10\" width=\"4\" height=\"10\" fill=\"#ffffff\"  opacity=\"0.2\">\n\t\t  <animate attributeName=\"opacity\" attributeType=\"XML\" values=\"0.2; 1; .2\" begin=\"0.45s\" dur=\"0.6s\" repeatCount=\"indefinite\" />\n\t\t  <animate attributeName=\"height\" attributeType=\"XML\" values=\"10; 20; 10\" begin=\"0.45s\" dur=\"0.6s\" repeatCount=\"indefinite\" />\n\t\t  <animate attributeName=\"y\" attributeType=\"XML\" values=\"10; 5; 10\" begin=\"0.45s\" dur=\"0.6s\" repeatCount=\"indefinite\" />\n\t\t</rect>\n\t  </svg></div></div>\n\t\t\n\t\t<link rel=\"stylesheet\" href=\"";
        echo aDIR_Full_x;
        echo "media/styles.css?v=";
        echo CM_VERSION;
        echo "\" type=\"text/css\">\n\t\t<link rel=\"stylesheet\" href=\"";
        echo aDIR_Full_x;
        echo "media/custom.css?v=";
        echo CM_VERSION;
        echo "\" type=\"text/css\">\n\t\t<script src=\"";
        echo aDIR_Full_x;
        echo "media/jquery.js\"></script>\n\t\t<script src=\"";
        echo aDIR_Full_x;
        echo "media/ions.min.js\"></script>\n\t\t<script src=\"";
        echo aDIR_Full_x;
        echo "media/functions.js\"></script>\n\t\t\n\t\t<div id=\"TopPanel_x\">\n\t\t\t<div class=\"TopMenu_x\">\n                <div class=\"AdmLogoLink\">\n                    <div class=\"CodeTitle\">";
        echo $TitleValue;
        echo "</div>\n                    <a href=\"";
        echo FURL_x;
        echo "/\" class=\"catalog\" title=\"";
        echo Tip_x("Catalog", 0);
        echo "\"></a>\n                </div>\n                <div class=\"AdmTopmenu\">\n                    <a href=\"";
        echo aDIR_Full_x;
        echo "?logout=Y\" class=\"logout\" title=\"";
        echo Tip_x("Logout", 0);
        echo "\"></a>\n                    <a href=\"";
        echo aDIR_Full_x;
        echo "Settings.php\" class=\"tpsetts";
        if ($TitleCode == "Settings") {
            echo "_act";
        }
        echo "\" title=\"";
        echo Tip_x("Settings", 0);
        echo "\"></a>\n\n                    <div class=\"topsubdiv\" id=\"curbut\">\n                        <a href=\"";
        echo aDIR_Full_x;
        echo "Currencies.php\" class=\"tpcurs";
        if ($TitleCode == "Currencies") {
            echo "_act";
        }
        echo "\" title=\"";
        echo Tip_x("Exchange_rates", 0);
        echo "\">\n                            <svg id=\"APsizeSVG_x\" style=\"fill:white; margin-top:5px;\" height=\"32\" viewBox=\"0 0 511.579 511.579\" width=\"32\" xmlns=\"http://www.w3.org/2000/svg\"><g><path d=\"m5.587 419.228h111.715c-36.324-28.903-59.666-73.551-59.666-123.571 0-50.019 23.341-94.667 59.665-123.57h-111.779c-3.05 0-5.522 2.481-5.522 5.54v235.995c0 3.096 2.501 5.606 5.587 5.606z\"/><path d=\"m196.047 92.351h-117.167c-2.59 0-4.689 2.106-4.689 4.705v40.945h82.254c10.315-17.803 23.854-33.232 39.602-45.65z\"/><path d=\"m511.579 336.395v-241.846c0-1.213-.984-2.197-2.197-2.197h-119.495c15.758 12.418 29.294 27.847 39.594 45.649h27.977c9.382 0 16.987 7.631 16.987 17.043v184.448h34.038c1.71 0 3.096-1.386 3.096-3.097z\"/><path d=\"m436.957 172.087h-124.71c36.324 28.903 59.665 73.551 59.665 123.57s-23.341 94.668-59.666 123.571h121.35c3.796 0 6.874-3.077 6.874-6.874v-236.753c.001-1.941-1.573-3.514-3.513-3.514z\"/><path d=\"m214.774 419.228c67.913 0 123.164-55.434 123.164-123.571 0-68.136-55.251-123.57-123.164-123.57s-123.164 55.434-123.164 123.57c0 68.137 55.252 123.571 123.164 123.571zm-57.478-141.404h6.695c7.789-35.335 39.242-61.854 76.769-61.854 9.382 0 16.987 7.631 16.987 17.043 0 9.413-7.605 17.043-16.987 17.043-18.615 0-34.6 11.489-41.299 27.767h41.299c9.382 0 16.987 7.631 16.987 17.043s-7.605 17.043-16.987 17.043h-41.299c6.699 16.279 22.683 27.768 41.299 27.768 9.382 0 16.987 7.631 16.987 17.043s-7.605 17.043-16.987 17.043c-37.528 0-68.981-26.519-76.769-61.855h-6.695c-9.382 0-16.987-7.631-16.987-17.043s7.606-17.041 16.987-17.041z\"/><path d=\"m292.885 92.351c-36.775 0-71.745 17.286-95.152 45.649h190.472c-23.398-28.362-58.429-45.649-95.32-45.649z\"/></g></svg>\n                        </a>\n                        \t\t\t\t\t</div>\n\t\t\t\t\t\n                                        <div class=\"topsubdiv\" id=\"lngbut\">\n                        <a href=\"";
        echo aDIR_Full_x;
        echo "Language.php\" class=\"tplangs";
        if ($TitleCode == "Multilanguage") {
            echo "_act";
        }
        echo "\"><b>";
        echo UWord_x(LANG_x);
        echo "</b></a>\n                        <div class=\"topsubmenu\" id=\"lngsubmenu\">\n                            ";
        foreach ($CPMod->arLangs as $Lng) {
            if (!in_array($Lng, ["nl", "da", "no", "pt", "zh", "is", "ja", "th", "he", "in", "ko"])) {
                if (in_array($Lng, $CPMod->arSettings["ACTIVE_LANGS"]) && LANG_x != $Lng) {
                    echo "<a href=\"javascript:void(0)\" class=\"AdLangElement\" onclick=\"\$('#lnv').val('";
                    echo $Lng;
                    echo "'); \$('#lnf').submit();\">";
                    echo UWord_x($Lng);
                    echo "</a>";
                }
            }
        }
        echo "                        </div>\n                    </div>\n                    <a href=\"";
        echo aDIR_Full_x;
        echo "Prices.php\" class=\"";
        if ($TitleCode == "Prices") {
            echo "tpprice_act";
        }
        echo "\"><div class=\"tpprice AdmPrBut\"></div></a>\n                                        <a href=\"";
        echo aDIR_Full_x;
        echo "Import.php\" class=\"tpimport";
        if ($TitleCode == "Import_master") {
            echo "_act";
        }
        echo "\"></b></a>\n                    <a href=\"";
        echo aDIR_Full_x;
        echo "\" class=\"tphome";
        if ($TitleCode == "") {
            echo "_act";
        }
        echo "\" title=\"";
        echo Tip_x("Admin_side", 0);
        echo "\"></a>\n                    <a href=\"";
        echo aDIR_Full_x;
        echo "Profile.php\" class=\"tradmtop";
        if ($TitleCode == "Profile") {
            echo "_act";
        }
        echo "\" title=\"";
        echo Tip_x("Profile", 0);
        echo "\"></a>\n                </div>\n                <div class=\"AdmTopButton\">\n                    <svg class=\"AdmOpenB\" width=\"24\" height=\"24\" fill-rule=\"evenodd\" clip-rule=\"evenodd\"><path d=\"M24 18v1h-24v-1h24zm0-6v1h-24v-1h24zm0-6v1h-24v-1h24z\" fill=\"#1040e2\"/><path d=\"M24 19h-24v-1h24v1zm0-6h-24v-1h24v1zm0-6h-24v-1h24v1z\"/></svg>\n                    <svg class=\"AdmCloseB\" width=\"24\" height=\"24\" fill-rule=\"evenodd\" clip-rule=\"evenodd\"><path d=\"M12 11.293l10.293-10.293.707.707-10.293 10.293 10.293 10.293-.707.707-10.293-10.293-10.293 10.293-.707-.707 10.293-10.293-10.293-10.293.707-.707 10.293 10.293z\"/></svg>                </div>\n\t\t\t</div>\n\t\t\t<form id=\"crf\" method=\"POST\"><input type=\"hidden\" name=\"SET_CUR\" id=\"crv\" value=\"\"></form>\n\t\t\t<form id=\"lnf\" method=\"POST\"><input type=\"hidden\" name=\"SET_LANG\" id=\"lnv\" value=\"\"></form>\n\t\t\t<div class=\"tclear\"></div>\n\t\t\t<script type=\"text/javascript\">\n\t\t\t\$(document).ready(function() {\n\t\t\t\t\n\t\t\t});\n\t\t\t\n\t\t\t</script>\n\t\t</div>\n\t\t";
    } else {
        echo "\t\t<link rel=\"stylesheet\" href=\"";
        echo aDIR_Full_x;
        echo "media/apanel.css?v=";
        echo CM_VERSION;
        echo "\" type=\"text/css\">\n\t\t<script src=\"";
        echo aDIR_Full_x;
        echo "media/functions.js\"></script>\n\t\t<script src=\"";
        echo aDIR_Full_x;
        echo "media/public.js\"></script>\n\t\t<link rel=\"stylesheet\" href=\"";
        echo aDIR_Full_x;
        echo "media/public.css?v=";
        echo CM_VERSION;
        echo "\" type=\"text/css\">\n\t\t<link rel=\"stylesheet\" href=\"";
        echo aDIR_Full_x;
        echo "media/custom.css?v=";
        echo CM_VERSION;
        echo "\" type=\"text/css\">\n\t\t\n\t\t<div id=\"BoxErTransfer\" class=\"fxOverlay_adm\"><div class=\"fxModal_adm\"><div class=\"fxCont_adm\">\n\t\t\t<form action=\"\" method=\"post\">\n\t\t\t\t<input type=\"hidden\" id=\"teLink\" name=\"teLink\" value=\"";
        echo $_SERVER["REQUEST_URI"];
        echo "\"/>\n\t\t\t\t<input type=\"hidden\" id=\"teLang\" name=\"teLang\" value=\"";
        echo LANG_x;
        echo "\"/>\n\t\t\t\t<table class=\"SetsTab\">\n\t\t\t\t\t<tr><td></td><td style=\"color:grey; font-size:11px;\">";
        echo $_SERVER["REQUEST_URI"];
        echo "</td></tr>\n\t\t\t\t\t<tr><td></td><td><br/></td></tr>\n\t\t\t\t\t<tr><td nowrap>";
        echo Tip_x("Incorrect_translation");
        echo ":</td>\n\t\t\t\t\t\t<td><textarea id=\"teFalse\" name=\"teFalse\" rows=\"5\" required class=\"TextA\"></textarea></td>\n\t\t\t\t\t</tr><tr><td nowrap>";
        echo Tip_x("Correct_translation");
        echo " (";
        echo LANG_x;
        echo "):</td>\n\t\t\t\t\t\t<td><textarea id=\"teTrue\" required name=\"teTrue\" rows=\"5\" class=\"TextA\"></textarea></td>\n\t\t\t\t\t</tr><tr><td></td>\n\t\t\t\t\t\t<td><br/><input type=\"submit\" class=\"ButDiv\" id=\"teSend\" style=\"float:right;\" value=\"";
        echo Tip_x("Send", 0);
        echo "\"/></td>\n\t\t\t\t\t</tr>\n\t\t\t\t</table>\n\t\t\t</form>\n\t\t</div></div></div>\n\t\t\n\t\t\n\t\t<div class=\"BoxAPanel_x\">\n\t\t\t<div class=\"PABLogo_x\">\n\t\t\t\t<div class=\"ALogo_x\"><img src=\"";
        echo aDIR_Full_x;
        echo "/media/images/minilogo40.png\"/></div>\n\t\t\t\t<div class=\"VerticalALogo_x\"><img src=\"";
        echo aDIR_Full_x;
        echo "/media/images/vertical_carmod.png\"/></div>\n\t\t\t</div>\n\t\t\t<div class=\"BoxMenuAP_x\">\n\t\t\t\t<div class=\"APLogoTop_x\">\n\t\t\t\t\t<img src=\"";
        echo aDIR_Full_x;
        echo "/media/images/minilogo40.png\"/>\n\t\t\t\t\t<span>DevSol</span>\n\t\t\t\t</div>\n\t\t\t\t<div class=\"boxBut50_x\">\n\t\t\t\t\t<div class=\"but50_x\" id=\"curbut\" style=\"width:49%; border-right:1px solid #232323;\">\n\t\t\t\t\t\t<div class=\"APBut_x\">";
        echo CURR_x;
        echo "</div>\n\t\t\t\t\t</div>\n\t\t\t\t\t<div class=\"but50_x\" id=\"lngbut\">\n\t\t\t\t\t\t<div class=\"APBut_x\">";
        echo UWord_x(LANG_x);
        echo "</div>\n\t\t\t\t\t</div>\n\t\t\t\t\t<div class=\"showMore\" id=\"cursubmenu\">\n\t\t\t\t\t\t<table><tr>\n\t\t\t\t\t\t\t";
        $cntC = 0;
        foreach ($CPMod->arCurr as $Cur => $arCur) {
            if ($Cur != CURR_x) {
                $cntC++;
                echo "\t\t\t\t\t\t\t\t<td><a href=\"javascript:void(0)\" style=\"padding:2px 10px;\" id=\"tdchcur\" onclick=\"\$('#crv').val('";
                echo $Cur;
                echo "'); \$('#crf').submit();\">";
                echo $Cur;
                echo "</a></td>\n\t\t\t\t\t\t\t\t";
                if (2 < $cntC) {
                    $cntC = 0;
                    echo "</tr><tr>";
                }
                echo "\t\t\t\t\t\t\t";
            }
        }
        echo "\t\t\t\t\t\t\t";
        foreach ($CPMod->arPriceType as $PtID => $PtName) {
            if ($_SESSION["TDM_USER_GROUP"] == $PtID) {
                $Style = "style=\"color:#FFBB00;\"";
            } else {
                $Style = "";
            }
            echo "\t\t\t\t\t\t\t\t<a href=\"javascript:void(0)\" onclick=\"\$('#ctp').val('";
            echo $PtID;
            echo "'); \$('#tpf').submit();\" ";
            echo $Style;
            echo " >";
            echo $PtName;
            echo "</a>\n\t\t\t\t\t\t\t";
        }
        echo "\t\t\t\t\t\t</table>\n\t\t\t\t\t</div>\n\t\t\t\t\t<div class=\"showMore\" id=\"lngsubmenu\">\n\t\t\t\t\t\t<table><tr>\n\t\t\t\t\t\t\t";
        $cntL = 0;
        foreach ($CPMod->arLangs as $Lng) {
            if (!in_array($Lng, ["sv", "hr", "nl", "da", "no", "pt", "zh", "is", "ja", "th", "he", "in", "ko"])) {
                echo "\t\t\t\t\t\t\t\t";
                if (in_array($Lng, $CPMod->arSettings["ACTIVE_LANGS"]) && LANG_x != $Lng) {
                    $cntL++;
                    echo "\t\t\t\t\t\t\t\t\t<td><a href=\"javascript:void(0)\" style=\"padding:2px 10px;\" onclick=\"\$('#lnv').val('";
                    echo $Lng;
                    echo "'); \$('#lnf').submit();\">";
                    echo UWord_x($Lng);
                    echo "</a></td>\n\t\t\t\t\t\t\t\t\t";
                    if (3 < $cntL) {
                        $cntL = 0;
                        echo "</tr><tr>";
                    }
                    echo "\t\t\t\t\t\t\t\t";
                }
                echo "\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t";
            }
        }
        echo "\t\t\t\t\t\t</table>\n\t\t\t\t\t</div>\n\t\t\t\t</div>\n\t\t\t\t";
        if (CM_CONTROLLER == "product_page") {
            echo "\t\t\t\t\t<div id=\"boxShowPC_x\">\n\t\t\t\t\t\t<div class=\"APBut_x\">\n\t\t\t\t\t\t\t<svg class=\"APsizeSVG_x\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\">\n\t\t\t\t\t\t\t\t<path d=\"M444.862,109.779L338.221,3.138C336.29,1.201,333.621,0,330.667,0h-224C83.146,0,64,19.135,64,42.667v426.667\n\t\t\t\t\t\t\t\t\tC64,492.865,83.146,512,106.667,512h298.667C428.854,512,448,492.865,448,469.333v-352\n\t\t\t\t\t\t\t\t\tC448,114.379,446.799,111.71,444.862,109.779z M160,149.333c-17.646,0-32-14.354-32-32c0-13.888,8.944-25.617,21.333-30.035\n\t\t\t\t\t\t\t\t\tv-1.965c0-5.896,4.771-10.667,10.667-10.667s10.667,4.771,10.667,10.667h10.667C187.229,85.333,192,90.104,192,96\n\t\t\t\t\t\t\t\t\ts-4.771,10.667-10.667,10.667H160c-5.875,0-10.667,4.781-10.667,10.667c0,5.885,4.792,10.667,10.667,10.667\n\t\t\t\t\t\t\t\t\tc17.646,0,32,14.354,32,32c0,13.888-8.944,25.617-21.333,30.035V192c0,5.896-4.771,10.667-10.667,10.667\n\t\t\t\t\t\t\t\t\ts-10.667-4.771-10.667-10.667h-10.667c-5.896,0-10.667-4.771-10.667-10.667c0-5.896,4.771-10.667,10.667-10.667H160\n\t\t\t\t\t\t\t\t\tc5.875,0,10.667-4.781,10.667-10.667S165.875,149.333,160,149.333z M266.667,448h-128c-5.896,0-10.667-4.771-10.667-10.667\n\t\t\t\t\t\t\t\t\tc0-5.896,4.771-10.667,10.667-10.667h128c5.896,0,10.667,4.771,10.667,10.667C277.333,443.229,272.563,448,266.667,448z\n\t\t\t\t\t\t\t\t\t M373.333,384H138.667c-5.896,0-10.667-4.771-10.667-10.667c0-5.896,4.771-10.667,10.667-10.667h234.667\n\t\t\t\t\t\t\t\t\tc5.896,0,10.667,4.771,10.667,10.667C384,379.229,379.229,384,373.333,384z M373.333,320H138.667\n\t\t\t\t\t\t\t\t\tc-5.896,0-10.667-4.771-10.667-10.667c0-5.896,4.771-10.667,10.667-10.667h234.667c5.896,0,10.667,4.771,10.667,10.667\n\t\t\t\t\t\t\t\t\tC384,315.229,379.229,320,373.333,320z M373.333,256H138.667c-5.896,0-10.667-4.771-10.667-10.667\n\t\t\t\t\t\t\t\t\tc0-5.896,4.771-10.667,10.667-10.667h234.667c5.896,0,10.667,4.771,10.667,10.667C384,251.229,379.229,256,373.333,256z\n\t\t\t\t\t\t\t\t\t M373.333,192h-128c-5.896,0-10.667-4.771-10.667-10.667c0-5.896,4.771-10.667,10.667-10.667h128\n\t\t\t\t\t\t\t\t\tc5.896,0,10.667,4.771,10.667,10.667C384,187.229,379.229,192,373.333,192z M362.667,106.667\n\t\t\t\t\t\t\t\t\tc-11.771,0-21.333-9.573-21.333-21.333V36.417l70.25,70.25H362.667z\"/>\n\t\t\t\t\t\t\t</svg>&ensp;\n\t\t\t\t\t\t";
            echo Tip_x("Product_card");
            echo " &#9660;</div>\n\t\t\t\t\t\t<div class=\"showMore\" style=\"display:block;\">\n\t\t\t\t\t\t\t<a id=\"EditPrice\" class=\"\" data-path=\"";
            echo CM_DIR . "/" . CM_ADM;
            echo "\" data-pkey=\"";
            echo $aRes["PKey"];
            echo "\" data-brand=\"";
            echo $aRes["BKey"];
            echo "\" data-art=\"";
            echo $aRes["ArtNum"];
            echo "\" data-type=\"";
            echo $aRes["ProdID"];
            echo "\" style=\"";
            if ($aSets["NOT_HIDE_PRICES"] == 1) {
                echo "order:2;";
            }
            echo "\">\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span>";
            echo Tip_x("Add_price", 0);
            echo "</span>\n\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>\n\t\t\t\t";
        }
        echo "\t\t\t\t<div class=\"\" id=\"ptbut\">\n\t\t\t\t\t<div class=\"APBut_x\">\n\t\t\t\t\t\t<svg class=\"APsizeSVG_x\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 542.183 542.183\">\n\t\t\t\t\t\t\t<path d=\"M432.544,310.636c0-9.897-3.521-18.559-10.564-25.984L217.844,80.8c-7.232-7.238-16.939-13.374-29.121-18.416\n\t\t\t\t\t\t\t\tc-12.181-5.043-23.319-7.565-33.407-7.565H36.545c-9.896,0-18.464,3.619-25.694,10.848C3.616,72.9,0,81.466,0,91.365v118.771\n\t\t\t\t\t\t\t\tc0,10.088,2.519,21.219,7.564,33.404c5.046,12.185,11.187,21.792,18.417,28.837L230.12,476.799\n\t\t\t\t\t\t\t\tc7.043,7.043,15.608,10.564,25.694,10.564c9.898,0,18.562-3.521,25.984-10.564l140.186-140.47\n\t\t\t\t\t\t\t\tC429.023,329.284,432.544,320.725,432.544,310.636z M117.204,172.02c-7.139,7.138-15.752,10.709-25.841,10.709\n\t\t\t\t\t\t\t\tc-10.085,0-18.698-3.571-25.837-10.709c-7.139-7.139-10.705-15.749-10.705-25.837c0-10.089,3.566-18.702,10.705-25.837\n\t\t\t\t\t\t\t\tc7.139-7.139,15.752-10.71,25.837-10.71c10.089,0,18.702,3.571,25.841,10.71c7.135,7.135,10.707,15.749,10.707,25.837\n\t\t\t\t\t\t\t\tC127.91,156.271,124.339,164.881,117.204,172.02z\"/>\n\t\t\t\t\t\t\t<path d=\"M531.612,284.655L327.473,80.804c-7.23-7.238-16.939-13.374-29.122-18.417c-12.177-5.042-23.313-7.564-33.402-7.564\n\t\t\t\t\t\t\t\th-63.953c10.088,0,21.222,2.522,33.402,7.564c12.185,5.046,21.892,11.182,29.125,18.417l204.137,203.851\n\t\t\t\t\t\t\t\tc7.046,7.423,10.571,16.084,10.571,25.981c0,10.089-3.525,18.647-10.571,25.693L333.469,470.519\n\t\t\t\t\t\t\t\tc5.718,5.9,10.759,10.182,15.133,12.847c4.38,2.666,9.996,3.998,16.844,3.998c9.903,0,18.565-3.521,25.98-10.564l140.186-140.47\n\t\t\t\t\t\t\t\tc7.046-7.046,10.571-15.604,10.571-25.693C542.179,300.739,538.658,292.078,531.612,284.655z\"/>\n\t\t\t\t\t\t</svg>&ensp;\n\t\t\t\t\t";
        echo Tip_x($CPMod->UserGroupName, 0);
        echo " &#9660;</div>\n\t\t\t\t\t<div class=\"showMore\" id=\"ptsubmenu\">\n\t\t\t\t\t\t";
        foreach ($CPMod->aUserGroups as $GrID => $aGr) {
            if ($CPMod->UserGroupName != $aGr["NAME"]) {
                echo "\t\t\t\t\t\t\t<a href=\"javascript:void(0)\" onclick=\"\$('#ctp').val('";
                echo $GrID;
                echo "'); \$('#tpf').submit();\">";
                echo Tip_x($aGr["NAME"], 0);
                echo "</a>\n\t\t\t\t\t\t";
            }
        }
        echo "\t\t\t\t\t</div>\n\t\t\t\t</div>\n\t\t\t\t<a href=\"javascript:void(0);\" class=\"APBut_x meta ";
        if ($_REQUEST["hseom"] == "Y") {
            echo "bactive";
        }
        echo "\" id=\"metabut\" title=\"\">\n\t\t\t\t\t<svg class=\"APsizeSVG_x\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 486.742 486.742\">\n\t\t\t\t\t\t<path d=\"M33,362.371v78.9c0,4.8,3.9,8.8,8.8,8.8h61c4.8,0,8.8-3.9,8.8-8.8v-138.8l-44.3,44.3\n\t\t\t\t\t\t\tC57.9,356.071,45.9,361.471,33,362.371z\"/><path d=\"M142,301.471v139.8c0,4.8,3.9,8.8,8.8,8.8h61c4.8,0,8.8-3.9,8.8-8.8v-82.3c-13.9-0.3-26.9-5.8-36.7-15.6L142,301.471z\"/><path d=\"M251,350.271v91c0,4.8,3.9,8.8,8.8,8.8h61c4.8,0,8.8-3.9,8.8-8.8v-167.9l-69.9,69.9\n\t\t\t\t\t\t\tC257,345.971,254.1,348.271,251,350.271z\"/><path d=\"M432.7,170.171l-72.7,72.7v198.4c0,4.8,3.9,8.8,8.8,8.8h61c4.8,0,8.8-3.9,8.8-8.8v-265.6c-2-1.7-3.5-3.2-4.6-4.2\n\t\t\t\t\t\t\tL432.7,170.171z\"/><path d=\"M482.6,41.371c-2.9-3.1-7.3-4.7-12.9-4.7c-0.5,0-1.1,0-1.6,0c-28.4,1.3-56.7,2.7-85.1,4c-3.8,0.2-9,0.4-13.1,4.5\n\t\t\t\t\t\t\tc-1.3,1.3-2.3,2.8-3.1,4.6c-4.2,9.1,1.7,15,4.5,17.8l7.1,7.2c4.9,5,9.9,10,14.9,14.9l-171.6,171.7l-77.1-77.1\n\t\t\t\t\t\t\tc-4.6-4.6-10.8-7.2-17.4-7.2c-6.6,0-12.7,2.6-17.3,7.2L7.2,286.871c-9.6,9.6-9.6,25.1,0,34.7l4.6,4.6c4.6,4.6,10.8,7.2,17.4,7.2\n\t\t\t\t\t\t\ts12.7-2.6,17.3-7.2l80.7-80.7l77.1,77.1c4.6,4.6,10.8,7.2,17.4,7.2c6.6,0,12.7-2.6,17.4-7.2l193.6-193.6l21.9,21.8\n\t\t\t\t\t\t\tc2.6,2.6,6.2,6.2,11.7,6.2c2.3,0,4.6-0.6,7-1.9c1.6-0.9,3-1.9,4.2-3.1c4.3-4.3,5.1-9.8,5.3-14.1c0.8-18.4,1.7-36.8,2.6-55.3\n\t\t\t\t\t\t\tl1.3-27.7C487,49.071,485.7,44.571,482.6,41.371z\"/>\n\t\t\t\t\t</svg>&ensp;\n\t\t\t\tSEO-Meta</a>\n\t\t\t\t";
        if ($_REQUEST["com"] != "") {
            if ($_REQUEST["brand"] != "") {
                $RLast .= "&brand=" . $_REQUEST["brand"];
            }
            if (0 < $_REQUEST["sec_id"]) {
                $RLast .= "&sec_id=" . $_REQUEST["sec_id"];
            }
            if ($_REQUEST["sec_name"] != "") {
                $RLast .= "&sec_name=" . $_REQUEST["sec_name"];
            }
            echo "\t\t\t\t\t<a href=\"javascript:;\" class=\"APBut_x\" title=\"";
            echo Tip_x("Edit", 0);
            echo " ";
            echo Tip_x("this", 0);
            echo " ";
            echo Tip_x("Component", 0);
            echo "\">";
            echo Tip_x("Settings", 0);
            echo "</a></td><td>\n\t\t\t\t";
        }
        echo "\t\t\t\t<a href=\"";
        echo aDIR_Full_x;
        echo "Prices.php\" class=\"APBut_x\">\n\t\t\t\t\t<svg class=\"APsizeSVG_x\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 475.082 475.081\">\n\t\t\t\t\t\t<path d=\"M461.667,49.963c-8.949-8.947-19.698-13.418-32.265-13.418H45.682c-12.562,0-23.317,4.471-32.264,13.418\n\t\t\t\t\t\t\tC4.473,58.912,0,69.663,0,82.228V392.86c0,12.566,4.473,23.309,13.418,32.261c8.947,8.949,19.701,13.415,32.264,13.415h383.72\n\t\t\t\t\t\t\tc12.566,0,23.315-4.466,32.265-13.415c8.945-8.952,13.415-19.701,13.415-32.261V82.228\n\t\t\t\t\t\t\tC475.082,69.663,470.612,58.909,461.667,49.963z M146.183,392.85c0,2.673-0.859,4.856-2.574,6.571\n\t\t\t\t\t\t\tc-1.712,1.711-3.899,2.562-6.567,2.562h-91.36c-2.662,0-4.853-0.852-6.567-2.562c-1.713-1.715-2.568-3.898-2.568-6.571V338.03\n\t\t\t\t\t\t\tc0-2.669,0.855-4.853,2.568-6.56c1.714-1.719,3.905-2.574,6.567-2.574h91.363c2.667,0,4.858,0.855,6.567,2.574\n\t\t\t\t\t\t\tc1.711,1.707,2.57,3.891,2.57,6.56V392.85z M146.183,283.221c0,2.663-0.859,4.854-2.574,6.564\n\t\t\t\t\t\t\tc-1.712,1.714-3.899,2.569-6.567,2.569h-91.36c-2.662,0-4.853-0.855-6.567-2.569c-1.713-1.711-2.568-3.901-2.568-6.564v-54.819\n\t\t\t\t\t\t\tc0-2.664,0.855-4.854,2.568-6.567c1.714-1.709,3.905-2.565,6.567-2.565h91.363c2.667,0,4.854,0.855,6.567,2.565\n\t\t\t\t\t\t\tc1.711,1.713,2.57,3.903,2.57,6.567V283.221z M146.183,173.587c0,2.666-0.859,4.853-2.574,6.567\n\t\t\t\t\t\t\tc-1.712,1.709-3.899,2.568-6.567,2.568h-91.36c-2.662,0-4.853-0.859-6.567-2.568c-1.713-1.715-2.568-3.901-2.568-6.567V118.77\n\t\t\t\t\t\t\tc0-2.666,0.855-4.856,2.568-6.567c1.714-1.713,3.905-2.568,6.567-2.568h91.363c2.667,0,4.854,0.855,6.567,2.568\n\t\t\t\t\t\t\tc1.711,1.711,2.57,3.901,2.57,6.567V173.587z M292.362,392.85c0,2.673-0.855,4.856-2.563,6.571c-1.711,1.711-3.9,2.562-6.57,2.562\n\t\t\t\t\t\t\tH191.86c-2.663,0-4.853-0.852-6.567-2.562c-1.713-1.715-2.568-3.898-2.568-6.571V338.03c0-2.669,0.855-4.853,2.568-6.56\n\t\t\t\t\t\t\tc1.714-1.719,3.904-2.574,6.567-2.574h91.365c2.669,0,4.859,0.855,6.57,2.574c1.704,1.707,2.56,3.891,2.56,6.56v54.819H292.362z\n\t\t\t\t\t\t\t M292.362,283.221c0,2.663-0.855,4.854-2.563,6.564c-1.711,1.714-3.9,2.569-6.57,2.569H191.86c-2.663,0-4.853-0.855-6.567-2.569\n\t\t\t\t\t\t\tc-1.713-1.711-2.568-3.901-2.568-6.564v-54.819c0-2.664,0.855-4.854,2.568-6.567c1.714-1.709,3.904-2.565,6.567-2.565h91.365\n\t\t\t\t\t\t\tc2.669,0,4.859,0.855,6.57,2.565c1.704,1.713,2.56,3.903,2.56,6.567v54.819H292.362z M292.362,173.587\n\t\t\t\t\t\t\tc0,2.666-0.855,4.853-2.563,6.567c-1.711,1.709-3.9,2.568-6.57,2.568H191.86c-2.663,0-4.853-0.859-6.567-2.568\n\t\t\t\t\t\t\tc-1.713-1.715-2.568-3.901-2.568-6.567V118.77c0-2.666,0.855-4.856,2.568-6.567c1.714-1.713,3.904-2.568,6.567-2.568h91.365\n\t\t\t\t\t\t\tc2.669,0,4.859,0.855,6.57,2.568c1.704,1.711,2.56,3.901,2.56,6.567v54.817H292.362z M438.536,392.85\n\t\t\t\t\t\t\tc0,2.673-0.855,4.856-2.562,6.571c-1.718,1.711-3.908,2.562-6.571,2.562h-91.354c-2.673,0-4.862-0.852-6.57-2.562\n\t\t\t\t\t\t\tc-1.711-1.715-2.56-3.898-2.56-6.571V338.03c0-2.669,0.849-4.853,2.56-6.56c1.708-1.719,3.897-2.574,6.57-2.574h91.354\n\t\t\t\t\t\t\tc2.663,0,4.854,0.855,6.571,2.574c1.707,1.707,2.562,3.891,2.562,6.56V392.85z M438.536,283.221c0,2.663-0.855,4.854-2.562,6.564\n\t\t\t\t\t\t\tc-1.718,1.714-3.908,2.569-6.571,2.569h-91.354c-2.673,0-4.862-0.855-6.57-2.569c-1.711-1.711-2.56-3.901-2.56-6.564v-54.819\n\t\t\t\t\t\t\tc0-2.664,0.849-4.854,2.56-6.567c1.708-1.709,3.897-2.565,6.57-2.565h91.354c2.663,0,4.854,0.855,6.571,2.565\n\t\t\t\t\t\t\tc1.707,1.713,2.562,3.903,2.562,6.567V283.221z M438.536,173.587c0,2.666-0.855,4.853-2.562,6.567\n\t\t\t\t\t\t\tc-1.718,1.709-3.908,2.568-6.571,2.568h-91.354c-2.673,0-4.862-0.859-6.57-2.568c-1.711-1.715-2.56-3.901-2.56-6.567V118.77\n\t\t\t\t\t\t\tc0-2.666,0.849-4.856,2.56-6.567c1.708-1.713,3.897-2.568,6.57-2.568h91.354c2.663,0,4.854,0.855,6.571,2.568\n\t\t\t\t\t\t\tc1.707,1.711,2.562,3.901,2.562,6.567V173.587z\"/>\n\t\t\t\t\t</svg>&ensp;\n\t\t\t\t";
        echo Tip_x("Prices_base", 0);
        echo "</a>\n\t\t\t\t<a href=\"";
        echo aDIR_Full_x;
        echo "Import.php\" class=\"APBut_x\">\n\t\t\t\t\t<svg class=\"APsizeSVG_x\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\">\n\t\t\t\t\t\t<path d=\"M352,416.002H64v-288h32v-64H32c-17.664,0-32,14.336-32,32v352c0,17.696,14.336,32,32,32h352\n\t\t\t\t\t\t\tc17.696,0,32-14.304,32-32V256.994h-64V416.002z\"/><path d=\"M134.4,131.202l128-96c4.8-3.648,11.328-4.224,16.736-1.504c5.44,2.72,8.864,8.256,8.864,14.304v48\n\t\t\t\t\t\t\th48c97.056,0,176,78.944,176,176c0,7.424-5.12,13.888-12.32,15.584c-1.216,0.288-2.464,0.416-3.68,0.416\n\t\t\t\t\t\t\tc-5.952,0-11.552-3.328-14.304-8.832l-3.776-7.52c-24.544-49.12-73.888-79.648-128.8-79.648H288v48\n\t\t\t\t\t\t\tc0,6.048-3.424,11.584-8.832,14.304s-11.936,2.144-16.768-1.504l-128-96c-4.032-3.008-6.4-7.776-6.4-12.8\n\t\t\t\t\t\t\tS130.368,134.21,134.4,131.202z\"/>\n\t\t\t\t\t</svg>&ensp;\n\t\t\t\t";
        echo Tip_x("Import_master", 0);
        echo "</a>\n\t\t\t\t<a href=\"";
        echo aDIR_Full_x;
        echo "Webservices.php\" class=\"APBut_x\">\n\t\t\t\t\t<svg class=\"APsizeSVG_x\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 958.752 958.752\">\n\t\t\t\t\t\t<path d=\"M449.253,958.752v-0.531V832.572c-16.291,7.475-34.135,11.438-52.273,11.438c-17.053,0-33.599-3.375-49.179-10.03\n\t\t\t\t\t\t\tc-15.033-6.423-28.497-15.601-40.015-27.279c-23.725-24.055-36.533-55.922-36.065-89.728\n\t\t\t\t\t\t\tc0.453-32.706,13.529-63.528,36.821-86.788c23.291-23.261,54.13-36.296,86.842-36.707c0.534-0.009,1.063-0.011,1.597-0.011\n\t\t\t\t\t\t\tc18.14,0,35.982,3.965,52.274,11.438l0.122-125.12H299.506c3.631-6.34,8.994-14.236,15.154-23.226\n\t\t\t\t\t\t\tc11.912-17.385,20.783-37.496,20.497-60.273c-0.646-51.367-42.547-93.327-93.914-94.038c-0.448-0.006-0.903-0.009-1.35-0.009\n\t\t\t\t\t\t\tc-52.62-0.004-95.271,42.652-95.271,95.271c0,22.269,8.737,41.944,20.445,58.973c5.693,8.28,11.58,16.957,15.213,23.302H40.411\n\t\t\t\t\t\t\tc-22.091,0-40,17.909-40,40v398.965c0,22.092,17.909,40,40,40L449.253,958.752L449.253,958.752z\"/><path d=\"M832.692,508.965c7.474,16.291,11.438,34.135,11.438,52.273c0,33.463-13.029,64.922-36.688,88.582\n\t\t\t\t\t\t\tc-23.66,23.66-55.119,36.688-88.582,36.688c-0.583,0-1.177-0.004-1.767-0.012c-32.707-0.453-63.527-13.529-86.789-36.82\n\t\t\t\t\t\t\tc-23.26-23.291-36.296-54.131-36.707-86.838c-0.233-18.711,3.729-37.108,11.423-53.875h-95.644h-15h-15.141l0.018,150.16\n\t\t\t\t\t\t\tc-5.298-3.033-15.108-9.637-24.136-15.863c-16.723-11.537-36.252-19.793-58.14-19.793c-0.408,0-0.813,0.002-1.224,0.008\n\t\t\t\t\t\t\tc-51.367,0.646-93.326,42.548-94.038,93.914c-0.244,17.599,4.289,34.119,12.378,48.354c16.382,28.824,47.36,48.268,82.884,48.268\n\t\t\t\t\t\t\tc21.888,0,40.968-8.93,58.136-19.793c10.578-6.692,18.84-12.832,24.138-15.865v0.705v179.164h0.122h15h15h408.843\n\t\t\t\t\t\t\tc22.092,0,40-17.909,40-40V508.965H832.692z\"/><path d=\"M918.34,0H479.375v183.766c0,0,16.088-13.928,21.23-17.577c16.507-13.723,37.721-21.979,60.863-21.979\n\t\t\t\t\t\t\tc53.066,0,95.999,43.386,95.264,96.622c-0.711,51.366-42.671,93.268-94.038,93.913c-0.408,0.005-0.818,0.008-1.227,0.008\n\t\t\t\t\t\t\tc-23.145,0-44.356-8.255-60.863-21.979c-5.145-3.648-21.229-17.576-21.229-17.576v183.768h30h149.87\n\t\t\t\t\t\t\tc-1.389,2.841-9.421,15.021-15.986,24.294c-11.921,16.836-19.943,36.914-19.665,59.205c0.646,51.365,42.548,93.324,93.914,94.037\n\t\t\t\t\t\t\tc0.448,0.006,0.902,0.01,1.352,0.01c24.636,0,47.087-9.352,63.999-24.694c19.21-17.431,31.271-42.595,31.271-70.578\n\t\t\t\t\t\t\tc0-21.832-8.228-41.308-19.7-58.017c-7.307-10.643-12.829-18.817-15.786-23.966c-0.059-0.1-0.113-0.192-0.171-0.292h177.133\n\t\t\t\t\t\t\th2.735v-17.018V40C958.34,17.909,940.432,0,918.34,0z\"/>\n\t\t\t\t\t</svg>&ensp;\n\t\t\t\t";
        echo Tip_x("Webservices2", 0);
        echo "</a>\n\t\t\t\t<a href=\"";
        echo aDIR_Full_x;
        echo "Settings.php\" class=\"APBut_x\">\n\t\t\t\t\t<svg class=\"APsizeSVG_x\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 268.765 268.765\">\n\t\t\t\t\t\t<path style=\"fill-rule:evenodd;clip-rule:evenodd;\" d=\"M267.92,119.461c-0.425-3.778-4.83-6.617-8.639-6.617\n\t\t\t\t\t\t\tc-12.315,0-23.243-7.231-27.826-18.414c-4.682-11.454-1.663-24.812,7.515-33.231c2.889-2.641,3.24-7.062,0.817-10.133\n\t\t\t\t\t\t\tc-6.303-8.004-13.467-15.234-21.289-21.5c-3.063-2.458-7.557-2.116-10.213,0.825c-8.01,8.871-22.398,12.168-33.516,7.529\n\t\t\t\t\t\t\tc-11.57-4.867-18.866-16.591-18.152-29.176c0.235-3.953-2.654-7.39-6.595-7.849c-10.038-1.161-20.164-1.197-30.232-0.08\n\t\t\t\t\t\t\tc-3.896,0.43-6.785,3.786-6.654,7.689c0.438,12.461-6.946,23.98-18.401,28.672c-10.985,4.487-25.272,1.218-33.266-7.574\n\t\t\t\t\t\t\tc-2.642-2.896-7.063-3.252-10.141-0.853c-8.054,6.319-15.379,13.555-21.74,21.493c-2.481,3.086-2.116,7.559,0.802,10.214\n\t\t\t\t\t\t\tc9.353,8.47,12.373,21.944,7.514,33.53c-4.639,11.046-16.109,18.165-29.24,18.165c-4.261-0.137-7.296,2.723-7.762,6.597\n\t\t\t\t\t\t\tc-1.182,10.096-1.196,20.383-0.058,30.561c0.422,3.794,4.961,6.608,8.812,6.608c11.702-0.299,22.937,6.946,27.65,18.415\n\t\t\t\t\t\t\tc4.698,11.454,1.678,24.804-7.514,33.23c-2.875,2.641-3.24,7.055-0.817,10.126c6.244,7.953,13.409,15.19,21.259,21.508\n\t\t\t\t\t\t\tc3.079,2.481,7.559,2.131,10.228-0.81c8.04-8.893,22.427-12.184,33.501-7.536c11.599,4.852,18.895,16.575,18.181,29.167\n\t\t\t\t\t\t\tc-0.233,3.955,2.67,7.398,6.595,7.85c5.135,0.599,10.301,0.898,15.481,0.898c4.917,0,9.835-0.27,14.752-0.817\n\t\t\t\t\t\t\tc3.897-0.43,6.784-3.786,6.653-7.696c-0.451-12.454,6.946-23.973,18.386-28.657c11.059-4.517,25.286-1.211,33.281,7.572\n\t\t\t\t\t\t\tc2.657,2.89,7.047,3.239,10.142,0.848c8.039-6.304,15.349-13.534,21.74-21.494c2.48-3.079,2.13-7.559-0.803-10.213\n\t\t\t\t\t\t\tc-9.353-8.47-12.388-21.946-7.529-33.524c4.568-10.899,15.612-18.217,27.491-18.217l1.662,0.043\n\t\t\t\t\t\t\tc3.853,0.313,7.398-2.655,7.865-6.588C269.044,139.917,269.058,129.639,267.92,119.461z M134.595,179.491\n\t\t\t\t\t\t\tc-24.718,0-44.824-20.106-44.824-44.824c0-24.717,20.106-44.824,44.824-44.824c24.717,0,44.823,20.107,44.823,44.824\n\t\t\t\t\t\t\tC179.418,159.385,159.312,179.491,134.595,179.491z\"/>\n\t\t\t\t\t</svg>&ensp;\n\t\t\t\t";
        echo Tip_x("Settings", 0);
        echo "</a>\n\t\t\t\t<a href=\"";
        echo aDIR_Full_x;
        echo "\" class=\"APBut_x\">\n\t\t\t\t\t<svg class=\"APsizeSVG_x\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 460.298 460.297\">\n\t\t\t\t\t\t<path d=\"M230.149,120.939L65.986,256.274c0,0.191-0.048,0.472-0.144,0.855c-0.094,0.38-0.144,0.656-0.144,0.852v137.041\n\t\t\t\t\t\t\tc0,4.948,1.809,9.236,5.426,12.847c3.616,3.613,7.898,5.431,12.847,5.431h109.63V303.664h73.097v109.64h109.629\n\t\t\t\t\t\t\tc4.948,0,9.236-1.814,12.847-5.435c3.617-3.607,5.432-7.898,5.432-12.847V257.981c0-0.76-0.104-1.334-0.288-1.707L230.149,120.939\n\t\t\t\t\t\t\tz\"/><path d=\"M457.122,225.438L394.6,173.476V56.989c0-2.663-0.856-4.853-2.574-6.567c-1.704-1.712-3.894-2.568-6.563-2.568h-54.816\n\t\t\t\t\t\t\tc-2.666,0-4.855,0.856-6.57,2.568c-1.711,1.714-2.566,3.905-2.566,6.567v55.673l-69.662-58.245\n\t\t\t\t\t\t\tc-6.084-4.949-13.318-7.423-21.694-7.423c-8.375,0-15.608,2.474-21.698,7.423L3.172,225.438c-1.903,1.52-2.946,3.566-3.14,6.136\n\t\t\t\t\t\t\tc-0.193,2.568,0.472,4.811,1.997,6.713l17.701,21.128c1.525,1.712,3.521,2.759,5.996,3.142c2.285,0.192,4.57-0.476,6.855-1.998\n\t\t\t\t\t\t\tL230.149,95.817l197.57,164.741c1.526,1.328,3.521,1.991,5.996,1.991h0.858c2.471-0.376,4.463-1.43,5.996-3.138l17.703-21.125\n\t\t\t\t\t\t\tc1.522-1.906,2.189-4.145,1.991-6.716C460.068,229.007,459.021,226.961,457.122,225.438z\"/>\n\t\t\t\t\t</svg>&ensp;\n\t\t\t\tAdmin side</a>\n\t\t\t\t<div id=\"teBut\" class=\"APBut_x\">\n\t\t\t\t\t<svg class=\"APsizeSVG_x\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 554.2 554.199\"><g><g>\n\t\t\t\t\t<path d=\"M538.5,386.199L356.5,70.8c-16.4-28.4-46.7-45.9-79.501-45.9c-32.8,0-63.1,17.5-79.5,45.9L12.3,391.6   c-16.4,28.4-16.4,63.4,0,91.8C28.7,511.8,59,529.3,91.8,529.3H462.2c0.101,0,0.2,0,0.2,0c50.7,0,91.8-41.101,91.8-91.8   C554.2,418.5,548.4,400.8,538.5,386.199z M316.3,416.899c0,21.7-16.7,38.3-39.2,38.3s-39.2-16.6-39.2-38.3V416   c0-21.601,16.7-38.301,39.2-38.301S316.3,394.3,316.3,416V416.899z M317.2,158.7L297.8,328.1c-1.3,12.2-9.4,19.8-20.7,19.8   s-19.4-7.7-20.7-19.8L237,158.6c-1.3-13.1,5.801-23,18-23H299.1C311.3,135.7,318.5,145.6,317.2,158.7z\" data-original=\"#000000\" class=\"active-path\" data-old_color=\"#000000\" fill=\"\"/>\n\t\t\t\t</g></g> </svg>&ensp;\n\t\t\t\t";
        echo Tip_x("Translation_error", 0);
        echo "</div>\n\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(document).ready(function(){\n\t\t\t\t\t\t\$(\"#lngbut\").on(\"click\",\"\", function(e){\n\t\t\t\t\t\t\t\$('#lngsubmenu').fadeToggle();\n\t\t\t\t\t\t\t\$('#cursubmenu').hide();\n\t\t\t\t\t\t});\n\t\t\t\t\t\t\$(\"#curbut\").on(\"click\",\"\", function(e){\n\t\t\t\t\t\t\t\$('#cursubmenu').fadeToggle();\n\t\t\t\t\t\t\t\$('#lngsubmenu').hide();\n\t\t\t\t\t\t});\n\t\t\t\t\t\t\$(\"#ptbut\").on(\"click\",\"\", function(e){\n\t\t\t\t\t\t\t\$('#ptbut .showMore').slideToggle();\n\t\t\t\t\t\t});\n\t\t\t\t\t\t\n\t\t\t\t\t\t\n\t\t\t\t\t\t\$(\"#boxShowPC_x .APBut_x\").on(\"click\",\"\", function(e){\n\t\t\t\t\t\t\t\$('#boxShowPC_x .showMore').slideToggle();\n\t\t\t\t\t\t});\n\t\t\t\t\t\t\$('#metabut').click(function(){ \$('#metalay').fadeIn(); });\n\t\t\t\t\t\t";
        if ($_POST["SET_META"] == "Y") {
            echo "\$('#metalay').show();";
        }
        echo "\t\t\t\t\t});\n\t\t\t\t</script>\n\t\t\t\t<div style=\"display:none;\">\n\t\t\t\t<form id=\"crf\" method=\"POST\"><input type=\"hidden\" name=\"SET_CUR\" id=\"crv\" value=\"\"></form>\n\t\t\t\t<form id=\"lnf\" method=\"POST\"><input type=\"hidden\" name=\"SET_LANG\" id=\"lnv\" value=\"\"></form>\n\t\t\t\t<form id=\"tpf\" method=\"POST\"><input type=\"hidden\" name=\"SET_USER_GROUP\" id=\"ctp\" value=\"\"></form>\n\t\t\t\t</div>\n\t\t\t</div>\n\t\t</div>\n\t\t\n\t\t<div id=\"metalay\" class=\"fxOverlay_adm\" style=\"display: none;\"><div class=\"fxModal_adm\"><div class=\"fxCont_adm\">\n\t\t\t<form action=\"\" method=\"post\">\n\t\t\t<input type=\"hidden\" name=\"SET_META\" value=\"Y\">\n\t\t\t<table class=\"sublaytab\">\n\t\t\t\t<tr><td></td><td><span class=\"tiptext\">";
        echo Tip_x("With_form_create_unique_SEO", 0);
        echo "</span></td></tr>\n\t\t\t\t<tr><td>Title: </td><td><input type=\"text\" name=\"TITLE\" value=\"";
        if (defined("TITLE_x")) {
            echo TITLE_x;
        }
        echo "\" class=\"subinput\" placeholder=\"";
        echo Tip_x("if_seometa_not_set", 0);
        echo "\"></td></tr>\n\t\t\t\t<tr><td>Keywords: </td><td><input type=\"text\" name=\"KEYWORDS\" value=\"";
        if (defined("KEYWORDS_x")) {
            echo KEYWORDS_x;
        }
        echo "\" class=\"subinput\" ></td></tr>\n\t\t\t\t<tr><td>Description: </td><td><input type=\"text\" name=\"DESCRIPTION\" value=\"";
        if (defined("DESCRIPTION_x")) {
            echo DESCRIPTION_x;
        }
        echo "\" class=\"subinput\" ></td></tr>\n\t\t\t\t<tr><td><nobr>";
        echo Tip_x("Title", 0);
        echo " H1: </nobr></td><td><input type=\"text\" name=\"H1\" value=\"";
        if (defined("H1_x")) {
            echo H1_x;
        }
        echo "\" class=\"subinput\" ></td></tr>\n\t\t\t\t<tr><td><nobr>";
        echo Tip_x("Top_SEO_text", 0);
        echo ": </nobr></td><td><textarea name=\"TOPTEXT\" class=\"subinput sbinp\">";
        if (defined("TOPTEXT_x")) {
            echo TOPTEXT_x;
        }
        echo "</textarea>\n\t\t\t\t<tr><td><nobr>";
        echo Tip_x("Bottom_SEO_text", 0);
        echo ": </nobr></td><td><textarea name=\"BOTTEXT\" class=\"subinput sbinp\">";
        if (defined("BOTTEXT_x")) {
            echo BOTTEXT_x;
        }
        echo "</textarea></td></tr>\n\t\t\t\t<tr><td></td><td>\n\t\t\t\t\t<input type=\"submit\" value=\"";
        echo Tip_x("Save", 0);
        echo "\" class=\"gButDiv\"/> \n\t\t\t\t\t";
        if (defined("HAVE_SEOMETA_x")) {
            echo "\t\t\t\t\t\t<input type=\"submit\" name=\"DEL_META\" value=\"";
            echo Tip_x("Delete_this_Meta_record", 0);
            echo "\" class=\"gButDiv flrig\"/>\n\t\t\t\t\t";
        }
        echo "\t\t\t\t</td></tr>\n\t\t\t</table>\n\t\t\t</form>\n\t\t</div></div></div>\n\t\t\n\t\t<script type=\"text/javascript\">\n\t\t\$(\"#teBut\").on(\"click\",\"\", function(e){\n\t\t\t\$('#BoxErTransfer').fadeIn();\n\t\t});\n\t\t</script>\n\t\t";
    }
}

?>