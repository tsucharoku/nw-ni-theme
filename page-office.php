<?php
/**
 * オフィス紹介（固定ページ /office/）
 *
 * 静的 HTML（HTML/office/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => 'オフィス紹介｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '東京・銀座の日本インフォメーションのオフィスをご紹介します。ラウンジ、フリーアドレスの執務スペース、社内ライブラリー、スナックステーション、会議室、大阪営業所まで。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <img class="page-head__ni" src="<?php echo ni_img( 'lower/pagehead_ni.png' ); ?>" alt="" width="988" height="936">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">オフィス紹介</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">Our Office</p>
      <h1 class="page-head__jp">オフィス紹介</h1>
    </div>
    <p class="page-head__read">東京・銀座の中心地に構える日本インフォメーションのオフィス。<br class="u-pc">仕事に集中できる環境と、人とつながれる場所が共存しています。</p>
  </div>

  <!-- ===== Hero（562:15278 / SP 1140:15250）: 写真 + 流れる英字 + リード + 数字 ===== -->
  <div class="office-hero">
    <div class="office-hero__photo"><img src="<?php echo ni_img( 'office/hero.jpg' ); ?>" alt="日本インフォメーションのオフィス" width="1344" height="895"></div>
    <p class="office-hero__marquee u-en" aria-hidden="true"><span class="office-hero__marquee-track"><span>Focus. Connect. Work Your Way.</span><span>Focus. Connect. Work Your Way.</span><span>Focus. Connect. Work Your Way.</span><span>Focus. Connect. Work Your Way.</span></span></p>
    <div class="office-hero__body">
      <p class="office-hero__lead">銀座という場所で、自分らしい働き方を。<br class="u-pc">ラウンジ、ライブラリー、フォーカスブース——<br class="u-pc">その日の仕事に合わせて、空間を選ぶことができます。</p>
      <ul class="office-stats">
        <li class="office-stats__item">
          <p class="office-stats__label"><span>社内ライブラリー蔵書数</span></p>
          <p class="office-stats__num">200<img class="office-stats__unit" src="<?php echo ni_img( 'office/unit_satsu.svg' ); ?>" alt="冊以上" width="48" height="28"></p>
        </li>
        <li class="office-stats__item">
          <p class="office-stats__label"><span>スナックミー利用料</span></p>
          <p class="office-stats__num office-stats__num--jp">無料</p>
        </li>
      </ul>
    </div>
  </div>

  <!-- ===== Lounge（562:15297 / SP 1140:15268） ===== -->
  <section class="lower-sec office-sec office-lounge">
    <div class="office-split">
      <div class="office-split__txt">
        <div class="sec-head sec-head--sub">
          <p class="sec-head__label u-grd-text">Lounge &amp; Communication Space</p>
          <h2 class="sec-head__title sec-head__title--cap"><span>仕事の合間に、<br class="u-pc">人とアイデアを温める場所。</span></h2>
        </div>
        <p class="office-text">ブース型のソファ席、デザインチェアを配した長テーブル、緑あふれる植栽——。会議室を取る必要のない、気軽な打ち合わせや1on1に使えるラウンジスペースです。フリーアドレスの文化と組み合わせることで、部署を越えた自然なコミュニケーションが生まれます。</p>
        <ul class="office-tags"><li class="office-tags__item">#グリーン空間</li><li class="office-tags__item">#気軽な打ち合わせ</li><li class="office-tags__item">#ランチ</li><li class="office-tags__item">#リフレッシュ</li></ul>
      </div>
      <div class="office-split__photo office-photo"><img src="<?php echo ni_img( 'office/lounge_main.jpg' ); ?>" alt="ラウンジスペース" width="1020" height="680" loading="lazy"></div>
    </div>
    <div class="office-lounge__subs">
      <div class="office-photo office-lounge__sub office-lounge__sub--1"><img src="<?php echo ni_img( 'office/lounge_sub_01.jpg' ); ?>" alt="" width="744" height="495" loading="lazy"></div>
      <div class="office-photo office-lounge__sub office-lounge__sub--2"><img src="<?php echo ni_img( 'office/lounge_sub_02.jpg' ); ?>" alt="" width="424" height="282" loading="lazy"></div>
      <div class="office-photo office-lounge__sub office-lounge__sub--3"><img src="<?php echo ni_img( 'office/lounge_sub_03.jpg' ); ?>" alt="" width="552" height="369" loading="lazy"></div>
    </div>
  </section>

  <!-- ===== Work Space（562:15383 / SP 1140:15292） ===== -->
  <section class="lower-sec office-sec office-work">
    <div class="office-work__col">
      <div class="sec-head sec-head--sub">
          <p class="sec-head__label u-grd-text">Work Space</p>
          <h2 class="sec-head__title sec-head__title--cap"><span>今日の仕事に合わせて、<br class="u-pc">居場所を選ぶ。</span></h2>
        </div>
      <div class="office-item">
        <div class="office-item__photo"><img src="<?php echo ni_img( 'office/workspace_01.jpg' ); ?>" alt="フリーアドレスの執務スペース" width="683" height="455" loading="lazy"></div>
        <h3 class="office-item__title">フリーアドレス執務スペース</h3>
        <p class="office-item__body">座席を固定しないフリーアドレス制。チームの垣根を超えて自由に席を選べるため、普段話さない人との偶然の会話が生まれます。大きな窓から自然光が入る明るい空間で、集中と交流を両立できます。</p>
      </div>
    </div>
    <div class="office-work__col">
      <div class="office-item">
        <div class="office-item__photo"><img src="<?php echo ni_img( 'office/workspace_02.jpg' ); ?>" alt="集中スペース" width="790" height="527" loading="lazy"></div>
        <h3 class="office-item__title">集中スペース</h3>
        <p class="office-item__body">執務スペースの奥に佇む、独立した集中スペース。人の往来が気にならない設計のため、データの深い分析や報告書の作成など、1つの業務に深く没頭したい日に最適な空間です。</p>
      </div>
    </div>
  </section>

  <!-- ===== In-house Library（562:15478 / SP 1140:15297）: PC は写真が右端まで ===== -->
  <section class="office-sec office-sec--flat office-library">
    <div class="office-library__txt">
      <div class="sec-head sec-head--sub">
          <p class="sec-head__label u-grd-text">In-house Library</p>
          <h2 class="sec-head__title sec-head__title--cap"><span>リサーチャーとして、<br class="u-pc">もっと深く学ぶ</span></h2>
        </div>
      <p class="office-text">マーケティング・統計学・消費者行動・UX・データサイエンス……。リサーチャーとして成長するための専門書が、社内に充実しています。自由に借り出して、昼休みに読んだり、持ち帰って自己学習したり。読書を習慣にしやすい環境がここにあります。</p>
      <ul class="office-tags"><li class="office-tags__item">#マーケティング</li><li class="office-tags__item">#統計学・データ分析</li><li class="office-tags__item">#消費者心理</li><li class="office-tags__item">#ビジネス書</li><li class="office-tags__item">#自由に貸し出しOK</li></ul>
    </div>
    <div class="office-library__photo office-photo"><img src="<?php echo ni_img( 'office/library.jpg' ); ?>" alt="社内ライブラリー" width="1600" height="1067" loading="lazy"></div>
  </section>

  <!-- ===== Snack Station（562:15539 / SP 1140:15310） ===== -->
  <section class="lower-sec office-sec office-sec--flat office-snack">
    <div class="office-snack__photos">
      <div class="office-photo office-snack__photo office-snack__photo--1"><img src="<?php echo ni_img( 'office/snack_01.jpg' ); ?>" alt="スナックステーション" width="840" height="560" loading="lazy"></div>
      <div class="office-photo office-snack__photo office-snack__photo--2"><img src="<?php echo ni_img( 'office/snack_02.jpg' ); ?>" alt="" width="224" height="336" loading="lazy"></div>
    </div>
    <div class="office-snack__txt">
      <div class="sec-head sec-head--sub">
          <p class="sec-head__label u-grd-text">Snack Station</p>
          <h2 class="sec-head__title sec-head__title--cap"><span>体にいいものを、<br class="u-pc">毎日無料で。</span></h2>
        </div>
      <p class="office-text">日本インフォメーションのラウンジには、スナックミーオフィスのスナックが毎日無料で用意されています。人工甘味料・保存料・合成着色料不使用のこだわりのスナックを、自由に手に取ることができます。<br>仕事の合間のリフレッシュタイムに、気になる人に「一緒にどうですか？」と声をかける——そんな小さなコミュニケーションも、ここから始まっています。</p>
      <div class="office-note">
        <div class="office-note__txt">
          <p class="office-note__title">スナックミーとは？</p>
          <p class="office-note__body">体にやさしい素材にこだわったスナックを提供するサービス。オフィスに導入されており、社員が無料でいつでも利用できます。</p>
        </div>
        <img class="office-note__icon" src="<?php echo ni_img( 'office/icon_snack.svg' ); ?>" alt="" width="50" height="43">
      </div>
    </div>
  </section>

  <!-- ===== Meeting Space（562:15583 / SP 1140:15328） ===== -->
  <section class="lower-sec office-sec office-meeting">
    <div class="sec-head sec-head--sub">
          <p class="sec-head__label u-grd-text">Meeting Space</p>
          <h2 class="sec-head__title sec-head__title--cap"><span>目的に合わせて選べる、複数の会議室。</span></h2>
        </div>
    <div class="office-meeting__list">
      <div class="office-item">
        <div class="office-item__photo"><img src="<?php echo ni_img( 'office/meeting_01.jpg' ); ?>" alt="オンラインMTG用ブース" width="779" height="519" loading="lazy"></div>
        <h3 class="office-item__title">オンラインMTG用ブース</h3>
        <p class="office-item__body">1on1や少人数の打ち合わせに。オープンラウンジより集中したいときに活用します。</p>
      </div>
      <div class="office-item">
        <div class="office-item__photo"><img src="<?php echo ni_img( 'office/meeting_02.jpg' ); ?>" alt="小会議室" width="779" height="519" loading="lazy"></div>
        <h3 class="office-item__title">小会議室</h3>
        <p class="office-item__body">部署内ミーティングや社外クライアントとのオンライン打ち合わせに使いやすい標準サイズ。</p>
      </div>
      <div class="office-item">
        <div class="office-item__photo"><img src="<?php echo ni_img( 'office/meeting_03.jpg' ); ?>" alt="中会議室" width="746" height="498" loading="lazy"></div>
        <h3 class="office-item__title">中会議室</h3>
        <p class="office-item__body">全部署ミーティングや研修・セミナーに対応できる大型スペース。プロジェクター完備。</p>
      </div>
    </div>
  </section>

  <!-- ===== Branch Office（562:15703 / SP 1140:15334）: 写真は右端まで ===== -->
  <section class="office-sec office-sec--flat office-branch">
    <div class="office-branch__txt">
      <div class="sec-head sec-head--sub">
          <p class="sec-head__label u-grd-text">Branch Office</p>
          <h2 class="sec-head__title sec-head__title--cap"><span>大阪営業所</span></h2>
        </div>
      <p class="office-text">2024年に開設した大阪営業所。関西エリアのクライアント対応を中心に、東京本社と連携して業務を行っています。大阪勤務希望の方も、ぜひご相談ください。</p>
      <dl class="office-data">
        <div class="office-data__row"><dt>所在地</dt><dd>大阪市中央区西心斎橋</dd></div>
        <div class="office-data__row"><dt>規　模</dt><dd>少人数チーム体制</dd></div>
        <div class="office-data__row"><dt>勤　務</dt><dd>在宅・リモートオフィス併用可</dd></div>
      </dl>
    </div>
    <div class="office-branch__photo office-photo"><img src="<?php echo ni_img( 'office/osaka_main.jpg' ); ?>" alt="大阪営業所" width="702" height="468" loading="lazy"></div>
    <div class="office-branch__subs">
      <div class="office-photo office-branch__sub office-branch__sub--1"><img src="<?php echo ni_img( 'office/osaka_sub_01.jpg' ); ?>" alt="" width="739" height="494" loading="lazy"></div>
      <div class="office-photo office-branch__sub office-branch__sub--2"><img src="<?php echo ni_img( 'office/osaka_sub_02.jpg' ); ?>" alt="" width="424" height="282" loading="lazy"></div>
    </div>
  </section>

</main>
<?php
get_footer();
