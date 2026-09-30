<?php
/**
 * 教育・研修・キャリアパス（固定ページ /development/）
 *
 * 静的 HTML（HTML/development/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => '教育・研修・キャリアパス｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '年次に関係なく、早い段階から大手企業の重要案件に関わることができます。バディ制のOJTと充実した資格支援で、専門家としての成長を会社全体でサポートします。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <img class="page-head__ni" src="<?php echo ni_img( 'lower/pagehead_ni.png' ); ?>" alt="" width="988" height="936">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">教育・研修・キャリアパス</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">Career &amp;<br>Development</p>
      <h1 class="page-head__jp">教育・研修・キャリアパス</h1>
    </div>
    <p class="page-head__read">年次に関係なく、早い段階から大手企業の重要案件に関わることができます。<br class="u-pc">バディ制のOJTと充実した資格支援で、専門家としての成長を会社全体でサポートします。</p>
  </div>

  <!-- 導入（Figma 553:10761 / SP 1140:13961） -->
  <div class="lower-sec dev-intro">
    <div class="dev-intro__txt">
      <p class="dev-intro__title">「早く」「広く」「深く」<br>成長できる環境がここにある。</p>
      <p class="dev-intro__read">成長意欲のある方、専門家を目指す方、最新テクノロジーを活かしたい方。<br class="u-pc">日本インフォメーションはあなたのキャリアを全力でサポートします。</p>
    </div>
    <ul class="dev-intro__list">
      <li class="dev-feature" data-anim="inview">
        <span class="dev-feature__icon"><img src="<?php echo ni_img( 'development/icon_fast.svg' ); ?>" alt="" width="40" height="40"></span>
        <h3 class="dev-feature__title">早く成長できる</h3>
        <p class="dev-feature__txt">年功序列なし。入社1年目後半から大手メーカーの案件をメイン担当。若いうちから重要な仕事を任されます。</p>
      </li>
      <li class="dev-feature" data-anim="inview">
        <span class="dev-feature__icon"><img src="<?php echo ni_img( 'development/icon_wide.svg' ); ?>" alt="" width="40" height="40"></span>
        <h3 class="dev-feature__title">広く経験できる</h3>
        <p class="dev-feature__txt">定量・定性、オフライン・オンライン。幅広い調査手法を一人のリサーチャーが担当できるのは日本インフォメーションならでは。</p>
      </li>
      <li class="dev-feature" data-anim="inview">
        <span class="dev-feature__icon"><img src="<?php echo ni_img( 'development/icon_deep.svg' ); ?>" alt="" width="40" height="40"></span>
        <h3 class="dev-feature__title">深く専門性を磨ける</h3>
        <p class="dev-feature__txt">バディ制OJT・資格支援・AI勉強会。段階的なサポートで、マーケティングリサーチの専門家へと成長できます。</p>
      </li>
    </ul>
  </div>

  <!-- 入社後の成長ステップ（Figma 553:10766 / SP）。タブ（common.js の .js-tabs）+ 横スクロール -->
  <section class="lower-sec dev-sec growth js-tabs">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Growth Path</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">入社後の成長ステップ</h2>
        <p class="sec-head__read">初めての案件から、一人前のリサーチャーへ。節目ごとの「できるようになること」を年次でまとめました。</p>
      </div>
    </div>
    <div class="growth__body">
      <div class="growth__bar">
        <div class="dev-tabs" role="tablist" aria-label="入社区分">
          <button type="button" class="job__tab" role="tab" id="growth-tab-1" aria-controls="growth-panel-1" aria-selected="true">新卒・中途(リサーチ未経験)</button>
          <button type="button" class="job__tab" role="tab" id="growth-tab-2" aria-controls="growth-panel-2" aria-selected="false">中途(リサーチ経験者)</button>
        </div>
        <p class="growth__hint" aria-hidden="true">横にスクロールして全ステップを見る<span class="growth__hint-icon"><span class="growth__hint-line"></span><img class="u-pc" src="<?php echo ni_img( 'development/scroll_mouse.svg' ); ?>" alt="" width="24" height="15"><img class="u-sp" src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
      </div>
      <div class="growth__panel" role="tabpanel" id="growth-panel-1" aria-labelledby="growth-tab-1">
        <div class="growth__scroll js-growth-scroll" tabindex="0">
        <ol class="growth__list">
          <li class="growth-step">
            <p class="growth-step__no u-grd-text">Step1</p>
            <p class="growth-step__badge">〜1ヶ月✍️座学研修</p>
            <span class="growth-step__pin" aria-hidden="true"><img src="<?php echo ni_img( 'development/step_pin.svg' ); ?>" alt="" width="24" height="36"></span>
            <div class="growth-step__card">
              <h3 class="growth-step__title">基礎を固める</h3>
              <p class="growth-step__txt">マナー研修→会社全般→リサーチ基礎→課題研修（調査設計〜報告）の約1か月。</p>
            </div>
          </li>
          <li class="growth-step">
            <p class="growth-step__no u-grd-text">Step2</p>
            <p class="growth-step__badge">〜3ヶ月🎉 初案件</p>
            <span class="growth-step__pin" aria-hidden="true"><img src="<?php echo ni_img( 'development/step_pin.svg' ); ?>" alt="" width="24" height="36"></span>
            <div class="growth-step__card">
              <h3 class="growth-step__title">先輩のサブ担当として実案件へ</h3>
              <p class="growth-step__txt">バディ（S2以上）と組んで実案件をサポート。初めて自分で調査票を作成。</p>
            </div>
          </li>
          <li class="growth-step">
            <p class="growth-step__no u-grd-text">Step3</p>
            <p class="growth-step__badge">〜6ヶ月🎉 初メイン担当</p>
            <span class="growth-step__pin" aria-hidden="true"><img src="<?php echo ni_img( 'development/step_pin.svg' ); ?>" alt="" width="24" height="36"></span>
            <div class="growth-step__card">
              <h3 class="growth-step__title">クライアント対応を含む案件を主導</h3>
              <p class="growth-step__txt">ヒアリングから報告書まで、自分がメインで推進する案件を担当。先輩がサポート。</p>
            </div>
          </li>
          <li class="growth-step">
            <p class="growth-step__no u-grd-text">Step4</p>
            <p class="growth-step__badge">1年目後半🎉 主担当を任される</p>
            <span class="growth-step__pin" aria-hidden="true"><img src="<?php echo ni_img( 'development/step_pin.svg' ); ?>" alt="" width="24" height="36"></span>
            <div class="growth-step__card">
              <h3 class="growth-step__title">大手メーカーの窓口を担当</h3>
              <p class="growth-step__txt">提案営業やクライアント窓口を任される。定型案件（主要4手法）で実力をつける。</p>
            </div>
          </li>
        </ol>
        </div>
      </div>
      <!-- TODO: 「中途(リサーチ経験者)」の内容は Figma に無いためダミー -->
      <div class="growth__panel" role="tabpanel" id="growth-panel-2" aria-labelledby="growth-tab-2" hidden>
        <div class="growth__scroll js-growth-scroll" tabindex="0">
        <ol class="growth__list">
          <li class="growth-step">
            <p class="growth-step__no u-grd-text">Step1</p>
            <p class="growth-step__badge">時期テキスト</p>
            <span class="growth-step__pin" aria-hidden="true"><img src="<?php echo ni_img( 'development/step_pin.svg' ); ?>" alt="" width="24" height="36"></span>
            <div class="growth-step__card">
              <h3 class="growth-step__title">見出しテキストが入ります</h3>
              <p class="growth-step__txt">テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります。</p>
            </div>
          </li>
          <li class="growth-step">
            <p class="growth-step__no u-grd-text">Step2</p>
            <p class="growth-step__badge">時期テキスト</p>
            <span class="growth-step__pin" aria-hidden="true"><img src="<?php echo ni_img( 'development/step_pin.svg' ); ?>" alt="" width="24" height="36"></span>
            <div class="growth-step__card">
              <h3 class="growth-step__title">見出しテキストが入ります</h3>
              <p class="growth-step__txt">テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります。</p>
            </div>
          </li>
          <li class="growth-step">
            <p class="growth-step__no u-grd-text">Step3</p>
            <p class="growth-step__badge">時期テキスト</p>
            <span class="growth-step__pin" aria-hidden="true"><img src="<?php echo ni_img( 'development/step_pin.svg' ); ?>" alt="" width="24" height="36"></span>
            <div class="growth-step__card">
              <h3 class="growth-step__title">見出しテキストが入ります</h3>
              <p class="growth-step__txt">テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります。</p>
            </div>
          </li>
          <li class="growth-step">
            <p class="growth-step__no u-grd-text">Step4</p>
            <p class="growth-step__badge">時期テキスト</p>
            <span class="growth-step__pin" aria-hidden="true"><img src="<?php echo ni_img( 'development/step_pin.svg' ); ?>" alt="" width="24" height="36"></span>
            <div class="growth-step__card">
              <h3 class="growth-step__title">見出しテキストが入ります</h3>
              <p class="growth-step__txt">テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります。</p>
            </div>
          </li>
        </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- 研修・教育制度（Figma 557:12407 / SP） -->
  <section class="lower-sec dev-sec training">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Training</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">研修・教育制度</h2>
        <p class="sec-head__read">入社直後の座学研修から、バディOJT・資格支援・AI勉強会まで。各ステージに合わせた仕組みが整っています。</p>
      </div>
    </div>
    <div class="training__blocks">
      <div class="training__block">
        <h3 class="dev-h3">等級制度</h3>
        <div class="grade">
          <ol class="grade__list">
          <li class="grade__cell grade__cell--1"><span class="grade__code">J1</span><span class="grade__label">バディOJT対象</span><span class="grade__badge">入社直後</span></li>
          <li class="grade__cell grade__cell--2"><span class="grade__code">J2</span><span class="grade__label">バディOJT対象</span><span class="grade__badge">〜2年目</span></li>
          <li class="grade__cell grade__cell--3"><span class="grade__code">S1</span><span class="grade__label">通常OJT</span><span class="grade__badge">〜4年目</span></li>
          <li class="grade__cell grade__cell--4"><span class="grade__code">S2</span><span class="grade__label">ディレクター→サブリーダー</span><span class="grade__badge">〜6年目</span></li>
          <li class="grade__cell grade__cell--5"><span class="grade__code">S3</span><span class="grade__label">シニア・管理職候補</span></li>
          <li class="grade__cell grade__cell--6"><span class="grade__code">MGR</span><span class="grade__label">課長→部長</span></li>
          </ol>
          <p class="grade__note"><span>※新卒・リサーチ未経験者の場合の目安</span></p>
        </div>
      </div>
      <div class="training__block training__block--gap">
        <h3 class="dev-h3">約1か月間の段階的な座学研修</h3>
        <p class="training__read">新卒は約1か月間、中途未経験者は1週間の研修からスタート。</p>
        <ul class="icon-cards">
          <li class="icon-card">
            <span class="icon-card__icon"><img src="<?php echo ni_img( 'development/icon_manner.svg' ); ?>" alt="" width="40" height="40"></span>
            <div class="icon-card__txt">
              <h4 class="icon-card__title">ビジネスマナー研修（1日）</h4>
              <p class="icon-card__desc">メッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入ります</p>
            </div>
          </li>
          <li class="icon-card">
            <span class="icon-card__icon"><img src="<?php echo ni_img( 'development/icon_company.svg' ); ?>" alt="" width="40" height="40"></span>
            <div class="icon-card__txt">
              <h4 class="icon-card__title">会社全般の研修（1週間）</h4>
              <p class="icon-card__desc">メッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入ります</p>
            </div>
          </li>
          <li class="icon-card">
            <span class="icon-card__icon"><img src="<?php echo ni_img( 'development/icon_research.svg' ); ?>" alt="" width="40" height="40"></span>
            <div class="icon-card__txt">
              <h4 class="icon-card__title">リサーチ基礎研修（1週間）</h4>
              <p class="icon-card__desc">メッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入ります</p>
            </div>
          </li>
          <li class="icon-card">
            <span class="icon-card__icon"><img src="<?php echo ni_img( 'development/icon_task.svg' ); ?>" alt="" width="40" height="40"></span>
            <div class="icon-card__txt">
              <h4 class="icon-card__title">課題研修（2週間）</h4>
              <p class="icon-card__desc">メッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入ります</p>
            </div>
          </li>
        </ul>
      </div>
      <div class="training__block">
        <h3 class="dev-h3">S2以上の先輩と1対1でマンツーマン指導</h3>
        <p class="training__read">J1・J2はS2以上の先輩社員がバディとして付き、毎月1回の進捗面談を実施。</p>
        <ul class="icon-cards">
          <li class="icon-card">
            <span class="icon-card__icon"><img src="<?php echo ni_img( 'development/icon_buddy.svg' ); ?>" alt="" width="40" height="40"></span>
            <div class="icon-card__txt">
              <h4 class="icon-card__title">平均3〜4年間の<br>バディOJT期間</h4>
              <p class="icon-card__desc">メッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入ります</p>
            </div>
          </li>
          <li class="icon-card">
            <span class="icon-card__icon"><img src="<?php echo ni_img( 'development/icon_plan.svg' ); ?>" alt="" width="40" height="40"></span>
            <div class="icon-card__txt">
              <h4 class="icon-card__title">半年に1回 <br>OJT計画書・スキルマップ作成</h4>
              <p class="icon-card__desc">メッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入ります</p>
            </div>
          </li>
          <li class="icon-card">
            <span class="icon-card__icon"><img src="<?php echo ni_img( 'development/icon_meeting.svg' ); ?>" alt="" width="40" height="40"></span>
            <div class="icon-card__txt">
              <h4 class="icon-card__title">毎月のバディ面談で<br>着実に進捗確認</h4>
              <p class="icon-card__desc">メッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入ります</p>
            </div>
          </li>
          <li class="icon-card">
            <span class="icon-card__icon"><img src="<?php echo ni_img( 'development/icon_senior.svg' ); ?>" alt="" width="40" height="40"></span>
            <div class="icon-card__txt">
              <h4 class="icon-card__title">年次の近い先輩が<br>サポート役（会社ルールなど）</h4>
              <p class="icon-card__desc">メッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入りますメッセージ本文が入ります</p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </section>

  <!-- キャリアパス（Figma 557:12580 / SP）。タブ 3 つ + 右に追従する Interview カード（PC は sticky） -->
  <section class="lower-sec dev-sec career-path js-tabs">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Training</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">キャリアパス</h2>
        <p class="sec-head__read">入社区分（新卒・中途）に関係なく、実績と意向次第でキャリアを選べます。<br class="u-pc">年1回の自己申告書制度で、希望の方向性を会社に相談できます。</p>
      </div>
    </div>
    <div class="dev-tabs dev-tabs--wrap" role="tablist" aria-label="キャリアの路線">
      <button type="button" class="job__tab" role="tab" id="career-tab-1" aria-controls="career-panel-1" aria-selected="true">マネジメント路線</button>
      <button type="button" class="job__tab" role="tab" id="career-tab-2" aria-controls="career-panel-2" aria-selected="false">スペシャリスト路線</button>
      <button type="button" class="job__tab" role="tab" id="career-tab-3" aria-controls="career-panel-3" aria-selected="false">キャリアチェンジ路線</button>
    </div>
    <div class="career-path__panels">
      <div class="career-case" role="tabpanel" id="career-panel-1" aria-labelledby="career-tab-1">
        <div class="career-case__main">
          <div class="career-case__intro">
            <div class="career-case__head">
              <p class="career-case__label u-grd-text">Case1</p>
              <p class="career-case__route"><span class="career-case__role">リサーチャー</span><img src="<?php echo ni_img( 'development/icon_tri.svg' ); ?>" alt="から" width="9" height="11"><span class="career-case__role">マネージャー</span></p>
            </div>
            <p class="career-case__lead">リサーチャーとして実績を積み、チームのマネジメントへ。<br class="u-pc">副課長・課長・部長と段階的にポジションが上がります。<br class="u-pc">新卒・中途の区別はなく、実績次第でマネジメントへの道が開かれています。</p>
          </div>
          <ul class="career-case__stages">
            <li class="career-stage">
              <div class="career-stage__head">
                <p class="career-stage__badge">入社1〜3年目</p>
                <h4 class="career-stage__title">基礎を固め、一人前のリサーチャーへ</h4>
              </div>
              <p class="career-stage__txt">バディ制OJTのもと、先輩のサブ担当として実案件に関わる。6か月でメイン担当を経験し、2〜3年目には大手メーカーの案件を複数担当。後輩への指導も始まる。</p>
            </li>
            <li class="career-stage">
              <div class="career-stage__head">
                <p class="career-stage__badge">4〜5年目</p>
                <h4 class="career-stage__title">S等級昇格・バディトレーナーに</h4>
              </div>
              <p class="career-stage__txt">担当案件数が増加。S等級（S1〜）に昇格し、新入社員のバディとして指導役に。複雑な案件にも自力で対応できるようになる。</p>
            </li>
            <li class="career-stage">
              <div class="career-stage__head">
                <p class="career-stage__badge">6〜7年目</p>
                <h4 class="career-stage__title">ディレクターとして多数の案件を主導</h4>
              </div>
              <p class="career-stage__txt">大手クライアントの主担当を複数並行して担当。後輩の育成にも注力しながら、マネージャー候補としてチームを引っ張る。</p>
            </li>
            <li class="career-stage">
              <div class="career-stage__head">
                <p class="career-stage__badge">8年目〜</p>
                <h4 class="career-stage__title">サブリーダー → 課長 → 部長へ</h4>
              </div>
              <p class="career-stage__txt">サブリーダーを経て管理職へ昇格。チームマネジメントを担いながらも、プレイングマネージャーとしてクライアントと向き合い続ける。</p>
            </li>
          </ul>
        </div>
        <div class="career-case__voice">
            <p class="career-case__label u-grd-text">Interview</p>
            <div class="voice-card">
              <a class="voice-card__img" href="<?php echo ni_url( '/interview/detail/' ); ?>"><img src="<?php echo ni_img( 'common/voice_card_01.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"><span class="career-case__name u-pc"><span class="career-case__name-jp">田中 太郎</span><span class="career-case__name-en">Taro Tanaka</span></span></a>
              <div class="voice-card__body">
                <div class="voice-card__row">
                  <p class="voice-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
                  <a class="arrow-pill arrow-pill--l voice-card__arrow" href="<?php echo ni_url( '/interview/detail/' ); ?>" aria-label="記事を読む"><img src="<?php echo ni_img( 'common/arrow_pill_white_l.svg' ); ?>" alt="" width="20" height="24"></a>
                </div>
                <div class="voice-card__meta">
                  <ul class="voice-card__chips"><li>新卒入社</li><li>リサーチャー</li></ul>
                  <ul class="voice-card__tags"><li># フルリモート</li><li># 時短勤務</li></ul>
                </div>
              </div>
            </div>
          </div>
      </div>
      <!-- TODO: Case2 / Case3 の内容は Figma に無いためダミー -->
      <div class="career-case" role="tabpanel" id="career-panel-2" aria-labelledby="career-tab-2" hidden>
        <div class="career-case__main">
          <div class="career-case__intro">
            <div class="career-case__head">
              <p class="career-case__label u-grd-text">Case2</p>
              <p class="career-case__route"><span class="career-case__role">リサーチャー</span><img src="<?php echo ni_img( 'development/icon_tri.svg' ); ?>" alt="から" width="9" height="11"><span class="career-case__role">スペシャリスト</span></p>
            </div>
            <p class="career-case__lead">テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります。</p>
          </div>
          <ul class="career-case__stages">
            <li class="career-stage">
              <div class="career-stage__head">
                <p class="career-stage__badge">入社1〜3年目</p>
                <h4 class="career-stage__title">見出しテキストが入ります</h4>
              </div>
              <p class="career-stage__txt">テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります。</p>
            </li>
            <li class="career-stage">
              <div class="career-stage__head">
                <p class="career-stage__badge">4〜5年目</p>
                <h4 class="career-stage__title">見出しテキストが入ります</h4>
              </div>
              <p class="career-stage__txt">テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります。</p>
            </li>
            <li class="career-stage">
              <div class="career-stage__head">
                <p class="career-stage__badge">6〜7年目</p>
                <h4 class="career-stage__title">見出しテキストが入ります</h4>
              </div>
              <p class="career-stage__txt">テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります。</p>
            </li>
            <li class="career-stage">
              <div class="career-stage__head">
                <p class="career-stage__badge">8年目〜</p>
                <h4 class="career-stage__title">見出しテキストが入ります</h4>
              </div>
              <p class="career-stage__txt">テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります。</p>
            </li>
          </ul>
        </div>
        <div class="career-case__voice">
            <p class="career-case__label u-grd-text">Interview</p>
            <div class="voice-card">
              <a class="voice-card__img" href="<?php echo ni_url( '/interview/detail/' ); ?>"><img src="<?php echo ni_img( 'common/voice_card_01.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"><span class="career-case__name u-pc"><span class="career-case__name-jp">田中 太郎</span><span class="career-case__name-en">Taro Tanaka</span></span></a>
              <div class="voice-card__body">
                <div class="voice-card__row">
                  <p class="voice-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
                  <a class="arrow-pill arrow-pill--l voice-card__arrow" href="<?php echo ni_url( '/interview/detail/' ); ?>" aria-label="記事を読む"><img src="<?php echo ni_img( 'common/arrow_pill_white_l.svg' ); ?>" alt="" width="20" height="24"></a>
                </div>
                <div class="voice-card__meta">
                  <ul class="voice-card__chips"><li>新卒入社</li><li>リサーチャー</li></ul>
                  <ul class="voice-card__tags"><li># フルリモート</li><li># 時短勤務</li></ul>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="career-case" role="tabpanel" id="career-panel-3" aria-labelledby="career-tab-3" hidden>
        <div class="career-case__main">
          <div class="career-case__intro">
            <div class="career-case__head">
              <p class="career-case__label u-grd-text">Case3</p>
              <p class="career-case__route"><span class="career-case__role">リサーチャー</span><img src="<?php echo ni_img( 'development/icon_tri.svg' ); ?>" alt="から" width="9" height="11"><span class="career-case__role">他職種</span></p>
            </div>
            <p class="career-case__lead">テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります。</p>
          </div>
          <ul class="career-case__stages">
            <li class="career-stage">
              <div class="career-stage__head">
                <p class="career-stage__badge">入社1〜3年目</p>
                <h4 class="career-stage__title">見出しテキストが入ります</h4>
              </div>
              <p class="career-stage__txt">テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります。</p>
            </li>
            <li class="career-stage">
              <div class="career-stage__head">
                <p class="career-stage__badge">4〜5年目</p>
                <h4 class="career-stage__title">見出しテキストが入ります</h4>
              </div>
              <p class="career-stage__txt">テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります。</p>
            </li>
            <li class="career-stage">
              <div class="career-stage__head">
                <p class="career-stage__badge">6〜7年目</p>
                <h4 class="career-stage__title">見出しテキストが入ります</h4>
              </div>
              <p class="career-stage__txt">テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります。</p>
            </li>
            <li class="career-stage">
              <div class="career-stage__head">
                <p class="career-stage__badge">8年目〜</p>
                <h4 class="career-stage__title">見出しテキストが入ります</h4>
              </div>
              <p class="career-stage__txt">テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります。</p>
            </li>
          </ul>
        </div>
        <div class="career-case__voice">
            <p class="career-case__label u-grd-text">Interview</p>
            <div class="voice-card">
              <a class="voice-card__img" href="<?php echo ni_url( '/interview/detail/' ); ?>"><img src="<?php echo ni_img( 'common/voice_card_01.jpg' ); ?>" alt="" width="384" height="472" loading="lazy"><span class="career-case__name u-pc"><span class="career-case__name-jp">田中 太郎</span><span class="career-case__name-en">Taro Tanaka</span></span></a>
              <div class="voice-card__body">
                <div class="voice-card__row">
                  <p class="voice-card__quote">リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
                  <a class="arrow-pill arrow-pill--l voice-card__arrow" href="<?php echo ni_url( '/interview/detail/' ); ?>" aria-label="記事を読む"><img src="<?php echo ni_img( 'common/arrow_pill_white_l.svg' ); ?>" alt="" width="20" height="24"></a>
                </div>
                <div class="voice-card__meta">
                  <ul class="voice-card__chips"><li>新卒入社</li><li>リサーチャー</li></ul>
                  <ul class="voice-card__tags"><li># フルリモート</li><li># 時短勤務</li></ul>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </section>

</main>
<?php
get_footer();
