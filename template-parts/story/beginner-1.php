<?php
/**
 * プロジェクトストーリー 新卒・中途未経験 #01（固定ページ /beginner/story-1/）の <main> の中身
 *
 * page-story-1.php から読み込む。文言・画像は固定（Figma 1433:18565 のまま。WP の投稿内容は出していない）。
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

  <!-- ===== タイトル（1433:18570）: 四隅カッコの枠に 番号 + タイトル + リード、その下に流れる英字 ===== -->
  <div class="ps-intro">
    <div class="lower-sec">
      <div class="ps-intro__box bracket">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <p class="ps-intro__num"><small>#</small><b>01</b></p>
        <h1 class="ps-intro__title">消費者の声を、ヒット商品につなげるまで。<br class="u-pc">ニーズ探索から試作品評価まで、<br class="u-pc">新商品開発に伴走したプロジェクト</h1>
        <p class="ps-intro__lead">大手食品メーカーの調味料カテゴリーにおける新商品開発プロジェクト。<br class="u-pc">ニーズ探索からコンセプト評価、試作品のテストまで一貫して伴走し、のちにヒット商品となった実例を、3名のメンバーが語ります。</p>
      </div>
    </div>
    <p class="ps-marquee u-en" aria-hidden="true"><span class="ps-marquee__track"><span>Real Projects, Real Insights</span><span>Real Projects, Real Insights</span><span>Real Projects, Real Insights</span><span>Real Projects, Real Insights</span></span></p>
  </div>

  <!-- ===== Story Overview / Member / Before After（1433:18586 の親） ===== -->
  <section class="lower-sec ps-overview">
    <div class="ps-overview__row">
      <h2 class="ps-heading">Story<br class="u-pc"> Overview</h2>
      <div class="ps-overview__txt">
        <p>日本インフォメーションは、大手食品メーカーが手がける調味料カテゴリーの新商品開発にあたり、「消費者ニーズの探索から商品化まで、一貫して伴走してほしい」という依頼を受けた。</p>
        <p>担当したのは、リサーチ・ディレクション部のY.N、インターネットリサーチグループのK.Y、フィールドワークグループのS.K。ニーズ探索のインターネット調査から、コンセプト評価、試食調査、パッケージ調査まで、マーケティングプロセスの一連の流れに沿ってリサーチを実施したプロジェクトを、3名が振り返る。</p>
      </div>
    </div>

    <!-- Member（block: コメント）。アバターは Figma のイラストを丸く切り出した画像 -->
    <div class="ps-members">
      <h2 class="ps-heading">Member</h2>
      <ul class="ps-members__list">
        <li class="ps-member">
          <img class="ps-member__img" src="<?php echo ni_img( 'story/beginner-1/avatar_01.png' ); ?>" alt="" width="88" height="88" loading="lazy">
          <div class="ps-member__body">
            <p class="ps-member__dept">リサーチ・ディレクション部</p>
            <p class="ps-member__name">Y.N（中途入社7年目・男性）</p>
            <p class="ps-member__bio">前職は調査会社で「クライアントの意思決定に、もっと近い場所で関わりたい」と思い日本インフォメーションへ入社。食品・日用品メーカーを中心に担当しており、本プロジェクトでは調査の設計からクライアントとのやり取りまで、全体を見ている役割。</p>
          </div>
        </li>
        <li class="ps-member">
          <img class="ps-member__img" src="<?php echo ni_img( 'story/beginner-1/avatar_02.png' ); ?>" alt="" width="88" height="88" loading="lazy">
          <div class="ps-member__body">
            <p class="ps-member__dept">インターネットリサーチグループ</p>
            <p class="ps-member__name">K.Y（新卒入社1年目・女性）</p>
            <p class="ps-member__bio">大学では心理学を専攻し、「人の行動の裏にある理由を探りたい」という思いで日本インフォメーションに入社。本プロジェクトでは、ニーズ探索調査における調査画面の作成や、調査の配信・回収状況の管理を担当。</p>
          </div>
        </li>
        <li class="ps-member">
          <img class="ps-member__img" src="<?php echo ni_img( 'story/beginner-1/avatar_03.png' ); ?>" alt="" width="88" height="88" loading="lazy">
          <div class="ps-member__body">
            <p class="ps-member__dept">フィールドワークグループ</p>
            <p class="ps-member__name">S.K（中途入社3年目・男性）</p>
            <p class="ps-member__bio">前職はリサーチとは全く異なる業界で、「マーケティングに携わりたい」という思いで日本インフォメーションへ入社。本プロジェクトでは試食調査とパッケージ調査の運営全般を担当し、対象者の手配から試食品の準備、調査員への指示出しまでを担った。</p>
          </div>
        </li>
      </ul>
    </div>

    <!-- Before / After（1433:27724） -->
    <div class="ps-ba">
      <div class="ps-ba__col ps-ba__col--before">
        <p class="ps-ba__head"><span class="ps-ba__label">調査前の状況</span><span class="ps-ba__en">Before</span></p>
        <ul class="ps-checks"><li>消費者ニーズの捉え方を模索している状態</li><li>試作品を同一条件で提供する難しさ、味の再現に苦戦</li><li>ヒット商品がなかなか生まれない状況</li></ul>
      </div>
      <span class="ps-ba__arrow" aria-hidden="true"></span>
      <div class="ps-ba__col ps-ba__col--after">
        <p class="ps-ba__head"><span class="ps-ba__label">調査・提案後</span><span class="ps-ba__en">After</span></p>
        <ul class="ps-checks"><li>「不」を集めるリサーチによって、需要度の高い商品コンセプトを構築</li><li>リハーサルで細かくチェックし、条件を揃えて提供できる体制を構築</li><li>発売後にヒットし、カテゴリー内で高いシェアを獲得</li></ul>
      </div>
    </div>
  </section>

  <!-- ===== 調査の流れ（1433:18618）: 図は timeline-chart を HTML + CSS で組んだもの。章ではいまの工程だけを強調する ===== -->
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
      <ol class="ps-timeline">
        <li class="ps-timeline__step ps-timeline__step--top" style="--i:0"><div class="ps-timeline__card"><p class="ps-timeline__title">消費者ニーズの把握<br>消費者の生活実態把握</p><p class="ps-timeline__tag">インターネットリサーチ</p></div></li>
        <li class="ps-timeline__step ps-timeline__step--bottom" style="--i:1"><div class="ps-timeline__card"><p class="ps-timeline__title">商品アイデア・<br>コンセプト評価</p><p class="ps-timeline__tag">インターネットリサーチ</p></div></li>
        <li class="ps-timeline__step ps-timeline__step--top" style="--i:2"><div class="ps-timeline__card"><p class="ps-timeline__title">プロダクト評価</p><p class="ps-timeline__tag">会場調査（CLT）</p></div></li>
        <li class="ps-timeline__step ps-timeline__step--bottom" style="--i:3"><div class="ps-timeline__card"><p class="ps-timeline__title">商品パッケージ評価<br>需要把握</p><p class="ps-timeline__tag">会場調査（CLT）</p></div></li>
        <li class="ps-timeline__goal">
          <p class="ps-timeline__mark">発売</p>
          <div class="ps-timeline__after">
            <p class="ps-timeline__after-title">発売後もリサーチを実施</p>
            <ul class="ps-checks"><li>購入実態の把握</li><li>初期購入者の満足点</li><li>広告効果の測定</li><li>売上不振の理由把握、等</li></ul>
          </div>
        </li>
      </ol>
    </div>
  </section>

  <!-- ===== Chapter 01（1433:18634） ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head">
      <p class="ps-chapter__num"><small>Chapter</small><b>01</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title">ニーズ探索：<br>チャット形式の調査で「不」を拾い上げる</h2>
      <p class="ps-hint u-sp" aria-hidden="true">横にスクロールして全ステップを見る<span class="ps-hint__icon"><span class="ps-hint__line"></span><img src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
      <div class="ps-chart ps-chapter__chart">
        <ol class="ps-timeline ps-timeline--focus">
          <li class="ps-timeline__step ps-timeline__step--top" style="--i:0"><div class="ps-timeline__card"><p class="ps-timeline__title">消費者ニーズの把握<br>消費者の生活実態把握</p><p class="ps-timeline__tag">インターネットリサーチ</p></div></li>
          <li class="ps-timeline__step ps-timeline__step--bottom is-off" style="--i:1"><div class="ps-timeline__card"><p class="ps-timeline__title">商品アイデア・<br>コンセプト評価</p><p class="ps-timeline__tag">インターネットリサーチ</p></div></li>
          <li class="ps-timeline__step ps-timeline__step--top is-off" style="--i:2"><div class="ps-timeline__card"><p class="ps-timeline__title">プロダクト評価</p><p class="ps-timeline__tag">会場調査（CLT）</p></div></li>
          <li class="ps-timeline__step ps-timeline__step--bottom is-off" style="--i:3"><div class="ps-timeline__card"><p class="ps-timeline__title">商品パッケージ評価<br>需要把握</p><p class="ps-timeline__tag">会場調査（CLT）</p></div></li>
          <li class="ps-timeline__goal is-off">
            <p class="ps-timeline__mark">発売</p>
            <div class="ps-timeline__after">
              <p class="ps-timeline__after-title">発売後もリサーチを実施</p>
              <ul class="ps-checks"><li>購入実態の把握</li><li>初期購入者の満足点</li><li>広告効果の測定</li><li>売上不振の理由把握、等</li></ul>
            </div>
          </li>
        </ol>
      </div>
    </header>

    <!-- 対話の箱（1433:18657）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 01</p>
        <h3 class="ps-question__title">プロジェクトの最初の一歩は、どんな調査から始まりましたか？</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">Y.N</span></p>
            <div class="ps-speech__text">
              <p>最初に取り組んだのは、「そもそも生活者は、このカテゴリーの商品にどんな実態や不満を抱えているのか」を洗い出すことでした。まだ商品コンセプトも何もない段階だったので、先入観を持たずにニーズを拾い上げる設計が大事だと考えて、今回は1問1答形式のいわゆる普通のアンケートではなく、チャット形式で生活者が「不」を感じた瞬間ごとに回答できるリサーチツールを使うことを提案しました。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_02.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">インターネットリサーチグループ</span><span class="ps-speech__name">K.Y</span></p>
            <div class="ps-speech__text">
              <p>私はその調査画面の作成と、配信・回収状況の管理を担当しました。チャット形式なので、回答者の言葉でリアルな不満や要望が集まるのが面白いところです。想定していなかった「不」の声がたくさん集まってきたときは、「この形式にした意味があったんだな」と感じました。正直、入社したばかりの頃は「アンケートって選択肢を並べるだけじゃないの？」と思っていたので、こんなに色々なやり方があるんだと驚いた記憶があります。</p>
            </div>
            <figure class="ps-speech__img" style="--w:312;--h:330"><img src="<?php echo ni_img( 'story/beginner-1/ch01_01.png' ); ?>" alt="チャット形式の調査画面（質問と回答の吹き出しが並ぶ画面）" width="625" height="660" loading="lazy"></figure>
          </div>
        </div>
      </div>
    </div>
  </article>

  <!-- ===== Chapter 02（1433:18666） ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head">
      <p class="ps-chapter__num"><small>Chapter</small><b>02</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title">コンセプト評価：<br>需要と受容性を、数字で検証する</h2>
      <p class="ps-hint u-sp" aria-hidden="true">横にスクロールして全ステップを見る<span class="ps-hint__icon"><span class="ps-hint__line"></span><img src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
      <div class="ps-chart ps-chapter__chart">
        <ol class="ps-timeline ps-timeline--focus">
          <li class="ps-timeline__step ps-timeline__step--top is-off" style="--i:0"><div class="ps-timeline__card"><p class="ps-timeline__title">消費者ニーズの把握<br>消費者の生活実態把握</p><p class="ps-timeline__tag">インターネットリサーチ</p></div></li>
          <li class="ps-timeline__step ps-timeline__step--bottom" style="--i:1"><div class="ps-timeline__card"><p class="ps-timeline__title">商品アイデア・<br>コンセプト評価</p><p class="ps-timeline__tag">インターネットリサーチ</p></div></li>
          <li class="ps-timeline__step ps-timeline__step--top is-off" style="--i:2"><div class="ps-timeline__card"><p class="ps-timeline__title">プロダクト評価</p><p class="ps-timeline__tag">会場調査（CLT）</p></div></li>
          <li class="ps-timeline__step ps-timeline__step--bottom is-off" style="--i:3"><div class="ps-timeline__card"><p class="ps-timeline__title">商品パッケージ評価<br>需要把握</p><p class="ps-timeline__tag">会場調査（CLT）</p></div></li>
          <li class="ps-timeline__goal is-off">
            <p class="ps-timeline__mark">発売</p>
            <div class="ps-timeline__after">
              <p class="ps-timeline__after-title">発売後もリサーチを実施</p>
              <ul class="ps-checks"><li>購入実態の把握</li><li>初期購入者の満足点</li><li>広告効果の測定</li><li>売上不振の理由把握、等</li></ul>
            </div>
          </li>
        </ol>
      </div>
    </header>

    <!-- 対話の箱（1433:18689）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 02</p>
        <h3 class="ps-question__title">ニーズ探索の結果は、どう活かされましたか？</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">Y.N</span></p>
            <div class="ps-speech__text">
              <p>ニーズ探索の結果をもとに、いくつかの商品コンセプト案を作り、もう一度インターネットリサーチでコンセプト評価を行いました。結果は、需要度・受容性ともに一定の水準をクリアするもの。クライアントの商品開発チームからも「これなら次のフェーズの調査に進みたい」という話になりました。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_02.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">インターネットリサーチグループ</span><span class="ps-speech__name">K.Y</span></p>
            <div class="ps-speech__text">
              <p>私はここでも、調査画面の作成と配信のコントロールを担当していました。コンセプト案ごとの評価がはっきり数字に出て、それが次のフェーズに進むかどうかの判断材料になったと聞いたときは、自分たちが用意した画面がちゃんと役に立ったんだと実感できました。商品化されたら世間の反応はどうなるのだろうと期待も膨らんでいました。</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>

  <!-- ===== Chapter 03（1433:18694） ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head">
      <p class="ps-chapter__num"><small>Chapter</small><b>03</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title">試作品評価：<br>味の壁を、検証の繰り返しで越える</h2>
      <p class="ps-hint u-sp" aria-hidden="true">横にスクロールして全ステップを見る<span class="ps-hint__icon"><span class="ps-hint__line"></span><img src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
      <div class="ps-chart ps-chapter__chart">
        <ol class="ps-timeline ps-timeline--focus">
          <li class="ps-timeline__step ps-timeline__step--top is-off" style="--i:0"><div class="ps-timeline__card"><p class="ps-timeline__title">消費者ニーズの把握<br>消費者の生活実態把握</p><p class="ps-timeline__tag">インターネットリサーチ</p></div></li>
          <li class="ps-timeline__step ps-timeline__step--bottom is-off" style="--i:1"><div class="ps-timeline__card"><p class="ps-timeline__title">商品アイデア・<br>コンセプト評価</p><p class="ps-timeline__tag">インターネットリサーチ</p></div></li>
          <li class="ps-timeline__step ps-timeline__step--top" style="--i:2"><div class="ps-timeline__card"><p class="ps-timeline__title">プロダクト評価</p><p class="ps-timeline__tag">会場調査（CLT）</p></div></li>
          <li class="ps-timeline__step ps-timeline__step--bottom is-off" style="--i:3"><div class="ps-timeline__card"><p class="ps-timeline__title">商品パッケージ評価<br>需要把握</p><p class="ps-timeline__tag">会場調査（CLT）</p></div></li>
          <li class="ps-timeline__goal is-off">
            <p class="ps-timeline__mark">発売</p>
            <div class="ps-timeline__after">
              <p class="ps-timeline__after-title">発売後もリサーチを実施</p>
              <ul class="ps-checks"><li>購入実態の把握</li><li>初期購入者の満足点</li><li>広告効果の測定</li><li>売上不振の理由把握、等</li></ul>
            </div>
          </li>
        </ol>
      </div>
    </header>

    <!-- 対話の箱（1433:18717）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 03</p>
        <h3 class="ps-question__title">試食調査では、どんな結果が出ましたか？</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">Y.N</span></p>
            <div class="ps-speech__text">
              <p>コンセプト評価で見えてきた方向性をもとに、クライアントに試作品を用意してもらい、会場での試食調査を行うことになりました。ところが、いざ実際に食べてもらうと、味の評価が思っていたほど伸びなかったんです。「コンセプトへの期待は高いのに、味では選ばれない」——ここで初めて、このプロジェクトの本当の壁にぶつかりました。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_03.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">フィールドワークグループ</span><span class="ps-speech__name">S.K</span></p>
            <div class="ps-speech__text">
              <p>一度の調査で終わらせず、クライアントの製品開発チームが試作品を作り直し、それをまた会場で評価してもらう、というサイクルを何度も繰り返しました。地域によって味の感じ方に差が出ることもあるので、東京と大阪の2会場で実施して、両方の反応を見ながら方向性を絞り込んでいきました。</p>
            </div>
          </div>
        </div>
      </div>
      <div class="ps-question">
        <p class="ps-question__label">Question 04</p>
        <h3 class="ps-question__title">繰り返しの試食調査で、特に大切にしたことはありますか？</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_03.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">フィールドワークグループ</span><span class="ps-speech__name">S.K</span></p>
            <div class="ps-speech__text">
              <p>一つは、調査の条件をそろえることです。食材の大きさや切り方一つで、口に入れたときの印象が変わってしまうので、試作品ごとに材料の切り方・分量・提供温度まで数値で決めて、東京・大阪どちらの会場でも同じ条件で提供できるように、調査員向けの指示書に落とし込みました。もう一つは、前日のリハーサルです。事前にクライアントから預かっていたレシピ通りに作っても、会場の機材や条件によっては同じ状態で再現できないことが意外と多いんです。だから毎回、Y.Nさんとクライアントの担当者にも入ってもらって、実際にレシピ通りに仕上げてみる場を設けていました。</p>
            </div>
            <figure class="ps-speech__img" style="--w:464;--h:261"><img src="<?php echo ni_img( 'story/beginner-1/ch03_01.jpg' ); ?>" alt="試食調査の会場に並べた調理器具（カセットコンロ・鍋・フライパンなど）" width="928" height="522" loading="lazy"></figure>
          </div>
        </div>
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">Y.N</span></p>
            <div class="ps-speech__text">
              <p>S.Kさんが話したような懸念点をその場で一つひとつ潰しておくことで、本番の調査でクライアントが安心して結果を受け止められるようになるんです。「調査を届ける」というより、「調査を一緒につくる」という感覚に近いかもしれません。試食調査を重ねるたびに、コンセプトはそのままに、味だけを着実に磨き込んでいけた実感がありました。</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>

  <!-- ===== Chapter 04（1433:18722） ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head">
      <p class="ps-chapter__num"><small>Chapter</small><b>04</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title">パッケージ調査：<br>店頭で選ばれるための、もう一つの検証</h2>
      <p class="ps-hint u-sp" aria-hidden="true">横にスクロールして全ステップを見る<span class="ps-hint__icon"><span class="ps-hint__line"></span><img src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
      <div class="ps-chart ps-chapter__chart">
        <ol class="ps-timeline ps-timeline--focus">
          <li class="ps-timeline__step ps-timeline__step--top is-off" style="--i:0"><div class="ps-timeline__card"><p class="ps-timeline__title">消費者ニーズの把握<br>消費者の生活実態把握</p><p class="ps-timeline__tag">インターネットリサーチ</p></div></li>
          <li class="ps-timeline__step ps-timeline__step--bottom is-off" style="--i:1"><div class="ps-timeline__card"><p class="ps-timeline__title">商品アイデア・<br>コンセプト評価</p><p class="ps-timeline__tag">インターネットリサーチ</p></div></li>
          <li class="ps-timeline__step ps-timeline__step--top is-off" style="--i:2"><div class="ps-timeline__card"><p class="ps-timeline__title">プロダクト評価</p><p class="ps-timeline__tag">会場調査（CLT）</p></div></li>
          <li class="ps-timeline__step ps-timeline__step--bottom" style="--i:3"><div class="ps-timeline__card"><p class="ps-timeline__title">商品パッケージ評価<br>需要把握</p><p class="ps-timeline__tag">会場調査（CLT）</p></div></li>
          <li class="ps-timeline__goal is-off">
            <p class="ps-timeline__mark">発売</p>
            <div class="ps-timeline__after">
              <p class="ps-timeline__after-title">発売後もリサーチを実施</p>
              <ul class="ps-checks"><li>購入実態の把握</li><li>初期購入者の満足点</li><li>広告効果の測定</li><li>売上不振の理由把握、等</li></ul>
            </div>
          </li>
        </ol>
      </div>
    </header>

    <!-- 対話の箱（1433:18745）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 05</p>
        <h3 class="ps-question__title">パッケージ調査では、どんなことを確認しましたか？</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">Y.N</span></p>
            <div class="ps-speech__text">
              <p>試作品の方向性が固まった後は、パッケージ案についても会場調査で確認しました。中身の味だけでなく、お店の棚で実際に手に取ってもらえるかどうかも、新商品にとっては同じくらい大事な要素です。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_03.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">フィールドワークグループ</span><span class="ps-speech__name">S.K</span></p>
            <div class="ps-speech__text">
              <p>試食調査と同じく会場での実査という点は共通していましたが、パッケージ調査では実物のサンプルを何案か並べて反応を見るというところが違いました。試食調査の運営で身につけた会場の準備や対象者への案内を、そのまま活かせた調査でしたね。</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>

  <!-- ===== Chapter 05（1433:18750） ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head">
      <p class="ps-chapter__num"><small>Chapter</small><b>05</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title">発売後調査：<br>ヒットしてからも、伴走は続く</h2>
      <p class="ps-hint u-sp" aria-hidden="true">横にスクロールして全ステップを見る<span class="ps-hint__icon"><span class="ps-hint__line"></span><img src="<?php echo ni_img( 'development/scroll_hand.svg' ); ?>" alt="" width="16" height="31"></span></p>
      <div class="ps-chart ps-chapter__chart">
        <ol class="ps-timeline ps-timeline--focus">
          <li class="ps-timeline__step ps-timeline__step--top is-off" style="--i:0"><div class="ps-timeline__card"><p class="ps-timeline__title">消費者ニーズの把握<br>消費者の生活実態把握</p><p class="ps-timeline__tag">インターネットリサーチ</p></div></li>
          <li class="ps-timeline__step ps-timeline__step--bottom is-off" style="--i:1"><div class="ps-timeline__card"><p class="ps-timeline__title">商品アイデア・<br>コンセプト評価</p><p class="ps-timeline__tag">インターネットリサーチ</p></div></li>
          <li class="ps-timeline__step ps-timeline__step--top is-off" style="--i:2"><div class="ps-timeline__card"><p class="ps-timeline__title">プロダクト評価</p><p class="ps-timeline__tag">会場調査（CLT）</p></div></li>
          <li class="ps-timeline__step ps-timeline__step--bottom is-off" style="--i:3"><div class="ps-timeline__card"><p class="ps-timeline__title">商品パッケージ評価<br>需要把握</p><p class="ps-timeline__tag">会場調査（CLT）</p></div></li>
          <li class="ps-timeline__goal">
            <p class="ps-timeline__mark">発売</p>
            <div class="ps-timeline__after">
              <p class="ps-timeline__after-title">発売後もリサーチを実施</p>
              <ul class="ps-checks"><li>購入実態の把握</li><li>初期購入者の満足点</li><li>広告効果の測定</li><li>売上不振の理由把握、等</li></ul>
            </div>
          </li>
        </ol>
      </div>
    </header>

    <!-- 対話の箱（1433:18773）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 06</p>
        <h3 class="ps-question__title">商品が発売された後も、リサーチは続いたのでしょうか？</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">Y.N</span></p>
            <div class="ps-speech__text">
              <p>発売して終わり、ではありません。発売後も購入実態や満足度、売上の動向をインターネットリサーチで継続的に追いかけていました。「売れているかどうか」だけでなく、「なぜ売れているのか」「初期に買ってくれた人はどこに満足しているのか」まで見えると、次の商品展開の話にもつながっていきます。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_03.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">フィールドワークグループ</span><span class="ps-speech__name">S.K</span></p>
            <div class="ps-speech__text">
              <p>発売後の調査は、私にとっても新鮮でした。ニーズ探索の頃から関わっていた調査が、実際に店頭に並んだ商品の評価につながっていくのを、画面の向こう側の数字として見届けられるので。良い結果が出たときはもちろん嬉しいですし、思ったより伸びていない項目があれば、それも次の改善のヒントになります。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">Y.N</span></p>
            <div class="ps-speech__text">
              <p>実際、このプロジェクトでは発売後の調査結果を踏まえて、翌期には同じカテゴリーの別ブランドについても声をかけてもらいました。一度きりの調査で終わらず、発売後も伴走し続けることが、次のお仕事につながっていく——それを実感できた案件でした。</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>

  <!-- ===== Chapter 06（1433:18778）: 図なし ===== -->
  <article class="lower-sec ps-chapter">
    <header class="ps-chapter__head ps-chapter__head--plain">
      <p class="ps-chapter__num"><small>Chapter</small><b>06</b></p>
      <span class="ps-chapter__line" aria-hidden="true"></span>
      <h2 class="ps-chapter__title ps-chapter__title--single">商品開発に、最後まで伴走するという仕事</h2>
    </header>

    <!-- 対話の箱（1433:18802）: 質問 + 吹き出し。--left = アイコンが左、--right = 右 -->
    <div class="ps-talk">
      <div class="ps-question">
        <p class="ps-question__label">Question 07</p>
        <h3 class="ps-question__title">このプロジェクトを通じて、やりがいを感じた瞬間を教えてください。</h3>
      </div>
      <div class="ps-talk__list">
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_03.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">フィールドワークグループ</span><span class="ps-speech__name">S.K</span></p>
            <div class="ps-speech__text">
              <p>試食調査の会場で、調査票を検票しているときに目にした自由記述の一文が印象に残っています。「店頭で売られていたら絶対買いたい」と書かれているのを見つけたときです。自分が手配した材料と、自分が組んだ当日の段取りの先に、こういう生の反応があったんだと思うと、地味な準備の積み重ねにもちゃんと意味があったんだなと感じました。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--right">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_02.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">インターネットリサーチグループ</span><span class="ps-speech__name">K.Y</span></p>
            <div class="ps-speech__text">
              <p>私はまだ入社1年目で、最初は画面の作成や配信の管理といった、目の前の作業をこなすだけで精一杯でした。でも、自分が関わった調査の結果が、コンセプトの絞り込みや試作品の方向性にそのまま使われていくのを見て、「自分が触っていた画面の先に、こんな意思決定があるんだ」と実感できたのが大きかったです。</p>
            </div>
          </div>
        </div>
        <div class="ps-speech ps-speech--left">
          <img class="ps-speech__avatar" src="<?php echo ni_img( 'story/beginner-1/avatar_01.png' ); ?>" alt="" width="48" height="48" loading="lazy">
          <div class="ps-speech__bubble">
            <p class="ps-speech__who"><span class="ps-speech__dept">リサーチ・ディレクション部</span><span class="ps-speech__name">Y.N</span></p>
            <div class="ps-speech__text">
              <p>日本インフォメーションの仕事の面白いところは、まさにこの「最後まで一緒にいられる」ところだと思っています。ニーズ探索だけ、コンセプト評価だけ、といった単発の調査で終わるのではなく、そこからの試作品評価、パッケージ調査、発売後のトラッキングまで、商品が生まれて育っていく過程にずっと関わることができる。リサーチャーって裏方の仕事に見えるかもしれませんが、実は商品開発の意思決定の、かなり近くにいる仕事なんです。</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Project Result（1433:18808）: 箱から縦線でつながる青い帯 -->
    <div class="ps-result">
      <h2 class="ps-result__title">Project Result</h2>
      <div class="ps-result__txt">
        <p>消費者のインサイトを形にしたコンセプトと、何度も試行錯誤を繰り返した試食調査で見えた改善点を反映した新商品は、発売後、想定を上回るペースで売れ行きを伸ばし、カテゴリー内でのシリーズ売上上位に食い込む結果となった。発売後もリサーチは継続しており、購入実態や満足度のトラッキングを通じて、次の商品展開の検討にもつながっている。</p>
      </div>
    </div>
  </article>

  <!-- ===== ディレクターからのメッセージ（1433:18815） ===== -->
  <section class="lower-sec ps-message">
    <div class="sec-head sec-head--sub ps-message__head">
      <p class="sec-head__label u-grd-text">From the Director</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap"><span>ディレクターからの<br class="u-pc">メッセージ</span></h2>
      </div>
    </div>
    <div class="ps-message__txt">
      <p>この仕事の面白いところは、マーケティングの一つのフェーズだけでなく、川上のニーズ探索から川下の発売後調査まで、幅広く支援できるところにあると思っています。今回のプロジェクトのように、生活者が何に困っているのかを探るところから、コンセプトの検証、試作品の評価、パッケージの検証、発売後のトラッキングまで、一つの調査会社がここまで一気通貫で関われるケースは、業界の中でも珍しいのではないでしょうか。</p>
      <p>私たちが向き合っているのは、いずれも業界を代表するような大手メーカーで、その新商品開発の意思決定に、リサーチという立場から深く関わらせてもらえています。これは、まだ経験の浅いメンバーであっても変わりません。自分が担当した調査の結果が、商品開発の方向性を左右することもある——それだけ影響力の大きい仕事に早いうちから携われるのが、この仕事の魅力だと思います。</p>
      <p>新商品がヒットするかどうかは、正直、誰にも保証できません。それでも、生活者の声を丁寧に拾って、根拠を持って提案して、商品が世の中に出ていく過程にマーケティングの上流から下流まで立ち会える——それが、この仕事の一番の醍醐味だと思っています。</p>
    </div>
  </section>
