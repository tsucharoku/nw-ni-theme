<?php
/**
 * 座談会詳細（カスタム投稿 cross-talk の詳細 /cross-talk/{パーマリンク}/）
 *
 * 静的 HTML（HTML/cross-talk/detail/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => 'タイトルが入りますタイトルが入りますタイトルが入りますタイトルが入ります｜座談会｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head: 詳細はパンくずだけ（Figma H2 900:28233。英字・和文・リード・NI ロゴなし）。id="js-fv" はここに残す -->
  <div class="page-head ct-page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li><a href="<?php echo ni_url( '/cross-talk/' ); ?>">座談会</a></li><li aria-current="page">タイトルが入りますタイトルが入りますタイトルが入りますタイトルが入ります</li></ol></nav>
  </div>

  <article class="ct-article">

    <!-- メインビジュアル + タイトル（Figma PC 900:28234 / SP 1200:19639）。写真はアイキャッチ -->
    <header class="ct-hero">
      <div class="ct-hero__img"><img src="<?php echo ni_img( 'cross-talk/detail_mv.jpg' ); ?>" alt="" width="2048" height="1366" fetchpriority="high"></div>
      <div class="ct-hero__txt">
        <p class="ct-hero__label">Cross Talk</p>
        <h1 class="ct-hero__title">タイトルが入りますタイトルが入りますタイトルが入りますタイトルが入ります</h1>
      </div>
    </header>

    <div class="lower-sec ct-article__main">

      <!-- 参加メンバー（Figma PC 900:28260 / SP 1140:20472）。PC は本文の左で sticky。WP ではカスタムフィールドの繰り返し -->
      <aside class="ct-members bracket" aria-label="参加メンバー">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <p class="ct-members__label u-grd-text">Member</p>
        <ul class="ct-members__list">
          <li class="ct-member">
            <img class="ct-member__img" src="<?php echo ni_img( 'cross-talk/member_01.jpg' ); ?>" alt="" width="88" height="88">
            <div class="ct-member__body">
              <p class="ct-member__year">2016年入社</p>
              <p class="ct-member__dept">リサーチ・コンサルティング部 サブリーダー</p>
              <p class="ct-member__name">H.Wさん</p>
            </div>
          </li>
          <li class="ct-member">
            <img class="ct-member__img" src="<?php echo ni_img( 'cross-talk/member_02.jpg' ); ?>" alt="" width="88" height="88">
            <div class="ct-member__body">
              <p class="ct-member__year">2022年入社</p>
              <p class="ct-member__dept">リサーチ・ディレクション部</p>
              <p class="ct-member__name">T.Sさん</p>
            </div>
          </li>
          <li class="ct-member">
            <img class="ct-member__img" src="<?php echo ni_img( 'cross-talk/member_03.jpg' ); ?>" alt="" width="88" height="88">
            <div class="ct-member__body">
              <p class="ct-member__year">2022年入社</p>
              <p class="ct-member__dept">NIマーケティング研究所</p>
              <p class="ct-member__name">K.Mさん</p>
            </div>
          </li>
        </ul>
      </aside>

      <!-- 本文（Figma PC 900:28251 / SP 1140:20441）。WP ではブロックエディタの出力がそのまま入る想定:
           見出し = h2、段落 = p、写真 = figure、質問 = .ct-question、発言 = .speech（--left / --right）。
           ブロック間の余白は .cross-talk-body の直下セレクタで付けている（グループで囲まなくてよい） -->
      <div class="cross-talk-body">
        <h2>見出しが入ります見出しが入ります見出しが入ります見出しが入ります見出しが入ります</h2>
        <div class="ct-question">
          <p class="ct-question__label">Question 01</p>
          <h3 class="ct-question__title">質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります</h3>
        </div>
        <p>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
        <div class="speech speech--left">
          <div class="speech__who"><img class="speech__avatar" src="<?php echo ni_img( 'cross-talk/member_01.jpg' ); ?>" alt="" width="80" height="80" loading="lazy"><span class="speech__name">氏名</span></div>
          <div class="speech__text"><p>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p></div>
        </div>
        <div class="ct-question">
          <p class="ct-question__label">Question 02</p>
          <h3 class="ct-question__title">質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります</h3>
        </div>
        <div class="speech speech--left">
          <div class="speech__who"><img class="speech__avatar" src="<?php echo ni_img( 'cross-talk/member_01.jpg' ); ?>" alt="" width="80" height="80" loading="lazy"><span class="speech__name">氏名</span></div>
          <div class="speech__text"><p>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p></div>
        </div>
        <div class="speech speech--left">
          <div class="speech__who"><img class="speech__avatar" src="<?php echo ni_img( 'cross-talk/member_01.jpg' ); ?>" alt="" width="80" height="80" loading="lazy"><span class="speech__name">氏名</span></div>
          <div class="speech__text"><p>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p></div>
        </div>
        <figure><img src="<?php echo ni_img( 'cross-talk/detail_photo_01.jpg' ); ?>" alt="" width="2048" height="1366" loading="lazy"></figure>
        <h2>見出しが入ります見出しが入ります見出しが入ります見出しが入ります見出しが入ります</h2>
        <div class="ct-question">
          <p class="ct-question__label">Question 03</p>
          <h3 class="ct-question__title">質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります</h3>
        </div>
        <div class="speech speech--left">
          <div class="speech__who"><img class="speech__avatar" src="<?php echo ni_img( 'cross-talk/member_01.jpg' ); ?>" alt="" width="80" height="80" loading="lazy"><span class="speech__name">氏名</span></div>
          <div class="speech__text"><p>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p></div>
        </div>
        <div class="ct-question">
          <p class="ct-question__label">Question 04</p>
          <h3 class="ct-question__title">質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります</h3>
        </div>
        <div class="speech speech--left">
          <div class="speech__who"><img class="speech__avatar" src="<?php echo ni_img( 'cross-talk/member_01.jpg' ); ?>" alt="" width="80" height="80" loading="lazy"><span class="speech__name">氏名</span></div>
          <div class="speech__text"><p>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p></div>
        </div>
        <div class="speech speech--left">
          <div class="speech__who"><img class="speech__avatar" src="<?php echo ni_img( 'cross-talk/member_01.jpg' ); ?>" alt="" width="80" height="80" loading="lazy"><span class="speech__name">氏名</span></div>
          <div class="speech__text"><p>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p></div>
        </div>
        <div class="speech speech--left">
          <div class="speech__who"><img class="speech__avatar" src="<?php echo ni_img( 'cross-talk/member_01.jpg' ); ?>" alt="" width="80" height="80" loading="lazy"><span class="speech__name">氏名</span></div>
          <div class="speech__text"><p>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p></div>
        </div>
        <figure><img src="<?php echo ni_img( 'cross-talk/detail_photo_01.jpg' ); ?>" alt="" width="2048" height="1366" loading="lazy"></figure>
        <h2>見出しが入ります見出しが入ります見出しが入ります見出しが入ります見出しが入ります</h2>
        <div class="ct-question">
          <p class="ct-question__label">Question 05</p>
          <h3 class="ct-question__title">質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります</h3>
        </div>
        <div class="speech speech--left">
          <div class="speech__who"><img class="speech__avatar" src="<?php echo ni_img( 'cross-talk/member_01.jpg' ); ?>" alt="" width="80" height="80" loading="lazy"><span class="speech__name">氏名</span></div>
          <div class="speech__text"><p>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p></div>
        </div>
        <div class="speech speech--left">
          <div class="speech__who"><img class="speech__avatar" src="<?php echo ni_img( 'cross-talk/member_01.jpg' ); ?>" alt="" width="80" height="80" loading="lazy"><span class="speech__name">氏名</span></div>
          <div class="speech__text"><p>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p></div>
        </div>
        <div class="speech speech--left">
          <div class="speech__who"><img class="speech__avatar" src="<?php echo ni_img( 'cross-talk/member_01.jpg' ); ?>" alt="" width="80" height="80" loading="lazy"><span class="speech__name">氏名</span></div>
          <div class="speech__text"><p>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p></div>
        </div>
      </div>

    </div>
  </article>

  <!-- その他の記事（Figma PC 900:28297 / SP 1140:20492）。PC 3 件 / SP 4 件（4 件目は PC で非表示） -->
  <section class="lower-sec ct-others">
    <div class="sec-head sec-head--sub ct-others__head">
      <p class="sec-head__label u-grd-text">Other Articles</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">その他の記事</h2>
      </div>
    </div>
    <ul class="ct-others__list">
      <li><a class="ct-card" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">
        <span class="ct-card__img"><img src="<?php echo ni_img( 'cross-talk/talk_01.jpg' ); ?>" alt="" width="1024" height="566" loading="lazy"></span>
        <span class="ct-card__title">タイトルが入りますタイトルが入りますタイトルが入りますタイトルが入ります</span>
      </a></li>
      <li><a class="ct-card" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">
        <span class="ct-card__img"><img src="<?php echo ni_img( 'cross-talk/talk_01.jpg' ); ?>" alt="" width="1024" height="566" loading="lazy"></span>
        <span class="ct-card__title">タイトルが入りますタイトルが入りますタイトルが入りますタイトルが入ります</span>
      </a></li>
      <li><a class="ct-card" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">
        <span class="ct-card__img"><img src="<?php echo ni_img( 'cross-talk/talk_01.jpg' ); ?>" alt="" width="1024" height="566" loading="lazy"></span>
        <span class="ct-card__title">タイトルが入りますタイトルが入りますタイトルが入りますタイトルが入ります</span>
      </a></li>
      <li><a class="ct-card" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">
        <span class="ct-card__img"><img src="<?php echo ni_img( 'cross-talk/talk_01.jpg' ); ?>" alt="" width="1024" height="566" loading="lazy"></span>
        <span class="ct-card__title">タイトルが入りますタイトルが入りますタイトルが入りますタイトルが入ります</span>
      </a></li>
    </ul>
    <a class="btn btn--w ct-others__btn" href="<?php echo ni_url( '/cross-talk/' ); ?>">記事一覧へ戻る<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
  </section>

</main>
<?php
get_footer();
