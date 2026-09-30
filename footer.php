<?php
/**
 * フッター 〜 </html>（</main> の後から）
 *
 * TODO（リンク先未確定で # のまま）: 公式採用インスタグラム / プロジェクトストーリー / 業界の未来 / メッセージ / 個人情報保護方針 / コーポレートサイト
 */
?>

<!-- ===== Footer ===== -->
<?php /* data-header-hide（新卒 TOP のみ）: SP の下固定 CTA をフッターに入る手前で消す（common.js。2026-09-17 指示「フッターはいる手前で非表示に」。以前は Entry で消していた） */ ?>
<footer class="footer"<?php echo 'beginner' === ni_page()['type'] ? ' data-header-hide' : ''; ?>>
  <img class="footer__deco u-pc" src="<?php echo ni_img( 'common/footer_insight.svg' ); ?>" alt="" width="986" height="431">
  <img class="footer__deco u-sp" src="<?php echo ni_img( 'common/footer_insight_sp.svg' ); ?>" alt="" width="404" height="177">
  <div class="footer__inner">
    <div class="footer__brand">
      <div class="footer__brand-logo">
        <a class="footer__logo" href="<?php echo ni_url( '/' ); ?>"><img src="<?php echo ni_img( 'common/logo_white.svg' ); ?>" alt="NIPPON INFORMATION INCORPORATED" width="151" height="57"></a>
        <span class="footer__badge">採用情報サイト</span>
      </div>
      <a class="footer__insta" href="#" target="_blank" rel="noopener">
        <span class="footer__insta-icon" aria-hidden="true"></span>
        <span class="footer__insta-body">
          <span class="footer__insta-lead">採用情報、仕事紹介、<br>就活Tipsなどを随時発信中！</span>
          <span class="footer__insta-title">公式採用インスタグラム</span>
        </span>
      </a>
    </div>
    <nav class="footer__nav" aria-label="フッターナビゲーション">
      <div class="footer__group">
        <h2 class="footer__group-title"><button type="button" class="footer__group-toggle js-footer-toggle" aria-controls="footer-panel-1" aria-expanded="false">新卒・中途(リサーチ未経験者)</button></h2>
        <div class="footer__panel" id="footer-panel-1">
          <ul class="footer__list">
            <li><a href="<?php echo ni_url( '/beginner/' ); ?>">新卒・中途(リサーチ未経験者)向けTOP</a></li>
            <li><a href="<?php echo ni_url( '/interview/' ); ?>">社員インタビュー</a></li>
            <li><a href="#">プロジェクトストーリー</a></li>
          </ul>
        </div>
      </div>
      <div class="footer__group">
        <h2 class="footer__group-title"><button type="button" class="footer__group-toggle js-footer-toggle" aria-controls="footer-panel-2" aria-expanded="false">中途(リサーチ経験者)</button></h2>
        <div class="footer__panel" id="footer-panel-2">
          <ul class="footer__list">
            <li><a href="<?php echo ni_url( '/career/' ); ?>">中途(リサーチ経験者)向けTOP</a></li>
            <li><a href="<?php echo ni_url( '/interview/' ); ?>">社員インタビュー</a></li>
            <li><a href="#">プロジェクトストーリー</a></li>
          </ul>
        </div>
      </div>
      <div class="footer__group">
        <h2 class="footer__group-title"><button type="button" class="footer__group-toggle js-footer-toggle" aria-controls="footer-panel-3" aria-expanded="false">日本インフォメーションを知る</button></h2>
        <div class="footer__panel" id="footer-panel-3">
          <ul class="footer__list">
            <li><a href="<?php echo ni_url( '/about/' ); ?>">3分でわかる日本インフォメーション</a></li>
            <li><a href="#">業界の未来</a></li>
            <li><a href="#">メッセージ</a></li>
            <li class="footer__subgroup">
              <p class="footer__subhead">仕事とキャリア</p>
              <ul class="footer__sub footer__list">
                <li><a href="<?php echo ni_url( '/chart/' ); ?>">仕事の相関図</a></li>
                <li><a href="<?php echo ni_url( '/development/' ); ?>">教育・研修・キャリアパス</a></li>
              </ul>
            </li>
            <li class="footer__subgroup">
              <p class="footer__subhead">人とカルチャー</p>
              <ul class="footer__sub footer__list">
                <li><a href="<?php echo ni_url( '/cross-talk/' ); ?>">座談会</a></li>
                <li><a href="<?php echo ni_url( '/work-style/' ); ?>">制度・環境</a></li>
                <li><a href="<?php echo ni_url( '/office/' ); ?>">オフィス紹介</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <div class="footer__group">
        <h2 class="footer__group-title"><button type="button" class="footer__group-toggle js-footer-toggle" aria-controls="footer-panel-4" aria-expanded="false">募集中の職種一覧</button></h2>
        <div class="footer__panel" id="footer-panel-4">
          <ul class="footer__list">
            <li><a href="<?php echo ni_job_category_url( 'new-graduate' ); ?>">新卒採用</a></li>
            <li><a href="<?php echo ni_job_category_url( 'mid-beginner' ); ?>">中途採用(未経験)</a></li>
            <li><a href="<?php echo ni_job_category_url( 'mid-career' ); ?>">中途採用(経験者)</a></li>
            <li><a href="<?php echo ni_job_category_url( 'part-time' ); ?>">アルバイト</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
  <div class="footer__bottom">
    <p class="footer__copy"><small>© 2026 NIPPON INFORMATION Inc.</small></p>
    <ul class="footer__links">
      <li><a href="#" target="_blank" rel="noopener">個人情報保護方針<img src="<?php echo ni_img( 'common/icon_external.svg' ); ?>" alt="（外部サイト）" width="13" height="11"></a></li>
      <li><a href="#" target="_blank" rel="noopener">コーポレートサイト<img src="<?php echo ni_img( 'common/icon_external.svg' ); ?>" alt="（外部サイト）" width="13" height="11"></a></li>
    </ul>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
