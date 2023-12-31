<?
$aTip = Array(
	1 => 'The list of all OEM manufacturers/suppliers <b>available</b> for addition and use in the plugin',
	2 => 'Use "Aliases" to join prices to a single Brand that can have different names in suppliers.',
	3 => 'The list of Producers <b>available</b> for adding into your CarMod local base',
	4 => 'Currently added to your base and <b>active</b> Vehicle Producers, used by your CarMod',
	5 => 'Affects the sorting of goods in the list. Value from 1 to 999',
	6 => 'Alternative brand names (or prefixes) that can be in the supplier`s prices. Help correctly load prices for this nominal brand name',
	7 => '',
	8 => 'Attention! When a language is disabled, all its language phrases, product names and sections will be deleted',
	9 => 'You can create your own template in /'.CM_DIR.'/templates/.. by copying and renaming the template "default". Do not edit the "default" template as it is regularly overwritten by the auto-update system',
	10 => 'You can add your own integration script of your CMS to /'.CM_DIR.'/tocms/.. or copy and rename an existing one for your modifications. Note that the default integration scripts that are in this folder can be overwritten by the plugin auto-update system. But your own and renamed scripts will not be overwritten during updates',
	11 => 'Every time you enter the admin side, the National Bank exchange rate request will be executed. You can add or change methods for any currency in /'.CM_DIR.'/core/exrates.php',
	12 => 'This html DOM element is used in the AJAX script for adding products to the cart in /'.CM_DIR.'/templates/default/includes.php as PHP constant: CmsCartID<br>JavaScript executed after updating the content of the basket should be added to /'.CM_DIR.'/templates/default/custom.js in the CmAfterCartAjax() function.',
	13 => '"Available" or "Out of stock" will be displayed',
	14 => 'The plugin templates are located in the /'.CM_DIR.'/templates/.. folder. Do not edit the "<b>default</b>" template as it is constantly <b>overwritten</b> by the auto-update system. To create your own template - copy and rename the template (by FTP) "default" and then switch to it in the admin-side of the plugin, in the basic settings',
	15 => 'The fixed amount that will be applied to the source loaded price. Note that the source price is stored in the currency in which it was loaded and the mark-up/discount will be applied to the stored price in its  currency',
	16 => 'CSS color code (6 characters) of the main elements of the template used in /'.CM_DIR.'/templates/default/includes.php',
	17 => 'When a customer first enters the catalog, he will see it in that language. If a language switch is added in CMS and the integration php code is present in the CMS integration script, the catalog will be shown in the language selected by the user',
	18 => 'Same as “Default Language” above, but applicable to Currency',
	19 => 'You cannot delete the Markup Rule - because it is joined to the Price Type',
	20 => 'Additional service costs for one country',
	
	21 => 'Any Latin characters. It is used as an additional label for binding with other data of the database, filtering, searching, deleting and so on',
	22 => 'Web-service script located in the /'.CM_DIR.'/webservices/ folder that accepts incoming variables and must return a structured price array $aPrices',
	23 => 'Your Login or client Number that usually gives you a webservice provider. Please note that it does not always coincide with the login of your Account on the suppliers Website and can be issued separately upon request',
	24 => 'An optional parameter that may be required for authentication',
	25 => 'The price for product will be saved in the plugin database for the specified time. We recommend to cache prices for at least 1 day. This will significantly speed up the catalog and reduce the load on the web service',
	26 => 'If the provider of your webservice has a daily limit of requests, please indicate it. Otherwise, you may be blocked for exceeding the quota',
	27 => 'If your webservice returns Analogs (Crosses) for the requested Article+Brand, you can save these entries in the plugin for subsequent import into the catalog database',
	28 => 'Also request by Article, without specifying the Brand. Such a request may be longer - depending on the architecture of the web service. You can disable as a last resort to optimize the speed of the plugin',
	29 => 'If the web service returns the product Names, you can save them in a separate table of the plugin',
	30 => 'On the product page (for admin only) will show an error if it exists when requesting prices for this product. Convenient for testing and debugging',
	31 => 'If a lower price of ANY supplier/webservice is already loaded for this product, then the higher price - will not be added. This option can slow down the catalog if you have hundreds of thousands (millions) of prices loaded and if your hosting/server has weak MySQL/RAM/CPU settings',
	32 => 'The visual text value that the buyer sees. Does not participate in logic',
	33 => 'Numeric value, not publicly displayed, participates in logic',
	34 => 'Port 993 should be open on your host/server for SSL connection with the IMAP mail server. Also allow remote connections to your mailbox in the settings on the E-Mail website',
	35 => 'Use the * sign to indicate the mask of any text',
	36 => 'Only ONE letter will be selected that matched the Subject and Sender - the one with the most recent date',
	37 => 'Any non-repeatable title (En). Used in plugin logic',
	38 => 'If you specify an incorrect file encoding, the file contents may be incorrectly displayed',
	39 => 'The file may contain header lines with column descriptions. To skip them, specify which line to start importing',
	40 => 'A file will be created in which all missing lines from the price list will be recorded during the import. After importing it can be downloaded',
	41 => 'If you need a search in the directory from the section, then activate this option. The import will last longer because it pulls the binding of each product to the section from the remote server',
	42 => 'It will always load the lowest price. If in the plugin database there are already prices for this product, then the lowest price will be left, the rest are deleted. As a result, the products from this price list will be only at 1 price',
	43 => 'The visible value can be in any form (10pcs, 10+ ...). This is what the customer sees when buying a product. The second field is numeric, which is involved in the plugin logic. Required number',
	44 => 'If in section "Columns" section binding is activated, then the import step is limited to 100',
	45 => 'The markup rule can be created in the "Price Settings" section',
	46 => 'Your data is stored on our servers. When reinstalling the plugin, you can synchronize and update active brands. Thus, you do not lose the list of brands you work with',
	47 => 'Instead of the price block for the product, the “Find price” button will be displayed when you click on it, it will be redirected to the link specified in the template',
	48 => 'Relative or absolute link of the "Find price" button. Use the template values from the table below - which will be replaced in the link to the values of the Product Brand and Article',
	49 => 'A set of characters that should be removed from the names of Brands and Articles. For example: spaces, periods, brackets, etc.',
	50 => 'Each page view is logged in the plugin. If there will be more views than the set value per hour/day, then such a user will be marked as a Bot - scanning the site. For such a visitor, part of the data will not be displayed as unnecessary. For example, prices and additional product characteristics - which will significantly reduce the load on the CPU, traffic and Databases. At the bottom of the public side of the plugin for such a visitor, for debugging, will be displayed the text: [data limited]',
	51 => 'Use CSS for a narrow design template. Suitable for the template of your CMS in which there is a side column of the menu - limiting the width of the content area',
	52 => 'It is forbidden to upload images containing any watermark (of any website), except for the watermark of the Brand of the spare part',
	53 => 'The Sitemaps protocol allows a webmaster to inform search engines about URLs on a website that are available for crawling. A Sitemap is an XML file that lists the URLs for a site. It allows webmasters to include additional information about each URL. This allows search engines to crawl the site more efficiently and to find URLs that may be isolated from rest of the sites content.',
	54 => 'It is not recommended to use more than 1 time per day',
	55 => 'Turn ON - only if links of your web-site are configured through .htaccess to work with prefix of the active language',
	56 => 'A link will be generated for each product with prices. Products without prices will not be recorded in the Sitemap. Since there are millions of products in the base, too large for Sitemap (unnecessary links)',
	57 => 'You may need a lot of PHP memory. If you see the error "<b>Fatal error: Allowed memory size of</b> .." - then you need to allocate more memory for PHP (the parameter "<b>memory_limit</b>" in php.ini or in the hosting settings)',
	58 => 'Instead of the "Add to Cart" button, the "Order" button will be displayed - when you click on it, a window pops up with the fields for quick ordering the product with a message sent to the Admin E-Mail (in the main settings). However, the product does not fit into the CMS basket. Under this button, the addon /'.CM_DIR.'/add/mail_order/.. is used which templates you can create and edit (except "default", since it is overwritten by the Updates System)',
	59 => 'This is the <b>actual</b> number of prices currently downloaded to your local database. Note that the left column indicates the number of prices that <b>were loaded</b> for the last time by this import template. Then you could <b>remove</b> the prices from the base... But the record of how many of them were added will still be preserved and will not coincide with the current <b>actual</b> amount of prices.',
	60 => 'If this is an abbreviated (short/alternative) name of an existing Brand in the Database, then turn OFF and specify it below in the field',
	61 => 'Provide a link to the Website of the new Brand. Then we can add it to the Database',
	62 => 'On all pages of the plugin (above the content part) an add-on template will be connected /'.CM_DIR.'/add/header/..',
	63 => 'If the webservice did not return the price for the requested Article, then the old price will not be removed from the database',
	64 => 'Search by part number has the following logic:<br>1) If only <b>one</b> product is found, then there will be <b>redirection</b> to the product page.<br>2) If <b>several matches</b> by article are found (the quantity can be adjusted) - there will be a drop-down list with the choice of which <b>brand and type</b> of spare part the buyer is looking for.<br>3) If the option "Show search result with analogues" is enabled, then the list of results will be supplemented with a <b>lot of suitable analogs</b> by article number which matched the search number.',
	65 => 'Redirect to link containing only the first OE number instead of the Article of this product itself',
	66 => 'Show prices and Cart button anyway',
	67 => 'Basic, wholesale and other types of prices that you can add in the section "Price settings" ',
	68 => 'Price after all markups have been applied',
	69 => 'It is the integer value of the DELIVERY_NUM field. Not to be confused with the DELIVERY_VIEW text field of the visual representation ("tomorrow" or "2-3 days", etc.)',
	70 => 'PriceID is formed from price fields (table CM_PRICES_NEW). The <b>logic for updating</b> prices depends on which fields you select as Key. For example, if your supplier offers <u>several</u> prices for the same spare part with different Delivery times, then include the "Delivery time" field in the formation of the price Key. Otherwise, you will always have <u>only one</u> price for a given spare part from a given supplier. The same principle applies to the rest of the fields', 
	71 => 'For example, when searching by the number "986494107", it will also search by its nominal "0986494107" with a leading zero', 
	72 => 'Additional SEO description/Product name - that is loaded with the Price-List, via the suppliers web-service API or added manually', 
	73 => 'Section editing (active, sorting and deleting) will apply for all languages',
	74 => 'List of Brands that are not activated in the <a href="Brands.php">Brands settings</a>. Perhaps the Brand is already in the system, but under a different name. Then you can add an Alias for it to bind an custom name from your price-list to the nominal name in the CarMod',
	75 => 'Specify the maximum number of acceptable seconds that a catalog user will wait while the server makes API requests for prices of your active Web-Services. Upon reaching the limit, requests will be interrupted and the user will see only those prices for the products that have already been requested. If disabled, only the AJAX request API method in the visitors browser will be used',
	
);
?>