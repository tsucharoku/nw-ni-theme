<?php
/**
 * 業界の未来（固定ページ /future/）
 *
 * Figma（PC 515:6722 / SP 1137:10918）から起こした静的なページ。中身は固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => '業界の未来｜日本インフォメーション株式会社 採用情報サイト',
		'description' => 'AIで「点」を繋ぎ、リアルで「五感」を捉える、次世代のマーケティングリサーチ。業界の現在地、AIがもたらす時代の変曲点、AIとオフライン調査を組み合わせる日本インフォメーションのポジションをご紹介します。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- ===== Hero（515:6727 / SP 1140:13579）: パンくず + 見出し + リード + 点と線の立体 + 流れる英字 =====
       ほかの下層と違い、英字タイトルの .page-head__txt は無い（Figma の H2 部品はパンくずだけ）。
       立体は Figma の付箋 1370:17380 の参考（https://ni-future.pages.dev/ = デモ/NI_CRYSTAL.html）を WebGL で動かす（future-crystal.js が
       この枠に canvas を足す）。<img> はその 1 コマで、WebGL が動かない環境・動き抑制・?nowebgl の代替（動くときは <html> の is-future-crystal で隠す） -->
  <div class="future-hero">
    <div class="future-hero__inner">
      <div class="future-hero__obj" aria-hidden="true"><img src="<?php echo ni_img( 'future/hero_object.jpg' ); ?>" alt="" width="758" height="790"></div>
      <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
      <div class="page-head" id="js-fv">
        <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">業界の未来</li></ol></nav>
      </div>
      <div class="future-hero__body">
        <h1 class="future-hero__title u-grd-text">AIで「点」を繋ぎ、リアルで「五感」を捉える、<br class="u-pc">次世代のマーケティングリサーチ。</h1>
        <p class="future-hero__text">マーケティングリサーチの現場では、アンケートの回答データに加えて、WEBサイトの閲覧履歴や購買履歴、行動ログ、SNS上の口コミ、POSデータといったデータまで、これまでより早く・大量に集まるようになりました。ただ、数字やテキストの羅列を眺めているだけでは、人の心を動かすヒット商品につながるヒントは見えてきません。私たち日本インフォメーションは、AI技術と、創業以来現場で培ってきたオフライン調査を組み合わせ、効率化の先にある「本当の人間理解」に取り組んでいます。</p>
      </div>
    </div>
    <p class="future__marquee future-hero__marquee" aria-hidden="true" data-anim="marquee"><span>Connect the Dots. Capture the Senses.</span><span>The Future of the Industry</span><span>Industry Future</span></p>
  </div>

  <!-- ===== Chapter 01 業界の現在地（522:8072 / SP 1140:13588）: 光と影のカード ===== -->
  <section class="future-sec future-sec--now">
    <div class="lower-sec future-sec__inner">
      <div class="future-chapter">
        <p class="future-chapter__no"><span class="future-chapter__label u-grd-text">Chapter</span><span class="future-chapter__num u-grd-text">01</span></p>
        <span class="future-chapter__line"></span>
        <p class="future-chapter__name">業界の現在地</p>
      </div>
      <div class="future-now">
        <div class="sec-head sec-head--sub future-now__head">
          <h2 class="sec-head__title sec-head__title--cap"><span>デジタルシフトの<br class="u-pc">光と影</span></h2>
          <p class="sec-head__read">画面に並ぶ数字だけを追いかけていても、ヒット商品につながるヒントは見えてきません。</p>
        </div>
        <div class="future-now__cards">
          <div class="future-side future-side--light">
            <div class="future-side__bg"><img src="<?php echo ni_img( 'future/card_light.jpg' ); ?>" alt="" width="1024" height="683" loading="lazy"></div>
            <p class="future-side__mark"><span class="future-side__kanji">光</span><span class="future-side__en">LIGHT SIDE</span></p>
            <h3 class="future-side__title">インターネットリサーチとビッグデータがもたらした変化</h3>
            <p class="future-side__text">インターネットリサーチの普及とビッグデータ活用により、多くの人を対象にしたアンケートデータを、以前より短い期間と少ない費用で集められるようになりました。マーケティングリサーチの現場でも、データ収集や集計の効率化が着実に進んでいます。</p>
          </div>
          <div class="future-side future-side--shadow">
            <div class="future-side__bg"><img src="<?php echo ni_img( 'future/card_shadow.jpg' ); ?>" alt="" width="1024" height="683" loading="lazy"></div>
            <p class="future-side__mark"><span class="future-side__kanji">影</span><span class="future-side__en">SHADOW SIDE</span></p>
            <h3 class="future-side__title">データから見えにくくなっているもの</h3>
            <p class="future-side__text">整理されたグラフや数値からは、購買という「結果」は見えても、消費者がその商品を選んだ理由や、言葉にならない感情までは読み取りにくいのが実情です。綺麗に整理されたデータや示唆ほど説得力を持ってしまうからこそ、意思決定者がその数字だけを鵜呑みにし、実態とズレた判断につながってしまうリスクも、業界の課題として指摘されています。</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== Chapter 02 時代の変曲点（522:8078 / SP 1140:13615）: OLD ERA → NEW ERA の帯 + カッコの引用 + 手書きの Insight ===== -->
  <section class="future-sec future-sec--turn">
    <div class="future-squares future-squares--flip" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div>
    <div class="lower-sec future-sec__inner">
      <div class="future-chapter">
        <p class="future-chapter__no"><span class="future-chapter__label u-grd-text">Chapter</span><span class="future-chapter__num u-grd-text">02</span></p>
        <span class="future-chapter__line"></span>
        <p class="future-chapter__name">時代の変曲点</p>
      </div>
      <div class="future-turn__intro">
        <div class="sec-head sec-head--sub future-turn__head">
          <h2 class="sec-head__title sec-head__title--cap"><span>AIの台頭が告げる<br class="u-pc">新時代の到来</span></h2>
          <p class="sec-head__read"><span>「集計」はAIへ。人間は、<br class="u-pc">意思決定を動かす「洞察」へ。</span></p>
        </div>
        <p class="future-turn__text">アンケートの単純集計や定型レポートの作成といった従来の作業は、AIの進化によって自動化が進んでいます。近年では、購買データや行動ログをもとにAIが疑似的な生活者像を再現する「AIペルソナ」や、特定個人をデータ上に再現する「AIデジタルツイン」といった技術も登場し、マーケティングリサーチのあり方は大きな転換期を迎えています。</p>
      </div>
      <div class="future-era">
        <p class="future-era__item future-era__item--old"><span class="future-era__label">OLD ERA</span><span class="future-era__txt">データそのものを「人間が作る」時代</span></p>
        <p class="future-era__item future-era__item--new"><span class="future-era__label">NEW ERA</span><span class="future-era__txt u-grd-text">「AIが瞬時に生成・予測する」時代</span></p>
      </div>
      <div class="future-quote bracket">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <p class="future-quote__lead u-grd-text">どれほど精巧なデジタルペルソナであっても、人が示す予期せぬ反応や、言葉にしにくい感情までを再現することは容易ではありません。</p>
        <p class="future-quote__text">だからこそ、マーケティングリサーチの価値は「データを集める・生成する」ことだけでなく、AIによる分析と人間のリアルな反応を組み合わせ、意思決定に役立つ洞察を導き出すことに移ってきています。</p>
      </div>
      <p class="future-turn__closing">AIが定型的な作業や予測を担ってくれることで、リサーチャーは「何を明らかにすべきか」という問いの設計や、仮説の検証により時間を使えるようになります。</p>
    </div>
    <div class="future-insight" aria-hidden="true">
      <img class="u-pc" src="<?php echo ni_img( 'future/insight.svg' ); ?>" alt="" width="787" height="344" loading="lazy">
      <img class="u-sp" src="<?php echo ni_img( 'future/insight_sp.svg' ); ?>" alt="" width="400" height="181" loading="lazy">
    </div>
  </section>

  <!-- ===== Chapter 03 当社のポジション（522:8224 / SP 1140:13663）: Real Domain × AI Domain ===== -->
  <section class="future-sec future-sec--position">
    <div class="lower-sec future-sec__inner">
      <div class="future-chapter">
        <p class="future-chapter__no"><span class="future-chapter__label u-grd-text">Chapter</span><span class="future-chapter__num u-grd-text">03</span></p>
        <span class="future-chapter__line"></span>
        <p class="future-chapter__name">当社のポジション</p>
      </div>
      <div class="sec-head sec-head--sub future-position__head">
        <h2 class="sec-head__title sec-head__title--cap"><span>AIとオフライン調査の「共存」</span></h2>
        <p class="sec-head__read">AIのロジックと、五感から読み解くリアルな声。その交差点にこそ、未開のインサイトがある。</p>
      </div>
      <div class="future-position">
        <div class="future-domains">
          <div class="future-domain future-domain--real">
            <h3 class="future-domain__head"><span class="future-domain__en u-grd-text">Real Domain</span><span class="future-domain__title">深さと生きた感覚</span></h3>
            <p class="future-domain__text">会場調査(CLT)やホームユーステスト(HUT)、グループインタビューといったリアルな調査を通じて、画面越しでは把握しづらい、生活者の味覚・触覚・直感的な印象といった感覚的な情報を、丁寧に収集・分析します。</p>
            <ul class="future-tags"><li class="future-tags__item">会場調査(CLT)</li><li class="future-tags__item">ホームユーステスト(HUT)</li><li class="future-tags__item">グループインタビュー</li><li class="future-tags__item">味覚・触覚・直感的印象の収集</li></ul>
          </div>
          <div class="future-domain future-domain--ai">
            <h3 class="future-domain__head"><span class="future-domain__en u-grd-text">AI Domain</span><span class="future-domain__title">網羅性とスピード</span></h3>
            <p class="future-domain__text">AIチャットインタビューやAIによる動画・画像解析を活用し、膨大な量の定性データからトレンドの兆候や潜在的な課題を抽出・整理します。人の手だけでは時間のかかっていた定性データの集計・構造化を、スピーディかつ網羅的に行うことができます。</p>
            <ul class="future-tags"><li class="future-tags__item">AIチャットインタビュー</li><li class="future-tags__item">AIデータ分析</li><li class="future-tags__item">定性データの自動構造化</li></ul>
          </div>
        </div>
        <div class="future-position__cross" aria-hidden="true">
          <img class="u-pc" src="<?php echo ni_img( 'future/cross.svg' ); ?>" alt="" width="78" height="77" loading="lazy">
          <img class="u-sp" src="<?php echo ni_img( 'future/cross_sp.svg' ); ?>" alt="" width="50" height="50" loading="lazy">
        </div>
        <p class="future-position__summary">AIによるスピードと網羅性、そして人間のリアルな体験から得られる示唆。<br>その両方を組み合わせることが、クライアントの「次の一手」につながる判断材料を提供することにつながります。<br>それこそが、私たちの果たすべき役割だと考えています。</p>
      </div>
    </div>
  </section>

  <!-- ===== Message to You（522:8269 / SP 1140:13697）: 流れる英字 + カッコの枠 + 青いカード 2 枚 ===== -->
  <section class="future-message">
    <p class="future__marquee future-message__marquee" aria-hidden="true" data-anim="marquee"><span>Connect the Dots. Capture the Senses.</span></p>
    <div class="future-squares" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div>
    <div class="lower-sec future-message__inner">
      <div class="future-message__box bracket">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <div class="future-message__head">
          <p class="future-message__label u-grd-text">Message to You</p>
          <h2 class="future-message__title">データの力も、人の言葉も。<br>両方から読み解くマーケティングリサーチへ。</h2>
        </div>
        <div class="future-message__cards">
          <div class="future-note">
            <h3 class="future-note__label">ABOUT US</h3>
            <p class="future-note__text">私たちが大切にしているのは、これまでのやり方に固執することでも、新しい技術をただ追いかけることでもありません。「人間の本音を解き明かす」というマーケティングリサーチ本来の目的のために、AIという手段を柔軟に取り入れながら、一つひとつの調査を丁寧に積み重ねています。</p>
          </div>
          <div class="future-note">
            <h3 class="future-note__label">YOUR ROLE</h3>
            <p class="future-note__text">AIに限らず、新しい技術を臆せず使いこなす姿勢と、現場で生活者の声を丁寧に汲み取る観察眼。その両方を大切にするリサーチャーとして、入社年数やキャリアに関係なく、早い段階からクライアントの案件に主体的に携わり、実務経験を積みながら着実に成長できる環境があります。</p>
          </div>
        </div>
        <p class="future-message__closing">既存の強みに満足することなく、新しい手法を柔軟に取り入れながら進化を続ける——<br>そんな環境で、私たちと一緒にマーケティングリサーチの仕事に取り組んでいきませんか。</p>
      </div>
    </div>
  </section>

</main>
<?php
get_footer();
