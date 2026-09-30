<?php
/**
 * 仕事の相関図（固定ページ /chart/）
 *
 * 静的 HTML（HTML/chart/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => '仕事の相関図｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '日本インフォメーションの仕事の相関図。クライアントの窓口となるリサーチ・ディレクション部を中心に、現場・集計・分析の専門職が連携して調査を完成させる流れを、職種ごとの役割とあわせて紹介します。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <img class="page-head__ni" src="<?php echo ni_img( 'lower/pagehead_ni.png' ); ?>" alt="" width="988" height="936">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">仕事の相関図</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">What<br class="u-sp"> You'll Do</p>
      <h1 class="page-head__jp">仕事の相関図</h1>
    </div>
    <p class="page-head__read">日本インフォメーションでは、すべての案件でリサーチディレクターがクライアントの窓口を一本化します。<br class="u-pc">現場データから集計・分析、報告書まで、各職種が連携して調査をワンストップで完結させます。</p>
  </div>

  <!-- ===== Intro（720:7086 / SP 1140:17345） ===== -->
  <div class="lower-sec chart-intro">
    <h2 class="chart-intro__title">調査のはじまりから終わりまで、<br class="u-pc">日本インフォメーションの職種はつながっています。</h2>
    <p class="chart-intro__text">ひとりの担当者が案件全体を動かし、現場・集計・分析の専門職が連携して調査を完成させる。<br class="u-pc">日本インフォメーションの仕事は職種を超えた"チームワーク"で成り立っています。</p>
  </div>

  <!-- ===== 相関図（720:6715 / SP 1140:17348） =====
       PC = .chart: Figma の img（722:8368）と同じ 1248×2372px の座標系。カードとラベルは style の --x / --y（Figma の座標）で置く。
       線と矢印は Figma から書き出した lines.svg。幅に合わせて縮小（chart.js）。
       SP = .chart-pic: ボタンなしの図の画像を枠の中でピンチ・ドラッグ（chart.js）。
       ボタンのリンク先は WP で職種ごとのインタビュー絞り込みに差し替える -->
  <section class="lower-sec chart-sec" aria-label="仕事の相関図">
    <div class="chart-tools">
      <p class="chart-tools__hint"><img src="<?php echo ni_img( 'chart/icon_pinch.svg' ); ?>" alt="" width="30" height="24">ピンチで画像を拡大・縮小</p>
      <button type="button" class="chart-tools__reset" data-chart-reset>リセット<img src="<?php echo ni_img( 'chart/icon_reset.svg' ); ?>" alt="" width="14" height="14"></button>
    </div>
    <div class="chart-viewer js-chart-viewer">
      <!-- SP: Figma の SP と同じ、ボタンなしの図の画像（1456:21700 img 3、2237×4096）。枠の中でピンチ・ドラッグ。
           インタビューへのリンクは図の下（.chart-links）。文言を変えたら画像も Figma から書き出し直す -->
      <img class="chart-pic" src="<?php echo ni_img( 'chart/chart_sp.webp' ); ?>" alt="仕事の相関図。クライアント（大手消費財メーカーを中心に約800社）の窓口は、リサーチ・ディレクション部またはリサーチ・コンサルティング部（リサーチャー）。調査企画をインターネットリサーチグループと FW 管理部に共有し、生活者へのアンケートや会場調査を実施。外部パートナーのモデレーター・調査員とも連携する。集まった調査データは NI マーケティング研究所が集計し、結果を共有。経営企画室・新価値創造部・品質管理委員会が全体を支える。" width="2237" height="4096" loading="lazy" draggable="false">
      <!-- PC: HTML の図 -->
      <div class="chart">
        <img class="chart__lines" src="<?php echo ni_img( 'chart/lines.svg' ); ?>" alt="" width="1248" height="2372" loading="lazy">

        <!-- クライアント -->
        <div class="chart-card chart-card--client" style="--x:146;--y:39.6">
          <p class="chart-card__badge">お客様</p>
          <span class="chart-card__img"><img src="<?php echo ni_img( 'chart/illust_client.svg' ); ?>" alt="" width="263" height="118" loading="lazy"></span>
          <div class="chart-card__txt">
            <h3 class="chart-card__name">クライアント</h3>
            <p class="chart-card__desc">大手消費財メーカーを中心に約800社</p>
          </div>
        </div>
        <p class="chart-label" style="--x:619;--y:79;--w:151;--h:24">提案・調査結果の報告</p>
        <p class="chart-label chart-label--pink" style="--x:593;--y:207.5;--w:71;--h:24">課題共有</p>

        <!-- 本部ブロック: リサーチ・ディレクション部 OR リサーチ・コンサルティング部 -->
        <div class="chart-hq" style="--x:143;--y:315.3">
          <div class="chart-card">
            <p class="chart-card__badge">調査全体の司令塔</p>
            <span class="chart-card__img"><img src="<?php echo ni_img( 'chart/illust_direction.svg' ); ?>" alt="" width="326" height="245" loading="lazy"></span>
            <div class="chart-card__txt">
              <h3 class="chart-card__name">リサーチ・ディレクション部</h3>
              <p class="chart-card__desc">クライアントの窓口として、調査票の作成から実査、集計の指示まで幅広く担います。</p>
            </div>
            <a class="chart-btn" href="<?php echo ni_url( '/interview/' ); ?>">この職種のインタビューを見る</a>
          </div>
          <div class="chart-hq__or"><p class="chart-label chart-label--round">OR</p></div>
          <div class="chart-card">
            <p class="chart-card__badge">顧客の課題を解決するリサーチのプロ</p>
            <span class="chart-card__img"><img src="<?php echo ni_img( 'chart/illust_consulting.svg' ); ?>" alt="" width="326" height="245" loading="lazy"></span>
            <div class="chart-card__txt">
              <h3 class="chart-card__name">リサーチ・コンサルティング部<br>（リサーチャー）</h3>
              <p class="chart-card__desc">調査の企画から高度なデータ分析、意思決定を支える報告書作成まで伴走します。</p>
            </div>
            <a class="chart-btn" href="<?php echo ni_url( '/interview/' ); ?>">この職種のインタビューを見る</a>
          </div>
        </div>
        <p class="chart-label chart-label--gray chart-label--v" style="--x:25;--y:513;--w:30;--h:125">顧客獲得・共有</p>
        <p class="chart-label chart-label--s" style="--x:523;--y:923.1;--w:98;--h:24">調査企画の共有</p>
        <p class="chart-label chart-label--v" style="--x:92;--y:1038;--w:30;--h:121">集計方法の相談</p>
        <p class="chart-label chart-label--gray chart-label--s chart-label--v" style="--x:64;--y:1236.3;--w:29;--h:135">カスタマーサポート</p>

        <!-- 外部パートナー -->
        <p class="chart-label chart-label--black" style="--x:1087;--y:595.3;--w:118;--h:32">外部パートナー</p>
        <div class="chart-partner" style="--x:1033;--y:616.3">
          <div class="chart-card">
            <p class="chart-card__badge">定性調査</p>
            <span class="chart-card__img"><img src="<?php echo ni_img( 'chart/illust_moderator.svg' ); ?>" alt="" width="120" height="120" loading="lazy"></span>
            <div class="chart-card__txt">
              <h3 class="chart-card__name">モデレーター</h3>
              <p class="chart-card__desc">グループインタビュー<br>などの定性調査の<br>ファシリテーションを<br>担当する専門職。</p>
            </div>
          </div>
          <div class="chart-card">
            <p class="chart-card__badge">現場対応</p>
            <span class="chart-card__img"><img src="<?php echo ni_img( 'chart/illust_investigator.svg' ); ?>" alt="" width="120" height="120" loading="lazy"></span>
            <div class="chart-card__txt">
              <h3 class="chart-card__name">調査員</h3>
              <p class="chart-card__desc">CLT・HUT調査の対象者対応を担う専属スタッフ。当社CLT会場で活躍。</p>
            </div>
          </div>
        </div>
        <p class="chart-label chart-label--purple chart-label--round" style="--x:1005;--y:722.2;--w:40;--h:40">連携</p>
        <p class="chart-label chart-label--purple chart-label--round" style="--x:1005;--y:1074.2;--w:40;--h:40">連携</p>

        <!-- インターネットリサーチグループ / 生活者 / FW管理部 -->
        <div class="chart-card chart-card--ops chart-card--net" style="--x:142;--y:961">
          <p class="chart-card__badge">インターネットリサーチのオペレーション</p>
          <span class="chart-card__img"><img src="<?php echo ni_img( 'chart/illust_internet.svg' ); ?>" alt="" width="326" height="245" loading="lazy"></span>
          <div class="chart-card__txt">
            <h3 class="chart-card__name">インターネットリサーチグループ</h3>
            <p class="chart-card__desc">Webアンケートの画面作成や配信を管理。矛盾した回答を防ぐため、裏側で緻密なシステム制御をかけます。</p>
          </div>
          <a class="chart-btn" href="<?php echo ni_url( '/interview/' ); ?>">この職種のインタビューを見る</a>
        </div>
        <p class="chart-label chart-label--orange chart-label--r4" style="--x:539.5;--y:1106;--w:61;--h:28">生活者</p>
        <p class="chart-label chart-label--orange chart-label--v" style="--x:555;--y:1193.9;--w:30;--h:118">アンケート依頼</p>
        <p class="chart-label chart-label--orange chart-label--v" style="--x:555;--y:1327.9;--w:30;--h:46">回答</p>
        <div class="chart-card chart-card--ops chart-card--fw" style="--x:624;--y:961">
          <p class="chart-card__badge">定性調査/HUT/CLTのオペレーション</p>
          <span class="chart-card__img"><img src="<?php echo ni_img( 'chart/illust_fw.svg' ); ?>" alt="" width="326" height="245" loading="lazy"></span>
          <div class="chart-card__txt">
            <h3 class="chart-card__name">FW管理部</h3>
            <p class="chart-card__desc">会場調査やホームテストなどのオフライン調査の現場を統括。資材の準備、参加する対象者のリクルートから当日の運営管理まで担います。</p>
          </div>
          <a class="chart-btn" href="<?php echo ni_url( '/interview/' ); ?>">この職種のインタビューを見る</a>
        </div>
        <p class="chart-label chart-label--green chart-label--s" style="--x:502;--y:1537.3;--w:108;--h:24">調査データの集約</p>

        <!-- NIマーケティング研究所 -->
        <div class="chart-card chart-card--lab" style="--x:303;--y:1618.1">
          <p class="chart-card__badge">分析の土台を支える集計の専門集団</p>
          <div class="chart-card__row">
            <span class="chart-card__img"><img src="<?php echo ni_img( 'chart/illust_lab.svg' ); ?>" alt="" width="120" height="120" loading="lazy"></span>
            <div class="chart-card__txt">
              <h3 class="chart-card__name">NIマーケティング研究所</h3>
              <p class="chart-card__desc">回収されたアンケートデータを正確に集計し、<br>見やすいクロス表やグラフを作成します。</p>
            </div>
          </div>
          <a class="chart-btn" href="<?php echo ni_url( '/interview/' ); ?>">この職種のインタビューを見る</a>
        </div>
        <p class="chart-label chart-label--beige" style="--x:849;--y:1765;--w:112;--h:31">集計結果の共有</p>

        <!-- 経営企画室 / 新価値創造部 / 品質管理委員会 -->
        <div class="chart-card chart-card--staff chart-card--half" style="--x:0;--y:1986.4">
          <span class="chart-card__img"><img src="<?php echo ni_img( 'chart/illust_planning.svg' ); ?>" alt="" width="120" height="145" loading="lazy"></span>
          <div class="chart-card__body">
            <div class="chart-card__txt">
              <h3 class="chart-card__name">経営企画室</h3>
              <p class="chart-card__desc">経営陣のサポートをはじめ、Webマーケティング、セミナー運営、自主調査推進、広報活動など多角的に会社を支えます。</p>
            </div>
            <a class="chart-btn" href="<?php echo ni_url( '/interview/' ); ?>">この職種のインタビューを見る</a>
          </div>
        </div>
        <div class="chart-card chart-card--staff chart-card--half" style="--x:636;--y:1986.4">
          <span class="chart-card__img"><img src="<?php echo ni_img( 'chart/illust_newvalue.svg' ); ?>" alt="" width="120" height="145" loading="lazy"></span>
          <div class="chart-card__body">
            <div class="chart-card__txt">
              <h3 class="chart-card__name">新価値創造部</h3>
              <p class="chart-card__desc">AIを活用した新ツールの開発や導入、カスタマーサポートを担当。社内の業務効率化やDXも推進します。</p>
            </div>
            <a class="chart-btn" href="<?php echo ni_url( '/interview/' ); ?>">この職種のインタビューを見る</a>
          </div>
        </div>
        <div class="chart-card chart-card--staff chart-card--wide" style="--x:264.5;--y:2203.4">
          <span class="chart-card__img"><img src="<?php echo ni_img( 'chart/illust_quality.svg' ); ?>" alt="" width="120" height="120" loading="lazy"></span>
          <div class="chart-card__txt">
            <h3 class="chart-card__name">品質管理委員会</h3>
            <p class="chart-card__desc">全案件の品質チェックを担当。社内の全職種から選抜されたメンバーで構成。<br>実査・集計・報告書など全工程の品質を横断的に監視。</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== 各職種のインタビューを見る（SP のみ。1456:21749）。PC は図の中のボタンから ===== -->
  <section class="lower-sec chart-links">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Interview</p>
      <h2 class="sec-head__title sec-head__title--cap">各職種のインタビューを見る</h2>
    </div>
    <ul class="chart-links__list">
      <li><a class="chart-btn" href="<?php echo ni_url( '/interview/' ); ?>">リサーチ・ディレクション部</a></li>
      <li><a class="chart-btn" href="<?php echo ni_url( '/interview/' ); ?>">リサーチ・コンサルティング部（リサーチャー）</a></li>
      <li><a class="chart-btn" href="<?php echo ni_url( '/interview/' ); ?>">インターネットリサーチグループ</a></li>
      <li><a class="chart-btn" href="<?php echo ni_url( '/interview/' ); ?>">FW管理部</a></li>
      <li><a class="chart-btn" href="<?php echo ni_url( '/interview/' ); ?>">NIマーケティング研究所</a></li>
      <li><a class="chart-btn" href="<?php echo ni_url( '/interview/' ); ?>">経営企画室</a></li>
      <li><a class="chart-btn" href="<?php echo ni_url( '/interview/' ); ?>">新価値創造部</a></li>
    </ul>
  </section>

</main>
<?php
get_footer();
