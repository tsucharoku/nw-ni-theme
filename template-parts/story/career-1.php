<?php
/**
 * プロジェクトストーリー 中途経験者 #01（固定ページ /career/story-1/）の <main> の中身
 *
 * page-story-1.php から読み込む。文言・画像は固定（Figma 1433:19185 のまま。WP の投稿内容は出していない）。
 * 3 ページ（beginner-1 / beginner-2 / career-1）は同じ部品・同じマークアップで、文言・図・章の数だけが違う。見た目は assets/css/story.css。
 */
?>

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱）。パンくずは Figma どおり 2 階層（親の TOP は挟まない） -->
  <div class="page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">プロジェクトストーリー #01</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">Project Story</p>
      <p class="page-head__jp">プロジェクトストーリー</p>
    </div>
  </div>

  <!-- ===== タイトル（1433:19190）: 四隅カッコの枠に 番号 + タイトル + リード、その下に流れる英字 ===== -->
  <div class="ps-intro">
    <div class="lower-sec">
      <div class="ps-intro__box bracket">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <p class="ps-intro__num"><small>#</small><b>01</b></p>
        <h1 class="ps-intro__title">「対面のリアル」をテクノロジーで共有化。<br class="u-pc">二人三脚で実現した、<br class="u-pc">前例なきAIプロダクト導入プロジェクト</h1>
        <p class="ps-intro__lead">大手菓子メーカーに伴走し続ける担当者が、定性調査のAIプロダクト活用でサポートしたプロジェクトを語ります。</p>
      </div>
    </div>
    <p class="ps-marquee u-en" aria-hidden="true"><span class="ps-marquee__track"><span>Real Projects, Real Insights</span><span>Real Projects, Real Insights</span><span>Real Projects, Real Insights</span><span>Real Projects, Real Insights</span></span></p>
  </div>

  <!-- ===== Story Overview / Member / Before After（1433:19206 の親） ===== -->
  <section class="lower-sec ps-overview">
    <div class="ps-overview__row">
      <h2 class="ps-heading">Story<br class="u-pc"> Overview</h2>
      <div class="ps-overview__txt">
        <p>日本インフォメーションは、大手菓子メーカーの新商品開発にあたり、生活者の潜在ニーズをより深く・速く意思決定に反映してほしいという依頼を受けた。対面・オンラインのデプスインタビューで、現場の温度感を組織にどう届けるか、記録・分析の負荷をどう減らすかに向き合ったのが今回のプロジェクトだった。</p>
        <p>担当は、定性調査を長年知り尽くすリサーチ・ディレクション部のK.Hと、同部署から異動しAI活用を推進する新価値創造部のY.S。実査のリアルさを守りながら意思決定を進化させたい——同じ思いを持つ2部署が手を組んだプロジェクトを、2名が振り返る。</p>
      </div>
    </div>

    <!-- Member（block: コメント）。アバターは Figma のイラストを丸く切り出した画像 -->
    <div class="ps-members">
      <h2 class="ps-heading">Member</h2>
      <ul class="ps-members__list">
        <li class="ps-member">
          <img class="ps-member__img" src="<?php echo ni_img( 'story/career-1/avatar_01.png' ); ?>" alt="" width="88" height="88" loading="lazy">
          <div class="ps-member__body">
            <p class="ps-member__dept">リサーチ・ディレクション部</p>
            <p class="ps-member__name">K.H（中途入社・マネージャー・男性）</p>
            <p class="ps-member__bio">異業種から中途入社し20年以上のマネージャー。長年このクライアントの定性調査を担当し、調査設計から合意形成までを担う。一社に深く入り込み、ブランド理解を積み重ねてきた。「対面の熱量を届けたい」という思いからAI導入を主導した。</p>
          </div>
        </li>
        <li class="ps-member">
          <img class="ps-member__img" src="<?php echo ni_img( 'story/career-1/avatar_02.png' ); ?>" alt="" width="88" height="88" loading="lazy">
          <div class="ps-member__body">
            <p class="ps-member__dept">新価値創造部</p>
            <p class="ps-member__name">Y.S（中途入社3年目・男性）</p>
            <p class="ps-member__bio">中途入社3年目。リサーチ・ディレクション部で2年勤務後、新価値創造部へ異動。「テクノロジーは調査の質を上げるために使うべきだ」という感覚をK.Hと共有できたことが連携の土台に。AIプロダクトの開発指示や提案方針の策定、カスタマーサクセスを担う。</p>
          </div>
        </li>
      </ul>
    </div>

    <!-- Before / After（1433:27856） -->
    <div class="ps-ba">
      <div class="ps-ba__col ps-ba__col--before">
        <p class="ps-ba__head"><span class="ps-ba__label">導入前の状況</span><span class="ps-ba__en">Before</span></p>
        <ul class="ps-checks"><li>現場の熱量や非言語的なニュアンスが、立ち会えない関係者に伝わりきらない状況</li><li>モデレーションと並行した記録に限界があり、記録漏れへの懸念</li><li>発言内容の整理・要約に時間がかかり、意思決定のスピードがボトルネックに</li></ul>
      </div>
      <span class="ps-ba__arrow" aria-hidden="true"></span>
      <div class="ps-ba__col ps-ba__col--after">
        <p class="ps-ba__head"><span class="ps-ba__label">AIプロダクト導入後</span><span class="ps-ba__en">After</span></p>
        <ul class="ps-checks"><li>動画・文字起こし・サマリーで、立ち会えないメンバーも現場と同じ解像度で把握</li><li>記録作業から解放され、実査そのものに集中できることで質が向上</li><li>整理・要約が自動化され、データに基づく意思決定のスピードと質が向上</li></ul>
      </div>
    </div>
  </section>

  <!-- ===== AI導入プロセス（1433:19238）: 図は ai-flow-chart を HTML + CSS で組んだもの。章ではいまの工程だけを強調する ===== -->
  <section class="lower-sec ps-process">
    <div class="sec-head sec-head--sub ps-process__head">
      <p class="sec-head__label u-grd-text">AI Adoption Process</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">AI導入プロセス</h2>
      </div>
    </div>
    <!-- SP は図を横スクロールで見せる（案内の行は SP だけ） -->
    <p class="ps-hint u-sp" aria-hidden="true">横にスクロールして全ステップを見る<span class="ps-hint__icon"><span class="ps-hint__line"></span><img src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
    <div class="ps-chart">
      <div class="ps-aiflow">
        <p class="ps-aiflow__head"><span>ここからAIプロダクトの提案</span></p>
        <ol class="ps-aiflow__cards">
          <li class="ps-aiflow__card ps-aiflow__card--issue" style="--i:0"><span class="ps-aiflow__pill">課題 1</span><p class="ps-aiflow__title"><span class="ps-aiflow__main">立ち会えない<br>ことの壁</span></p><p class="ps-aiflow__note">現場の熱量が伝わらない</p></li>
          <li class="ps-aiflow__card ps-aiflow__card--issue" style="--i:1"><span class="ps-aiflow__pill">課題 2</span><p class="ps-aiflow__title"><span class="ps-aiflow__main">進行と記録の<br>制約</span></p><p class="ps-aiflow__note">記録漏れ・分析の遅延</p></li>
          <li class="ps-aiflow__card ps-aiflow__card--ai" style="--i:2"><span class="ps-aiflow__pill">AI</span><p class="ps-aiflow__title"><span class="ps-aiflow__sub">前例のない挑戦</span><span class="ps-aiflow__main">デモ・POCで<br>提案を重ねる</span></p><p class="ps-aiflow__note">二人三脚の粘り強い提案</p></li>
          <li class="ps-aiflow__card ps-aiflow__card--ai" style="--i:3"><span class="ps-aiflow__pill">AI</span><p class="ps-aiflow__title"><span class="ps-aiflow__sub">導入後の変化</span><span class="ps-aiflow__main">解釈のブレが減り<br>意思決定の質が向上</span></p><p class="ps-aiflow__note">継続的なCS活動へ</p></li>
        </ol>
        <ul class="ps-aiflow__legend"><li class="ps-aiflow__legend-item ps-aiflow__legend-item--issue">従来の調査フェーズ</li><li class="ps-aiflow__legend-item ps-aiflow__legend-item--ai">AIプロダクト導入フェーズ</li></ul>
      </div>
    </div>
  </section>

  <!-- ===== Chapter 01（1433:19254） ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head">
      <p class="ps-chapter__num"><small>Chapter</small><b>01</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title">立ち会えないことの壁：<br>現場の熱量は、報告書だけでは伝わらない</h2>
      <p class="ps-hint u-sp" aria-hidden="true">横にスクロールして全ステップを見る<span class="ps-hint__icon"><span class="ps-hint__line"></span><img src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
      <div class="ps-chart ps-chapter__chart">
        <div class="ps-aiflow">
          <p class="ps-aiflow__head"><span>ここからAIプロダクトの提案</span></p>
          <ol class="ps-aiflow__cards">
            <li class="ps-aiflow__card ps-aiflow__card--issue" style="--i:0"><span class="ps-aiflow__pill">課題 1</span><p class="ps-aiflow__title"><span class="ps-aiflow__main">立ち会えない<br>ことの壁</span></p><p class="ps-aiflow__note">現場の熱量が伝わらない</p></li>
            <li class="ps-aiflow__card ps-aiflow__card--issue is-off" style="--i:1"><span class="ps-aiflow__pill">課題 2</span><p class="ps-aiflow__title"><span class="ps-aiflow__main">進行と記録の<br>制約</span></p><p class="ps-aiflow__note">記録漏れ・分析の遅延</p></li>
            <li class="ps-aiflow__card ps-aiflow__card--ai is-off" style="--i:2"><span class="ps-aiflow__pill">AI</span><p class="ps-aiflow__title"><span class="ps-aiflow__sub">前例のない挑戦</span><span class="ps-aiflow__main">デモ・POCで<br>提案を重ねる</span></p><p class="ps-aiflow__note">二人三脚の粘り強い提案</p></li>
            <li class="ps-aiflow__card ps-aiflow__card--ai is-off" style="--i:3"><span class="ps-aiflow__pill">AI</span><p class="ps-aiflow__title"><span class="ps-aiflow__sub">導入後の変化</span><span class="ps-aiflow__main">解釈のブレが減り<br>意思決定の質が向上</span></p><p class="ps-aiflow__note">継続的なCS活動へ</p></li>
          </ol>
          <ul class="ps-aiflow__legend"><li class="ps-aiflow__legend-item ps-aiflow__legend-item--issue">従来の調査フェーズ</li><li class="ps-aiflow__legend-item ps-aiflow__legend-item--ai">AIプロダクト導入フェーズ</li></ul>
        </div>
      </div>
    </header>

    <!-- 対話の箱（1433:19277）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 01</p>
        <h3 class="ps-question__title">このクライアントの定性調査は、どんな課題を抱えていたのでしょうか。</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/career-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">K.H</span></p>
            <div class="ps-speech__text">
              <p>このクライアントの新商品開発では、生活者の潜在ニーズを探るデプスインタビューを繰り返し実施していました。対面・オンライン両方で実施するのですが、特に対面のインタビューは、対象者の表情の変化や間の取り方といった非言語的な情報が重要な意味を持ちます。私自身、この「その場の空気感」こそが定性調査の本質だと思っていたので、それをどうにかしてクライアント全体に届けたいという思いがずっとありました。ただ、クライアント側の商品開発メンバー全員が実査に立ち会うのは物理的に難しく、参加できなかった方には後日レポートで報告するしかありませんでした。現場の熱量やニュアンスって、文章だけではどうしても伝わりきらないんですよね。結果として、参加者と不参加者でクライアント社内の解像度にバラつきが生まれてしまっていました。</p>
            </div>
            <figure class="ps-speech__img" style="--w:464;--h:309"><img src="<?php echo ni_img( 'story/career-1/ch01_01.jpg' ); ?>" alt="長机と椅子が並ぶインタビュールーム（壁にモニター）" width="512" height="342" loading="lazy"></figure>
          </div>
        </div>
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/career-1/avatar_02.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">新価値創造部</span><span class="ps-speech__name">Y.S</span></p>
            <div class="ps-speech__text">
              <p>私がこのプロジェクトに関わり始めたのは、まさにその課題感がクライアント内で共有され始めていたタイミングでした。実査に同席できなかった商品開発チームの方から「現場の空気感がもう少し伝わる形にできないか」という声が上がっていたと聞いています。私自身も元々リサーチ・ディレクション部にいたので、この「伝わらないもどかしさ」は肌感覚として理解できました。</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>

  <!-- ===== Chapter 02（1433:19286） ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head">
      <p class="ps-chapter__num"><small>Chapter</small><b>02</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title">記録という制約：<br>進行のフォローと記録は、両立しない</h2>
      <p class="ps-hint u-sp" aria-hidden="true">横にスクロールして全ステップを見る<span class="ps-hint__icon"><span class="ps-hint__line"></span><img src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
      <div class="ps-chart ps-chapter__chart">
        <div class="ps-aiflow">
          <p class="ps-aiflow__head"><span>ここからAIプロダクトの提案</span></p>
          <ol class="ps-aiflow__cards">
            <li class="ps-aiflow__card ps-aiflow__card--issue is-off" style="--i:0"><span class="ps-aiflow__pill">課題 1</span><p class="ps-aiflow__title"><span class="ps-aiflow__main">立ち会えない<br>ことの壁</span></p><p class="ps-aiflow__note">現場の熱量が伝わらない</p></li>
            <li class="ps-aiflow__card ps-aiflow__card--issue" style="--i:1"><span class="ps-aiflow__pill">課題 2</span><p class="ps-aiflow__title"><span class="ps-aiflow__main">進行と記録の<br>制約</span></p><p class="ps-aiflow__note">記録漏れ・分析の遅延</p></li>
            <li class="ps-aiflow__card ps-aiflow__card--ai is-off" style="--i:2"><span class="ps-aiflow__pill">AI</span><p class="ps-aiflow__title"><span class="ps-aiflow__sub">前例のない挑戦</span><span class="ps-aiflow__main">デモ・POCで<br>提案を重ねる</span></p><p class="ps-aiflow__note">二人三脚の粘り強い提案</p></li>
            <li class="ps-aiflow__card ps-aiflow__card--ai is-off" style="--i:3"><span class="ps-aiflow__pill">AI</span><p class="ps-aiflow__title"><span class="ps-aiflow__sub">導入後の変化</span><span class="ps-aiflow__main">解釈のブレが減り<br>意思決定の質が向上</span></p><p class="ps-aiflow__note">継続的なCS活動へ</p></li>
          </ol>
          <ul class="ps-aiflow__legend"><li class="ps-aiflow__legend-item ps-aiflow__legend-item--issue">従来の調査フェーズ</li><li class="ps-aiflow__legend-item ps-aiflow__legend-item--ai">AIプロダクト導入フェーズ</li></ul>
        </div>
      </div>
    </header>

    <!-- 対話の箱（1433:19309）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 02</p>
        <h3 class="ps-question__title">実査そのものにも、課題があったそうですね。</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/career-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">K.H</span></p>
            <div class="ps-speech__text">
              <p>はい。モデレーション自体は外部パートナーにお願いしているのですが、私は進行のフォローという立場で実査に立ち会いながら、並行して記録も残していました。ただこれも、物理的な限界があります。対話の流れを注視しながら記録に意識を割かれると、重要な発言の温度感を書き漏らしてしまうかもしれない、という不安が常につきまとっていました。デプスインタビューは、対象者の発言をその場でどれだけ深掘りできるかが勝負なので、記録という制約が実査全体の質に影響していたと思います。<br>さらにその先の分析工程でも、膨大な発言内容を整理・要約するのに多大な時間がかかり、調査結果を次のアクションへ反映するスピードがボトルネックになっていました。せっかく良いインサイトが拾えても、意思決定に活かされるまでにタイムラグが生じてしまう状態です。</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>

  <!-- ===== Chapter 03（1433:19314） ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head">
      <p class="ps-chapter__num"><small>Chapter</small><b>03</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title">前例のない挑戦：<br>専門部署とともに重ねた、デモとPOC</h2>
      <p class="ps-hint u-sp" aria-hidden="true">横にスクロールして全ステップを見る<span class="ps-hint__icon"><span class="ps-hint__line"></span><img src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
      <div class="ps-chart ps-chapter__chart">
        <div class="ps-aiflow">
          <p class="ps-aiflow__head"><span>ここからAIプロダクトの提案</span></p>
          <ol class="ps-aiflow__cards">
            <li class="ps-aiflow__card ps-aiflow__card--issue is-off" style="--i:0"><span class="ps-aiflow__pill">課題 1</span><p class="ps-aiflow__title"><span class="ps-aiflow__main">立ち会えない<br>ことの壁</span></p><p class="ps-aiflow__note">現場の熱量が伝わらない</p></li>
            <li class="ps-aiflow__card ps-aiflow__card--issue is-off" style="--i:1"><span class="ps-aiflow__pill">課題 2</span><p class="ps-aiflow__title"><span class="ps-aiflow__main">進行と記録の<br>制約</span></p><p class="ps-aiflow__note">記録漏れ・分析の遅延</p></li>
            <li class="ps-aiflow__card ps-aiflow__card--ai" style="--i:2"><span class="ps-aiflow__pill">AI</span><p class="ps-aiflow__title"><span class="ps-aiflow__sub">前例のない挑戦</span><span class="ps-aiflow__main">デモ・POCで<br>提案を重ねる</span></p><p class="ps-aiflow__note">二人三脚の粘り強い提案</p></li>
            <li class="ps-aiflow__card ps-aiflow__card--ai is-off" style="--i:3"><span class="ps-aiflow__pill">AI</span><p class="ps-aiflow__title"><span class="ps-aiflow__sub">導入後の変化</span><span class="ps-aiflow__main">解釈のブレが減り<br>意思決定の質が向上</span></p><p class="ps-aiflow__note">継続的なCS活動へ</p></li>
          </ol>
          <ul class="ps-aiflow__legend"><li class="ps-aiflow__legend-item ps-aiflow__legend-item--issue">従来の調査フェーズ</li><li class="ps-aiflow__legend-item ps-aiflow__legend-item--ai">AIプロダクト導入フェーズ</li></ul>
        </div>
      </div>
    </header>

    <!-- 対話の箱（1433:19337）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 03</p>
        <h3 class="ps-question__title">そこで、どのようなAIプロダクトを提案されたのですか。</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/career-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">K.H</span></p>
            <div class="ps-speech__text">
              <p>定性調査の録画・文字起こし・サマリー生成を自動化するAIプロダクトです。これを全てのデプスインタビューに組み込んでもらうことを提案しました。ただ、このクライアントにとってはもちろん、私たちにとっても前例のない取り組みだったので、簡単には進みませんでした。正直、実査の現場感覚には自信があっても、テクノロジーをどう提案すればクライアントに響くのか、私一人ではわからない部分も多かったんです。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/career-1/avatar_02.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">新価値創造部</span><span class="ps-speech__name">Y.S</span></p>
            <div class="ps-speech__text">
              <p>そこで、私たち新価値創造部の出番でした。K.Hさんが持っている「このクライアントの調査をもっと良くしたい」という現場の解像度と、私たちが持っているプロダクトやテクノロジー活用の知見を掛け合わせる形で、先方のマネージャーや現場責任者に対して、デモや過去の活用事例、導入後のイメージ、そしてPOCという形で、粘り強く提案を重ねていきました。K.Hさんと二人三脚で、何度もその場を設けてもらったのを覚えています。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/career-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">K.H</span></p>
            <div class="ps-speech__text">
              <p>特に評価していただけたのは3点でした。1つは、テキストのレポートだけでは表現しきれない発言のニュアンスや表情の温度感まで、動画で共有できるということ。2つ目は、サマリーを実査終了直後のラップアップの場でそのまま画面投影して活用できるという、実務に即した使い方です。</p>
              <p>そして3つ目が、サマリーそのものの質でした。このクライアントは以前、汎用の生成AIを使って調査の要約を試したことがあったそうなんですが、角が取れて丸くなったような当たり障りのないまとめしかできず、活用しづらいと感じていたそうです。そこで私たちが提案したのは、人間のリサーチャーが実際に分析するときの手順や思考のプロセスに沿ってサマリーを生成するという点でした。具体的には、注目すべき発言をピックアップして付箋化し、KJ法的にグルーピングした上で、最後に横断的に分析する——という流れです。この分析プロセスに沿ったサマリーが出てくることで、質の面での懸念が払拭されたのも大きかったと思います。「これなら日々の調査運用の中に無理なく組み込める」と実感していただけたことが、本格導入への決め手になったと思います。一人で提案していたら、ここまで説得力のある形にはできなかったと思います。</p>
            </div>
            <figure class="ps-speech__img" style="--w:464;--h:288"><img src="<?php echo ni_img( 'story/career-1/ch03_01.jpg' ); ?>" alt="AIプロダクトの画面（インタビュー動画・文字起こし・ブックマークされたセグメント・個票サマリー）" width="928" height="575" loading="lazy"></figure>
          </div>
        </div>
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/career-1/avatar_02.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">新価値創造部</span><span class="ps-speech__name">Y.S</span></p>
            <div class="ps-speech__text">
              <p>私はカスタマーサクセスの立場として、この提案活動にずっと同行していました。単発の提案で終わらせず、先方の反応を見ながら訴求ポイントを調整し続けたことが、最終的な合意につながったと思っています。</p>
            </div>
          </div>
        </div>
      </div>
      <div class="ps-question">
        <p class="ps-question__label">Question 04</p>
        <h3 class="ps-question__title">本格導入が決まってからは、それで完了だったのでしょうか。</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/career-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">K.H</span></p>
            <div class="ps-speech__text">
              <p>いえ、そこからが本当の意味でのスタートでした。このクライアントのデプスインタビューにとって、どんな切り口でサマリーを作るのが一番使いやすいか——発言をそのまま時系列で並べるのか、テーマ別に整理するのか——というところまで、プロンプトの設計に踏み込んで詰めていきました。ここも、Y.Sさんたち新価値創造部と何度もすり合わせながら進めた部分です。実査の現場感覚と、プロダクトへの理解、その両方がないと詰めきれない作業でした。</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>

  <!-- ===== Chapter 04（1433:19398） ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head">
      <p class="ps-chapter__num"><small>Chapter</small><b>04</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title">導入後の変化：<br>解釈のブレが減り、意思決定の質が上がる</h2>
      <p class="ps-hint u-sp" aria-hidden="true">横にスクロールして全ステップを見る<span class="ps-hint__icon"><span class="ps-hint__line"></span><img src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
      <div class="ps-chart ps-chapter__chart">
        <div class="ps-aiflow">
          <p class="ps-aiflow__head"><span>ここからAIプロダクトの提案</span></p>
          <ol class="ps-aiflow__cards">
            <li class="ps-aiflow__card ps-aiflow__card--issue is-off" style="--i:0"><span class="ps-aiflow__pill">課題 1</span><p class="ps-aiflow__title"><span class="ps-aiflow__main">立ち会えない<br>ことの壁</span></p><p class="ps-aiflow__note">現場の熱量が伝わらない</p></li>
            <li class="ps-aiflow__card ps-aiflow__card--issue is-off" style="--i:1"><span class="ps-aiflow__pill">課題 2</span><p class="ps-aiflow__title"><span class="ps-aiflow__main">進行と記録の<br>制約</span></p><p class="ps-aiflow__note">記録漏れ・分析の遅延</p></li>
            <li class="ps-aiflow__card ps-aiflow__card--ai is-off" style="--i:2"><span class="ps-aiflow__pill">AI</span><p class="ps-aiflow__title"><span class="ps-aiflow__sub">前例のない挑戦</span><span class="ps-aiflow__main">デモ・POCで<br>提案を重ねる</span></p><p class="ps-aiflow__note">二人三脚の粘り強い提案</p></li>
            <li class="ps-aiflow__card ps-aiflow__card--ai" style="--i:3"><span class="ps-aiflow__pill">AI</span><p class="ps-aiflow__title"><span class="ps-aiflow__sub">導入後の変化</span><span class="ps-aiflow__main">解釈のブレが減り<br>意思決定の質が向上</span></p><p class="ps-aiflow__note">継続的なCS活動へ</p></li>
          </ol>
          <ul class="ps-aiflow__legend"><li class="ps-aiflow__legend-item ps-aiflow__legend-item--issue">従来の調査フェーズ</li><li class="ps-aiflow__legend-item ps-aiflow__legend-item--ai">AIプロダクト導入フェーズ</li></ul>
        </div>
      </div>
    </header>

    <!-- 対話の箱（1433:19422）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 05</p>
        <h3 class="ps-question__title">導入後、現場にはどんな変化がありましたか。</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/career-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">K.H</span></p>
            <div class="ps-speech__text">
              <p>まず、実査に立ち会えなかったメンバーも、動画・文字起こし・サマリーをシステム上でいつでも見返せるようになりました。参加者と不参加者の解像度の差がなくなり、全員が同じ土台で議論できるようになったのは大きな変化です。記録作業からも解放されたので、私自身は進行のフォローに専念できるようになり、実査の質そのものも上がったと感じています。テクノロジーに置き換わったのは記録という作業であって、対象者と向き合う時間そのものは、むしろ濃くなった感覚があります。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/career-1/avatar_02.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">新価値創造部</span><span class="ps-speech__name">Y.S</span></p>
            <div class="ps-speech__text">
              <p>クライアントからは、人による調査結果や発言の解釈のブレが減って、意思決定の質そのものが高まった、という声もいただきましたよね。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/career-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">K.H</span></p>
            <div class="ps-speech__text">
              <p>そうですね。例えば「買いたい」という発言ひとつとっても、前のめりに言った「買いたい」なのか、場の空気を読んだお世辞に近い「買いたい」なのか——その温度感をスピーディに確認できるようになったのは大きかったです。以前は、担当者の主観的な印象に頼らざるを得なかった部分ですから。さらに、サマリーは一度作って終わりではなく、後から様々な切り口で見直すことができます。会議の場で新しい論点が出たときに、その場でサマリーを見返して別の角度から解釈し直す、ということが自然にできるようになりました。結果として、議論そのものが以前より深くなったと感じています。</p>
            </div>
          </div>
        </div>
      </div>
      <div class="ps-question">
        <p class="ps-question__label">Question 06</p>
        <h3 class="ps-question__title">導入後も、継続的な取り組みをされているそうですね。</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/career-1/avatar_02.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">新価値創造部</span><span class="ps-speech__name">Y.S</span></p>
            <div class="ps-speech__text">
              <p>はい。本格導入がゴールではなく、そこからがカスタマーサクセスとしての本番だと思っています。定期的にサービスの改善状況をお伝えしたり、他社での活用事例を共有したりしながら、このクライアントにとって「もっとこう使えるのではないか」という提案を続けています。活用度を上げていただくこと自体も大事なのですが、その先も見据えています。デプスインタビューを重ねるほど、サマリーや文字起こしのデータもクライアントの中に蓄積されていくので、次はそのたまったデータをAIでどう活用していくか、という提案につなげていきたいと考えています。単発の実査の効率化で終わらせず、データが積み上がった先に何ができるかまで見据えて動く——そこが、このプロジェクトに継続的に関わる意味だと思っています。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/career-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">K.H</span></p>
            <div class="ps-speech__text">
              <p>実査の現場を担う私と、その先の活用を考えるY.Sさんが両輪で動けているのは、このクライアントとの関係が長く続いている理由の一つだと思います。正直、実査のことしか見えていなかった自分が、新しい技術をここまでクライアントに提案できたのは、Y.Sさんたち専門部署が伴走してくれたからです。一人だったら、きっとここまでたどり着けませんでした。中途で入った身としても、対面調査ならではの丁寧さを削ることなく、AIのような新しい技術にも臆せず取り組めるのは、この会社ならではだと感じています。一社のクライアントにここまで深く入り込ませてもらえるからこそブランドへの理解も深まり、次にどんな提案ができるかの引き出しも自然と増えていく実感があります。</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Project Result（1433:19428）: 箱から縦線でつながる青い帯 -->
    <div class="ps-result">
      <h2 class="ps-result__title">Project Result</h2>
      <div class="ps-result__txt">
        <p>対面・オンライン双方のデプスインタビューにAIプロダクトを組み込んだことで、実査の記録負荷と分析工数という2つのボトルネックを同時に解消。前例のない導入を、リサーチ・ディレクション部と新価値創造部の二人三脚による粘り強い提案活動で実現させたことで、発言の温度感を伴った解釈が可能になり、人による解釈のブレが減って意思決定の質が向上した。現在も継続的な活用提案を通じて定着が進んでおり、蓄積されたデータをどう次の意思決定に活かすか、という新たな提案にもつなげている。</p>
      </div>
    </div>
  </article>

  <!-- ===== ディレクターからのメッセージ（1433:19435） ===== -->
  <section class="lower-sec ps-message">
    <div class="sec-head sec-head--sub ps-message__head">
      <p class="sec-head__label u-grd-text">From the Director</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap"><span>ディレクターからの<br class="u-pc">メッセージ</span></h2>
      </div>
    </div>
    <div class="ps-message__txt">
      <p>定性調査は、対面でしか掴めない熱量がある仕事です。そのリアルさを、テクノロジーの力で確かなものに変えていきたいと思っています。この提案は私一人ではなく、専門部署と手を組んだからこそ実現できました。一社に深く入り込み続けるからこそ、次の提案の引き出しも育っていく——それも、この仕事ならではの成長の形だと思います。</p>
    </div>
  </section>
