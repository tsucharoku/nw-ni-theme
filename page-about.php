<?php
/**
 * 3分でわかるNI（固定ページ /about/）
 *
 * 静的 HTML（HTML/about/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => '3分でわかる日本インフォメーション｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '私たち日本インフォメーションの事業・強み・数字をまとめてご紹介します。1969年創業の独立系マーケティングリサーチ専業会社の規模、リサーチ環境、働き方・カルチャーを数字で。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">3分でわかる日本インフォメーション</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">About Us</p>
      <h1 class="page-head__jp">3分でわかる日本インフォメーション</h1>
    </div>
    <p class="page-head__read">私たち日本インフォメーションの事業・強み・数字をまとめてご紹介します。</p>
  </div>

  <!-- リード（Figma 522:9592 / SP 1140:12193） -->
  <div class="lower-sec about-lead">
    <p class="about-lead__title">多様なアプローチで発掘した生活者のインサイトを価値に変えて、<br class="u-pc">企業の経営判断を支援する会社</p>
    <p class="about-lead__txt">1969年創業の独立系マーケティングリサーチ専業会社。飲料・食品・化粧品・トイレタリーなど大手消費財メーカーを中心に、<br class="u-pc">年間約2,000件・800社超の調査を手がけています。</p>
  </div>

  <!-- 会社・事業規模（Figma 522:9633 / SP 1140:12198）。数字は data-count でカウントアップ（about.js） -->
  <section class="lower-sec about-sec about-sec--scale">
    <div class="about-sec__head">
      <div class="sec-head sec-head--sub">
        <p class="sec-head__label u-grd-text">Scale</p>
        <div class="sec-head__body">
          <h2 class="sec-head__title sec-head__title--cap">会社・事業規模</h2>
          <p class="sec-head__read">1969年の創業から積み上げてきた、日本インフォメーションの事業規模を数字で</p>
        </div>
      </div>
      <!-- TODO: 会社概要のリンク先（コーポレートサイト）未確定 -->
      <a class="btn" href="#">会社概要をみる<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
    </div>
    <div class="about-scale">
      <div class="num-card num-card--pie" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label">年間調査件数</p>
            <p class="num-card__num"><span class="num-card__value" data-count="2000">2,000</span><span class="num-card__unit">件</span></p>
          </div>
          <p class="num-card__note">CLT 40% ／ 定性 22% WEB 20% ／ HUT 18%</p>
        </div>
        <!-- 円グラフ: 扇は Figma のベクター（662:6986）、ラベルは HTML テキスト -->
        <div class="pie" role="img" aria-label="調査手法の内訳 CLT 40%、定性 22%、WEB 20%、HUT 18%">
          <div class="pie__sectors" aria-hidden="true">
            <img class="pie__sector pie__sector--clt" src="<?php echo ni_img( 'about/pie_clt.svg' ); ?>" alt="" width="114" height="206">
            <img class="pie__sector pie__sector--teisei" src="<?php echo ni_img( 'about/pie_teisei.svg' ); ?>" alt="" width="145" height="114">
            <img class="pie__sector pie__sector--web" src="<?php echo ni_img( 'about/pie_web.svg' ); ?>" alt="" width="114" height="132">
            <img class="pie__sector pie__sector--hut" src="<?php echo ni_img( 'about/pie_hut.svg' ); ?>" alt="" width="103" height="114">
          </div>
          <p class="pie__label pie__label--clt" aria-hidden="true"><span class="pie__name">CLT</span><span class="pie__val u-en">40%</span></p>
          <p class="pie__label pie__label--teisei" aria-hidden="true"><span class="pie__name">定性</span><span class="pie__val u-en">22%</span></p>
          <p class="pie__label pie__label--web" aria-hidden="true"><span class="pie__name">WEB</span><span class="pie__val u-en">20%</span></p>
          <p class="pie__label pie__label--hut" aria-hidden="true"><span class="pie__name">HUT</span><span class="pie__val u-en">18%</span></p>
          <span class="pie__hole" aria-hidden="true"></span>
        </div>
      </div>
      <div class="about-scale__side">
        <ul class="num-row">
      <li class="num-card num-card--media num-card--lead" data-anim="inview">
        <div class="num-card__txt num-card__txt--w207">
          <div class="num-card__head">
            <p class="num-card__label">業界成長率</p>
            <p class="num-card__lead">業界トップクラスの<br>110%超の成長率を維持</p>
          </div>
          <p class="num-card__note">コロナ禍でも売上成長率110%超を記録。<br class="u-pc">創業56年の独立系リサーチ会社として持続的な高成長を継続。</p>
        </div>
        <div class="num-card__thumb num-card__thumb--icon"><img src="<?php echo ni_img( 'about/icon_growth.svg' ); ?>" alt="" width="50" height="50"></div>
      </li>
      <li class="num-card num-card--center" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label">取引社数</p>
            <p class="num-card__num"><span class="num-card__value" data-count="800">800</span><span class="num-card__unit">社超</span></p>
          </div>
          <p class="num-card__note">リピート希望率96%<br>※当社お客様満足度調査調べ</p>
        </div>
      </li>
        </ul>
        <ul class="num-row">
      <li class="num-card num-card--center" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label">大手メーカーとの直接取引比率</p>
            <p class="num-card__num"><span class="num-card__value" data-count="90">90</span><span class="num-card__unit">％</span></p>
          </div>
          <p class="num-card__note">飲料・食品・化粧品・トイレタリーなど<br>代理店を介さず直接対峙</p>
        </div>
      </li>
      <li class="num-card num-card--media num-card--start" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label">創業</p>
            <p class="num-card__num"><span class="num-card__value" data-count="1969">1969</span><span class="num-card__unit">年</span></p>
          </div>
          <p class="num-card__note">独立系リサーチ専業会社として55年以上<br>JMRA・ESOMAR加盟</p>
        </div>
        <div class="num-card__thumb num-card__thumb--icon num-card__thumb--icon-l"><img src="<?php echo ni_img( 'about/icon_building.svg' ); ?>" alt="" width="50" height="50"></div>
      </li>
        </ul>
      </div>
    </div>
  </section>

  <!-- 仕事・リサーチ環境（Figma 540:10039 / SP 1140:12244） -->
  <section class="lower-sec about-sec about-sec--env">
    <div class="about-sec__head">
      <div class="sec-head sec-head--sub">
        <p class="sec-head__label u-grd-text">Environment</p>
        <div class="sec-head__body">
          <h2 class="sec-head__title sec-head__title--cap">仕事・リサーチ環境</h2>
          <p class="sec-head__read">他社では経験できない設備・手法・ツールが、日本インフォメーションには揃っています</p>
        </div>
      </div>
    </div>
    <div class="num-rows">
      <ul class="num-row">
      <li class="num-card num-card--center" data-anim="inview">
        <div class="num-card__txt num-card__txt--w355">
          <div class="num-card__head">
            <p class="num-card__label">パネルリーチ規模</p>
            <p class="num-card__num"><span class="num-card__value" data-count="1800">1,800</span><span class="num-card__unit">万人にリーチ可能</span></p>
          </div>
          <p class="num-card__note">日本の15歳以上の約6人に1人にリーチできる規模のパネルネットワーク（自社600万人＋提携1,200万人）</p>
        </div>
      </li>
      <li class="num-card num-card--center num-card--grow" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label">入社1年目に経験できる調査手法数</p>
            <p class="num-card__num"><span class="num-card__value" data-count="4">4</span><span class="num-card__unit">手法</span></p>
          </div>
          <p class="num-card__note">CLT・WEB・HUT・定性（GI）など<br>バランスよく全手法を経験</p>
        </div>
      </li>
      <li class="num-card num-card--media num-card--start" data-anim="inview">
        <div class="num-card__txt num-card__txt--w235">
          <div class="num-card__head">
            <p class="num-card__label">自社調査会場数</p>
            <p class="num-card__num"><span class="num-card__value" data-count="8">8</span><span class="num-card__unit">会場</span></p>
          </div>
          <p class="num-card__note">東京7・大阪1 同日7会場でCLT同時実施可能。オフィスと同ビルで移動ゼロ</p>
        </div>
        <div class="num-card__thumb"><img src="<?php echo ni_img( 'about/num_venue.jpg' ); ?>" alt="" width="744" height="524" loading="lazy" style="object-position: 95% 50%"></div>
      </li>
      </ul>
      <ul class="num-row">
      <li class="num-card num-card--center num-card--grow" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label">専属調査員数</p>
            <p class="num-card__num"><span class="num-card__value" data-count="220">220</span><span class="num-card__unit">名超</span></p>
          </div>
          <p class="num-card__note">業界最大級。機縁リクルーター150名と連携し、<br class="u-pc">困難条件の対象者も確保可能</p>
        </div>
      </li>
      <li class="num-card num-card--media num-card--lead" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label">NI Shopper Lab.</p>
            <p class="num-card__lead">業界唯一の<br>模擬店舗型実査施設</p>
          </div>
          <p class="num-card__note">コンビニ／ドラッグストアに切替可<br>店内カメラ完備・DIルーム2部屋併設</p>
        </div>
        <div class="num-card__thumb"><img src="<?php echo ni_img( 'about/num_shopperlab.jpg' ); ?>" alt="" width="744" height="524" loading="lazy" style="object-position: 57% 50%"></div>
      </li>
        <li class="num-card num-card--ai" data-anim="inview">
          <p class="num-card__label">自社開発AIツール</p>
          <div class="num-card__split">
            <div class="num-card__split-item">
              <p class="num-card__lead">AI × 定量調査</p>
              <p class="num-card__sub">自由回答の自動深掘り・<br>チャットインタビュー</p>
            </div>
            <div class="num-card__split-item">
              <p class="num-card__lead">AI × 定性調査</p>
              <p class="num-card__sub">インタビュー書き起こし・<br>サマリー自動化</p>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </section>

  <!-- 働き方・カルチャー（Figma 540:10040 / SP 1140:12268） -->
  <section class="lower-sec about-sec about-sec--culture">
    <div class="about-sec__head">
      <div class="sec-head sec-head--sub">
        <p class="sec-head__label u-grd-text">Culture</p>
        <div class="sec-head__body">
          <h2 class="sec-head__title sec-head__title--cap">働き方・カルチャー</h2>
          <p class="sec-head__read">異業種出身者も多く、多様なバックグラウンドを持った人が活躍しています</p>
        </div>
      </div>
    </div>
    <div class="num-rows">
      <ul class="num-row">
      <li class="num-card num-card--center num-card--grow" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label">新卒入社社員の3年後定着率</p>
            <p class="num-card__num"><span class="num-card__value" data-count="85.7">85.7</span><span class="num-card__unit">%</span></p>
          </div>
          <p class="num-card__note">入社後の定着率の高さを示す実績</p>
        </div>
      </li>
      <li class="num-card num-card--center num-card--grow" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label">離職率（2024年度）</p>
            <p class="num-card__num"><span class="num-card__value" data-count="7">7</span><span class="num-card__unit">%</span></p>
          </div>
          <p class="num-card__note">日本全体平均 11.5% と比較して低水準</p>
        </div>
      </li>
      <li class="num-card num-card--center num-card--grow" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label">平均勤続年数</p>
            <p class="num-card__num"><span class="num-card__value" data-count="7">7</span><span class="num-card__unit">年11ヶ月</span></p>
          </div>
          <p class="num-card__note">専門性が積み上がり、長く働ける環境</p>
        </div>
      </li>
      <li class="num-card num-card--center num-card--grow" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label">女性産休育休復職率</p>
            <p class="num-card__num"><span class="num-card__value" data-count="100">100</span><span class="num-card__unit">%</span></p>
          </div>
          <p class="num-card__note">小学校就学まで時短OK<br>遠隔地フルリモート制度あり</p>
        </div>
      </li>
      </ul>
      <ul class="num-row">
        <li class="num-card num-card--career" data-anim="inview">
          <p class="num-card__label">異業種からの活躍例</p>
          <ul class="num-card__career">
            <li><span>バスの運転手</span><img src="<?php echo ni_img( 'about/icon_tri.svg' ); ?>" alt="から" width="10" height="8"><span>集計部門ディレクター</span></li>
            <li><span>アパレル販売</span><img src="<?php echo ni_img( 'about/icon_tri.svg' ); ?>" alt="から" width="10" height="8"><span>営業部部長</span></li>
          </ul>
        </li>
        <li class="num-card num-card--gender num-card--start" data-anim="inview">
          <p class="num-card__label">男女比（正社員）</p>
          <div class="num-card__ratio">
            <p class="num-card__num"><span class="num-card__unit">男</span><span class="num-card__value" data-count="57">57</span><span class="num-card__unit">%</span></p>
            <p class="num-card__num"><span class="num-card__unit">女</span><span class="num-card__value" data-count="43">43</span><span class="num-card__unit">%</span></p>
          </div>
          <p class="num-card__sub">業界最大級。機縁リクルーター150名と連携し、<br>困難条件の対象者も確保可能</p>
        </li>
        <li class="num-card num-card--center num-card--lead num-card--grow" data-anim="inview">
          <div class="num-card__txt">
            <div class="num-card__head">
              <p class="num-card__label">制度の柔軟性</p>
              <p class="num-card__lead">ワーケーション／遠隔地勤務<br>時短・出社日数制限</p>
            </div>
            <p class="num-card__note">ライフステージに合わせた働き方が選択可</p>
          </div>
        </li>
      </ul>
      <ul class="num-row">
      <li class="num-card num-card--media num-card--grow" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label">コミュニケーションランチ</p>
            <p class="num-card__num"><span class="num-card__value" data-count="1500">1,500</span><span class="num-card__unit">円/月</span></p>
          </div>
          <p class="num-card__note">部署ランチ代を毎月会社が負担<br>チームの関係構築をサポート</p>
        </div>
        <div class="num-card__thumb"><img src="<?php echo ni_img( 'about/num_lunch.jpg' ); ?>" alt="" width="800" height="534" loading="lazy" style="object-position: 38% 50%"></div>
      </li>
      <li class="num-card num-card--media num-card--lead num-card--grow" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label">社内懇親会（年2回）</p>
            <p class="num-card__lead">すし職人が<br>オフィスに来社！？</p>
          </div>
          <p class="num-card__note">かき氷・軽食もふるまい<br>コミュニティチームが毎回企画</p>
        </div>
        <div class="num-card__thumb"><img src="<?php echo ni_img( 'about/num_party.jpg' ); ?>" alt="" width="416" height="556" loading="lazy" style="object-position: 50% 50%"></div>
      </li>
      <li class="num-card num-card--media num-card--lead num-card--grow" data-anim="inview">
        <div class="num-card__txt">
          <div class="num-card__head">
            <p class="num-card__label">無料軽食</p>
            <p class="num-card__lead">スナックミー<br class="u-pc">常時提供</p>
          </div>
          <p class="num-card__note">人工甘味料・保存料・合成着色料不使用のヘルシー軽食</p>
        </div>
        <div class="num-card__thumb"><img src="<?php echo ni_img( 'about/num_snack.jpg' ); ?>" alt="" width="800" height="534" loading="lazy" style="object-position: 67% 50%"></div>
      </li>
      </ul>
    </div>
  </section>

  <!-- 社員に聞きました（Figma 522:9670 / SP 1140:12315）。各質問の 1 つ目が紺のピル -->
  <section class="lower-sec about-sec about-voice">
    <div class="about-voice__top">
      <div class="sec-head sec-head--sub">
        <p class="sec-head__label u-grd-text">We Asked Our Team!</p>
        <div class="sec-head__body">
          <h2 class="sec-head__title sec-head__title--cap">日本インフォメーション<br>社員に聞きました！</h2>
          <p class="sec-head__read">日本インフォメーションで働く社員に、3つの質問をしました</p>
        </div>
      </div>
      <div class="about-voice__group about-voice__group--q1" data-anim="inview">
        <h3 class="about-voice__q">Q.入社を決めた理由</h3>
        <ul class="about-voice__list">
          <li class="voice-pill voice-pill--deep">自社で案件を最初から最後まで一貫して執り行えるところ</li>
          <li class="voice-pill">立地のよさ。銀座はトレンドと伝統が共存していて他にはない魅力がある。</li>
          <li class="voice-pill">若くて活気がある</li>
          <li class="voice-pill">ワークライフバランスのとれた働き方ができる</li>
          <li class="voice-pill">社員の風通しがいい会社</li>
        </ul>
      </div>
    </div>
    <div class="about-voice__bottom">
      <div class="about-voice__group about-voice__group--q2" data-anim="inview">
        <h3 class="about-voice__q">Q.面白い！と感じた瞬間</h3>
        <ul class="about-voice__list">
          <li class="voice-pill voice-pill--deep">開発段階から携わっていた商品が世の中に発売されて話題になった時</li>
          <li class="voice-pill">模擬店舗の実査運営に立ち会ったとき</li>
          <li class="voice-pill">ブランドを担当するお客様からリサーチ会社としての意見を求められ、その意見が反映されたとき</li>
          <li class="voice-pill">データやFA回答を通して、消費者の姿や生活がリアルに見えた時</li>
        </ul>
      </div>
      <div class="about-voice__group about-voice__group--q3" data-anim="inview">
        <h3 class="about-voice__q">Q.日本インフォメーションってどんな会社？</h3>
        <ul class="about-voice__list">
          <li class="voice-pill voice-pill--deep">消費者の声を社会につなぐ会社</li>
          <li class="voice-pill">生活者の本音に近い会社</li>
          <li class="voice-pill">リアルの調査に強い</li>
          <li class="voice-pill">長い歴史に見合った高い調査技術を持った会社</li>
          <li class="voice-pill">社員の風通しがいい会社</li>
        </ul>
      </div>
    </div>
  </section>

</main>
<?php
get_footer();
