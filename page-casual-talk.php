<?php
/**
 * カジュアル面談フォーム（固定ページ /casual-talk/）
 *
 * 文言は静的 HTML（HTML/casual-talk/index.html）のまま固定。フォームは Contact Form 7（inc/cf7.php、中身は cf7/casual-form.txt）。
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

      <!-- Contact Form 7 のフォーム「カジュアル面談申し込みフォーム」（中身は cf7/casual-form.txt。環境ごとに ID が変わるのでタイトルで引く） -->
      <?php echo do_shortcode( '[contact-form-7 title="カジュアル面談申し込みフォーム" html_title="カジュアル面談申し込みフォーム"]' ); ?>
    </div>
  </section>

</main>
<?php
get_footer();
