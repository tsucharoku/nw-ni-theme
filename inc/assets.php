<?php
/**
 * CSS・JS の読み込み（静的 HTML の <link> / <script> の置き換え）
 *
 * 読み込み順は静的 HTML と同じ:
 *   CSS: フォント → (Splide) → base → common → components → lower → ページ用
 *   JS:  (Splide) → common → footer-insight → lower → ページ用 → ES モジュール
 * TOP 扉は base / common / top だけ（components を読まない）。
 */

/* ES モジュール（ni_page() の modules）のうち、ほかのモジュールから import されているファイルの ?v= の値（ファイル名 => 値）。
   ブラウザは ?v= まで含めた URL でモジュールを見分けるので、<script> の URL と JS の中の import の URL が違うと
   同じファイルが 2 回実行される（fv-about.js は <script> と fv-entry.js の import の両方から読まれる）。
   そこで <script> 側は、JS の中の import（'./fv-about.js?v=…'）に書いてある値を読んでそのまま使う。
   JS を更新したら assets/js/*.js の ?v= を一括置換するだけでよい（こちらは自動で付いてくる）。 */
function ni_module_import_vers( $names ) {
	$vers = array();
	foreach ( $names as $name ) {
		$js = file_get_contents( get_theme_file_path( 'assets/js/' . $name . '.js' ) );
		if ( $js && preg_match_all( '#from\s+[\'"]\./([\w-]+)\.js\?v=([\w.-]+)[\'"]#', $js, $imports, PREG_SET_ORDER ) ) {
			foreach ( $imports as $import ) {
				$vers[ $import[1] ] = $import[2];
			}
		}
	}
	return $vers;
}

/* キャッシュ対策の ver = ファイルの更新時刻（静的 HTML の ?v=YYYYMMDDHHMM の置き換え） */
function ni_asset_ver( $path ) {
	$file = get_theme_file_path( $path );
	return file_exists( $file ) ? (string) filemtime( $file ) : null;
}

function ni_enqueue_style( $name ) {
	$path = 'assets/css/' . $name . '.css';
	wp_enqueue_style( 'ni-' . $name, get_theme_file_uri( $path ), array(), ni_asset_ver( $path ) );
}

function ni_enqueue_script( $name ) {
	$path = 'assets/js/' . $name . '.js';
	wp_enqueue_script( 'ni-' . $name, get_theme_file_uri( $path ), array(), ni_asset_ver( $path ), true );
}

function ni_enqueue_assets() {
	$page     = ni_page();
	$type     = $page['type'];
	$is_lower = 'lower' === $type;
	$has_fv   = 'beginner' === $type || 'career' === $type;   /* 新卒 TOP・中途 TOP: スライダー（Splide）と FV の WebGL 演出 */

	/* フォント: 和文 Gen Interface JP、欧文 Poppins。中途 TOP の Future の見出しだけ Shippori Antique */
	wp_enqueue_style( 'ni-font-gen-interface', 'https://cdn.jsdelivr.net/npm/gen-interface-jp@0.8.0/cdn/all.css', array(), null );
	wp_enqueue_style( 'ni-font-google', 'https://fonts.googleapis.com/css2?family=Poppins:wght@500;600' . ( 'career' === $type ? '&family=Shippori+Antique' : '' ) . '&display=swap', array(), null );

	if ( $has_fv ) {
		wp_enqueue_style( 'splide-core', get_theme_file_uri( 'assets/vendor/splide/splide-core.min.css' ), array(), '4.1.4' );
		wp_enqueue_script( 'splide', get_theme_file_uri( 'assets/vendor/splide/splide.min.js' ), array(), '4.1.4', true );
	}

	ni_enqueue_style( 'base' );
	ni_enqueue_style( 'common' );
	if ( $is_lower ) {
		ni_enqueue_style( 'components' );
		ni_enqueue_style( 'lower' );
	}
	array_map( 'ni_enqueue_style', $page['css'] );

	ni_enqueue_script( 'common' );
	ni_enqueue_script( 'footer-insight' );
	if ( $is_lower ) {
		ni_enqueue_script( 'lower' );
	}
	array_map( 'ni_enqueue_script', $page['js'] );
}
add_action( 'wp_enqueue_scripts', 'ni_enqueue_assets' );

/* <head> の先頭: CSS より前に <html> へクラスを付けるインラインスクリプトと、three.js の import map */
function ni_print_head_scripts() {
	$page = ni_page();

	if ( 'beginner' === $page['type'] ) :
		?>
<script>
/* 訪問時イントロ（fv-intro.js）: JS が動く前に FV フレームの目型の穴を閉じておく（開く前にちらつかないように） */
(function(){if(window.matchMedia('(prefers-reduced-motion: reduce)').matches)return;if(/[?&](nointro|capture|menu)/.test(location.search))return;document.documentElement.classList.add('is-intro');})();
</script>
		<?php
	elseif ( 'career' === $page['type'] ) :
		?>
<script>
/* FV コピーの登場（fv-unfold.js）: JS が文字を分割するまで見出し・サブを隠しておく（ちらつき防止）。動き抑制・撮影時は付けない = 静止表示 */
(function(){if(window.matchMedia('(prefers-reduced-motion: reduce)').matches)return;if(/[?&]capture/.test(location.search))return;document.documentElement.classList.add('is-fv-unfold');})();
</script>
		<?php
	endif;

	if ( $page['modules'] ) {
		$imports = array(
			'three'         => get_theme_file_uri( 'assets/vendor/three/three.module.min.js' ),
			'three/addons/' => get_theme_file_uri( 'assets/vendor/three/addons/' ),
		);
		echo '<script type="importmap">' . wp_json_encode( array( 'imports' => $imports ), JSON_UNESCAPED_SLASHES ) . "</script>\n";
	}
}
add_action( 'wp_head', 'ni_print_head_scripts', 1 );

/* </body> の直前: ES モジュール（wp_enqueue_script ぶんの後）。
   ?v= は、import されているファイルは import と同じ値、それ以外はファイルの更新時刻 */
function ni_print_modules() {
	$names = ni_page()['modules'];
	$vers  = ni_module_import_vers( $names );
	foreach ( $names as $name ) {
		$path = 'assets/js/' . $name . '.js';
		printf(
			'<script type="module" src="%s"></script>' . "\n",
			esc_url( get_theme_file_uri( $path ) . '?v=' . ( $vers[ $name ] ?? ni_asset_ver( $path ) ) )
		);
	}
}
add_action( 'wp_footer', 'ni_print_modules', 30 );
