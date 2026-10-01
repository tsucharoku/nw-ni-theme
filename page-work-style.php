<?php
/**
 * 制度・環境（固定ページ /work-style/）
 *
 * 静的 HTML（HTML/work-style/index.html）の <main> から起こしたもの。ページ頭・カルチャー・各セクションの見出し・働き方の大カードの
 * 見出しと本文は固定、それ以外（社員の声・各カード・写真の帯・社内コミュニケーションの大カード）は ACF。
 */

/* 固定ページ work-style の ACF「制度・環境」（acf-json/group_ni_work_style.json。設計書: NI採用サイト_ACFフィールド設計書_制度・環境.xlsx）。
   フィールドキー（field_ni_ws_○○）で引く。入力した内容だけを出す */
function ni_ws( $name ) {
	return function_exists( 'get_field' ) ? get_field( 'field_ni_ws_' . $name, get_queried_object_id() ) : null;
}

/* 複数行のテキスト（改行 → <br>） */
function ni_ws_br( $text ) {
	return implode( '<br>', array_map( 'esc_html', preg_split( '/\R/u', trim( (string) $text ) ) ) );
}

/* ACF の画像（配列）の <img>。$size は WP の画像サイズ名（無ければ元の画像）。SVG は寸法が無いので width / height を付けない */
function ni_ws_img( $img, $size = '', $atts = '' ) {
	if ( ! is_array( $img ) || empty( $img['url'] ) ) {
		return '';
	}
	$url = $img['url'];
	$w   = (int) $img['width'];
	$h   = (int) $img['height'];
	if ( $size && ! empty( $img['sizes'][ $size ] ) ) {
		$url = $img['sizes'][ $size ];
		$w   = (int) $img['sizes'][ $size . '-width' ];
		$h   = (int) $img['sizes'][ $size . '-height' ];
	}
	return sprintf( '<img src="%s" alt="%s"%s%s>', esc_url( $url ), esc_attr( $img['alt'] ), $w && $h ? sprintf( ' width="%d" height="%d"', $w, $h ) : '', $atts );
}

/* ミニカード（.icon-card）のリピーター 1 行。$class は li に足すクラス、$icon_class はアイコンの枠に足すクラス */
function ni_ws_icon_card( $card, $class = '', $icon_class = '', $amount = false ) {
	?>
      <li class="icon-card<?php echo $class ? ' ' . esc_attr( $class ) : ''; ?>">
        <?php if ( ! empty( $card['icon'] ) ) : ?>
        <span class="icon-card__icon<?php echo $icon_class ? ' ' . esc_attr( $icon_class ) : ''; ?>"><?php echo ni_ws_img( $card['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
        <?php endif; ?>
        <div class="icon-card__txt">
          <?php if ( $amount ) : ?>
          <h3 class="icon-card__title"><span class="icon-card__sub"><?php echo esc_html( $card['title'] ); ?></span><span class="icon-card__amount"><?php echo esc_html( $card['subtitle'] ); ?></span></h3>
          <?php else : ?>
          <h3 class="icon-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
          <?php endif; ?>
          <p class="icon-card__body"><?php echo ni_ws_br( $card['desc'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
        </div>
      </li>
	<?php
}

/* リピーターの行（無ければ空の配列） */
function ni_ws_rows( $name ) {
	$rows = ni_ws( $name );
	return is_array( $rows ) ? $rows : array();
}

ni_head(
	array(
		'title'       => '制度・環境｜日本インフォメーション株式会社 採用情報サイト',
		'description' => 'フルフレックス・在宅・ワーケーションなどの働き方、福利厚生、社内コミュニケーション・表彰制度、成長・キャリアを支える制度まで。日本インフォメーションの制度・環境をご紹介します。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">制度・環境</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">Work<br class="u-sp"> Environment<br> &amp; Benefits</p>
      <h1 class="page-head__jp">制度・環境</h1>
    </div>
    <p class="page-head__read">フルフレックス・在宅・ワーケーション…。日本インフォメーションでは、ライフスタイルに合わせて柔軟に働ける仕組みを整えています。<br class="u-pc">充実した研修制度と福利厚生で、長く活躍できる環境をサポートします。</p>
  </div>

  <!-- ===== Culture（557:13147 / SP 1140:14536） ===== -->
  <section class="lower-sec ws-sec ws-sec--first">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Culture</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">日本インフォメーションのカルチャー</h2>
        <p class="sec-head__read">制度や環境の前に、私たち日本インフォメーションという会社が大切にしている文化をご紹介します。</p>
      </div>
    </div>
    <ul class="ws-culture">
      <li class="ws-culture__item">
        <span class="ws-culture__icon"><img src="<?php echo ni_img( 'work-style/icon_01.svg' ); ?>" alt="" width="40" height="40"></span>
        <h3 class="ws-culture__title">リサーチの専門家を目指し<br>切磋琢磨できる環境</h3>
        <p class="ws-culture__body">クライアントの約9割が大手メーカーのマーケティング・リサーチ部署。高い水準の相手に「信頼されるリサーチャー」として認められることを目指し、互いに高め合える環境があります。</p>
      </li>
      <li class="ws-culture__item">
        <span class="ws-culture__icon"><img src="<?php echo ni_img( 'work-style/icon_02.svg' ); ?>" alt="" width="40" height="40"></span>
        <h3 class="ws-culture__title">新しい手法への<br>チャレンジ精神が豊富</h3>
        <p class="ws-culture__body">変化への対応やクライアントへの新提案のため、新しいリサーチ手法の開発を積極的に実施。AIツール開発など、アイデアは社員のボトムアップから生まれることも多いです。</p>
      </li>
      <li class="ws-culture__item">
        <span class="ws-culture__icon"><img src="<?php echo ni_img( 'work-style/icon_03.svg' ); ?>" alt="" width="40" height="40"></span>
        <h3 class="ws-culture__title">コミュニケーション活発で<br>働きやすい風土</h3>
        <p class="ws-culture__body">部署間連携が求められる業務のため、社内コミュニケーションを重視。フラットで風通しよく、業務外も含めてコミュニケーションが活発な職場環境です。</p>
      </li>
    </ul>
  </section>

  <!-- ===== Work Style（557:13156 / SP 1140:14542）。大カードの見出し・本文・アイコンは固定、社員の声とミニカードは ACF ===== -->
  <section class="lower-sec ws-sec">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Work Style</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">働き方</h2>
        <p class="sec-head__read">コアタイムなし、在宅OK、ワーケーションも可。実際に制度を使っている社員の声とともに紹介します。</p>
      </div>
    </div>
    <ul class="ws-flex-list">
      <?php
      foreach (
      	array(
      		'flex'   => array( 'icon_04.svg', 'フルフレックス勤務制度', 'コアタイムなし。5:00〜22:00の間で自由に勤務時間を設定できます。繁忙期は早めに動いて早帰り、納品後は遅めスタートにするなど、仕事の波に合わせて自分でコントロールできるのが特徴です。' ),
      		'remote' => array( 'icon_05.svg', '在宅・リモートオフィス勤務', '通勤ラッシュを避けて、自宅や近隣のリモートオフィスでの勤務が可能。在宅手当（月5,000円）も支給されるため、通信費・光熱費の心配なく活用できます。' ),
      	) as $ni_key => $ni_flex
      ) :
      	$ni_role  = (string) ni_ws( 'hataraki_' . $ni_key . '_voice_role' );
      	$ni_quote = (string) ni_ws( 'hataraki_' . $ni_key . '_voice_text' );
      	$ni_photo = ni_ws_img( ni_ws( 'hataraki_' . $ni_key . '_voice_image' ), 'medium', ' loading="lazy"' );
      	?>
      <li class="ws-flex">
        <div class="ws-flex__head">
          <span class="ws-flex__icon"><img src="<?php echo ni_img( 'work-style/' . $ni_flex[0] ); ?>" alt="" width="40" height="40"></span>
          <h3 class="ws-flex__title"><?php echo esc_html( $ni_flex[1] ); ?></h3>
          <p class="ws-flex__body"><?php echo esc_html( $ni_flex[2] ); ?></p>
        </div>
        <?php if ( '' !== $ni_role || '' !== trim( $ni_quote ) || $ni_photo ) : ?>
        <div class="ws-flex__voice">
          <p class="ws-flex__voice-label">実際に使っている社員の声</p>
          <p class="ws-flex__voice-who"><?php echo esc_html( $ni_role ); ?></p>
          <p class="ws-flex__voice-quote"><?php echo ni_ws_br( $ni_quote ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
          <?php if ( $ni_photo ) : ?>
          <span class="ws-flex__voice-photo"><?php echo $ni_photo; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php if ( ni_ws_rows( 'hataraki_mini_cards' ) ) : ?>
    <ul class="icon-cards icon-cards--4">
      <?php
      foreach ( ni_ws_rows( 'hataraki_mini_cards' ) as $ni_card ) {
      	ni_ws_icon_card( $ni_card );
      }
      ?>
    </ul>
    <?php endif; ?>
  </section>

  <!-- ===== Benefits（562:14074 / SP 1140:14553）。カードは ACF。金額の行（支援内容）は PC のみ（SP のデザインに無い） ===== -->
  <section class="lower-sec ws-sec">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Benefits</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">福利厚生・健康サポート</h2>
        <p class="sec-head__read">働きやすさを支える手当・補助・健康サポートを整えています。</p>
      </div>
    </div>
    <?php if ( ni_ws_rows( 'fukuri_cards' ) ) : ?>
    <ul class="icon-cards icon-cards--3">
      <?php
      foreach ( ni_ws_rows( 'fukuri_cards' ) as $ni_card ) {
      	ni_ws_icon_card( $ni_card, 'icon-card--amount', 'icon-card__icon--s', true );
      }
      ?>
    </ul>
    <?php endif; ?>
  </section>

  <?php $ni_gallery = ni_ws( 'ws_gallery' ); ?>
  <?php if ( is_array( $ni_gallery ) && $ni_gallery ) : ?>
  <!-- ===== 写真の帯（Autocarousel 1069:14885 / SP 1140:14564）。写真は ACF のギャラリー（注釈「画像は全て差し替え可能にする」）。work-style.js が複製して CSS で流す ===== -->
  <div class="photo-marquee" aria-hidden="true">
    <ul class="photo-marquee__track js-photo-marquee">
      <?php foreach ( $ni_gallery as $ni_img ) : ?>
      <li class="photo-marquee__item"><?php echo ni_ws_img( $ni_img, 'large', ' loading="lazy"' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php endif; ?>

  <!-- ===== Communication（562:14272 / SP 1140:14566）。大カード 3 枚（固定の枠）とミニカードは ACF ===== -->
  <section class="ws-sec ws-comm">
    <div class="lower-sec">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Communication</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">社内コミュニケーション・表彰制度</h2>
        <p class="sec-head__read">日本インフォメーションには、<br class="u-pc">仲間との接点を自然に増やすための制度と、がんばりをきちんと称える表彰制度があります。<br class="u-pc">どんな場面で活きているか、エピソードとともにご紹介します。</p>
      </div>
    </div>
    </div>
    <!-- 付箋 1370:17451: 中央 1 枚 → 背後のカードが左右に広がる → カルーセル（work-style.js）。SP は縦積み -->
    <div class="arc-cards js-arc-cards">
    <ul class="arc-cards__stage">
      <?php foreach ( array( 'comm_award', 'comm_thanks', 'comm_lunch' ) as $ni_key ) : ?>
      <li class="arc-card">
        <div class="arc-card__inner bracket">
          <span class="bracket__corner bracket__corner--tl"></span><span class="bracket__corner bracket__corner--tr"></span><span class="bracket__corner bracket__corner--bl"></span><span class="bracket__corner bracket__corner--br"></span>
          <p class="arc-card__pill"><span><?php echo esc_html( (string) ni_ws( $ni_key . '_title' ) ); ?></span></p>
          <div class="arc-card__photo"><?php echo ni_ws_img( ni_ws( $ni_key . '_image' ), '', ' loading="lazy"' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
          <h3 class="arc-card__catch"><?php echo esc_html( (string) ni_ws( $ni_key . '_subtitle' ) ); ?></h3>
          <p class="arc-card__body"><?php echo ni_ws_br( ni_ws( $ni_key . '_desc' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
        </div>
      </li>
      <?php endforeach; ?>
    </ul>
    </div>
    <?php if ( ni_ws_rows( 'comm_mini_cards' ) ) : ?>
    <div class="lower-sec">
    <ul class="icon-cards icon-cards--3 icon-cards--row">
      <?php
      foreach ( ni_ws_rows( 'comm_mini_cards' ) as $ni_card ) {
      	ni_ws_icon_card( $ni_card, 'icon-card--row' );
      }
      ?>
    </ul>
    </div>
    <?php endif; ?>
  </section>

  <!-- ===== Career Support（562:14406 / SP 1140:14590）。制度カードは ACF（アイコンは設計書に無いが、デザインに合わせて追加） ===== -->
  <section class="lower-sec ws-sec ws-sec--last">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Career Support</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">成長・キャリアを支える制度</h2>
        <p class="sec-head__read">日本インフォメーションに長く在籍しながら成長・キャリアを形成していくための制度・仕組みをまとめています。</p>
      </div>
    </div>
    <?php if ( ni_ws_rows( 'career_cards' ) ) : ?>
    <ul class="icon-cards icon-cards--3">
      <?php
      foreach ( ni_ws_rows( 'career_cards' ) as $ni_card ) {
      	ni_ws_icon_card( $ni_card );
      }
      ?>
    </ul>
    <?php endif; ?>
  </section>

</main>
<?php
get_footer();
