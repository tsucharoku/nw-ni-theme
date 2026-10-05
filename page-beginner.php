<?php
/**
 * 新卒・中途（リサーチ未経験者）向け TOP（固定ページ /beginner/）
 *
 * 静的 HTML（HTML/beginner/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => '新卒・中途（リサーチ未経験者）採用情報｜日本インフォメーション株式会社 採用情報サイト',
		'description' => 'ヒット商品の裏側に、いつも私たちのInsightがある。日本インフォメーション株式会社の新卒・中途（リサーチ未経験者）向け採用情報。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Hero（FV） -->
  <section class="hero" id="js-fv" data-anim="fv">
    <div class="hero__stage">
      <img class="hero__photo hero__photo--1" src="<?php echo ni_img( 'beginner/hero_photo_01.jpg' ); ?>" alt="" width="196" height="242">
      <img class="hero__photo hero__photo--2" src="<?php echo ni_img( 'beginner/hero_photo_02.jpg' ); ?>" alt="" width="104" height="129">
      <img class="hero__photo hero__photo--3" src="<?php echo ni_img( 'beginner/hero_photo_03.jpg' ); ?>" alt="" width="104" height="129">
      <img class="hero__photo hero__photo--4" src="<?php echo ni_img( 'beginner/hero_photo_04.jpg' ); ?>" alt="" width="108" height="134">
      <h1 class="hero__copy" data-anim="draw">
        <img class="u-pc" src="<?php echo ni_img( 'beginner/hero_txt.svg' ); ?>" alt="ヒット商品の裏側に いつも私たちの Insight（インサイト）がある。" width="902" height="387">
        <img class="u-sp" src="<?php echo ni_img( 'beginner/hero_txt_sp.svg' ); ?>" alt="ヒット商品の裏側に いつも私たちの Insight（インサイト）がある。" width="375" height="387">
      </h1>
    </div>
  </section>

  <!-- FV は画面固定（demo準拠）。スクロール量の基準として demo と同じ 220vh の余白を置く -->
  <div class="hero-spacer" data-fv-scroll aria-hidden="true"></div>

  <!-- Message -->
  <!-- Message: demo と同じく画面固定で JS が動かす（fv-message.js）。フローの高さは持たない（SP はフローモード）。
       data-logo-dock: SP では画面固定のロゴが、この Message 上の定位置（Figma 470:2697 の Frame 2299）まで来たら乗り換えて
       Have Fun! と一緒に上へ抜ける（ni-logo.js の P.spDock。2026-09-17 指示。PC は変えない） -->
  <section class="message message--fixed" data-anim="havefun" data-logo-dock>
    <p class="message__havefun u-en" aria-hidden="true">Have
     Fun!</p>
    <div class="message__body">
      <div class="message__head">
        <p class="message__label">Message</p>
        <h2 class="message__title">楽しんで働ける場を創る。</h2>
      </div>
      <p class="message__text">各人の仕事に対する考え方や姿勢は様々。<br class="u-pc">当社は多様な価値観、バックボーンを持つ人材が集まり、<br class="u-pc">それぞれが楽しみ尊重しあいながら仕事をしている<br class="u-pc">職場づくりを目指したい。<br>そんな想いで「Have fun！」を掲げ、<br class="u-pc">様々な働き方に関する取り組みを実施しています。</p>
      <a class="btn btn--w" href="#">メッセージ<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
    </div>
  </section>

  <!-- About -->
  <!-- About: demo 準拠。1 画面に固定（sticky）し、縦バーのモザイクで開示 → 次のセクションが同じモザイクで覆って抜ける（fv-about.js） -->
  <div class="about-pin">
  <section class="about">
    <div class="about__bg" aria-hidden="true"><img src="<?php echo ni_img( 'common/about_skyline_blend.png' ); ?>" alt="" width="1408" height="768"></div>
    <div class="about__inner">
      <div class="about__content">
        <div class="sec-head sec-head--sub sec-head--white">
          <p class="sec-head__label">About Us</p>
          <div class="sec-head__body">
            <h2 class="sec-head__title">3分でわかる、<br>日本インフォメーション</h2>
          </div>
        </div>
        <p class="about__text">独立系マーケティングリサーチ専業として、食品・化粧品・金融・官公庁まで幅広い業界の意思決定を支えてきました。AIを活用した自社開発ツール、業界唯一の模擬店舗型実査施設（NI Shopper Lab.）、自社600万人超のパネルなど、経験者がさらに専門性を深められる環境があります。</p>
        <a class="btn btn--w" href="<?php echo ni_url( '/about/' ); ?>">日本インフォメーションについて知る<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
      </div>
      <div class="about__stats">
        <img class="about__deco-circle u-pc" src="<?php echo ni_img( 'common/about_deco_circle.svg' ); ?>" alt="" width="563" height="630" aria-hidden="true">
        <img class="about__deco-circle u-sp" src="<?php echo ni_img( 'common/about_deco_circle_sp.svg' ); ?>" alt="" width="290" height="290" aria-hidden="true">
        <img class="about__deco-dots u-pc" src="<?php echo ni_img( 'common/about_deco_union.svg' ); ?>" alt="" width="569" height="291" aria-hidden="true">
        <img class="about__deco-dots u-sp" src="<?php echo ni_img( 'common/about_deco_union_sp.svg' ); ?>" alt="" width="244" height="162" aria-hidden="true">
        <dl class="about__grid">
          <div class="stat">
            <img class="stat__icon" src="<?php echo ni_img( 'common/icon_stat_founded.svg' ); ?>" alt="" width="88" height="88">
            <div class="stat__body"><dt class="stat__label">創業</dt><dd class="stat__value"><span class="stat__num">1969</span><span class="stat__unit">年</span></dd></div>
          </div>
          <div class="stat">
            <img class="stat__icon" src="<?php echo ni_img( 'common/icon_stat_clients.svg' ); ?>" alt="" width="88" height="88">
            <div class="stat__body"><dt class="stat__label">取引社数</dt><dd class="stat__value"><?php ni_about_stat( 'company_clients_number' ); ?></dd></div>
          </div>
          <div class="stat">
            <img class="stat__icon" src="<?php echo ni_img( 'common/icon_stat_growth.svg' ); ?>" alt="" width="88" height="88">
            <div class="stat__body"><dt class="stat__label">業界成長率</dt><dd class="stat__value"><?php ni_about_stat( 'company_growth_top_number' ); ?></dd></div>
          </div>
          <div class="stat">
            <img class="stat__icon" src="<?php echo ni_img( 'common/icon_stat_satisfaction.svg' ); ?>" alt="" width="88" height="88">
            <div class="stat__body"><dt class="stat__label">顧客満足度</dt><dd class="stat__value"><?php ni_about_stat( 'company_satisfaction_number' ); ?></dd></div>
          </div>
        </dl>
      </div>
    </div>
  </section>
  </div>
  <!-- About より下: About を覆って抜ける間だけ画面固定（fv-about.js が .is-fixlock を付ける） -->
  <div class="after-about">

  <!-- Info（Recruit pitch / 適性診断バナー）※プレースホルダ -->
  <section class="info">
    <h2 class="u-visually-hidden">採用ピッチ・適性診断</h2>
    <div class="info__pitch">Recruit pitch</div>
    <a class="info__bnr" href="#">適性診断バナー</a>
  </section>

  <!-- Do -->
  <section class="do">
    <div class="do__box bracket" data-anim="bracket">
      <span class="bracket__corner bracket__corner--tl"></span>
      <span class="bracket__corner bracket__corner--tr"></span>
      <span class="bracket__corner bracket__corner--bl"></span>
      <span class="bracket__corner bracket__corner--br"></span>
      <div class="do__content">
        <div class="do__img"><img src="<?php echo ni_img( 'beginner/do_photo.jpg' ); ?>" alt="" width="562" height="374"></div>
        <div class="do__txt">
          <div class="sec-head sec-head--sub">
            <p class="sec-head__label u-grd-text">What You’ll Do</p>
            <div class="sec-head__body">
              <h2 class="sec-head__title">リサーチの仕事って、<br>実際どんなことをするの？</h2>
            </div>
          </div>
          <p class="do__text">リサーチ・ディレクターがクライアントの窓口を一本化し、インターネットリサーチ・フィールドワーク管理・データ集計・品質管理・新価値創造部など、専門性の異なる職種がひとつのチームで動く日本インフォメーションの仕事の全体像を、相関図でご覧ください。</p>
          <a class="btn btn--w" href="<?php echo ni_url( '/chart/' ); ?>">仕事の相関図を見る<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
        </div>
      </div>
    </div>
  </section>

  <!-- Project Story -->
  <section class="story">
    <h2 class="story__title u-en">Project<br>Story</h2>
    <div class="story__body">
      <p class="story__intro">NIが実際に手がけたプロジェクトを紹介します。<br>課題の背景から、調査設計・分析・提案まで。<br>データで社会や企業の「なぜ」に向き合う仕事のリアルをご覧ください。</p>
      <div class="splide story__slider" aria-label="Project Story">
      <div class="splide__track">
      <ul class="splide__list story__list">
        <li class="splide__slide story-card">
          <div class="story-card__visual">
            <a class="story-card__img" href="#"><img src="<?php echo ni_img( 'common/story_photo_01.jpg' ); ?>" alt="" width="680" height="383"></a>
            <span class="story-card__cap" aria-hidden="true"></span>
            <p class="story-card__label u-en">PROJECT<br>STORY</p>
            <div class="story-card__tags">
              <p class="story-card__client">消費財メーカー × ブランド定点調査</p>
              <p class="story-card__lead"><span>"なぜ売れなくなったのか"をデータで解き明かし</span><span>商品リニューアルに貢献。</span></p>
            </div>
          </div>
          <div class="story-card__foot">
            <div class="story-card__avatar u-pc"><img src="<?php echo ni_img( 'common/story_avatar_01.png' ); ?>" alt="" width="88" height="88"></div>
            <div class="story-card__info">
              <p class="story-card__summary"><span class="u-sp">"なぜ売れなくなったのか"をデータで解き明かし商品リニューアルに貢献。</span><span class="u-pc">リサーチの仕事は、数字の向こうに人がいる仕事。好奇心さえあれば、社会を動かすプロジェクトに携わることができます。</span></p>
              <p class="story-card__person"><span class="story-card__badge">新卒入社</span>リサーチャー Y.N.</p>
            </div>
          </div>
        </li>
        <li class="splide__slide story-card">
          <div class="story-card__visual">
            <a class="story-card__img" href="#"><img src="<?php echo ni_img( 'common/story_photo_01.jpg' ); ?>" alt="" width="680" height="383"></a>
            <span class="story-card__cap" aria-hidden="true"></span>
            <p class="story-card__label u-en">PROJECT<br>STORY</p>
            <div class="story-card__tags">
              <p class="story-card__client">消費財メーカー × ブランド定点調査</p>
              <p class="story-card__lead"><span>"なぜ売れなくなったのか"をデータで解き明かし</span><span>商品リニューアルに貢献。</span></p>
            </div>
          </div>
          <div class="story-card__foot">
            <div class="story-card__avatar u-pc"><img src="<?php echo ni_img( 'common/story_avatar_01.png' ); ?>" alt="" width="88" height="88"></div>
            <div class="story-card__info">
              <p class="story-card__summary"><span class="u-sp">"なぜ売れなくなったのか"をデータで解き明かし商品リニューアルに貢献。</span><span class="u-pc">リサーチの仕事は、数字の向こうに人がいる仕事。好奇心さえあれば、社会を動かすプロジェクトに携わることができます。</span></p>
              <p class="story-card__person"><span class="story-card__badge">新卒入社</span>リサーチャー Y.N.</p>
            </div>
          </div>
        </li>
      </ul>
      </div>
      </div>
      <div class="slider-nav story__nav">
        <button type="button" class="arrow-pill arrow-pill--prev" aria-label="前へ"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></button>
        <button type="button" class="arrow-pill" aria-label="次へ"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></button>
      </div>
    </div>
  </section>

  <!-- Future: demo 準拠の登場（fv-future.js）。四隅カッコが中央から広がり、中身がフェード、飾りの四角が浮遊 -->
  <section class="future">
    <div class="future__squares" aria-hidden="true">
      <span class="is-navy" style="left:80.7%;top:41.9%;width:69px;height:85px"></span>
      <span style="left:9.1%;top:27.5%;width:93px;height:114px;background:rgba(0,170,213,.67)"></span>
      <span style="left:86.5%;top:1.8%;width:120px;height:149px"></span>
      <span class="is-navy" style="left:1.2%;top:1.8%;width:72px;height:90px"></span>
      <span style="left:90.3%;top:57.9%;width:40px;height:40px;border-radius:3px"></span>
      <span class="is-navy" style="left:96.2%;top:51.3%;width:20px;height:20px;border-radius:3px"></span>
      <span style="left:78.7%;top:20.9%;width:19px;height:19px;border-radius:3px"></span>
      <span class="is-navy" style="left:23%;top:13.6%;width:40px;height:40px;border-radius:3px"></span>
      <span style="left:0.8%;top:69.2%;width:26px;height:26px;border-radius:3px"></span>
      <span class="is-navy" style="left:14.8%;top:61.4%;width:40px;height:40px;border-radius:3px"></span>
      <span style="left:22%;top:58.1%;width:20px;height:20px;border-radius:3px"></span>
    </div>
    <p class="future__marquee" aria-hidden="true" data-anim="marquee"><span>The Future of the Industry</span><span>The Future of the Industry</span><span>Industry Future</span></p>
    <div class="future__box bracket" data-anim="bracket">
      <span class="bracket__corner bracket__corner--tl"></span>
      <span class="bracket__corner bracket__corner--tr"></span>
      <span class="bracket__corner bracket__corner--bl"></span>
      <span class="bracket__corner bracket__corner--br"></span>
      <div class="future__content">
        <h2 class="future__title">
          <img class="u-pc" src="<?php echo ni_img( 'beginner/future_title_01.svg' ); ?>" alt="リサーチ業界の今と" width="369" height="64">
          <img class="u-pc" src="<?php echo ni_img( 'beginner/future_title_02.svg' ); ?>" alt="日本インフォメーションが描く未来" width="369" height="55">
          <img class="u-sp" src="<?php echo ni_img( 'beginner/future_title_01_sp.svg' ); ?>" alt="リサーチ業界の今と" width="248" height="43">
          <img class="u-sp" src="<?php echo ni_img( 'beginner/future_title_02_sp.svg' ); ?>" alt="日本インフォメーションが描く未来" width="248" height="37">
        </h2>
        <p class="future__sub">そんな疑問にお答えします</p>
        <p class="future__text">AI・データ分析が加速する時代だからこそ、「人の声を聞き、意味を読み解く」リサーチの価値は高まっています。<br>日本インフォメーションが描く、業界の未来をご覧ください。</p>
        <a class="btn btn--w" href="#">業界の未来を読む<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
      </div>
    </div>
  </section>

  <!-- Member's Voice -->
  <section class="voice">
    <!-- 背景の形: PC は Figma PC の Frame 1900（1763x1230）、SP は SP の Frame 1900（1103x700。形の描かれ方が違う） -->
    <picture>
      <source media="(min-width: 768px)" srcset="<?php echo ni_img( 'common/voice_bg_shape.svg' ); ?>" width="1763" height="1230">
      <img class="voice__bg" src="<?php echo ni_img( 'common/voice_bg_shape_sp.svg' ); ?>" alt="" width="1103" height="700" aria-hidden="true">
    </picture>
    <div class="sec-head sec-head--top voice__head">
      <h2 class="sec-head__en u-en">Member’s<br>Voice</h2>
      <div class="sec-head__body">
        <p class="sec-head__title sec-head__title--cap">社員インタビュー</p>
        <p class="sec-head__read">未経験から入社した先輩たちのリアルな声をお届けします。</p>
      </div>
    </div>
    <?php
    /* カードは固定ページの ACF「社員インタビュー（ピックアップ）」で選んだ記事（最大 3 件）。2 枚目は下にずらす（--offset）。
       未選択ならスライダーと矢印は出さない（見出しと「全ての記事をみる」だけ） */
    $ni_voice_ids = ni_voice_pickup();
    if ( $ni_voice_ids ) :
    ?>
    <div class="splide voice__slider" aria-label="Member's Voice">
    <div class="splide__track">
    <ul class="splide__list voice__list">
      <?php
      foreach ( $ni_voice_ids as $ni_i => $ni_voice_id ) {
      	get_template_part( 'template-parts/voice-card', null, array( 'post' => $ni_voice_id, 'offset' => 1 === $ni_i ) );
      }
      ?>
    </ul>
    </div>
    </div>
    <div class="slider-nav voice__nav">
      <button type="button" class="arrow-pill arrow-pill--prev" aria-label="前へ"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></button>
      <button type="button" class="arrow-pill" aria-label="次へ"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></button>
    </div>
    <?php endif; ?>
    <a class="btn btn--w voice__btn" href="<?php echo ni_url( '/interview/' ); ?>">全ての記事をみる<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
  </section>

  <!-- Cross Talk -->
  <?php get_template_part( 'template-parts/talk-section' ); /* 座談会（Cross Talk）。記事は固定ページの ACF「座談会（ピックアップ）」で選ぶ */ ?>

  <!-- People & Culture -->
  <section class="culture">
    <img class="culture__bg" src="<?php echo ni_img( 'common/culture_bg_shape.svg' ); ?>" alt="" width="3022" height="1848" aria-hidden="true">
    <div class="culture__photos" aria-hidden="true" data-anim="photo-carousel">
      <div class="culture__cols">
        <ul class="culture__col culture__col--l">
          <li><img src="<?php echo ni_img( 'common/culture_01.jpg' ); ?>" alt="" width="470" height="626"></li>
          <li><img src="<?php echo ni_img( 'common/culture_02.jpg' ); ?>" alt="" width="470" height="626"></li>
          <li><img src="<?php echo ni_img( 'common/culture_03.jpg' ); ?>" alt="" width="470" height="626"></li>
          <li><img src="<?php echo ni_img( 'common/culture_04.jpg' ); ?>" alt="" width="470" height="626"></li>
          <li><img src="<?php echo ni_img( 'common/culture_05.jpg' ); ?>" alt="" width="470" height="626"></li>
          <li><img src="<?php echo ni_img( 'common/culture_06.jpg' ); ?>" alt="" width="470" height="626"></li>
        </ul>
        <ul class="culture__col culture__col--offset">
          <li><img src="<?php echo ni_img( 'common/culture_07.jpg' ); ?>" alt="" width="470" height="626"></li>
          <li><img src="<?php echo ni_img( 'common/culture_08.jpg' ); ?>" alt="" width="470" height="626"></li>
          <li><img src="<?php echo ni_img( 'common/culture_09.jpg' ); ?>" alt="" width="470" height="626"></li>
          <li><img src="<?php echo ni_img( 'common/culture_10.jpg' ); ?>" alt="" width="470" height="626"></li>
          <li><img src="<?php echo ni_img( 'common/culture_11.jpg' ); ?>" alt="" width="470" height="626"></li>
          <li><img src="<?php echo ni_img( 'common/culture_12.jpg' ); ?>" alt="" width="470" height="626"></li>
        </ul>
        <ul class="culture__col culture__col--r">
          <li><img src="<?php echo ni_img( 'common/culture_06.jpg' ); ?>" alt="" width="470" height="626"></li>
          <li><img src="<?php echo ni_img( 'common/culture_05.jpg' ); ?>" alt="" width="470" height="626"></li>
          <li><img src="<?php echo ni_img( 'common/culture_02.jpg' ); ?>" alt="" width="470" height="626"></li>
          <li><img src="<?php echo ni_img( 'common/culture_01.jpg' ); ?>" alt="" width="470" height="626"></li>
          <li><img src="<?php echo ni_img( 'common/culture_03.jpg' ); ?>" alt="" width="470" height="626"></li>
          <li><img src="<?php echo ni_img( 'common/culture_04.jpg' ); ?>" alt="" width="470" height="626"></li>
        </ul>
      </div>
    </div>
    <div class="culture__content">
      <div class="sec-head sec-head--top sec-head--white">
        <h2 class="sec-head__en u-en">People &amp;<br>Culture</h2>
        <div class="sec-head__body">
          <p class="sec-head__title sec-head__title--cap">どんな職場か、もっと知る</p>
        </div>
      </div>
      <ul class="culture__list">
        <li><a class="culture-item" href="<?php echo ni_url( '/work-style/' ); ?>"><span class="culture-item__body"><span class="culture-item__title">制度・環境</span><span class="culture-item__text">在宅勤務・フレックス・産休育休復職制度など、長く安心して働ける環境をご紹介します。</span></span><span class="culture-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
        <li><a class="culture-item" href="<?php echo ni_url( '/development/' ); ?>"><span class="culture-item__body"><span class="culture-item__title">教育・研修・キャリアパス</span><span class="culture-item__text">OJT・メンター・AIツール研修・資格支援まで、入社直後から専門性を積み上げる仕組みが整っています。</span></span><span class="culture-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
        <li><a class="culture-item" href="<?php echo ni_url( '/office/' ); ?>"><span class="culture-item__body"><span class="culture-item__title">オフィス紹介</span><span class="culture-item__text">銀座に構える開放的なオフィス。リサーチの話題が日常的に飛び交う、日本インフォメーションの職場環境をご紹介します。</span></span><span class="culture-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
        <li><a class="btn btn--w" href="#">全ての記事をみる<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a></li>
      </ul>
    </div>
  </section>

  <!-- Job Openings -->
  <section class="job" id="job">
    <div class="sec-head sec-head--top">
      <h2 class="sec-head__en u-en">Job<br>Openings</h2>
      <div class="sec-head__body">
        <p class="sec-head__title sec-head__title--cap">募集中の職種一覧</p>
      </div>
    </div>
    <?php $ni_job_terms = ni_job_pickup(); /* 固定ページの ACF「募集中の職種一覧（カテゴリ）」で選んだカテゴリ（タブ 1・タブ 2） */ ?>
    <div class="job__body js-tabs">
      <?php if ( $ni_job_terms ) : ?>
      <div class="job__tabs" role="tablist" aria-label="採用区分">
        <?php foreach ( $ni_job_terms as $ni_i => $ni_job_term ) : ?>
        <button type="button" class="job__tab" role="tab" id="job-tab-<?php echo $ni_i + 1; ?>" aria-controls="job-panel-<?php echo $ni_i + 1; ?>" aria-selected="<?php echo 0 === $ni_i ? 'true' : 'false'; ?>"><?php echo esc_html( $ni_job_term->name ); ?></button>
        <?php endforeach; ?>
      </div>
      <?php foreach ( $ni_job_terms as $ni_i => $ni_job_term ) : ?>
      <div class="job__panel" role="tabpanel" id="job-panel-<?php echo $ni_i + 1; ?>" aria-labelledby="job-tab-<?php echo $ni_i + 1; ?>"<?php echo 0 === $ni_i ? '' : ' hidden'; ?>>
<?php get_template_part( 'template-parts/job-pickup', null, array( 'term' => $ni_job_term ) ); ?>
      </div>
      <?php endforeach; ?>
      <?php else : ?>
      <div class="job__panel">
<?php get_template_part( 'template-parts/job-pickup' ); ?>
      </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Entry -->
  <!-- Entry: demo と同型のバースイープで登場（fv-entry.js）。ピンで直前セクションに重ね、その間 Entry は画面固定 -->
  <div class="entry-pin">
  <section class="entry" data-anim="entry-transition">
    <img class="entry__bg" src="<?php echo ni_img( 'common/entry_bg_blend.png' ); ?>" alt="" width="1232" height="928" aria-hidden="true">
    <div class="entry__head">
      <h2 class="entry__title u-en">Entry</h2>
      <p class="entry__lead">あなたのスタートラインから、一緒に始めましょう。</p>
    </div>
    <div class="entry__cards">
      <div class="entry-card">
        <div class="entry-card__head">
          <div><p class="entry-card__label">新卒採用</p><h3 class="entry-card__title">はじめてリサーチの仕事をする方へ</h3></div>
        </div>
        <div class="entry-card__body">
          <div class="entry-card__img"><img src="<?php echo ni_img( 'common/entry_photo_new.jpg' ); ?>" alt="" width="136" height="189"></div>
          <div class="entry-card__text">
            <p>文系・理系・業種問わず大歓迎。入社後は段階的な研修とOJTで、リサーチャーとして着実に育てます。まずは募集要項をご覧ください。</p>
            <a class="entry-card__btn u-pc" href="<?php echo esc_url( ni_beginner_cta()['url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( ni_beginner_cta()['text'] ); ?><span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn_navy.svg' ); ?>" alt="" width="12" height="20"></span></a>
          </div>
        </div>
        <a class="entry-card__btn u-sp" href="<?php echo esc_url( ni_beginner_cta()['url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( ni_beginner_cta()['text'] ); ?><span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn_navy.svg' ); ?>" alt="" width="12" height="20"></span></a>
      </div>
      <div class="entry-card">
        <div class="entry-card__head">
          <div><p class="entry-card__label">中途（リサーチ未経験者）採用</p><h3 class="entry-card__title">異業種からのご転職をお考えの方へ</h3></div>
        </div>
        <div class="entry-card__body">
          <div class="entry-card__img"><img src="<?php echo ni_img( 'common/entry_photo_mid.jpg' ); ?>" alt="" width="136" height="189"></div>
          <div class="entry-card__text">
            <p>営業・IT・製造・サービス業など、さまざまな業界からの転職者が活躍中。前職で培った経験は、リサーチの仕事に必ず活きます。まずはカジュアル面談でお話ししましょう。</p>
            <a class="entry-card__btn u-pc" href="<?php echo ni_url( '/casual-talk/' ); ?>">カジュアル面談に申し込む<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn_navy.svg' ); ?>" alt="" width="12" height="20"></span></a>
          </div>
        </div>
        <a class="entry-card__btn u-sp" href="<?php echo ni_url( '/casual-talk/' ); ?>">カジュアル面談に申し込む<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn_navy.svg' ); ?>" alt="" width="12" height="20"></span></a>
      </div>
    </div>
  </section>
  </div>

  </div>
</main>
<?php
get_footer();
