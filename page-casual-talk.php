<?php
/**
 * カジュアル面談フォーム（固定ページ /casual-talk/）
 *
 * 静的 HTML（HTML/casual-talk/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => 'カジュアル面談申し込みフォーム｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '日本インフォメーションのカジュアル面談申し込みフォームです。会社や仕事内容、働き方について、選考とは別に気軽にお話しできます。2〜3営業日以内に採用担当者よりご連絡いたします。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">カジュアル面談申し込みフォーム</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">Entry for<br>Casual Talk</p>
      <h1 class="page-head__jp">カジュアル面談申し込みフォーム</h1>
    </div>
  </div>

  <!-- フォーム（PC 900:29139 / SP 1140:20800） -->
  <section class="form-sec" aria-label="申し込みフォーム">
    <div class="form-panel">
      <ul class="form-panel__lead">
        <li>2～3営業日以内に、採用担当者よりご連絡いたします。</li>
        <li>個人情報の取り扱いについては、プライバシーポリシーをご覧ください。</li>
        <li>エントリーフォームが表示されない場合や、申し込みボタンがクリックできない場合は、アドブロッカー、Ghosteryなどのアドオンを一時的にOFFにしてみてください。</li>
        <li>うまく行かない場合は、<a href="mailto:niitoiawase@n-info.co.jp">niitoiawase@n-info.co.jp</a>まで直接お問い合わせください。</li>
      </ul>

      <!-- ここから下は Contact Form 7 が出力する DOM に合わせてある（WP 化のとき CF7 のショートコードに置き換える）。
           .form__row / __label / __field などの行の構造は CF7 のフォームテンプレートに書く部分。
           静的版の検証・同意チェック・完了ページへの移動は assets/js/form.js（WP 化後は CF7 本体が行う） -->
      <div class="wpcf7 js" id="wpcf7-f0-o1" lang="ja" dir="ltr">
        <div class="screen-reader-response"><p role="status" aria-live="polite" aria-atomic="true"></p><ul></ul></div>
        <form action="<?php echo ni_url( '/casual-talk/thanks/' ); ?>" method="post" class="wpcf7-form init" aria-label="カジュアル面談申し込みフォーム" novalidate data-status="init">
          <div class="form__row">
            <p class="form__label"><label for="your-name">お名前（漢字）</label><span class="form__req">必須</span></p>
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
            <p class="form__label"><label for="company">現在の会社名</label><span class="form__req">必須</span></p>
            <div class="form__field">
              <span class="wpcf7-form-control-wrap" data-name="company"><input class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" id="company" name="company" type="text" size="40" maxlength="400" aria-required="true" aria-invalid="false" value=""></span>
            </div>
          </div>
          <div class="form__row">
            <p class="form__label"><label for="job">興味のある職種</label></p>
            <div class="form__field">
              <span class="wpcf7-form-control-wrap" data-name="job"><select class="wpcf7-form-control wpcf7-select" id="job" name="job" aria-invalid="false"><option value="">選択してください</option><option value="リサーチャー">リサーチャー</option><option value="営業">営業</option><option value="データ集計・分析">データ集計・分析</option><option value="その他">その他</option></select></span>
            </div>
          </div>
          <div class="form__row form__row--top" role="group" aria-labelledby="label-status">
            <p class="form__label"><span id="label-status">転職活動のステータス<br class="u-pc">（複数選択可）</span><span class="form__req">必須</span></p>
            <div class="form__field">
              <span class="wpcf7-form-control-wrap" data-name="status"><span class="wpcf7-form-control wpcf7-checkbox wpcf7-validates-as-required" id="status"><span class="wpcf7-list-item first"><label><input type="checkbox" name="status[]" value="転職活動に向けて動いている(応募・面接中など)"><span class="wpcf7-list-item-label">転職活動に向けて動いている(応募・面接中など)</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="status[]" value="良い出会いがあれば転職したい"><span class="wpcf7-list-item-label">良い出会いがあれば転職したい</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="status[]" value="まだ転職は考えていないが、情報収集をしたい"><span class="wpcf7-list-item-label">まだ転職は考えていないが、情報収集をしたい</span></label></span><span class="wpcf7-list-item last"><label><input type="checkbox" name="status[]" value="その他"><span class="wpcf7-list-item-label">その他</span></label></span></span></span>
            </div>
          </div>
          <div class="form__row form__row--top" role="group" aria-labelledby="label-reason">
            <p class="form__label"><span id="label-reason">申し込みいただいた理由<br class="u-pc">（複数選択可）</span></p>
            <div class="form__field">
              <span class="wpcf7-form-control-wrap" data-name="reason"><span class="wpcf7-form-control wpcf7-checkbox" id="reason"><span class="wpcf7-list-item first"><label><input type="checkbox" name="reason[]" value="会社・事業内容を知りたい"><span class="wpcf7-list-item-label">会社・事業内容を知りたい</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="reason[]" value="具体的な職種・業務内容を知りたい"><span class="wpcf7-list-item-label">具体的な職種・業務内容を知りたい</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="reason[]" value="働き方や社風を知りたい"><span class="wpcf7-list-item-label">働き方や社風を知りたい</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="reason[]" value="キャリアパス・成長機会を知りたい"><span class="wpcf7-list-item-label">キャリアパス・成長機会を知りたい</span></label></span><span class="wpcf7-list-item last"><label><input type="checkbox" name="reason[]" value="社員と話してみたい"><span class="wpcf7-list-item-label">社員と話してみたい</span></label></span></span></span>
            </div>
          </div>
          <div class="form__row form__row--textarea">
            <p class="form__label"><label for="your-message">その他ご質問・要望</label></p>
            <div class="form__field">
              <span class="wpcf7-form-control-wrap" data-name="your-message"><textarea class="wpcf7-form-control wpcf7-textarea" id="your-message" name="your-message" cols="40" rows="10" maxlength="2000" aria-invalid="false" placeholder="ご質問がありましたらご記入ください"></textarea></span>
            </div>
          </div>

          <!-- エラー表示のサンプル（CF7 が検証エラー時に出す形。form.css に用意済み。表示はしない）
          <div class="form__row">
            <p class="form__label"><label for="your-name">お名前（漢字）</label><span class="form__req">必須</span></p>
            <div class="form__field">
              <span class="wpcf7-form-control-wrap" data-name="your-name"><input class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required wpcf7-not-valid" id="your-name" name="your-name" type="text" size="40" aria-required="true" aria-invalid="true" value=""><span class="wpcf7-not-valid-tip" aria-hidden="true">入力してください。</span></span>
            </div>
          </div>
          募集要項詳細のエントリーフォームで使うファイル選択（履歴書 / 職務経歴書）:
          <div class="form__row">
            <p class="form__label"><label for="resume">履歴書</label><span class="form__req">必須</span></p>
            <div class="form__field form__field--file">
              <span class="wpcf7-form-control-wrap" data-name="resume"><input class="wpcf7-form-control wpcf7-file wpcf7-validates-as-required" id="resume" name="resume" type="file" size="40" accept=".pdf,.doc,.docx" aria-required="true" aria-invalid="false"></span>
              <span class="form__note">※様式不問</span>
            </div>
          </div>
          送信結果（form のクラスが init → invalid / sent に変わると表示される）:
          <form class="wpcf7-form invalid" data-status="invalid"> … <div class="wpcf7-response-output">入力内容に問題があります。確認して再度お試しください。</div></form>
          <form class="wpcf7-form sent" data-status="sent"> … <div class="wpcf7-response-output">ありがとうございます。メッセージは送信されました。</div></form>
          -->

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

</main>
<?php
get_footer();
