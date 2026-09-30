<?php
/**
 * 募集要項詳細（カスタム投稿 job-opening の詳細 /job-opening/{パーマリンク}/）
 *
 * 静的 HTML（HTML/job-opening/detail/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => 'プランナー｜中途採用(未経験)｜募集中の職種一覧｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '日本インフォメーション株式会社 中途採用(未経験)「プランナー」の募集要項です。仕事内容、1日の流れ、一緒に働く人、募集要項、よくある質問をご紹介します。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head page-head--job" id="js-fv">
    <img class="page-head__ni" src="<?php echo ni_img( 'lower/pagehead_ni.png' ); ?>" alt="" width="988" height="936">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li><a href="<?php echo ni_url( '/job-opening/' ); ?>">募集中の職種一覧</a></li><li><a href="<?php echo ni_url( '/job-opening/category/' ); ?>">中途採用(未経験)の募集一覧</a></li><li aria-current="page">プランナー</li></ol></nav>
    <!-- カテゴリ名 + 職種名（565:17166。共通 .page-head の英字タイトルの代わり） -->
    <div class="page-head__txt">
      <p class="page-head__cat">中途採用(未経験)</p>
      <h1 class="page-head__name">プランナー</h1>
    </div>
    <p class="page-head__read">東京・銀座の中心地に構える日本インフォメーションのオフィス。<br class="u-pc">仕事に集中できる環境と、人とつながれる場所が共存しています。</p>
  </div>

  <!-- 本文 2 カラム（565:17168）: 左 = 追従アンカーナビ（PC は sticky）、右 = 本文の箱 -->
  <div class="lower-sec job-detail">

    <!-- アンカーナビ: リンク先は本文 h2 の id（WP: 見出しブロックの「HTML アンカー」）と #entry -->
    <nav class="job-detail__nav" aria-label="ページ内リンク">
      <ul class="anchor-nav">
        <li><a class="anchor-nav__link" href="#work">仕事内容</a></li>
        <li><a class="anchor-nav__link" href="#schedule">1日の流れ</a></li>
        <li><a class="anchor-nav__link" href="#members">一緒に働く人</a></li>
        <li><a class="anchor-nav__link" href="#requirements">募集要項</a></li>
        <li><a class="anchor-nav__link" href="#faq">よくある質問</a></li>
        <li><a class="anchor-nav__link" href="#entry">エントリー</a></li>
      </ul>
    </nav>

    <article class="job-detail__body">

      <!-- ▼ 本文（WP: the_content()）。ここから下は Gutenberg が出力するマークアップそのまま。スタイルは editor-style.css -->
      <div class="entry-content">

        <!-- core/heading（h2。HTML アンカー = 左のアンカーナビのリンク先） -->
        <h2 class="wp-block-heading" id="work">仕事内容</h2>
        <!-- core/heading h3 / h4 -->
        <h3 class="wp-block-heading">H3 見出しが入ります見出しが入ります</h3>
        <h4 class="wp-block-heading">H4 見出しが入ります</h4>

        <!-- core/paragraph -->
        <p>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります。</p>

        <!-- core/image -->
        <figure class="wp-block-image size-large"><img src="<?php echo ni_img( 'common/story_photo_01.jpg' ); ?>" alt="" width="1360" height="766" loading="lazy"></figure>

        <!-- core/video（再生ボタンは editor-style.css + job-opening.js。YouTube 等は core/embed = figure.wp-block-embed > .wp-block-embed__wrapper > iframe） -->
        <figure class="wp-block-video"><video controls preload="none" playsinline poster="<?php echo ni_img( 'common/talk_main.jpg' ); ?>" src="<?php echo esc_url( get_theme_file_uri( 'assets/video/fv_bg.mp4' ) ); ?>"></video></figure>

        <!-- core/list -->
        <ul class="wp-block-list">
          <li>リストの項目が入ります</li>
          <li>リストの項目が入ります</li>
          <li>リストの項目が入ります</li>
        </ul>

        <!-- core/list（ordered） -->
        <ol class="wp-block-list">
          <li>数字つきリストの項目が入ります</li>
          <li>数字つきリストの項目が入ります</li>
          <li>数字つきリストの項目が入ります</li>
        </ol>

        <!-- core/quote -->
        <blockquote class="wp-block-quote"><p>引用が入ります引用が入ります引用が入ります引用が入ります引用が入ります引用が入ります引用が入ります引用が入ります引用が入ります。</p><cite>引用元が入ります</cite></blockquote>

        <!-- core/buttons > core/button（2 つ目は core/button + is-style-external = 外部リンク） -->
        <div class="wp-block-buttons is-vertical">
          <div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#">ボタンテキスト</a></div>
          <div class="wp-block-button is-style-external"><a class="wp-block-button__link wp-element-button" href="#" target="_blank" rel="noreferrer noopener">ボタンテキスト</a></div>
        </div>

        <h2 class="wp-block-heading" id="schedule">1日の流れ</h2>

        <!-- core/media-text（文の見出しは h5） -->
        <div class="wp-block-media-text is-stacked-on-mobile">
          <figure class="wp-block-media-text__media"><img src="<?php echo ni_img( 'common/talk_thumb_02.jpg' ); ?>" alt="" width="768" height="425" loading="lazy"></figure>
          <div class="wp-block-media-text__content">
            <h5 class="wp-block-heading">見出し5タイトルが入ります見出し5タイトルが入ります見出し5タイトルが入りますタイトルが入りますタイトルが入りますタイトルが入ります</h5>
            <p>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります。本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が</p>
          </div>
        </div>

        <!-- core/table（ヘッダーセクションあり） -->
        <figure class="wp-block-table"><table class="has-fixed-layout">
          <thead><tr><th>th</th><th>th</th><th>th</th><th>th</th></tr></thead>
          <tbody>
            <tr><td>td</td><td>td</td><td>td</td><td>td</td></tr>
            <tr><td>td</td><td>td</td><td>td</td><td>td</td></tr>
            <tr><td>td</td><td>td</td><td>td</td><td>td</td></tr>
          </tbody>
        </table></figure>

        <h2 class="wp-block-heading" id="members">一緒に働く人</h2>

        <!-- core/columns + is-style-cards（社員カード 3 列）
             列の中: core/image → core/paragraph → core/paragraph + is-style-name → core/list + is-style-pills → core/list + is-style-hashtags -->
        <div class="wp-block-columns is-style-cards">
          <div class="wp-block-column">
            <figure class="wp-block-image size-large"><img src="<?php echo ni_img( 'common/voice_card_01.jpg' ); ?>" alt="" width="768" height="944" loading="lazy"></figure>
            <p>リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
            <p class="is-style-name">田中 太郎</p>
            <ul class="wp-block-list is-style-pills"><li>新卒入社</li><li>リサーチャー</li></ul>
            <ul class="wp-block-list is-style-hashtags"><li># フルリモート</li><li># 時短勤務</li></ul>
          </div>
          <div class="wp-block-column">
            <figure class="wp-block-image size-large"><img src="<?php echo ni_img( 'common/voice_card_02.jpg' ); ?>" alt="" width="768" height="944" loading="lazy"></figure>
            <p>リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
            <p class="is-style-name">田中 太郎</p>
            <ul class="wp-block-list is-style-pills"><li>新卒入社</li><li>リサーチャー</li></ul>
            <ul class="wp-block-list is-style-hashtags"><li># フルリモート</li><li># 時短勤務</li></ul>
          </div>
          <div class="wp-block-column">
            <figure class="wp-block-image size-large"><img src="<?php echo ni_img( 'common/voice_card_03.jpg' ); ?>" alt="" width="768" height="944" loading="lazy"></figure>
            <p>リサーチの力で未来を動かす、それが私たちの仕事です。テキストテキストテキストテキスト</p>
            <p class="is-style-name">田中 太郎</p>
            <ul class="wp-block-list is-style-pills"><li>新卒入社</li><li>リサーチャー</li></ul>
            <ul class="wp-block-list is-style-hashtags"><li># フルリモート</li><li># 時短勤務</li></ul>
          </div>
        </div>

        <!-- core/columns + is-style-profile（プロフィール行。1 列目 = core/image + キャプション（氏名）、2 列目 = 本文。モバイルでも横並び） -->
        <div class="wp-block-columns is-not-stacked-on-mobile is-style-profile">
          <div class="wp-block-column">
            <figure class="wp-block-image size-thumbnail"><img src="<?php echo ni_img( 'editor/sample_profile.jpg' ); ?>" alt="" width="320" height="320" loading="lazy"><figcaption class="wp-element-caption">氏名</figcaption></figure>
          </div>
          <div class="wp-block-column">
            <p>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
          </div>
        </div>

        <!-- core/media-text + is-style-comment（コメント）。肩書き行は core/paragraph + is-style-byline（太字 = バッジ） -->
        <div class="wp-block-media-text is-style-comment">
          <figure class="wp-block-media-text__media"><img src="<?php echo ni_img( 'editor/sample_comment.jpg' ); ?>" alt="" width="272" height="272" loading="lazy"></figure>
          <div class="wp-block-media-text__content">
            <p>リサーチの仕事は、数字の向こうに人がいる仕事。好奇心さえあれば、社会を動かすプロジェクトに携わることができます。</p>
            <p class="is-style-byline"><strong>新卒入社</strong>リサーチャー Y.N.</p>
          </div>
        </div>

        <h2 class="wp-block-heading" id="requirements">募集要項</h2>

        <!-- core/group + is-style-question（質問見出し）: core/paragraph + is-style-en-label → core/heading -->
        <div class="wp-block-group is-style-question">
          <p class="is-style-en-label">Question 01</p>
          <h3 class="wp-block-heading">質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります質問が入ります</h3>
        </div>

        <!-- core/group + is-style-steps（選考ステップ）> core/group + is-style-step × n（core/heading + core/paragraph）。番号 01〜 と ▼ は CSS -->
        <div class="wp-block-group is-style-steps">
          <div class="wp-block-group is-style-step">
            <h4 class="wp-block-heading">エントリー</h4>
            <p>マイページを登録のうえ、エントリーシートをご提出ください。</p>
          </div>
          <div class="wp-block-group is-style-step">
            <h4 class="wp-block-heading">書類選考</h4>
            <p>ご提出いただいた書類をもとに選考します。結果はマイページにてご連絡します。</p>
          </div>
          <div class="wp-block-group is-style-step">
            <h4 class="wp-block-heading">適性検査</h4>
            <p>Webにて受検いただきます。所要時間は約60分です。</p>
          </div>
          <div class="wp-block-group is-style-step">
            <h4 class="wp-block-heading">一次面接</h4>
            <p>オンラインで実施します。</p>
          </div>
          <div class="wp-block-group is-style-step">
            <h4 class="wp-block-heading">最終面接</h4>
            <p>当社オフィスにて対面で実施します。</p>
          </div>
          <div class="wp-block-group is-style-step">
            <h4 class="wp-block-heading">内定</h4>
            <p>内定後の流れは個別にご案内します。</p>
          </div>
        </div>

        <h2 class="wp-block-heading" id="faq">よくある質問</h2>

        <!-- core/details（FAQ）。Q. / A. / 開閉アイコンは CSS。1 つ目は「デフォルトで開く」 -->
        <details class="wp-block-details" open><summary>質問が入ります質問が入ります質問が入りますか？</summary>
          <p>回答が入ります回答が入ります回答が入ります回答が入ります回答が入ります回答が入ります回答が入ります。</p>
        </details>
        <details class="wp-block-details"><summary>質問が入ります質問が入ります質問が入りますか？</summary>
          <p>回答が入ります回答が入ります回答が入ります回答が入ります回答が入ります回答が入ります回答が入ります。</p>
        </details>
        <details class="wp-block-details"><summary>質問が入ります質問が入ります質問が入りますか？</summary>
          <p>回答が入ります回答が入ります回答が入ります回答が入ります回答が入ります回答が入ります回答が入ります。</p>
        </details>

      </div>
      <!-- ▲ 本文ここまで -->

      <!-- エントリーフォーム（567:17870）: 見出しと白い箱だけテンプレート側。中身は form.css -->
      <section class="job-entry" id="entry">
        <h2 class="job-entry__title">エントリー</h2>
        <div class="job-entry__box">
          <!-- Contact Form 7 の出力 DOM に合わせたマークアップ（casual-talk と同じ作り。見た目は form.css、静的版の検証は form.js） -->
          <div class="wpcf7 js" id="wpcf7-f0-o2" lang="ja" dir="ltr">
            <div class="screen-reader-response"><p role="status" aria-live="polite" aria-atomic="true"></p><ul></ul></div>
            <form action="<?php echo ni_url( '/casual-talk/thanks/' ); ?>" method="post" class="wpcf7-form init" aria-label="エントリーフォーム" novalidate data-status="init">
              <div class="form__row">
                <p class="form__label"><label for="your-name">お名前</label><span class="form__req">必須</span></p>
                <div class="form__field">
                  <span class="wpcf7-form-control-wrap" data-name="your-name"><input class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" id="your-name" name="your-name" type="text" size="40" maxlength="400" aria-required="true" aria-invalid="false" placeholder="例）日本 太郎" value=""></span>
                </div>
              </div>
              <div class="form__row">
                <p class="form__label"><label for="your-kana">フリガナ</label><span class="form__req">必須</span></p>
                <div class="form__field">
                  <span class="wpcf7-form-control-wrap" data-name="your-kana"><input class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" id="your-kana" name="your-kana" type="text" size="40" maxlength="400" aria-required="true" aria-invalid="false" placeholder="例）ニホン タロウ" value=""></span>
                </div>
              </div>
              <div class="form__row">
                <p class="form__label"><label for="birth">生年月日</label><span class="form__req">必須</span></p>
                <div class="form__field form__field--date">
                  <span class="wpcf7-form-control-wrap" data-name="birth"><input class="wpcf7-form-control wpcf7-date wpcf7-validates-as-required wpcf7-validates-as-date" id="birth" name="birth" type="date" aria-required="true" aria-invalid="false" value=""></span>
                </div>
              </div>
              <div class="form__row">
                <p class="form__label"><label for="gender">性別</label><span class="form__req">必須</span></p>
                <div class="form__field form__field--hug">
                  <span class="wpcf7-form-control-wrap" data-name="gender"><select class="wpcf7-form-control wpcf7-select wpcf7-validates-as-required" id="gender" name="gender" aria-required="true" aria-invalid="false"><option value="">選択してください</option><option value="男性">男性</option><option value="女性">女性</option><option value="その他">その他</option><option value="回答しない">回答しない</option></select></span>
                </div>
              </div>
              <div class="form__row">
                <p class="form__label"><label for="your-email">メールアドレス</label><span class="form__req">必須</span></p>
                <div class="form__field">
                  <span class="wpcf7-form-control-wrap" data-name="your-email"><input class="wpcf7-form-control wpcf7-email wpcf7-text wpcf7-validates-as-required wpcf7-validates-as-email" id="your-email" name="your-email" type="email" size="40" maxlength="400" aria-required="true" aria-invalid="false" placeholder="example@ni.co.jp" value=""></span>
                </div>
              </div>
              <div class="form__row">
                <p class="form__label"><label for="your-email-confirm">メールアドレス（確認用）</label><span class="form__req">必須</span></p>
                <div class="form__field">
                  <span class="wpcf7-form-control-wrap" data-name="your-email-confirm"><input class="wpcf7-form-control wpcf7-email wpcf7-text wpcf7-validates-as-required wpcf7-validates-as-email" id="your-email-confirm" name="your-email-confirm" type="email" size="40" maxlength="400" aria-required="true" aria-invalid="false" placeholder="example@ni.co.jp" data-confirm="your-email" value=""></span>
                </div>
              </div>
              <div class="form__row">
                <p class="form__label"><label for="address">住所</label></p>
                <div class="form__field">
                  <span class="wpcf7-form-control-wrap" data-name="address"><input class="wpcf7-form-control wpcf7-text" id="address" name="address" type="text" size="40" maxlength="400" aria-invalid="false" placeholder="例）東京都中央区銀座1-2-3" value=""></span>
                </div>
              </div>
              <div class="form__row">
                <p class="form__label"><label for="resume">履歴書</label><span class="form__req">必須</span></p>
                <div class="form__field form__field--file">
                  <span class="wpcf7-form-control-wrap" data-name="resume"><input class="wpcf7-form-control wpcf7-file wpcf7-validates-as-required" id="resume" name="resume" type="file" size="40" accept=".pdf,.doc,.docx" aria-required="true" aria-invalid="false"></span>
                  <span class="form__note">※様式不問</span>
                </div>
              </div>
              <div class="form__row">
                <p class="form__label"><label for="cv">職務経歴書</label></p>
                <div class="form__field form__field--file">
                  <span class="wpcf7-form-control-wrap" data-name="cv"><input class="wpcf7-form-control wpcf7-file" id="cv" name="cv" type="file" size="40" accept=".pdf,.doc,.docx" aria-invalid="false"></span>
                  <span class="form__note">※様式不問</span>
                </div>
              </div>
              <div class="form__row form__row--textarea">
                <p class="form__label"><label for="your-message">その他ご質問</label></p>
                <div class="form__field">
                  <span class="wpcf7-form-control-wrap" data-name="your-message"><textarea class="wpcf7-form-control wpcf7-textarea" id="your-message" name="your-message" cols="40" rows="10" maxlength="2000" aria-invalid="false" placeholder="ご質問がありましたらご記入ください"></textarea></span>
                </div>
              </div>

              <div class="form__policy">
                <p class="form__policy-title" id="policy-title">記入された情報の取扱について</p>
                <div class="form__policy-box">
                  <div class="form__policy-body" tabindex="0" role="region" aria-labelledby="policy-title">
                      <p>応募の際にお申し込みフォームへご入力いただいた内容は、下記の目的に利用させていただくものです。<br>採用・選考、選考活動に伴うメール等の各種連絡</p>
                      <p>上記の利用目的の範囲で委託する場合があります。</p>
                      <p>当社は、ご記入者様の個人情報の流出・漏洩の防止、その他個人情報の安全管理のために必要かつ適切な措置を講じるものとし、調査目的達成に必要な業務委託先への提供及び法令等に基づく正当な理由がある場合を除き、ご記入者様の同意なく目的外での利用及び第三者への提供は行いません。<br>当社は、個人情報保護法に基づき、個人情報を提供した場合、その提供記録を適切に管理しております。また、当社が保有する第三者提供記録について、法令に基づき開示を求めることができます。</p>
                      <p>記入された情報に付きましては、当社の「個人情報の取扱について」に基づき管理いたします。<br>記入された情報について、個人情報に関するお問い合わせ・利用目的の通知・開示・内容の訂正・追加 または削除・利用の停止・消去についてお受けいたしますので、お問い合わせについては、当社の 「個人情報の取扱について」内の「5.お問い合わせについて」、その他については、「2.個人情報の開示等の請求について」をご覧いただきご請求ください。<br>また、当社のウェブサイトをご利用される方の利便性向上のため、また、当サイトへのアクセスを分析するために、クッキーを使用してサイトにアクセスされたコンピュータの識別情報や、訪問履歴を取得する場合があります。クッキーはブラウザの設定で「オフ」にすることができますが、この場合、ウェブサイトのサービスが利用できない場合があります。</p>
                      <p>また、お申し込みフォームの必須項目の記入は任意ですが、お申し込みフォームの必須項目の未記入や上記ご同意頂けない場合はお申し込み頂くことができません。</p>
                      <p>記入された情報は、SSL暗号化された通信により、個人情報が外部に漏れることがないよう保護されています。</p>
                      <p>＜採用に係わるご登録に関するお問合わせ窓口＞<br>TEL : 03-3542-9441　採用担当<br>※電話口にてお問合せ要件をお申し出ください。担当から折り返しご連絡致します。<br>※受付時間：午前10時～午後5時（土日・祝日を除く）</p>
                      <p>＜個人情報に関するお問い合わせ窓口＞<br>日本インフォメーション株式会社<br>〒104-0061　東京都中央区銀座3-15-10　JRE銀座三丁目ビル4F<br>管理担当者　個人情報保護管理者　取締役　小倉祐二<br>Eメール:n-info@n-info. co. jp</p>
                      <p>上記お申し込みフォームにご記入頂き、個人情報の取扱について及び上記内容に同意される場合には、以下にチェックを入れた上、お申し込みください。</p>
                      <p>同意する</p>
                  </div>
                </div>
              </div>
              <div class="form__agree">
                <span class="wpcf7-form-control-wrap" data-name="acceptance"><span class="wpcf7-form-control wpcf7-acceptance"><span class="wpcf7-list-item"><label><input type="checkbox" name="acceptance" value="1" aria-invalid="false"><span class="wpcf7-list-item-label">プライバシーポリシーに同意する</span></label></span></span></span>
              </div>
              <p class="form__submit"><input class="wpcf7-form-control wpcf7-submit has-spinner" type="submit" value="送信する"></p>
              <div class="wpcf7-response-output" aria-hidden="true"></div>
            </form>
          </div>
        </div>
      </section>

    </article>
  </div>

  <!-- その他の募集職種（565:17454）: 同じカテゴリの他の職種 + 一覧へ戻る -->
  <section class="job-other">
    <img class="job-other__deco" src="<?php echo ni_img( 'job-opening/other_deco.svg' ); ?>" alt="" width="2250" height="1257">
    <div class="job-other__head">
      <div class="sec-head sec-head--sub">
        <p class="sec-head__label u-grd-text">More Open Positions</p>
        <h2 class="sec-head__title sec-head__title--cap">その他の募集職種</h2>
      </div>
    </div>
    <div class="job-other__body">
      <ul class="job__list">
        <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">プランナー（営業企画）</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
        <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">フィールドワーク（FW）</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
        <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">インターネットリサーチ</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
        <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">アナリスト（NIマーケティング研究所）</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
      </ul>
      <a class="btn" href="<?php echo ni_url( '/job-opening/' ); ?>">募集中の職種一覧に戻る<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
    </div>
  </section>

</main>
<?php
get_footer();
