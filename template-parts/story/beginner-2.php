<?php
/**
 * プロジェクトストーリー 新卒・中途未経験 #02（固定ページ /beginner/story-2/）の <main> の中身
 *
 * page-story-2.php から読み込む。文言・画像は固定（Figma 1433:18875 のまま。WP の投稿内容は出していない）。
 * 3 ページ（beginner-1 / beginner-2 / career-1）は同じ部品・同じマークアップで、文言・図・章の数だけが違う。見た目は assets/css/story.css。
 */
?>

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱）。パンくずは Figma どおり 2 階層（親の TOP は挟まない） -->
  <div class="page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">プロジェクトストーリー #02</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">Project Story</p>
      <p class="page-head__jp">プロジェクトストーリー</p>
    </div>
  </div>

  <!-- ===== タイトル（1433:18880）: 四隅カッコの枠に 番号 + タイトル + リード、その下に流れる英字 ===== -->
  <div class="ps-intro">
    <div class="lower-sec">
      <div class="ps-intro__box bracket">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <p class="ps-intro__num"><small>#</small><b>02</b></p>
        <h1 class="ps-intro__title">検証を重ねるほど、答えは形になっていった。<br class="u-pc">クライアントと磨き上げたリニューアルプロジェクト</h1>
        <p class="ps-intro__lead">大手日用品メーカーの主力商品リニューアルにおける容器デザイン開発。<br class="u-pc">複数回のCLTを重ねた約8ヶ月間のプロジェクトを、3名のメンバーが語ります。</p>
      </div>
    </div>
    <p class="ps-marquee u-en" aria-hidden="true"><span class="ps-marquee__track"><span>Real Projects, Real Insights</span><span>Real Projects, Real Insights</span><span>Real Projects, Real Insights</span><span>Real Projects, Real Insights</span></span></p>
  </div>

  <!-- ===== Story Overview / Member / Before After（1433:18896 の親） ===== -->
  <section class="lower-sec ps-overview">
    <div class="ps-overview__row">
      <h2 class="ps-heading">Story<br class="u-pc"> Overview</h2>
      <div class="ps-overview__txt">
        <p>日本インフォメーションは、日用品メーカーの主力商品リニューアルにあたり、「生活者に求められる容器の形状・色・質感を明らかにしたい」という依頼を受けた。</p>
        <p>担当したのは、リサーチ・ディレクション部のM.S、フィールドワークグループのA.O、NIマーケティング研究所のK.M。会場調査（CLT）を四段階にわたって重ね、デザイン案を絞り込んでいったプロジェクトを、3名が振り返る。</p>
      </div>
    </div>

    <!-- Member（block: コメント）。アバターは Figma のイラストを丸く切り出した画像 -->
    <div class="ps-members">
      <h2 class="ps-heading">Member</h2>
      <ul class="ps-members__list">
        <li class="ps-member">
          <img class="ps-member__img" src="<?php echo ni_img( 'story/beginner-2/avatar_01.png' ); ?>" alt="" width="88" height="88" loading="lazy">
          <div class="ps-member__body">
            <p class="ps-member__dept">リサーチ・ディレクション部</p>
            <p class="ps-member__name">M.S（新卒入社5年目・女性）</p>
            <p class="ps-member__bio">大学では経営学を専攻し、「ものづくりの現場に近い場所で働きたい」という思いから日本インフォメーションへ入社。日用品・食品メーカーを中心に担当しており、本プロジェクトでは調査設計からクライアントとのやり取りまで、全体のディレクションを担当。</p>
          </div>
        </li>
        <li class="ps-member">
          <img class="ps-member__img" src="<?php echo ni_img( 'story/beginner-2/avatar_02.png' ); ?>" alt="" width="88" height="88" loading="lazy">
          <div class="ps-member__body">
            <p class="ps-member__dept">フィールドワークグループ</p>
            <p class="ps-member__name">A.O（中途入社4年目・女性）</p>
            <p class="ps-member__bio">大学時代にマーケティングを学んだことをきっかけに、いつかその知識を活かせる仕事がしたいと考えるようになり転職。本プロジェクトでは、CLT会場の手配や当日の運営、サンプルの準備、調査員への指示出しまで、現場全般を担当。</p>
          </div>
        </li>
        <li class="ps-member">
          <img class="ps-member__img" src="<?php echo ni_img( 'story/beginner-2/avatar_03.png' ); ?>" alt="" width="88" height="88" loading="lazy">
          <div class="ps-member__body">
            <p class="ps-member__dept">NIマーケティング研究所</p>
            <p class="ps-member__name">K.M（新卒入社1年目・男性）</p>
            <p class="ps-member__bio">大学では統計学を専攻し、「データから消費者の本音を読み解きたい」と考え入社。本プロジェクトでは、CLTで得られたデータの集計・分析を担当し、速報値の算出から本納品までのスピーディーな対応を担当。</p>
          </div>
        </li>
      </ul>
    </div>

    <!-- Before / After（1433:27790） -->
    <div class="ps-ba">
      <div class="ps-ba__col ps-ba__col--before">
        <p class="ps-ba__head"><span class="ps-ba__label">調査前の状況</span><span class="ps-ba__en">Before</span></p>
        <ul class="ps-checks"><li>社内に候補案はあったが、消費者のリアルな反応を踏まえた意思決定が課題</li><li>ロングセラーブランドであるがゆえの、変えるべき部分の見極めの難しさ</li></ul>
      </div>
      <span class="ps-ba__arrow" aria-hidden="true"></span>
      <div class="ps-ba__col ps-ba__col--after">
        <p class="ps-ba__head"><span class="ps-ba__label">調査・提案後</span><span class="ps-ba__en">After</span></p>
        <ul class="ps-checks"><li>CLTを重ね、形状・質感・色・香り・ラベルコピーを検証</li><li>「従来の魅力＋新しさ」を体現した容器デザインが実現</li></ul>
      </div>
    </div>
  </section>

  <!-- ===== 調査の流れ（1433:18928）: 図は funnel-chart を HTML + CSS で組んだもの。章ではいまの工程だけを強調する ===== -->
  <section class="lower-sec ps-process">
    <div class="sec-head sec-head--sub ps-process__head">
      <p class="sec-head__label u-grd-text">Research Process</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">調査の流れ</h2>
      </div>
    </div>
    <!-- SP は図を横スクロールで見せる（案内の行は SP だけ） -->
    <p class="ps-hint u-sp" aria-hidden="true">横にスクロールして全ステップを見る<span class="ps-hint__icon"><span class="ps-hint__line"></span><img src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
    <div class="ps-chart">
      <div class="ps-funnel">
        <div class="ps-funnel__src"><p class="ps-funnel__src-label">複数案</p><ul class="ps-funnel__src-list"><li>案A</li><li>案B</li><li>案C</li></ul></div>
        <ol class="ps-funnel__steps">
          <li class="ps-funnel__step ps-funnel__step--1"><span class="ps-funnel__num">STEP01</span><p class="ps-funnel__title">複数デザイン案<br>からの候補選定</p></li>
          <li class="ps-funnel__step ps-funnel__step--2"><span class="ps-funnel__num">STEP02</span><p class="ps-funnel__title">形状・色・質感の<br>評価</p></li>
          <li class="ps-funnel__step ps-funnel__step--3"><span class="ps-funnel__num">STEP03</span><p class="ps-funnel__title">香り・カラー展開・<br>コピーの評価</p></li>
          <li class="ps-funnel__step ps-funnel__step--4"><span class="ps-funnel__num">STEP04</span><p class="ps-funnel__title">広告表現を含めた<br>最終評価</p></li>
        </ol>
        <p class="ps-funnel__goal">最終案</p>
      </div>
    </div>
  </section>

  <!-- ===== Chapter 01（1433:18944）: 図なし ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head ps-chapter__head--plain">
      <p class="ps-chapter__num"><small>Chapter</small><b>01</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title ps-chapter__title--single">生活者が「魅力的」と感じる容器デザインを探る</h2>
    </header>

    <!-- 対話の箱（1433:18967）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 01</p>
        <h3 class="ps-question__title">今回のプロジェクトは、クライアントからどのような依頼を受けて始まったのでしょうか？</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-2/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">M.S</span></p>
            <div class="ps-speech__text">
              <p>ご依頼をいただいたのは、あるメーカーの主力商品のリニューアルでした。中身の処方はある程度固まっていたうえで、「容器のデザインを刷新したい」というのが最初のご相談でした。長年愛されてきた商品だけに、変えていい部分と守るべき部分の線引きも難しい。どんな形状や質感の容器なら消費者に手に取ってもらえるのか、実際に会場で確かめたいという思いがクライアント側にも強くあったこともあり、一度きりの調査ではなく、CLTを複数回重ねながら少しずつ答えに近づいていく進め方で実施することになりました。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-2/avatar_02.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">フィールドワークグループ</span><span class="ps-speech__name">A.O</span></p>
            <div class="ps-speech__text">
              <p>この案件では、複数回CLTを実施しましたが各回ごとに検証したいポイントが異なります。だからこそ、会場のレイアウトや呈示の仕方も毎回同じというわけにはいかず、その回のテーマに合わせて最適な動線と呈示方法を準備していました。同じCLTという手法でも、回によって求められる工夫がまったく違うのだと、このプロジェクトを通じて実感しました。</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>

  <!-- ===== Chapter 02（1433:18976） ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head">
      <p class="ps-chapter__num"><small>Chapter</small><b>02</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title">候補を絞り込む：<br>数ある案の中に見えた、生活者の好み</h2>
      <p class="ps-hint u-sp" aria-hidden="true">横にスクロールして全ステップを見る<span class="ps-hint__icon"><span class="ps-hint__line"></span><img src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
      <div class="ps-chart ps-chapter__chart">
        <div class="ps-funnel ps-funnel--focus">
          <div class="ps-funnel__src is-on"><p class="ps-funnel__src-label">複数案</p><ul class="ps-funnel__src-list"><li>案A</li><li>案B</li><li>案C</li></ul></div>
          <ol class="ps-funnel__steps">
            <li class="ps-funnel__step ps-funnel__step--1 is-on"><span class="ps-funnel__num">STEP01</span><p class="ps-funnel__title">複数デザイン案<br>からの候補選定</p></li>
            <li class="ps-funnel__step ps-funnel__step--2"><span class="ps-funnel__num">STEP02</span><p class="ps-funnel__title">形状・色・質感の<br>評価</p></li>
            <li class="ps-funnel__step ps-funnel__step--3"><span class="ps-funnel__num">STEP03</span><p class="ps-funnel__title">香り・カラー展開・<br>コピーの評価</p></li>
            <li class="ps-funnel__step ps-funnel__step--4"><span class="ps-funnel__num">STEP04</span><p class="ps-funnel__title">広告表現を含めた<br>最終評価</p></li>
          </ol>
          <p class="ps-funnel__goal">最終案</p>
        </div>
      </div>
    </header>

    <!-- 対話の箱（1433:18999）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 02</p>
        <h3 class="ps-question__title">1回目のCLTでは、どのような目的をもって、どんな内容の検証を行ったのでしょうか？</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-2/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">M.S</span></p>
            <div class="ps-speech__text">
              <p>社内のデザインチームが用意した容器の案は、方向性もばらばらで、丸みのあるものからシャープなもの、素材感が異なるものまで幅広く揃っていました。そこで、これらすべてを会場に並べ、対象者一人ひとりにどの案を買いたいと思うか評価してもらいました。狙いは、この時点で良し悪しを一つに決めることではなく、「どんな方向性に票が集まりやすいのか」という大まかな傾向をつかむこと。数多くの案を一度に見てもらうからこそ見えてくる相対的な好みの分布があり、それが次の段階で案を絞り込むための、確かな土台になりました。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-2/avatar_03.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">NIマーケティング研究所</span><span class="ps-speech__name">K.M</span></p>
            <div class="ps-speech__text">
              <p>私は評価データの集計を担当しました。この回は候補案の数が多く、対象者ごとに見てもらう順番を入れ替えるローテーションも複雑だったので、どの評価がどの案に対するものなのか、回答データと評価対象がきちんと紐づいているかを丁寧に確認しながら集計を進めました。もし紐づけを誤ってしまうとクライアントの意思決定にも影響が及ぶため、集計の前段階でのチェックには特に神経を使いました。地道な作業ですが、この確認を丁寧に行ったからこそ、その後の判断材料となる正確なデータをお渡しできたのだと思っています。</p>
            </div>
            <figure class="ps-speech__img" style="--w:464;--h:348"><img src="<?php echo ni_img( 'story/beginner-2/ch02_01.jpg' ); ?>" alt="CLT 会場の様子（白いカーテンの衝立と、仕切り板を置いた長机が並ぶ会議室）" width="928" height="696" loading="lazy"></figure>
          </div>
        </div>
      </div>
    </div>
  </article>

  <!-- ===== Chapter 03（1433:19004） ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head">
      <p class="ps-chapter__num"><small>Chapter</small><b>03</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title">かたち・質感を検証：<br>見え方の違いが、印象を分ける</h2>
      <p class="ps-hint u-sp" aria-hidden="true">横にスクロールして全ステップを見る<span class="ps-hint__icon"><span class="ps-hint__line"></span><img src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
      <div class="ps-chart ps-chapter__chart">
        <div class="ps-funnel ps-funnel--focus">
          <div class="ps-funnel__src"><p class="ps-funnel__src-label">複数案</p><ul class="ps-funnel__src-list"><li>案A</li><li>案B</li><li>案C</li></ul></div>
          <ol class="ps-funnel__steps">
            <li class="ps-funnel__step ps-funnel__step--1"><span class="ps-funnel__num">STEP01</span><p class="ps-funnel__title">複数デザイン案<br>からの候補選定</p></li>
            <li class="ps-funnel__step ps-funnel__step--2 is-on"><span class="ps-funnel__num">STEP02</span><p class="ps-funnel__title">形状・色・質感の<br>評価</p></li>
            <li class="ps-funnel__step ps-funnel__step--3"><span class="ps-funnel__num">STEP03</span><p class="ps-funnel__title">香り・カラー展開・<br>コピーの評価</p></li>
            <li class="ps-funnel__step ps-funnel__step--4"><span class="ps-funnel__num">STEP04</span><p class="ps-funnel__title">広告表現を含めた<br>最終評価</p></li>
          </ol>
          <p class="ps-funnel__goal">最終案</p>
        </div>
      </div>
    </header>

    <!-- 対話の箱（1433:19027）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 03</p>
        <h3 class="ps-question__title">2回目のCLTでは、1回目の調査結果を受けて、さらにどのような検証を進めたのですか？</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-2/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">M.S</span></p>
            <div class="ps-speech__text">
              <p>1回目のCLTの結果をもとに、方向性の異なる2案にまで絞り込みました。ここからは、その2案それぞれについて、丸みを帯びた形状と角張った形状、なめらかな質感とざらつきのある質感など、細かいバリエーションを追加で用意して評価してもらう段階に入りました。さらに色の質感についても、マットやメタリック、ビビッドやポップといった複数パターンを並べ、形状・質感・色という三つの軸を同時に検証しました。組み合わせの数が一気に増えるので、会場での見せ方や順序にも工夫が必要でしたが、生活者の反応から「求められている方向性」がだんだん輪郭を帯びてきた回でもありました。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-2/avatar_02.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">フィールドワークグループ</span><span class="ps-speech__name">A.O</span></p>
            <div class="ps-speech__text">
              <p>この回は特に、クライアントの呈示物に対するこだわりが強く出た調査でした。容器の刷新は今回のリニューアルの中でも特に重視されていたポイントだったこともあり、棚の高さ一つにも細かい要望があり、当日会場で何度も調整を重ねました。事前に決めていた調査票にも、当日実際に棚やブースへ並べてみたときの見え方をもとに、その場で微調整が必要な部分があり、柔軟に対応する力がこれまで以上に求められた回だったと思います。細かい部分まで一緒に詰めていく中で、クライアントの「絶対に譲れない部分」を肌で理解できたのも、この調査ならではの経験でした。</p>
            </div>
            <figure class="ps-speech__img" style="--w:464;--h:261"><img src="<?php echo ni_img( 'story/beginner-2/ch03_01.jpg' ); ?>" alt="CLT 会場の様子（A・B・F・H・I などの記号を貼った仕切りつきの机が壁沿いに並ぶ会議室）" width="928" height="522" loading="lazy"></figure>
          </div>
        </div>
      </div>
      <div class="ps-question">
        <p class="ps-question__label">Question 04</p>
        <h3 class="ps-question__title">細かい要望に応えながら進めるうえで、現場では具体的にどのように工夫していたのですか？</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-2/avatar_02.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">フィールドワークグループ</span><span class="ps-speech__name">A.O</span></p>
            <div class="ps-speech__text">
              <p>決まったやり方をそのまま繰り返すのではなく、現場で急な変更や要望があっても柔軟に対応できるよう、事前の準備と心構えを整えて臨むようにしていました。たとえば棚のレイアウトも、パターンごとに毎回確認してもらい、少しでも気になる点があればその場で直せるよう、備品や時間に余裕を持たせておきました。最初は「そこまでやるのか」と感じることもありましたが、細部までこだわり抜いた結果として容器が生まれ変わるのだと思うと、一つひとつの調整にも意味があると思えるようになりました。回を重ねるごとに、クライアントとの間で「ここまで確認すれば安心」という感覚が共有できるようになっていったのも印象的でした。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-2/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">M.S</span></p>
            <div class="ps-speech__text">
              <p>A.Oさんが現場で細部まで丁寧に対応してくれたおかげで、クライアントの中に「この調査会社になら任せられる」という安心感が少しずつ生まれていったように思います。容器という目に見える部分は、良し悪しの基準が人によって分かれやすく、数字だけでは語りきれない部分も多くあります。だからこそ、現場での細かいやり取りの積み重ねが、最終的な意思決定への信頼につながっていくのだと、この調査を通して改めて感じました。ディレクションを担う立場としても、現場の判断を信頼して任せられることのありがたさを実感した回でした。</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>

  <!-- ===== Chapter 04（1433:19032） ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head">
      <p class="ps-chapter__num"><small>Chapter</small><b>04</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title">香り・色・コピーを検証：<br>多角的に確かめ、確度を高める</h2>
      <p class="ps-hint u-sp" aria-hidden="true">横にスクロールして全ステップを見る<span class="ps-hint__icon"><span class="ps-hint__line"></span><img src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
      <div class="ps-chart ps-chapter__chart">
        <div class="ps-funnel ps-funnel--focus">
          <div class="ps-funnel__src"><p class="ps-funnel__src-label">複数案</p><ul class="ps-funnel__src-list"><li>案A</li><li>案B</li><li>案C</li></ul></div>
          <ol class="ps-funnel__steps">
            <li class="ps-funnel__step ps-funnel__step--1"><span class="ps-funnel__num">STEP01</span><p class="ps-funnel__title">複数デザイン案<br>からの候補選定</p></li>
            <li class="ps-funnel__step ps-funnel__step--2"><span class="ps-funnel__num">STEP02</span><p class="ps-funnel__title">形状・色・質感の<br>評価</p></li>
            <li class="ps-funnel__step ps-funnel__step--3 is-on"><span class="ps-funnel__num">STEP03</span><p class="ps-funnel__title">香り・カラー展開・<br>コピーの評価</p></li>
            <li class="ps-funnel__step ps-funnel__step--4"><span class="ps-funnel__num">STEP04</span><p class="ps-funnel__title">広告表現を含めた<br>最終評価</p></li>
          </ol>
          <p class="ps-funnel__goal">最終案</p>
        </div>
      </div>
    </header>

    <!-- 対話の箱（1433:19055）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 05</p>
        <h3 class="ps-question__title">3回目のCLTでは、これまでとは違う要素も検証したと伺いました。具体的にはどんな内容ですか？</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-2/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">M.S</span></p>
            <div class="ps-speech__text">
              <p>2回目の調査で容器の形状・質感の方向性がある程度固まったので、3回目のCLTでは検証する要素を広げました。一つは香りの評価です。実際にいくつかの香りの試作品を用意し、会場でその場で嗅ぎ比べてもらいました。もう一つはカラーバリエーションの評価で、絞り込んだデザインを複数の色展開で見せ、どの組み合わせが売り場で選ばれやすいかを確認しました。さらに、容器本体に貼るラベルのデザインコピー案も複数用意し、どの表現が生活者にとって魅力的に映るかを聴取しました。香り・色・コピーと、一度に扱う要素が一気に増えた、密度の濃い回でした。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-2/avatar_03.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">NIマーケティング研究所</span><span class="ps-speech__name">K.M</span></p>
            <div class="ps-speech__text">
              <p>この回で特に大変だったのは、集計データをどれだけ早く形にできるかという点でした。香り・色・コピーと評価項目が増えた分、集計にも時間がかかりやすく、それでもクライアントからは速報性を求められていたので、集計部門と連携して、まずは主要な指標だけをまとめた速報を先に納品し、そのあとで詳細な分析を加えた本納品を行うという、二段構えの対応をとりました。限られた時間の中で何を優先して数字をまとめるべきか判断する感覚は、この案件を通じて大きく鍛えられたと感じていますし、入社1年目にしては責任の大きい役割を任せてもらえたことにも、大きなやりがいを感じました。</p>
            </div>
            <figure class="ps-speech__img" style="--w:464;--h:261"><img src="<?php echo ni_img( 'story/beginner-2/ch04_01.jpg' ); ?>" alt="CLT 会場の様子（H・I・J・K の記号を貼った白いカーテンの衝立が並ぶ）" width="928" height="522" loading="lazy"></figure>
          </div>
        </div>
      </div>
    </div>
  </article>

  <!-- ===== Chapter 05（1433:19060） ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head">
      <p class="ps-chapter__num"><small>Chapter</small><b>05</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title">広告表現込みの最終チェック：<br>呈示への妥協なきこだわりに応える</h2>
      <p class="ps-hint u-sp" aria-hidden="true">横にスクロールして全ステップを見る<span class="ps-hint__icon"><span class="ps-hint__line"></span><img src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
      <div class="ps-chart ps-chapter__chart">
        <div class="ps-funnel ps-funnel--focus">
          <div class="ps-funnel__src"><p class="ps-funnel__src-label">複数案</p><ul class="ps-funnel__src-list"><li>案A</li><li>案B</li><li>案C</li></ul></div>
          <ol class="ps-funnel__steps">
            <li class="ps-funnel__step ps-funnel__step--1"><span class="ps-funnel__num">STEP01</span><p class="ps-funnel__title">複数デザイン案<br>からの候補選定</p></li>
            <li class="ps-funnel__step ps-funnel__step--2"><span class="ps-funnel__num">STEP02</span><p class="ps-funnel__title">形状・色・質感の<br>評価</p></li>
            <li class="ps-funnel__step ps-funnel__step--3"><span class="ps-funnel__num">STEP03</span><p class="ps-funnel__title">香り・カラー展開・<br>コピーの評価</p></li>
            <li class="ps-funnel__step ps-funnel__step--4 is-on"><span class="ps-funnel__num">STEP04</span><p class="ps-funnel__title">広告表現を含めた<br>最終評価</p></li>
          </ol>
          <p class="ps-funnel__goal is-on">最終案</p>
        </div>
      </div>
    </header>

    <!-- 対話の箱（1433:19083）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 06</p>
        <h3 class="ps-question__title">最終段階となるモック評価では、クライアントからどのような要望があったのでしょうか？</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-2/avatar_02.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">フィールドワークグループ</span><span class="ps-speech__name">A.O</span></p>
            <div class="ps-speech__text">
              <p>4回目のCLTは、実際に容器とラベルのモックを作成した上で、最終的な見栄えを評価してもらう回でした。ここでもクライアントの呈示物へのこだわりは強く、むしろ最終判断の場だからこそ、これまで以上に細かい要望が出ました。棚に並べたときの見え方はもちろん、ラベルの向き、隣り合う案との間隔や照明の当たり方まで、少しの違いが印象を左右するという考えのもと、当日会場で何度も並べ方を調整しました。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-2/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">M.S</span></p>
            <div class="ps-speech__text">
              <p>この調査では、CLTのあとに対象者へミニインタビューを行うことになっていました。数字だけでは拾いきれない、容器を手に取った瞬間の細かなニュアンスを聞きたいという狙いがあったからです。クライアントが思い描くターゲット像に近い方から話を聞けるよう、どのような条件で対象者を絞り込むかを具体的に設計して提案しました。この提案に対してクライアントから「それいいですね」と言っていただけたときは、単なる調査の実施者ではなく、一緒に作り上げていくパートナーとして見てもらえた気がして、とても嬉しかったのを覚えています。</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>

  <!-- ===== Chapter 06（1433:19088）: 図なし ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head ps-chapter__head--plain">
      <p class="ps-chapter__num"><small>Chapter</small><b>06</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title ps-chapter__title--single">生活者と、クライアントと、一緒に作り上げた容器</h2>
    </header>

    <!-- 対話の箱（1433:19112）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 07</p>
        <h3 class="ps-question__title">全4回にわたるCLTを終えて、このプロジェクトでやりがいを感じた瞬間を教えてください。</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-2/avatar_02.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">フィールドワークグループ</span><span class="ps-speech__name">A.O</span></p>
            <div class="ps-speech__text">
              <p>今回のCLTを通じて印象に残っているのは、最初はばらばらだった形状や質感の案が、会場を重ねるたびに少しずつ一つの答えへと近づいていくのを、一番近くで見届けられたことです。候補が絞り込まれ、質感や色のバリエーションが磨かれていく過程で、棚の高さやラベルの向きといった細かい調整の一つひとつが、最終的な「これだ」という形につながっていく手応えがありました。地道な準備の積み重ねにもちゃんと意味があったんだと実感できましたし、フィールドワークという仕事の面白さを改めて感じられた瞬間でもありました。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-2/avatar_03.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">NIマーケティング研究所</span><span class="ps-speech__name">K.M</span></p>
            <div class="ps-speech__text">
              <p>私はまだ入社1年目で、最初は集計作業を正確にこなすだけで精一杯でした。それでも、自分がまとめたデータが、どの案を残すか・どの方向性に進むかという意思決定にそのまま使われていくのを見て、「自分が扱っている数字の先に、こんな意思決定があるんだ」と実感できたのが大きかったです。特に3回目の調査での速報対応は責任も大きく緊張しましたが、地味に見える集計の仕事も、プロジェクト全体で見ると容器のかたちを決める大事な一歩を担っているんだと感じられるようになり、それが今の仕事へのモチベーションにもつながっています。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-2/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">M.S</span></p>
            <div class="ps-speech__text">
              <p>主力商品のリニューアルという、会社にとって大きな決断に最初から携われたことは、自分にとって貴重な経験でした。クライアントの皆さんもとてもフランクな方々で、「一緒につくっている」という感覚を持ちながら進められたのも印象的です。何度も重ねたCLTの結果が、そのままクライアントの意思決定に採用され、リニューアルが正式に決まったと聞いたときは、本当に嬉しかったですね。一つのアイデアが、生活者の声を通して確かな形になっていく——その過程にメンバーと一緒に立ち会えることこそ、この仕事の一番の面白さだと思っています。</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Project Result（1433:19118）: 箱から縦線でつながる青い帯 -->
    <div class="ps-result">
      <h2 class="ps-result__title">Project Result</h2>
      <div class="ps-result__txt">
        <p>複数回のCLTを重ねて磨き上げたデザイン案は、発売後の店頭でも高い視認性を実現し、昔からの魅力はそのままに、新しさが感じられるデザインとして好意的な声が寄せられている。クライアントの担当者からも「消費者と一緒につくった容器」という手応えの言葉があり、調査で得られた知見がそのまま容器リニューアルの意思決定に反映されたプロジェクトとなった。</p>
      </div>
    </div>
  </article>

  <!-- ===== ディレクターからのメッセージ（1433:19125） ===== -->
  <section class="lower-sec ps-message">
    <div class="sec-head sec-head--sub ps-message__head">
      <p class="sec-head__label u-grd-text">From the Director</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap"><span>ディレクターからの<br class="u-pc">メッセージ</span></h2>
      </div>
    </div>
    <div class="ps-message__txt">
      <p>この仕事の楽しいところは、商品の開発やリニューアルの中で、何度も調査を重ねながら案を磨き上げ、実際に商品化して店頭に並ぶ過程に、クライアントと一緒に立ち会えることだと思います。「良い」と思ったデザインが、本当に消費者に届くとは限らない——だからこそ検証を重ねる意味があり、その一回一回に、一緒につくっている実感があります。</p>
      <p>容器のように、生活者自身も言葉にしにくい「好み」を扱うテーマだからこそ、最初から正解が見えているわけではありません。それでも、クライアントと同じ目線に立ちながら、何度も検証を重ねて一緒に答えを探していく——この仕事のやりがいは、まさにそのプロセスにあると思っています。</p>
    </div>
  </section>
