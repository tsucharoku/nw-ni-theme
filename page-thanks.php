<?php
/**
 * エントリー送信完了（固定ページ /casual-talk/thanks/）
 *
 * 静的 HTML（HTML/casual-talk/thanks/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => 'エントリー送信完了｜日本インフォメーション株式会社 採用情報サイト',
		'description' => 'エントリーいただきありがとうございました。ご入力内容を確認の上、通常2〜3営業日以内に担当よりご連絡を差し上げます。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head page-head--bare" id="js-fv">
    <img class="page-head__ni" src="<?php echo ni_img( 'lower/pagehead_ni.png' ); ?>" alt="" width="988" height="936">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">エントリー送信完了</li></ol></nav>
  </div>

  <!-- メッセージ（PC 900:29719 / SP 1140:21163） -->
  <section class="msg">
    <h1 class="msg__title">エントリーいただき<br>ありがとうございました</h1>
    <p class="msg__txt">ご入力内容を確認の上、通常2〜3営業日以内に担当よりご連絡を差し上げます。<br>自動返信メールが届かない場合、迷惑メールフォルダをご確認いただくか、<br>メールアドレスをご確認の上、もう一度フォームよりお問い合わせくださいますようお願い申し上げます。</p>
    <a class="btn" href="<?php echo ni_url( '/' ); ?>">TOPへ戻る<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
  </section>

</main>
<?php
get_footer();
