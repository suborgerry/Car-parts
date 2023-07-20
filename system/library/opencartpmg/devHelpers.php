<?php

/**
 * Dump and die();
 *
 * @param      $var
 * @param bool $vardump print_r by default, if !FALSE - var_dump
 */
function dd( $var, $vardump = FALSE ) {
	if ( !isWpDumperAllowed() ) {
		return;
	}

	$backtrace = debug_backtrace()[0];
	$fh = fopen($backtrace['file'], 'r');
	$line = 0;
	while (++$line <= $backtrace['line']) {
		$code = fgets($fh);
	}
	fclose($fh);
	preg_match('/' . __FUNCTION__ . '\s*\((.*)\)\s*;/u', $code, $name);
	$varName = isset($name[1])?trim ( $name[1] ):'';
	wpDumper($var, $varName, $backtrace, $vardump);
	echo '<div style="background: #ff9494;color: #3e3e3e;font-weight: bold;padding: 2px 5px;border: 1px solid darkgrey;margin: -25px 12px; float: right;">Good job)));</div>';
	die();
}

/**
 * Print and colored block with dump data
 *
 * @param      $var
 * @param bool $user id or nickname
 * @param bool $vardump print_r by default, if !FALSE - var_dump
 */
function pp( $var, $vardump = FALSE ) {
	if ( !iswpDumperAllowed() ) {
		return;
	}

	$backtrace = debug_backtrace()[0];
	$fh = fopen($backtrace['file'], 'r');
	$line = 0;
	while (++$line <= $backtrace['line']) {
		$code = fgets($fh);
	}
	fclose($fh);
	preg_match('/' . __FUNCTION__ . '\s*\((.*)\)\s*;/u', $code, $name);
	$varName = trim ( $name[1] );
	wpDumper($var, $varName, $backtrace, $vardump);
}


/**
 * method for colorise dump block
 * @param $varName - variabe name whicj will be dumped
 * @return string
 */
function getDumpColor($varName) {
	$varNameArray = explode(',', $varName);
	$colors = array(
		'white',
		'#ffe8ec',
		'#fff1e4',
		'#fcfce6',
		'#e6fee6',
		'#e3f9f9',
		'#e3eaf4',
		'#eee3ee',
		'#f3f3f3',
		'#ebe1d9',
		'#dbeadb'
	);
	$colorCode = md5(md5($varNameArray[0]));
	$colorCode = preg_replace('~[^0-9]+~','',$colorCode);
	while ( strlen($colorCode) > 1 ) {
		$colorCode = array_sum( str_split($colorCode) );
	}
	$color = $colors[$colorCode];
	return $color;
}

/**
 * method for protecting dumping on any stage defferent to LOCAL
 * @return bool
 */
function isWpDumperAllowed() {
	if ( isset($_ENV['ENV'])
        && $_ENV['ENV'] === 'local' ) {
		return true;
	}

	return false;
}

/**
 * main methid for dumping data
 * @param $var
 * @param $varName
 * @param $backtrace
 * @param $vardump
 * @return void
 */
function wpDumper($var, $varName, $backtrace, $vardump) {
	if ( !iswpDumperAllowed() ) {
		return;
	}
	$color = getDumpColor($varName);
	$varNameArray = explode(',', $varName);
	$id = base64_encode($backtrace['file'].': '.$backtrace['line']);
	echo '<div style="background: '.$color.'; padding:5px 10px 10px; margin: 15px 2px; border: 1px solid darkgrey;">
			<div style="background: #dadada; padding: 2px 5px; border: 1px solid darkgrey; float: left; margin-top: -15px; font-weight: bold;">'.$varNameArray[0].' '.date('d-m-Y H:i:s').'</div>
			<div style="background: #dadada; padding: 2px 5px; border: 1px solid darkgrey; float:right; margin-top: -15px;">'.$backtrace['file'].': '.$backtrace['line'].'</div>';
	if ( count($varNameArray) > 1 ) {
		echo '
			<div style="background: #dadada; padding: 2px 5px; border: 1px solid darkgrey; float: right; margin-right: 20px; margin-top: -15px;">'.$varName.'</div>';
	}
	echo '<div style="border: 0; float:right; margin-top: -15px; margin-right: 10px;"><textarea style="width: 0; height: 0;" id="export'.$id.'">';
	var_export($var);
	echo '</textarea></div>';
	echo '<div style="background: #dadada; padding: 2px 5px; border: 1px solid darkgrey; float:right; margin-top: -15px; margin-right: 10px; cursor:pointer" id="button'.$id.'" title="Press to copy to clipboard">Export</div>';
	echo '<script>
					var copyTextareaBtn = document.getElementById(\'button'.$id.'\');

					copyTextareaBtn.addEventListener(\'click\', function(event) {
			          this.style.backgroundColor = "lightgrey";
					  var copyTextarea = document.getElementById(\'export'.$id.'\');
					  copyTextarea.select();

					  try {
						copyTextarea.style.display = \'block\';
						copyTextarea.focus();
						document.execCommand(\'SelectAll\');
						var successful = document.execCommand("Copy", false, null);
					    var msg = successful ? \'successful\' : \'unsuccessful\';
					    if (!successful) {
					        this.style.backgroundColor = "pink";
					        copyTextarea.style.height = "200px";
					        copyTextarea.style.width = "400px";
					    } else {
					        this.style.backgroundColor = "lightgreen";
					    }
					    console.log(\'Copying text command was \' + msg);
					  } catch (err) {
					    console.log(\'Oops, unable to copy\');
				        this.style.backgroundColor = "pink";
				        copyTextarea.style.height = "200px";
				        copyTextarea.style.width = "400px";
					  }
					});

			</script>';
	echo '
			<pre style="clear: both; margin-top: 30px; padding: 0; background: none; border: 0;">';
    if(empty($var)){
        var_dump( $var );
    }
    else{
        if ( $vardump === FALSE ) {
            print_r( $var );
        } else {
            var_dump($var);
        }
    }

	echo '</pre>
		</div>';
}
