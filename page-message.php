<?php
/**
 * メッセージ（固定ページ /message/）
 *
 * Figma: PC 507:8512（Container 507:8515）/ SP 1137:10917（Container 1140:13193）。
 * <main> の中身は固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => 'メッセージ｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '私たちはどんな会社で、何を大切にしているのか。日本インフォメーションの事業・カルチャー・代表メッセージ・求める人物像をご紹介します。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">メッセージ</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">Message</p>
      <h1 class="page-head__jp">メッセージ</h1>
    </div>
    <p class="page-head__read">私たちはどんな会社で、何を大切にしているのか。事業・カルチャー・求める人物像をご紹介します。</p>
  </div>

  <!-- ===== Intro（512:9301 / SP 1140:13195）: 写真（左端から）+ リード ===== -->
  <section class="msg-intro">
    <div class="msg-intro__photo"><div class="msg-photo msg-photo--intro-main"><img src="<?php echo ni_img( 'message/intro_main.jpg' ); ?>" alt="日本インフォメーションのエントランス" width="1475" height="1170"></div></div>
    <div class="msg-intro__txt">
      <h2 class="msg-intro__title">ビジネスが動き出す、<br class="u-pc">「インサイト」を掴む。</h2>
      <p class="msg-intro__text">「インサイト」とは、生活者自身も気づいていない購買行動の動機や、隠れたニーズのこと。私たちはマーケットリサーチを通じて、言葉だけでなく、見た目や香り、味、使い心地などの五感を通した反応にも目を向け、その奥に潜む「インサイト」を見つけ出します。そうして得られた生活者への深い理解は、マーケティングの確かな根拠となります。私たちはクライアントに伴走するマーケティングパートナーとして、商品開発やリニューアル、ブランディング、経営戦略など、ビジネスを動かすさまざまな意思決定を支えます。</p>
      <div class="msg-photo msg-photo--intro-sub"><img src="<?php echo ni_img( 'message/intro_sub.jpg' ); ?>" alt="執務スペース" width="544" height="361" loading="lazy"></div>
    </div>
  </section>

  <!-- ===== Our Culture（507:8581 / SP 1140:13207）: 見出し + カッコの枠（大きい見出し・写真つきの 4 項目）。背景に飾りの四角 ===== -->
  <section class="lower-sec msg-culture">
    <div class="msg-culture__squares" aria-hidden="true">
      <span class="msg-culture__sq msg-culture__sq--1"></span>
      <span class="msg-culture__sq msg-culture__sq--2"></span>
      <span class="msg-culture__sq msg-culture__sq--3"></span>
      <span class="msg-culture__sq msg-culture__sq--4"></span>
      <span class="msg-culture__sq msg-culture__sq--5"></span>
      <span class="msg-culture__sq msg-culture__sq--6"></span>
      <span class="msg-culture__sq msg-culture__sq--7"></span>
      <span class="msg-culture__sq msg-culture__sq--8"></span>
      <span class="msg-culture__sq msg-culture__sq--9"></span>
    </div>
    <div class="msg-head">
      <p class="msg-label"><span class="msg-label__en u-grd-text">OUR CULTURE</span><span class="msg-label__jp">働く環境・価値観</span></p>
      <div class="sec-head sec-head--sub">
        <div class="sec-head__body">
          <h2 class="sec-head__title sec-head__title--cap">日本インフォメーションで働くってどんな感じ？</h2>
          <p class="sec-head__read">肩書きより「おもしろい」を大切にする、日本インフォメーションの文化をお伝えします。</p>
        </div>
      </div>
    </div>
    <div class="msg-culture__box bracket">
      <span class="bracket__corner bracket__corner--tl"></span>
      <span class="bracket__corner bracket__corner--tr"></span>
      <span class="bracket__corner bracket__corner--bl"></span>
      <span class="bracket__corner bracket__corner--br"></span>
      <h3 class="msg-culture__title u-grd-text">リサーチの先にある<br class="u-sp">ビジネス成果まで、<br>見届けられるやりがい</h3>
      <p class="msg-culture__text">幅広い業界のクライアントと課題に向き合い、成果まで見届けられる醍醐味があります。その過程では、ひとりひとりの専門性を磨くことができます。</p>
      <ul class="msg-culture__list">
        <li class="msg-item">
          <div class="msg-photo msg-photo--culture-1"><img src="<?php echo ni_img( 'message/culture_01.jpg' ); ?>" alt="" width="646" height="304" loading="lazy"></div>
          <div class="msg-item__txt">
            <h4 class="msg-item__title">ヒットにつながる開発の道筋を示すため、生活者からリアルなデータを収集。</h4>
            <p class="msg-item__body">関わった新商品・サービスが実際に発売となったときには、大きな達成感を得られます。</p>
          </div>
        </li>
        <li class="msg-item">
          <div class="msg-photo msg-photo--culture-2"><img src="<?php echo ni_img( 'message/culture_02.jpg' ); ?>" alt="" width="685" height="329" loading="lazy"></div>
          <div class="msg-item__txt">
            <h4 class="msg-item__title">リニューアルの成果を、クライアントと喜び合える</h4>
            <p class="msg-item__body">課題解決に向けてリサーチし商品・サービスをリニューアル。「売り上げがV字回復した」「顧客満足度が向上」などのフィードバックに、手応えを感じられます。</p>
          </div>
        </li>
        <li class="msg-item">
          <div class="msg-photo msg-photo--culture-3"><img src="<?php echo ni_img( 'message/culture_03.jpg' ); ?>" alt="" width="646" height="305" loading="lazy"></div>
          <div class="msg-item__txt">
            <h4 class="msg-item__title">各分野のプロフェッショナルへと成長</h4>
            <p class="msg-item__body">企画設計やインタビュー、アンケート、分析など、それぞれの領域で専門性を発揮。心理学や行動経済学、統計学など幅広い知識や手法を活かして向き合います。</p>
          </div>
        </li>
        <li class="msg-item">
          <div class="msg-photo msg-photo--culture-4"><img src="<?php echo ni_img( 'message/culture_04.jpg' ); ?>" alt="" width="622" height="307" loading="lazy"></div>
          <div class="msg-item__txt">
            <h4 class="msg-item__title">創業50年超のノウハウと最新技術で、付加価値を高める</h4>
            <p class="msg-item__body">対面でのインタビューなど、一見アナログに見えるリサーチでも、その裏側ではAIやDXを活用。業務を効率化しながら、より付加価値の高い情報を提供します。</p>
          </div>
        </li>
      </ul>
    </div>
  </section>

  <!-- ===== 写真の帯（515:5924 / SP 1140:13254）: 写真 + 紺のベール + 流れる英字（components.css の .future__marquee。複製と横流れは common.js） ===== -->
  <div class="msg-band">
    <img class="msg-band__img" src="<?php echo ni_img( 'message/band.jpg' ); ?>" alt="" width="2200" height="1271" loading="lazy">
    <p class="future__marquee" aria-hidden="true"><span>Working at Japan Information</span><span>Working at Japan Information</span></p>
  </div>

  <!-- ===== President's Message（515:5581 / SP 1140:13259）: カッコの枠の中に見出し + 本文 + 写真 ===== -->
  <section class="lower-sec msg-president">
    <div class="msg-president__box bracket">
      <span class="bracket__corner bracket__corner--tl"></span>
      <span class="bracket__corner bracket__corner--tr"></span>
      <span class="bracket__corner bracket__corner--bl"></span>
      <span class="bracket__corner bracket__corner--br"></span>
      <div class="msg-president__head">
        <p class="msg-label"><span class="msg-label__en u-grd-text">President's Message</span><span class="msg-label__jp">代表メッセージ</span></p>
        <h2 class="msg-president__title">変化する事業環境にトライ。<br class="u-pc">第二創業期を共に創り、飛躍しましょう。</h2>
      </div>
      <div class="msg-president__body">
        <div class="msg-president__text">
          <p>現在、マーケティングを取り巻く環境は激しく変化しています。マーケティングリサーチ業界でも、勝ち負けがはっきりとし、変化に対応できない企業が生き残るのは難しくなってきています。</p>
          <p>従来の仕事のスタイルや成功体験は、瞬く間に陳腐化するため、新たな潮流に合わせたリサーチの開発が求められています。</p>
          <p>日本インフォメーションは、この環境下で時代の変化を捉え、既存のリサーチエージェンシーの枠に留まらず最新のIT技術を持つパートナーとオープンイノベーションを推進しています。クライアント企業の意思決定に役立つConsumer insightsのご提供を実現し続けるべく、様々なチャレンジに取り組んでいます。</p>
          <p>一生マーケティングに関わる仕事がしたい<br>マーケティングリサーチの専門性を身に着けたい<br>変化に柔軟に対応し自分を成長させたい</p>
          <p>そんな想いに応えられる働く場、仕事がここにはあります。<br>第二創業期といえる状況を迎えた弊社で、ともにさらなる飛躍を目指しましょう。</p>
          <p>代表取締役社長　斎藤啓太</p>
        </div>
        <div class="msg-photo msg-photo--president"><img src="<?php echo ni_img( 'message/president.jpg' ); ?>" alt="代表取締役社長 斎藤啓太" width="1440" height="1054" loading="lazy"></div>
      </div>
    </div>
  </section>

  <!-- ===== Ideal Person（507:8531 / SP 1140:13276）: 見出し + 吹き出しの枠つきの 3 項目 ===== -->
  <section class="lower-sec msg-ideal">
    <div class="msg-head">
      <p class="msg-label"><span class="msg-label__en u-grd-text">Ideal Person</span><span class="msg-label__jp">求める人物像</span></p>
      <div class="sec-head sec-head--sub">
        <div class="sec-head__body">
          <h2 class="sec-head__title sec-head__title--cap">こんな人と、一緒に働きたい。</h2>
          <p class="sec-head__read">スキルより姿勢。日本インフォメーションが大切にしている「人」の基準を3つの言葉で表しました。</p>
        </div>
      </div>
    </div>
    <ul class="msg-ideal__list">
      <li class="msg-item">
        <ul class="msg-words"><li><span>柔軟性</span></li><li><span>学習意欲</span></li><li><span>挑戦心</span></li></ul>
        <div class="msg-item__txt">
          <h3 class="msg-item__title">時代に合わせて、<br class="u-sp">自分をアップデートできる人</h3>
          <p class="msg-item__body">リサーチ業界では、手法も常識も時代とともに変化していきます。変化を前向きに受け止め、新しい知識や技術を柔軟に取り入れながら、自分自身をアップデートし続けられる方が活躍しています。</p>
        </div>
      </li>
      <li class="msg-item">
        <ul class="msg-words"><li class="msg-words__s"><span>コミュニ<br>ケーション</span></li><li class="msg-words__m"><span>共感力</span></li><li class="msg-words__s"><span>チーム<br>ワーク</span></li></ul>
        <div class="msg-item__txt">
          <h3 class="msg-item__title">互いに手を差し伸べ、<br class="u-sp">チームで期待に応えられる人</h3>
          <p class="msg-item__body">誰かが困っていたら自然と手を差し伸べられるような、気持ちの良いチームワークを大切にしています。一人で仕事を完結させるのではなく、部署を超えて互いの専門性を活かし、ときにはクライアントとも手を取り合いながら力を合わせます。</p>
        </div>
      </li>
      <li class="msg-item">
        <ul class="msg-words"><li><span>好奇心</span></li><li><span>探究心</span></li><li><span>共感力</span></li></ul>
        <div class="msg-item__txt">
          <h3 class="msg-item__title">相手の立場に立って、ゴールまで考え抜く人</h3>
          <p class="msg-item__body">リサーチ対象者は、自分とは年齢も価値観も生活環境も異なる方々かもしれません。だからこそ、相手の立場になって考えることが重要です。見据えたゴールに向かって、常により良い方向へと考え抜く方が活躍しています。</p>
        </div>
      </li>
    </ul>
  </section>

</main>
<?php
get_footer();
