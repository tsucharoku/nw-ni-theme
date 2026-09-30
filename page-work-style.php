<?php
/**
 * 制度・環境（固定ページ /work-style/）
 *
 * 静的 HTML（HTML/work-style/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => '制度・環境｜日本インフォメーション株式会社 採用情報サイト',
		'description' => 'フルフレックス・在宅・ワーケーションなどの働き方、福利厚生、社内コミュニケーション・表彰制度、成長・キャリアを支える制度まで。日本インフォメーションの制度・環境をご紹介します。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <img class="page-head__ni" src="<?php echo ni_img( 'lower/pagehead_ni.png' ); ?>" alt="" width="988" height="936">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">制度・環境</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">Work<br class="u-sp"> Environment<br> &amp; Benefits</p>
      <h1 class="page-head__jp">制度・環境</h1>
    </div>
    <p class="page-head__read">フルフレックス・在宅・ワーケーション…。日本インフォメーションでは、ライフスタイルに合わせて柔軟に働ける仕組みを整えています。<br class="u-pc">充実した研修制度と福利厚生で、長く活躍できる環境をサポートします。</p>
  </div>

  <!-- ===== Culture（557:13147 / SP 1140:14536） ===== -->
  <section class="lower-sec ws-sec ws-sec--first">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Culture</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">日本インフォメーションのカルチャー</h2>
        <p class="sec-head__read">制度や環境の前に、私たち日本インフォメーションという会社が大切にしている文化をご紹介します。</p>
      </div>
    </div>
    <ul class="ws-culture">
      <li class="ws-culture__item">
        <span class="ws-culture__icon"><img src="<?php echo ni_img( 'work-style/icon_01.svg' ); ?>" alt="" width="40" height="40"></span>
        <h3 class="ws-culture__title">リサーチの専門家を目指し<br>切磋琢磨できる環境</h3>
        <p class="ws-culture__body">クライアントの約9割が大手メーカーのマーケティング・リサーチ部署。高い水準の相手に「信頼されるリサーチャー」として認められることを目指し、互いに高め合える環境があります。</p>
      </li>
      <li class="ws-culture__item">
        <span class="ws-culture__icon"><img src="<?php echo ni_img( 'work-style/icon_02.svg' ); ?>" alt="" width="40" height="40"></span>
        <h3 class="ws-culture__title">新しい手法への<br>チャレンジ精神が豊富</h3>
        <p class="ws-culture__body">変化への対応やクライアントへの新提案のため、新しいリサーチ手法の開発を積極的に実施。AIツール開発など、アイデアは社員のボトムアップから生まれることも多いです。</p>
      </li>
      <li class="ws-culture__item">
        <span class="ws-culture__icon"><img src="<?php echo ni_img( 'work-style/icon_03.svg' ); ?>" alt="" width="40" height="40"></span>
        <h3 class="ws-culture__title">コミュニケーション活発で<br>働きやすい風土</h3>
        <p class="ws-culture__body">部署間連携が求められる業務のため、社内コミュニケーションを重視。フラットで風通しよく、業務外も含めてコミュニケーションが活発な職場環境です。</p>
      </li>
    </ul>
  </section>

  <!-- ===== Work Style（557:13156 / SP 1140:14542） ===== -->
  <section class="lower-sec ws-sec">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Work Style</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">働き方</h2>
        <p class="sec-head__read">コアタイムなし、在宅OK、ワーケーションも可。実際に制度を使っている社員の声とともに紹介します。</p>
      </div>
    </div>
    <ul class="ws-flex-list">
      <li class="ws-flex">
        <div class="ws-flex__head">
          <span class="ws-flex__icon"><img src="<?php echo ni_img( 'work-style/icon_04.svg' ); ?>" alt="" width="40" height="40"></span>
          <h3 class="ws-flex__title">フルフレックス勤務制度</h3>
          <p class="ws-flex__body">コアタイムなし。5:00〜22:00の間で自由に勤務時間を設定できます。繁忙期は早めに動いて早帰り、納品後は遅めスタートにするなど、仕事の波に合わせて自分でコントロールできるのが特徴です。</p>
        </div>
        <div class="ws-flex__voice">
          <p class="ws-flex__voice-label">実際に使っている社員の声</p>
          <p class="ws-flex__voice-who">リサーチャー・入社4年目（子育て中）</p>
          <p class="ws-flex__voice-quote">"保育園の送り迎えに合わせて9時〜17時半で働いています。繁忙期は朝7時半から始めて調整できるので、子どもとの時間を犠牲にせず仕事と両立できています。"</p>
          <span class="ws-flex__voice-photo"><img src="<?php echo ni_img( 'work-style/voice_avatar.jpg' ); ?>" alt="" width="264" height="264" loading="lazy"></span>
        </div>
      </li>
      <li class="ws-flex">
        <div class="ws-flex__head">
          <span class="ws-flex__icon"><img src="<?php echo ni_img( 'work-style/icon_05.svg' ); ?>" alt="" width="40" height="40"></span>
          <h3 class="ws-flex__title">在宅・リモートオフィス勤務</h3>
          <p class="ws-flex__body">通勤ラッシュを避けて、自宅や近隣のリモートオフィスでの勤務が可能。在宅手当（月5,000円）も支給されるため、通信費・光熱費の心配なく活用できます。</p>
        </div>
        <div class="ws-flex__voice">
          <p class="ws-flex__voice-label">実際に使っている社員の声</p>
          <p class="ws-flex__voice-who">ディレクター・入社6年目</p>
          <p class="ws-flex__voice-quote">"集中作業は在宅、チームのすり合わせがある日は出社、と使い分けています。片道1時間の通勤がなくなった分、朝の時間を読書や勉強に使えるようになりました。"</p>
          <span class="ws-flex__voice-photo"><img src="<?php echo ni_img( 'work-style/voice_avatar.jpg' ); ?>" alt="" width="264" height="264" loading="lazy"></span>
        </div>
      </li>
    </ul>
    <ul class="icon-cards icon-cards--4">
      <li class="icon-card">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_06.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">ワーケーション制度</h3>
          <p class="icon-card__body">旅先でも業務PCで仕事OK。旅行と仕事を組み合わせた長期休暇の取得が可能です。</p>
        </div>
      </li>
      <li class="icon-card">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_07.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">時短・出社日数制限勤務</h3>
          <p class="icon-card__body">育児・介護など生活の変化に合わせて、勤務時間・日数を柔軟に設定できます。</p>
        </div>
      </li>
      <li class="icon-card">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_08.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">遠隔地勤務制度</h3>
          <p class="icon-card__body">やむを得ず遠方に居住する場合も、承認を経て在宅勤務で継続就業が可能です。</p>
        </div>
      </li>
      <li class="icon-card">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_09.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">有給休暇奨励日</h3>
          <p class="icon-card__body">年6〜7日の奨励日を設定・社外公表。全員が取得しやすい文化を推進しています。(※年度によって変動します)</p>
        </div>
      </li>
    </ul>
  </section>

  <!-- ===== Benefits（562:14074 / SP 1140:14553）。金額の行は PC のみ（SP のデザインに無い） ===== -->
  <section class="lower-sec ws-sec">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Benefits</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">福利厚生・健康サポート</h2>
        <p class="sec-head__read">働きやすさを支える手当・補助・健康サポートを整えています。</p>
      </div>
    </div>
    <ul class="icon-cards icon-cards--3">
      <li class="icon-card icon-card--amount">
        <span class="icon-card__icon icon-card__icon--s"><img src="<?php echo ni_img( 'work-style/icon_10.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title"><span class="icon-card__sub">在宅勤務手当</span><span class="icon-card__amount">月5,000円</span></h3>
          <p class="icon-card__body">通信費や光熱費の負担軽減のため、月5,000円の在宅勤務手当が支給されます。</p>
        </div>
      </li>
      <li class="icon-card icon-card--amount">
        <span class="icon-card__icon icon-card__icon--s"><img src="<?php echo ni_img( 'work-style/icon_11.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title"><span class="icon-card__sub">住宅手当制度</span><span class="icon-card__amount">最大30,000円/月</span></h3>
          <p class="icon-card__body">30歳未満の一定条件に該当する社員に住宅補助手当を支給。生活の安定を支えます。</p>
        </div>
      </li>
      <li class="icon-card icon-card--amount">
        <span class="icon-card__icon icon-card__icon--s"><img src="<?php echo ni_img( 'work-style/icon_12.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title"><span class="icon-card__sub">スポーツクラブ・各種優待</span><span class="icon-card__amount">充実の福利厚生優待サービス</span></h3>
          <p class="icon-card__body">スポーツクラブをはじめ、映画鑑賞・旅行など多彩な優待サービスが利用可能です。</p>
        </div>
      </li>
      <li class="icon-card icon-card--amount">
        <span class="icon-card__icon icon-card__icon--s"><img src="<?php echo ni_img( 'work-style/icon_13.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title"><span class="icon-card__sub">定期健康診断・インフルエンザ予防接種補助</span><span class="icon-card__amount">年1回・一部補助</span></h3>
          <p class="icon-card__body">年1回の定期健康診断に加え、インフルエンザワクチン費用を会社が補助。心身ともに万全なパフォーマンスを維持できるようサポートします。</p>
        </div>
      </li>
      <li class="icon-card icon-card--amount">
        <span class="icon-card__icon icon-card__icon--s"><img src="<?php echo ni_img( 'work-style/icon_14.svg' ); ?>" alt="" width="40" height="34"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title"><span class="icon-card__sub">軽食（スナックミーオフィス）</span><span class="icon-card__amount">無料</span></h3>
          <p class="icon-card__body">ラウンジに体にやさしい無料軽食を用意。人工甘味料・保存料・合成着色料不使用のこだわりのスナックです。</p>
        </div>
      </li>
      <li class="icon-card icon-card--amount">
        <span class="icon-card__icon icon-card__icon--s"><img src="<?php echo ni_img( 'work-style/icon_15.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title"><span class="icon-card__sub">ハラスメント相談窓口</span><span class="icon-card__amount">社内・社外（社労士）2窓口設置</span></h3>
          <p class="icon-card__body">社内担当者と社外（社会保険労務士）それぞれに相談窓口を設置。安心して働ける環境を整えています。</p>
        </div>
      </li>
      <li class="icon-card icon-card--amount">
        <span class="icon-card__icon icon-card__icon--s"><img src="<?php echo ni_img( 'work-style/icon_16.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title"><span class="icon-card__sub">社内イベント</span><span class="icon-card__amount">BBQ・季節のイベント</span></h3>
          <p class="icon-card__body">季節ごとに社員が集まるイベントを開催。仕事を離れて仲間と楽しむ時間が、チームの絆を深めます。</p>
        </div>
      </li>
    </ul>
  </section>

  <!-- ===== 写真の帯（Autocarousel 1069:14885 / SP 1140:14564）。work-style.js が複製して CSS で流す ===== -->
  <div class="photo-marquee" aria-hidden="true">
    <ul class="photo-marquee__track js-photo-marquee">
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_01.jpg' ); ?>" alt="" width="900" height="675" loading="lazy"></li>
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_02.jpg' ); ?>" alt="" width="900" height="506" loading="lazy"></li>
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_03.jpg' ); ?>" alt="" width="900" height="674" loading="lazy"></li>
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_04.jpg' ); ?>" alt="" width="900" height="675" loading="lazy"></li>
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_05.jpg' ); ?>" alt="" width="900" height="506" loading="lazy"></li>
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_06.jpg' ); ?>" alt="" width="675" height="900" loading="lazy"></li>
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_07.jpg' ); ?>" alt="" width="675" height="900" loading="lazy"></li>
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_08.jpg' ); ?>" alt="" width="900" height="506" loading="lazy"></li>
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_09.jpg' ); ?>" alt="" width="900" height="675" loading="lazy"></li>
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_10.jpg' ); ?>" alt="" width="900" height="675" loading="lazy"></li>
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_11.jpg' ); ?>" alt="" width="900" height="506" loading="lazy"></li>
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_12.jpg' ); ?>" alt="" width="900" height="506" loading="lazy"></li>
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_13.jpg' ); ?>" alt="" width="675" height="900" loading="lazy"></li>
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_14.jpg' ); ?>" alt="" width="900" height="506" loading="lazy"></li>
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_15.jpg' ); ?>" alt="" width="675" height="900" loading="lazy"></li>
      <li class="photo-marquee__item"><img src="<?php echo ni_img( 'work-style/gallery_16.jpg' ); ?>" alt="" width="900" height="506" loading="lazy"></li>
    </ul>
  </div>

  <!-- ===== Communication（562:14272 / SP 1140:14566） ===== -->
  <section class="ws-sec ws-comm">
    <div class="lower-sec">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Communication</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">社内コミュニケーション・表彰制度</h2>
        <p class="sec-head__read">日本インフォメーションには、<br class="u-pc">仲間との接点を自然に増やすための制度と、がんばりをきちんと称える表彰制度があります。<br class="u-pc">どんな場面で活きているか、エピソードとともにご紹介します。</p>
      </div>
    </div>
    </div>
    <!-- 付箋 1370:17451: 中央 1 枚 → 背後のカードが左右に広がる → カルーセル（work-style.js）。SP は縦積み -->
    <div class="arc-cards js-arc-cards">
    <ul class="arc-cards__stage">
      <li class="arc-card">
        <div class="arc-card__inner bracket">
          <span class="bracket__corner bracket__corner--tl"></span><span class="bracket__corner bracket__corner--tr"></span><span class="bracket__corner bracket__corner--bl"></span><span class="bracket__corner bracket__corner--br"></span>
          <p class="arc-card__pill"><span>🏆 MVP賞 / 敢闘賞 / ベストサンクス賞</span></p>
          <div class="arc-card__photo"><img src="<?php echo ni_img( 'work-style/comm_award.jpg' ); ?>" alt="" width="1200" height="676" loading="lazy"></div>
          <h3 class="arc-card__catch">全員が見ている場所で、名前を呼ばれる瞬間。</h3>
          <p class="arc-card__body">半期ごとの社員総会（キックオフ）は、全社が同じ場所に集まる、年に2回の「全社の文化祭」。各部署の行動計画発表や経営方針の共有だけでなく、MVP・敢闘賞・ベストサンクス賞などの表彰も行われます。<br>大勢の仲間の前で名前を呼ばれる経験は、「頑張ったことが伝わっている」という実感につながります。</p>
        </div>
      </li>
      <li class="arc-card">
        <div class="arc-card__inner bracket">
          <span class="bracket__corner bracket__corner--tl"></span><span class="bracket__corner bracket__corner--tr"></span><span class="bracket__corner bracket__corner--bl"></span><span class="bracket__corner bracket__corner--br"></span>
          <p class="arc-card__pill"><span>💌 サンクスカード制度</span></p>
          <div class="arc-card__photo"><img src="<?php echo ni_img( 'work-style/comm_thanks.jpg' ); ?>" alt="" width="1200" height="800" loading="lazy"></div>
          <h3 class="arc-card__catch">「ありがとう」を、言葉にして渡せる場所。</h3>
          <p class="arc-card__body">「先日の資料、助かりました」「フォローしてくれてありがとう」——そんな気持ちをカードに書いて渡すのが、日本インフォメーションのサンクスカード文化。感謝は声に出さないと伝わらないけれど、面と向かって言うのが照れくさいことも。カードという「形」があることで、伝えやすくなります。多くのカードを集めた社員は「ベストサンクス賞」として全社で称えられる仕組みをとっています。</p>
        </div>
      </li>
      <li class="arc-card">
        <div class="arc-card__inner bracket">
          <span class="bracket__corner bracket__corner--tl"></span><span class="bracket__corner bracket__corner--tr"></span><span class="bracket__corner bracket__corner--bl"></span><span class="bracket__corner bracket__corner--br"></span>
          <p class="arc-card__pill"><span>🍽️ コミュニケーションランチ（月1回・1人1,500円補助）</span></p>
          <div class="arc-card__photo"><img src="<?php echo ni_img( 'work-style/comm_lunch.jpg' ); ?>" alt="" width="1200" height="800" loading="lazy"></div>
          <h3 class="arc-card__catch">「最近どうですか？」が、ここから始まることがある。</h3>
          <p class="arc-card__body">月に一度の部署ランチ。業務の話でも、プライベートの話でも、何でもいい。先輩に「この案件、どうやって乗り越えましたか？」と聞ける時間は、普段の業務とは違うリラックスした空気の中にあります。<br>日本インフォメーション社員アンケートでは「チームの雰囲気がいい」「話しかけやすい」という声が多数。その文化を支えているのが、こういった時間の積み重ねなのです。</p>
        </div>
      </li>
    </ul>
    </div>
    <div class="lower-sec">
    <ul class="icon-cards icon-cards--3 icon-cards--row">
      <li class="icon-card icon-card--row">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_17.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">部署間コミュニケーション企画</h3>
          <p class="icon-card__body">年数回、懇親会・ワーケーション等を会社費用で実施。</p>
        </div>
      </li>
      <li class="icon-card icon-card--row">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_18.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">部門行動計画策定会議</h3>
          <p class="icon-card__body">半期ごとに社員主体で部署の計画を策定。社員総会で発表。</p>
        </div>
      </li>
      <li class="icon-card icon-card--row">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_19.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">フリーアドレス</h3>
          <p class="icon-card__body">固定席なし。部署を超えた日常的なつながりが生まれやすい。</p>
        </div>
      </li>
    </ul>
    </div>
  </section>

  <!-- ===== Career Support（562:14406 / SP 1140:14590） ===== -->
  <section class="lower-sec ws-sec ws-sec--last">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Career Support</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">成長・キャリアを支える制度</h2>
        <p class="sec-head__read">日本インフォメーションに長く在籍しながら成長・キャリアを形成していくための制度・仕組みをまとめています。</p>
      </div>
    </div>
    <ul class="icon-cards icon-cards--3">
      <li class="icon-card">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_20.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">バディ制OJT</h3>
          <p class="icon-card__body">S2以上の先輩社員がバディとして就き、J1・J2等級の間マンツーマンで指導。毎月の進捗面談とスキルマップで成長を可視化します。</p>
        </div>
      </li>
      <li class="icon-card">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_21.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">1 on 1 ミーティング</h3>
          <p class="icon-card__body">定期的に部署内で1対1で行う面談制度。上長がメンバーの現状・悩みに向き合い、能力を引き出す育成の仕組みです。</p>
        </div>
      </li>
      <li class="icon-card">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_22.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">役員定期面談</h3>
          <p class="icon-card__body">入社後一定期間は定期的に役員と直接面談できる制度。困りごとや疑問を役員に直接ぶつけられる距離感が日本インフォメーションの特徴。</p>
        </div>
      </li>
      <li class="icon-card">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_23.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">マーケティング資格取得制度</h3>
          <p class="icon-card__body">マーケティングビジネス実務検定B・C級の取得を全員に義務付け。費用補助あり。社員の約9割が取得済み。</p>
        </div>
      </li>
      <li class="icon-card">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_24.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">資格取得補助制度</h3>
          <p class="icon-card__body">統計検定・Tableau・データ解析士・生成AIパスポート等、奨励資格の受験料を全額補助＋取得手当（2万円）を支給。</p>
        </div>
      </li>
      <li class="icon-card">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_25.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">社内ライブラリー制度</h3>
          <p class="icon-card__body">マーケティング・ビジネス・統計学の専門書籍を自由に借りられる社内図書館。自己学習をいつでも支援できる環境を整備しています。</p>
        </div>
      </li>
      <li class="icon-card">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_26.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">プロジェクトチーム制度</h3>
          <p class="icon-card__body">会社課題に対して部署横断メンバーで編成する制度。通常業務の枠を超えて視野・スキルを広げるチャンスが生まれます。</p>
        </div>
      </li>
      <li class="icon-card">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_27.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">マネジメント等級研修制度</h3>
          <p class="icon-card__body">管理職・リーダー層向けのマネジメントスキル習得プログラム。等級に紐づいた体系的な育成制度として新設。</p>
        </div>
      </li>
      <li class="icon-card">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_28.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">キャリア自己申告制度</h3>
          <p class="icon-card__body">年1回、職種・部署の異動希望を申告できる制度。面談を経て承認された場合、社内でのキャリアチェンジが可能です。</p>
        </div>
      </li>
      <li class="icon-card">
        <span class="icon-card__icon"><img src="<?php echo ni_img( 'work-style/icon_29.svg' ); ?>" alt="" width="40" height="40"></span>
        <div class="icon-card__txt">
          <h3 class="icon-card__title">資格等級制度・MBO</h3>
          <p class="icon-card__body">「役割・責任」を明示した資格等級制度と半期ごとの目標管理制度（MBO）を整備。透明な基準で公平な評価を実現します。</p>
        </div>
      </li>
    </ul>
  </section>

</main>
<?php
get_footer();
