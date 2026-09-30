<?php
/**
 * 社員インタビュー詳細（カスタム投稿 interview の詳細 /interview/{パーマリンク}/）
 *
 * 静的 HTML（HTML/interview/detail/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => 'タイトルが入りますタイトルが入りますタイトルが入りますタイトルが入ります｜社員インタビュー｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '日本インフォメーションで働く社員のインタビュー。仕事のやりがいや 1 日のスケジュールを紹介します。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li><a href="<?php echo ni_url( '/interview/' ); ?>">社員インタビュー</a></li><li aria-current="page">タイトルが入りますタイトルが入りますタイトルが入りますタイトルが入ります</li></ol></nav>
  </div>

  <!-- メインビジュアル + タイトル（855:26428 / SP 1140:19629）。写真は左端から、右に 96 / 24 の余白 -->
  <div class="interview-mv">
    <div class="interview-mv__img"><img src="<?php echo ni_img( 'interview/detail_mv.jpg' ); ?>" alt="" width="1600" height="1066"></div>
    <div class="interview-mv__txt">
      <p class="interview-mv__label">Interview</p>
      <h1 class="interview-mv__title">タイトルが入りますタイトルが入りますタイトルが入りますタイトルが入ります</h1>
      <p class="interview-mv__name">田中 太郎</p>
      <ul class="interview-mv__chips"><li>新卒入社</li><li>リサーチャー</li></ul>
      <ul class="interview-mv__tags"><li># フルリモート</li><li># 時短勤務</li></ul>
    </div>
  </div>

  <!-- 本文（855:26764 / SP 1140:19645）。WP では ACF のくり返し（Q&A / 写真）。左の写真は PC だけ（sticky で本文に追従） -->
  <div class="interview-body">
    <div class="interview-body__side"><img src="<?php echo ni_img( 'interview/detail_side.jpg' ); ?>" alt="" width="1600" height="1066"></div>
    <div class="interview-body__main">
        <section class="interview-qa">
          <div class="interview-qa__head">
            <p class="interview-qa__num u-grd-text">Question 01</p>
            <h2 class="interview-qa__q">質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります</h2>
          </div>
          <p class="interview-qa__a">本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
        </section>
        <section class="interview-qa">
          <div class="interview-qa__head">
            <p class="interview-qa__num u-grd-text">Question 02</p>
            <h2 class="interview-qa__q">質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります</h2>
          </div>
          <p class="interview-qa__a">本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
        </section>
        <figure class="interview-body__photo"><img src="<?php echo ni_img( 'interview/detail_photo_01.jpg' ); ?>" alt="" width="1600" height="1066" loading="lazy"></figure>
        <section class="interview-qa">
          <div class="interview-qa__head">
            <p class="interview-qa__num u-grd-text">Question 03</p>
            <h2 class="interview-qa__q">質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります</h2>
          </div>
          <p class="interview-qa__a">本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
        </section>
        <section class="interview-qa">
          <div class="interview-qa__head">
            <p class="interview-qa__num u-grd-text">Question 04</p>
            <h2 class="interview-qa__q">質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります</h2>
          </div>
          <p class="interview-qa__a">本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
        </section>
        <figure class="interview-body__photo"><img src="<?php echo ni_img( 'interview/detail_photo_01.jpg' ); ?>" alt="" width="1600" height="1066" loading="lazy"></figure>
        <section class="interview-qa">
          <div class="interview-qa__head">
            <p class="interview-qa__num u-grd-text">Question 05</p>
            <h2 class="interview-qa__q">質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります</h2>
          </div>
          <p class="interview-qa__a">本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
        </section>
        <section class="interview-qa">
          <div class="interview-qa__head">
            <p class="interview-qa__num u-grd-text">Question 06</p>
            <h2 class="interview-qa__q">質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります</h2>
          </div>
          <p class="interview-qa__a">本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
        </section>
    </div>
  </div>

  <!-- 1 日のスケジュール（855:26838 / SP 1140:19657）。背景の英字は横に流れ続ける（CSS animation） -->
  <section class="day">
    <div class="day__deco" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div>
    <div class="day__marquee u-en" aria-hidden="true"><div class="day__marquee-track"><span class="day__marquee-item">A Day at Work.</span><span class="day__marquee-item">A Day at Work.</span><span class="day__marquee-item">A Day at Work.</span><span class="day__marquee-item">A Day at Work.</span><span class="day__marquee-item">A Day at Work.</span><span class="day__marquee-item">A Day at Work.</span></div></div>
    <div class="day__box bracket">
      <span class="bracket__corner bracket__corner--tl"></span>
      <span class="bracket__corner bracket__corner--tr"></span>
      <span class="bracket__corner bracket__corner--bl"></span>
      <span class="bracket__corner bracket__corner--br"></span>
      <h2 class="day__title">仕事がある日のスケジュール</h2>
      <!-- --rows: PC で 2 列に分けるときの 1 列あたりの件数（WP では ceil(件数 / 2) を出力） -->
      <ol class="day__list" style="--rows: 4">
        <li class="day__item">
          <img class="day__marker" src="<?php echo ni_img( 'interview/icon_time_marker.svg' ); ?>" alt="" width="42" height="17">
          <div class="day__txt">
            <p class="day__time">9:00</p>
            <p class="day__desc">本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
          </div>
        </li>
        <li class="day__item">
          <img class="day__marker" src="<?php echo ni_img( 'interview/icon_time_marker.svg' ); ?>" alt="" width="42" height="17">
          <div class="day__txt">
            <p class="day__time">10:00</p>
            <p class="day__desc">本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
          </div>
        </li>
        <li class="day__item">
          <img class="day__marker" src="<?php echo ni_img( 'interview/icon_time_marker.svg' ); ?>" alt="" width="42" height="17">
          <div class="day__txt">
            <p class="day__time">11:00</p>
            <p class="day__desc">本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
          </div>
        </li>
        <li class="day__item">
          <img class="day__marker" src="<?php echo ni_img( 'interview/icon_time_marker.svg' ); ?>" alt="" width="42" height="17">
          <div class="day__txt">
            <p class="day__time">12:00</p>
            <p class="day__desc">本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
          </div>
        </li>
        <li class="day__item">
          <img class="day__marker" src="<?php echo ni_img( 'interview/icon_time_marker.svg' ); ?>" alt="" width="42" height="17">
          <div class="day__txt">
            <p class="day__time">13:00</p>
            <p class="day__desc">本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
          </div>
        </li>
        <li class="day__item">
          <img class="day__marker" src="<?php echo ni_img( 'interview/icon_time_marker.svg' ); ?>" alt="" width="42" height="17">
          <div class="day__txt">
            <p class="day__time">15:00</p>
            <p class="day__desc">本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
          </div>
        </li>
        <li class="day__item">
          <img class="day__marker" src="<?php echo ni_img( 'interview/icon_time_marker.svg' ); ?>" alt="" width="42" height="17">
          <div class="day__txt">
            <p class="day__time">16:00</p>
            <p class="day__desc">本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
          </div>
        </li>
        <li class="day__item">
          <img class="day__marker" src="<?php echo ni_img( 'interview/icon_time_marker.svg' ); ?>" alt="" width="42" height="17">
          <div class="day__txt">
            <p class="day__time">17:00</p>
            <p class="day__desc">本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
          </div>
        </li>
      </ol>
    </div>
  </section>

  <!-- 関連インタビュー（855:27157 / SP 1140:19698） -->
  <section class="lower-sec interview-related">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Related Interviews</p>
      <h2 class="sec-head__title sec-head__title--cap">関連インタビュー</h2>
    </div>
    <ul class="interview-related__list">
      <li>
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_01.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">タイトルが入りますタイトルが入りますタイトルが入りますタイトルが入ります</p>
              <p class="interview-card__name">田中 太郎</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>新卒入社</li><li>リサーチャー</li></ul>
              <ul class="interview-card__tags"><li># フルリモート</li><li># 時短勤務</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li>
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_02.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">タイトルが入りますタイトルが入りますタイトルが入りますタイトルが入ります</p>
              <p class="interview-card__name">山田 花子</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>新卒入社</li><li>リサーチャー</li></ul>
              <ul class="interview-card__tags"><li># フルリモート</li><li># 時短勤務</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li>
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_03.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">タイトルが入りますタイトルが入りますタイトルが入りますタイトルが入ります</p>
              <p class="interview-card__name">田中 太郎</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>新卒入社</li><li>リサーチャー</li></ul>
              <ul class="interview-card__tags"><li># フルリモート</li><li># 時短勤務</li></ul>
            </div>
          </div>
        </a>
      </li>
    </ul>
    <a class="btn btn--w interview-related__btn" href="<?php echo ni_url( '/interview/' ); ?>">記事一覧へ戻る<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
  </section>

</main>
<?php
get_footer();
