<?php
/**
 * 社員インタビュー一覧（カスタム投稿 interview の一覧 /interview/）
 *
 * 静的 HTML（HTML/interview/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => '社員インタビュー｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '日本インフォメーションで働く社員のインタビュー一覧。入社年次・職種・働き方のタグから、気になる社員の声を探せます。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <img class="page-head__ni" src="<?php echo ni_img( 'lower/pagehead_ni.png' ); ?>" alt="" width="988" height="936">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">社員インタビュー</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">Member’s Voice</p>
      <h1 class="page-head__jp">社員インタビュー</h1>
    </div>
    <p class="page-head__read">テキストが入りますテキストが入りますテキストが入りますテキストが入ります<br class="u-pc">テキストが入りますテキストが入りますテキストが入ります</p>
  </div>

  <!-- 絞り込み（855:25742 / SP 1140:19173）。WP ではタクソノミー（年次 / 職種 / タグ）のターム一覧を出力。
       静的版は interview.js が data-type / data-job / data-tags で絞り込む（グループ間は AND。年次・職種は単一選択、タグは複数選択で AND）。件数 (n) も JS が数えて入れる -->
  <div class="lower-sec">
    <div class="interview-filter js-interview-filter">
      <div class="interview-filter__group" role="group" aria-labelledby="filter-type" data-filter-group="type">
        <p class="interview-filter__label" id="filter-type">年次</p>
        <ul class="interview-filter__list">
          <li><button type="button" class="interview-filter__btn is-active" data-filter-value="" aria-pressed="true">すべて</button></li>
          <li><button type="button" class="interview-filter__btn" data-filter-value="new" aria-pressed="false">新卒入社 <span class="interview-filter__count js-filter-count"></span></button></li>
          <li><button type="button" class="interview-filter__btn" data-filter-value="mid-beginner" aria-pressed="false">中途入社(未経験) <span class="interview-filter__count js-filter-count"></span></button></li>
          <li><button type="button" class="interview-filter__btn" data-filter-value="mid-experienced" aria-pressed="false">中途入社(経験者) <span class="interview-filter__count js-filter-count"></span></button></li>
          <li><button type="button" class="interview-filter__btn" data-filter-value="part-time" aria-pressed="false">アルバイト <span class="interview-filter__count js-filter-count"></span></button></li>
        </ul>
      </div>
      <div class="interview-filter__group" role="group" aria-labelledby="filter-job" data-filter-group="job">
        <p class="interview-filter__label" id="filter-job">職種</p>
        <ul class="interview-filter__list">
          <li><button type="button" class="interview-filter__btn is-active" data-filter-value="" aria-pressed="true">すべて</button></li>
          <li><button type="button" class="interview-filter__btn" data-filter-value="sales" aria-pressed="false">営業 <span class="interview-filter__count js-filter-count"></span></button></li>
          <li><button type="button" class="interview-filter__btn" data-filter-value="researcher" aria-pressed="false">リサーチャー <span class="interview-filter__count js-filter-count"></span></button></li>
          <li><button type="button" class="interview-filter__btn" data-filter-value="fw" aria-pressed="false">FW <span class="interview-filter__count js-filter-count"></span></button></li>
          <li><button type="button" class="interview-filter__btn" data-filter-value="irg" aria-pressed="false">IRG <span class="interview-filter__count js-filter-count"></span></button></li>
          <li><button type="button" class="interview-filter__btn" data-filter-value="ni-lab" aria-pressed="false">NI研 <span class="interview-filter__count js-filter-count"></span></button></li>
        </ul>
      </div>
      <div class="interview-filter__group" role="group" aria-labelledby="filter-tags" data-filter-group="tags" data-filter-multi>
        <p class="interview-filter__label" id="filter-tags">タグ</p>
        <ul class="interview-filter__list">
          <li><button type="button" class="interview-filter__btn" data-filter-value="remote" aria-pressed="false"># フルリモート</button></li>
          <li><button type="button" class="interview-filter__btn" data-filter-value="short-time" aria-pressed="false"># 時短勤務</button></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- カード一覧（855:25428 / SP 1140:19198）。12 件ずつ表示 -->
  <div class="lower-sec interview-list">
    <ul class="interview-list__grid js-interview-list" data-per-page="12" aria-live="polite">
      <li class="interview-list__item js-interview-item" data-type="new" data-job="sales" data-tags="remote">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_01.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">田中 太郎</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>新卒入社</li><li>営業</li></ul>
              <ul class="interview-card__tags"><li># フルリモート</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="new" data-job="researcher" data-tags="remote short-time">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_02.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">山田 花子</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>新卒入社</li><li>リサーチャー</li></ul>
              <ul class="interview-card__tags"><li># フルリモート</li><li># 時短勤務</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="mid-beginner" data-job="fw" data-tags="short-time">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_03.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">佐藤 健</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>中途入社(未経験)</li><li>FW</li></ul>
              <ul class="interview-card__tags"><li># 時短勤務</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="mid-experienced" data-job="irg" data-tags="remote">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_01.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">田中 太郎</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>中途入社(経験者)</li><li>IRG</li></ul>
              <ul class="interview-card__tags"><li># フルリモート</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="new" data-job="ni-lab" data-tags="remote short-time">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_02.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">山田 花子</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>新卒入社</li><li>NI研</li></ul>
              <ul class="interview-card__tags"><li># フルリモート</li><li># 時短勤務</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="mid-beginner" data-job="sales" data-tags="short-time">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_03.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">佐藤 健</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>中途入社(未経験)</li><li>営業</li></ul>
              <ul class="interview-card__tags"><li># 時短勤務</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="part-time" data-job="researcher" data-tags="remote">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_01.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">田中 太郎</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>アルバイト</li><li>リサーチャー</li></ul>
              <ul class="interview-card__tags"><li># フルリモート</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="mid-experienced" data-job="fw" data-tags="remote short-time">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_02.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">山田 花子</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>中途入社(経験者)</li><li>FW</li></ul>
              <ul class="interview-card__tags"><li># フルリモート</li><li># 時短勤務</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="new" data-job="irg" data-tags="short-time">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_03.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">佐藤 健</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>新卒入社</li><li>IRG</li></ul>
              <ul class="interview-card__tags"><li># 時短勤務</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="mid-beginner" data-job="ni-lab" data-tags="remote">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_01.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">田中 太郎</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>中途入社(未経験)</li><li>NI研</li></ul>
              <ul class="interview-card__tags"><li># フルリモート</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="mid-experienced" data-job="sales" data-tags="remote short-time">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_02.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">山田 花子</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>中途入社(経験者)</li><li>営業</li></ul>
              <ul class="interview-card__tags"><li># フルリモート</li><li># 時短勤務</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="new" data-job="researcher" data-tags="short-time">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_03.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">佐藤 健</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>新卒入社</li><li>リサーチャー</li></ul>
              <ul class="interview-card__tags"><li># 時短勤務</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="part-time" data-job="fw" data-tags="remote">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_01.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">田中 太郎</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>アルバイト</li><li>FW</li></ul>
              <ul class="interview-card__tags"><li># フルリモート</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="new" data-job="irg" data-tags="remote short-time">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_02.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">山田 花子</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>新卒入社</li><li>IRG</li></ul>
              <ul class="interview-card__tags"><li># フルリモート</li><li># 時短勤務</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="mid-beginner" data-job="ni-lab" data-tags="short-time">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_03.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">佐藤 健</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>中途入社(未経験)</li><li>NI研</li></ul>
              <ul class="interview-card__tags"><li># 時短勤務</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="mid-experienced" data-job="sales" data-tags="remote">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_01.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">田中 太郎</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>中途入社(経験者)</li><li>営業</li></ul>
              <ul class="interview-card__tags"><li># フルリモート</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="new" data-job="researcher" data-tags="remote short-time">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_02.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">山田 花子</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>新卒入社</li><li>リサーチャー</li></ul>
              <ul class="interview-card__tags"><li># フルリモート</li><li># 時短勤務</li></ul>
            </div>
          </div>
        </a>
      </li>
      <li class="interview-list__item js-interview-item" data-type="mid-beginner" data-job="fw" data-tags="short-time">
        <a class="interview-card" href="<?php echo ni_url( '/interview/detail/' ); ?>">
          <div class="interview-card__img"><img src="<?php echo ni_img( 'common/voice_card_03.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
              <p class="interview-card__name">佐藤 健</p>
            </div>
            <div class="interview-card__meta">
              <ul class="interview-card__chips"><li>中途入社(未経験)</li><li>FW</li></ul>
              <ul class="interview-card__tags"><li># 時短勤務</li></ul>
            </div>
          </div>
        </a>
      </li>
    </ul>
    <p class="interview-list__empty js-interview-empty" hidden>条件に合うインタビューはありません。</p>
    <div class="interview-list__more">
      <button type="button" class="more-btn js-interview-more"><span class="more-btn__txt"><span class="js-interview-more-next">次の12件をみる</span><span class="more-btn__line" aria-hidden="true"></span><span class="js-interview-more-status">12 / 18件表示中</span></span><img class="more-btn__icon" src="<?php echo ni_img( 'lower/icon_more.svg' ); ?>" alt="" width="20" height="20"></button>
    </div>
  </div>

</main>
<?php
get_footer();
