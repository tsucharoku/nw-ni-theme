<?php
/**
 * 3分でわかるNI（固定ページ /about/）
 *
 * 数字のカード（会社・事業規模 / 仕事・リサーチ環境 / 働き方・カルチャー）は固定ページの ACF「3分でわかるNI」
 * （acf-json/group_ni_about.json。設計書: NI採用サイト_ACFフィールド設計書_3分でわかるNI.xlsx）。カードの数と並びは固定。
 * 入力した内容だけを出す（初期値・ダミーは出さない。未入力の画像は出さない）。改行は入力した改行どおり（<br>）。
 * ページ頭・リード・各セクションの見出し・社員に聞きましたは固定。
 */

/* このページの ACF の値。フィールドキー（field_ni_about_○○）で引く（名前で引くと、一度も保存していないページでは
   ACF がフィールドを特定できないため） */
function ni_about( $name ) {
	return function_exists( 'get_field' ) ? get_field( 'field_ni_about_' . $name, get_queried_object_id() ) : null;
}

/* 1 行のテキスト（エスケープして出力） */
function ni_about_text( $name ) {
	echo esc_html( (string) ni_about( $name ) );
}

/* 複数行のテキスト（改行 → <br>） */
function ni_about_br( $name ) {
	echo implode( '<br>', array_map( 'esc_html', preg_split( '/\R/u', trim( (string) ni_about( $name ) ) ) ) );
}

/* 画像（ACF の画像。未入力なら何も出さない）。$atts は src / alt / width / height 以外の属性 */
function ni_about_img( $name, $atts = '' ) {
	$img = ni_about( $name );
	if ( is_array( $img ) && ! empty( $img['url'] ) ) {
		printf( '<img src="%s" alt="%s" width="%d" height="%d"%s>', esc_url( $img['url'] ), esc_attr( $img['alt'] ), (int) $img['width'], (int) $img['height'], $atts );
	}
}

/* 数値 + 単位の見出し行（.num-card__num） */
function ni_about_num( $prefix ) {
	printf( '<p class="num-card__num"><span class="num-card__value">%s</span><span class="num-card__unit">%s</span></p>', esc_html( (string) ni_about( $prefix . '_number' ) ), esc_html( (string) ni_about( $prefix . '_unit' ) ) );
}

/* 年間調査件数の円グラフ: 手法内訳（リピーター）。未入力なら円グラフと内訳の文は出さない。
   扇は conic-gradient（割合の合計に対する比で描く）、色は 4 色を上から順に繰り返す。
   ラベルは扇の中央の角度、円の中心から 70px の位置（228 角の円グラフ） */
$ni_pie_rows = ni_about( 'company_survey_breakdown' );
if ( ! is_array( $ni_pie_rows ) ) {
	$ni_pie_rows = array();
}
$ni_pie_colors = array( '#11296b', '#1f49b0', '#2e6fd0', '#4a94e8' );
$ni_pie_total  = array_sum( array_map( 'floatval', wp_list_pluck( $ni_pie_rows, 'breakdown_percentage' ) ) );
$ni_pie        = array();
$ni_pie_from   = 0;
foreach ( array_values( $ni_pie_rows ) as $ni_i => $ni_row ) {
	$ni_share    = $ni_pie_total > 0 ? (float) $ni_row['breakdown_percentage'] / $ni_pie_total * 100 : 0;
	$ni_angle    = deg2rad( ( $ni_pie_from + $ni_share / 2 ) * 3.6 );
	$ni_pie[]    = array(
		'name'  => (string) $ni_row['breakdown_method'],
		'value' => (string) $ni_row['breakdown_percentage'] . '%',
		'color' => $ni_pie_colors[ $ni_i % count( $ni_pie_colors ) ],
		'from'  => $ni_pie_from,
		'to'    => $ni_pie_from + $ni_share,
		'x'     => round( 114 + 70 * sin( $ni_angle ), 1 ),
		'y'     => round( 114 - 70 * cos( $ni_angle ), 1 ),
	);
	$ni_pie_from += $ni_share;
}
$ni_pie_bg = 'conic-gradient(' . implode(
	', ',
	array_map(
		function ( $s ) {
			return $s['color'] . ' ' . round( $s['from'], 2 ) . '% ' . round( $s['to'], 2 ) . '%';
		},
		$ni_pie
	)
) . ')';
$ni_pie_items = array_map(
	function ( $s ) {
		return $s['name'] . ' ' . $s['value'];
	},
	$ni_pie
);
/* 下の内訳の文: 2 つずつ「／」でつなぐ（例: CLT 40% ／ 定性 22% WEB 20% ／ HUT 18%） */
$ni_pie_note = implode(
	' ',
	array_map(
		function ( $pair ) {
			return implode( ' ／ ', $pair );
		},
		array_chunk( $ni_pie_items, 2 )
	)
);

ni_head(
	array(
		'title'       => '3分でわかる日本インフォメーション｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '私たち日本インフォメーションの事業・強み・数字をまとめてご紹介します。1969年創業の独立系マーケティングリサーチ専業会社の規模、リサーチ環境、働き方・カルチャーを数字で。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">3分でわかる日本インフォメーション</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">About Us</p>
      <h1 class="page-head__jp">3分でわかる日本インフォメーション</h1>
    </div>
    <p class="page-head__read">私たち日本インフォメーションの事業・強み・数字をまとめてご紹介します。</p>
  </div>

  <!-- リード（Figma 522:9592 / SP 1140:12193） -->
  <div class="lower-sec about-lead">
    <p class="about-lead__title">多様なアプローチで発掘した生活者のインサイトを価値に変えて、<br class="u-pc">企業の経営判断を支援する会社</p>
    <p class="about-lead__txt">1969年創業の独立系マーケティングリサーチ専業会社。飲料・食品・化粧品・トイレタリーなど大手消費財メーカーを中心に、<br class="u-pc">年間約2,000件・800社超の調査を手がけています。</p>
  </div>

  <!-- 会社・事業規模（Figma 522:9633 / SP 1140:12198） -->
  <section class="lower-sec about-sec about-sec--scale">
    <div class="about-sec__head">
      <div class="sec-head sec-head--sub">
        <p class="sec-head__label u-grd-text">Scale</p>
        <div class="sec-head__body">
          <h2 class="sec-head__title sec-head__title--cap">会社・事業規模</h2>
          <p class="sec-head__read">1969年の創業から積み上げてきた、日本インフォメーションの事業規模を数字で</p>
        </div>
      </div>
      <!-- TODO: 会社概要のリンク先（コーポレートサイト）未確定 -->
      <a class="btn" href="#">会社概要をみる<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
    </div>
    <div class="about-scale">
      <div class="num-card num-card--pie" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label"><?php ni_about_text( 'company_survey_label' ); ?></p>
            <?php ni_about_num( 'company_survey' ); ?>
          </div>
          <?php if ( $ni_pie ) : ?>
          <p class="num-card__note"><?php echo esc_html( $ni_pie_note ); ?></p>
          <?php endif; ?>
        </div>
        <?php if ( $ni_pie ) : ?>
        <!-- 円グラフ: 扇は手法内訳から conic-gradient、ラベルは扇の中央 -->
        <div class="pie" role="img" aria-label="調査手法の内訳 <?php echo esc_attr( implode( '、', $ni_pie_items ) ); ?>">
          <div class="pie__sectors" aria-hidden="true" style="background: <?php echo esc_attr( $ni_pie_bg ); ?>"></div>
          <?php foreach ( $ni_pie as $ni_slice ) : ?>
          <p class="pie__label" aria-hidden="true" style="top: <?php echo esc_attr( $ni_slice['y'] ); ?>px; left: <?php echo esc_attr( $ni_slice['x'] ); ?>px"><span class="pie__name"><?php echo esc_html( $ni_slice['name'] ); ?></span><span class="pie__val u-en"><?php echo esc_html( $ni_slice['value'] ); ?></span></p>
          <?php endforeach; ?>
          <span class="pie__hole" aria-hidden="true"></span>
        </div>
        <?php endif; ?>
      </div>
      <div class="about-scale__side">
        <ul class="num-row">
      <li class="num-card num-card--media num-card--lead" data-anim="inview">
        <div class="num-card__txt num-card__txt--w207">
          <div class="num-card__head">
            <p class="num-card__label"><?php ni_about_text( 'company_growth_label' ); ?></p>
            <p class="num-card__lead"><?php ni_about_br( 'company_growth_title' ); ?></p>
          </div>
          <p class="num-card__note"><?php ni_about_br( 'company_growth_desc' ); ?></p>
        </div>
        <div class="num-card__thumb num-card__thumb--icon"><?php ni_about_img( 'company_growth_graph' ); ?></div>
      </li>
      <li class="num-card num-card--center" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label"><?php ni_about_text( 'company_clients_label' ); ?></p>
            <?php ni_about_num( 'company_clients' ); ?>
          </div>
          <p class="num-card__note"><?php ni_about_br( 'company_clients_desc' ); ?></p>
        </div>
      </li>
        </ul>
        <ul class="num-row">
      <li class="num-card num-card--center" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label"><?php ni_about_text( 'company_direct_label' ); ?></p>
            <?php ni_about_num( 'company_direct' ); ?>
          </div>
          <p class="num-card__note"><?php ni_about_br( 'company_direct_desc' ); ?></p>
        </div>
      </li>
      <li class="num-card num-card--media num-card--start" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label"><?php ni_about_text( 'company_founded_label' ); ?></p>
            <?php ni_about_num( 'company_founded' ); ?>
          </div>
          <p class="num-card__note"><?php ni_about_br( 'company_founded_desc' ); ?></p>
        </div>
        <div class="num-card__thumb num-card__thumb--icon num-card__thumb--icon-l"><?php ni_about_img( 'company_founded_image' ); ?></div>
      </li>
        </ul>
      </div>
    </div>
  </section>

  <!-- 仕事・リサーチ環境（Figma 540:10039 / SP 1140:12244） -->
  <section class="lower-sec about-sec about-sec--env">
    <div class="about-sec__head">
      <div class="sec-head sec-head--sub">
        <p class="sec-head__label u-grd-text">Environment</p>
        <div class="sec-head__body">
          <h2 class="sec-head__title sec-head__title--cap">仕事・リサーチ環境</h2>
          <p class="sec-head__read">他社では経験できない設備・手法・ツールが、日本インフォメーションには揃っています</p>
        </div>
      </div>
    </div>
    <div class="num-rows">
      <ul class="num-row">
      <li class="num-card num-card--center" data-anim="inview">
        <div class="num-card__txt num-card__txt--w355">
          <div class="num-card__head">
            <p class="num-card__label"><?php ni_about_text( 'research_panel_label' ); ?></p>
            <?php ni_about_num( 'research_panel' ); ?>
          </div>
          <p class="num-card__note"><?php ni_about_br( 'research_panel_desc' ); ?></p>
        </div>
      </li>
      <li class="num-card num-card--center num-card--grow" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label"><?php ni_about_text( 'research_methods_label' ); ?></p>
            <?php ni_about_num( 'research_methods' ); ?>
          </div>
          <p class="num-card__note"><?php ni_about_br( 'research_methods_desc' ); ?></p>
        </div>
      </li>
      <li class="num-card num-card--media num-card--start" data-anim="inview">
        <div class="num-card__txt num-card__txt--w235">
          <div class="num-card__head">
            <p class="num-card__label"><?php ni_about_text( 'research_venues_label' ); ?></p>
            <?php ni_about_num( 'research_venues' ); ?>
          </div>
          <p class="num-card__note"><?php ni_about_br( 'research_venues_desc' ); ?></p>
        </div>
        <div class="num-card__thumb"><?php ni_about_img( 'research_venues_image', ' loading="lazy"' ); ?></div>
      </li>
      </ul>
      <ul class="num-row">
      <li class="num-card num-card--center num-card--grow" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label"><?php ni_about_text( 'research_staff_label' ); ?></p>
            <?php ni_about_num( 'research_staff' ); ?>
          </div>
          <p class="num-card__note"><?php ni_about_br( 'research_staff_desc' ); ?></p>
        </div>
      </li>
      <li class="num-card num-card--media num-card--lead" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label"><?php ni_about_text( 'research_shopper_label' ); ?></p>
            <p class="num-card__lead"><?php ni_about_br( 'research_shopper_title' ); ?></p>
          </div>
          <p class="num-card__note"><?php ni_about_br( 'research_shopper_desc' ); ?></p>
        </div>
        <div class="num-card__thumb"><?php ni_about_img( 'research_shopper_image', ' loading="lazy"' ); ?></div>
      </li>
        <li class="num-card num-card--ai" data-anim="inview">
          <p class="num-card__label"><?php ni_about_text( 'research_ai_label' ); ?></p>
          <div class="num-card__split">
            <div class="num-card__split-item">
              <p class="num-card__lead"><?php ni_about_text( 'research_ai_quant_title' ); ?></p>
              <p class="num-card__sub"><?php ni_about_br( 'research_ai_quant_desc' ); ?></p>
            </div>
            <div class="num-card__split-item">
              <p class="num-card__lead"><?php ni_about_text( 'research_ai_quali_title' ); ?></p>
              <p class="num-card__sub"><?php ni_about_br( 'research_ai_quali_desc' ); ?></p>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </section>

  <!-- 働き方・カルチャー（Figma 540:10040 / SP 1140:12268） -->
  <section class="lower-sec about-sec about-sec--culture">
    <div class="about-sec__head">
      <div class="sec-head sec-head--sub">
        <p class="sec-head__label u-grd-text">Culture</p>
        <div class="sec-head__body">
          <h2 class="sec-head__title sec-head__title--cap">働き方・カルチャー</h2>
          <p class="sec-head__read">異業種出身者も多く、多様なバックグラウンドを持った人が活躍しています</p>
        </div>
      </div>
    </div>
    <div class="num-rows">
      <ul class="num-row">
      <?php foreach ( array( 'culture_retention', 'culture_turnover', 'culture_tenure', 'culture_maternity' ) as $ni_card ) : ?>
      <li class="num-card num-card--center num-card--grow" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label"><?php ni_about_text( $ni_card . '_label' ); ?></p>
            <?php ni_about_num( $ni_card ); ?>
          </div>
          <p class="num-card__note"><?php ni_about_br( $ni_card . '_desc' ); ?></p>
        </div>
      </li>
      <?php endforeach; ?>
      </ul>
      <ul class="num-row">
        <li class="num-card num-card--career" data-anim="inview">
          <p class="num-card__label"><?php ni_about_text( 'culture_career_label' ); ?></p>
          <ul class="num-card__career">
            <?php foreach ( array( 'culture_career_example1', 'culture_career_example2' ) as $ni_example ) : ?>
            <li><span><?php ni_about_text( $ni_example . '_from' ); ?></span><img src="<?php echo ni_img( 'about/icon_tri.svg' ); ?>" alt="から" width="10" height="8"><span><?php ni_about_text( $ni_example . '_to' ); ?></span></li>
            <?php endforeach; ?>
          </ul>
        </li>
        <li class="num-card num-card--gender num-card--start" data-anim="inview">
          <p class="num-card__label"><?php ni_about_text( 'culture_gender_label' ); ?></p>
          <div class="num-card__ratio">
            <p class="num-card__num"><span class="num-card__unit">男</span><span class="num-card__value"><?php ni_about_text( 'culture_gender_male' ); ?></span><span class="num-card__unit">%</span></p>
            <p class="num-card__num"><span class="num-card__unit">女</span><span class="num-card__value"><?php ni_about_text( 'culture_gender_female' ); ?></span><span class="num-card__unit">%</span></p>
          </div>
          <p class="num-card__sub"><?php ni_about_br( 'culture_gender_desc' ); ?></p>
        </li>
        <li class="num-card num-card--center num-card--lead num-card--grow" data-anim="inview">
          <div class="num-card__txt">
            <div class="num-card__head">
              <p class="num-card__label"><?php ni_about_text( 'culture_flex_title' ); ?></p>
              <p class="num-card__lead"><?php ni_about_br( 'culture_flex_lead' ); ?></p>
            </div>
            <p class="num-card__note"><?php ni_about_br( 'culture_flex_desc' ); ?></p>
          </div>
        </li>
      </ul>
      <ul class="num-row">
      <li class="num-card num-card--media num-card--grow" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label"><?php ni_about_text( 'culture_lunch_title' ); ?></p>
            <?php ni_about_num( 'culture_lunch' ); ?>
          </div>
          <p class="num-card__note"><?php ni_about_br( 'culture_lunch_desc' ); ?></p>
        </div>
        <div class="num-card__thumb"><?php ni_about_img( 'culture_lunch_image', ' loading="lazy"' ); ?></div>
      </li>
      <li class="num-card num-card--media num-card--lead num-card--grow" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label"><?php ni_about_text( 'culture_party_title' ); ?></p>
            <p class="num-card__lead"><?php ni_about_br( 'culture_party_lead' ); ?></p>
          </div>
          <p class="num-card__note"><?php ni_about_br( 'culture_party_desc' ); ?></p>
        </div>
        <div class="num-card__thumb"><?php ni_about_img( 'culture_party_image', ' loading="lazy"' ); ?></div>
      </li>
      <li class="num-card num-card--media num-card--lead num-card--grow" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label"><?php ni_about_text( 'culture_snack_title' ); ?></p>
            <p class="num-card__lead"><?php ni_about_br( 'culture_snack_lead' ); ?></p>
          </div>
          <p class="num-card__note"><?php ni_about_br( 'culture_snack_desc' ); ?></p>
        </div>
        <div class="num-card__thumb"><?php ni_about_img( 'culture_snack_image', ' loading="lazy"' ); ?></div>
      </li>
      </ul>
    </div>
  </section>

  <!-- 社員に聞きました（Figma 522:9670 / SP 1140:12315）。各質問の 1 つ目が紺のピル -->
  <section class="lower-sec about-sec about-voice">
    <div class="about-voice__top">
      <div class="sec-head sec-head--sub">
        <p class="sec-head__label u-grd-text">We Asked Our Team!</p>
        <div class="sec-head__body">
          <h2 class="sec-head__title sec-head__title--cap">日本インフォメーション<br>社員に聞きました！</h2>
          <p class="sec-head__read">日本インフォメーションで働く社員に、3つの質問をしました</p>
        </div>
      </div>
      <div class="about-voice__group about-voice__group--q1" data-anim="inview">
        <h3 class="about-voice__q">Q.入社を決めた理由</h3>
        <ul class="about-voice__list">
          <li class="voice-pill voice-pill--deep">自社で案件を最初から最後まで一貫して執り行えるところ</li>
          <li class="voice-pill">立地のよさ。銀座はトレンドと伝統が共存していて他にはない魅力がある。</li>
          <li class="voice-pill">若くて活気がある</li>
          <li class="voice-pill">ワークライフバランスのとれた働き方ができる</li>
          <li class="voice-pill">社員の風通しがいい会社</li>
        </ul>
      </div>
    </div>
    <div class="about-voice__bottom">
      <div class="about-voice__group about-voice__group--q2" data-anim="inview">
        <h3 class="about-voice__q">Q.面白い！と感じた瞬間</h3>
        <ul class="about-voice__list">
          <li class="voice-pill voice-pill--deep">開発段階から携わっていた商品が世の中に発売されて話題になった時</li>
          <li class="voice-pill">模擬店舗の実査運営に立ち会ったとき</li>
          <li class="voice-pill">ブランドを担当するお客様からリサーチ会社としての意見を求められ、その意見が反映されたとき</li>
          <li class="voice-pill">データやFA回答を通して、消費者の姿や生活がリアルに見えた時</li>
        </ul>
      </div>
      <div class="about-voice__group about-voice__group--q3" data-anim="inview">
        <h3 class="about-voice__q">Q.日本インフォメーションってどんな会社？</h3>
        <ul class="about-voice__list">
          <li class="voice-pill voice-pill--deep">消費者の声を社会につなぐ会社</li>
          <li class="voice-pill">生活者の本音に近い会社</li>
          <li class="voice-pill">リアルの調査に強い</li>
          <li class="voice-pill">長い歴史に見合った高い調査技術を持った会社</li>
          <li class="voice-pill">社員の風通しがいい会社</li>
        </ul>
      </div>
    </div>
  </section>

</main>
<?php
get_footer();
