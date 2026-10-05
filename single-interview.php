<?php
/**
 * 社員インタビュー詳細（カスタム投稿 interview の詳細 /interview/{パーマリンク}/）
 *
 * 設計書: NI採用サイト_ACFフィールド設計書_社員インタビュー.xlsx。タイトル = 投稿タイトル、メインビジュアル = アイキャッチ、
 * 入社区分・職種・タグ = タクソノミー、氏名・サイド追従画像・スケジュール = ACF「社員インタビュー」（acf-json/group_ni_interview.json）。
 * 本文だけ設計書（ブロックエディタ）から変えて、ACF のフレキシブルコンテンツ（質問・回答 / 画像）にしている
 * （2026-10-05 ユーザー指示。座談会と同じ考え方）。Question の番号は上から順に自動で付ける。
 * 関連インタビューは同じタクソノミーの記事を 3 件まで（ni_interview_related()）。入力した内容だけ出す。
 */

$ni_id       = get_queried_object_id();
$ni_title    = get_the_title( $ni_id );
$ni_name     = function_exists( 'get_field' ) ? (string) get_field( 'interview_name', $ni_id ) : '';
$ni_side     = function_exists( 'get_field' ) ? get_field( 'interview_side_image', $ni_id ) : null;
$ni_body     = function_exists( 'get_field' ) ? get_field( 'interview_body', $ni_id ) : array();
$ni_schedule = function_exists( 'get_field' ) ? get_field( 'interview_schedule', $ni_id ) : array();
$ni_body     = is_array( $ni_body ) ? $ni_body : array();
$ni_schedule = is_array( $ni_schedule ) ? $ni_schedule : array();
$ni_mv       = wp_get_attachment_image_src( get_post_thumbnail_id( $ni_id ), 'full' );
$ni_chips    = array_merge( ni_interview_terms( 'interview_entry_type', $ni_id ), ni_interview_terms( 'interview_job_type', $ni_id ) );
$ni_tags     = ni_interview_terms( 'interview_tag', $ni_id );
$ni_related  = ni_interview_related( $ni_id );

/* ACF の画像（配列）を <img> で出す。未入力なら何も出さない。$atts は追加の属性 */
function ni_interview_img( $img, $atts = '' ) {
	if ( is_array( $img ) && ! empty( $img['url'] ) ) {
		printf( '<img src="%s" alt="" width="%d" height="%d"%s>', esc_url( $img['url'] ), (int) $img['width'], (int) $img['height'], $atts );
	}
}

ni_head(
	array(
		'title'       => $ni_title . '｜社員インタビュー｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '日本インフォメーションで働く社員のインタビュー。仕事のやりがいや 1 日のスケジュールを紹介します。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li><a href="<?php echo ni_url( '/interview/' ); ?>">社員インタビュー</a></li><li aria-current="page"><?php echo esc_html( $ni_title ); ?></li></ol></nav>
  </div>

  <!-- メインビジュアル + タイトル（855:26428 / SP 1140:19629）。写真は左端から、右に 96 / 24 の余白。写真 = アイキャッチ -->
  <div class="interview-mv">
    <div class="interview-mv__img"><?php
    if ( $ni_mv ) {
    	printf( '<img src="%s" alt="" width="%d" height="%d">', esc_url( $ni_mv[0] ), (int) $ni_mv[1], (int) $ni_mv[2] );
    }
    ?></div>
    <div class="interview-mv__txt">
      <p class="interview-mv__label">Interview</p>
      <h1 class="interview-mv__title"><?php echo esc_html( $ni_title ); ?></h1>
      <?php if ( '' !== $ni_name ) : ?>
      <p class="interview-mv__name"><?php echo esc_html( $ni_name ); ?></p>
      <?php endif; ?>
      <?php if ( $ni_chips ) : ?>
      <ul class="interview-mv__chips"><?php foreach ( $ni_chips as $ni_term ) : ?><li><?php echo esc_html( $ni_term->name ); ?></li><?php endforeach; ?></ul>
      <?php endif; ?>
      <?php if ( $ni_tags ) : ?>
      <ul class="interview-mv__tags"><?php foreach ( $ni_tags as $ni_term ) : ?><li># <?php echo esc_html( $ni_term->name ); ?></li><?php endforeach; ?></ul>
      <?php endif; ?>
    </div>
  </div>

  <!-- 本文（855:26764 / SP 1140:19645）。ACF のフレキシブルコンテンツ（質問・回答 / 画像）。左の写真は PC だけ（sticky で本文に追従） -->
  <div class="interview-body">
    <div class="interview-body__side"><?php ni_interview_img( $ni_side ); ?></div>
    <div class="interview-body__main">
        <?php
        $ni_q = 0;
        foreach ( $ni_body as $ni_row ) :
        	if ( 'qa' === $ni_row['acf_fc_layout'] ) :
        		$ni_q++;
        		?>
        <section class="interview-qa">
          <div class="interview-qa__head">
            <p class="interview-qa__num u-grd-text">Question <?php echo esc_html( sprintf( '%02d', $ni_q ) ); ?></p>
            <h2 class="interview-qa__q"><?php echo nl2br( esc_html( trim( (string) $ni_row['question'] ) ) ); ?></h2>
          </div>
          <p class="interview-qa__a"><?php echo nl2br( esc_html( trim( (string) $ni_row['answer'] ) ) ); ?></p>
        </section>
        		<?php
        	elseif ( 'image' === $ni_row['acf_fc_layout'] && is_array( $ni_row['image'] ) && ! empty( $ni_row['image']['url'] ) ) :
        		?>
        <figure class="interview-body__photo"><?php ni_interview_img( $ni_row['image'], ' loading="lazy"' ); ?></figure>
        		<?php
        	endif;
        endforeach;
        ?>
    </div>
  </div>

  <?php if ( $ni_schedule ) : ?>
  <!-- 1 日のスケジュール（855:26838 / SP 1140:19657）。背景の英字は横に流れ続ける（CSS animation） -->
  <section class="day">
    <div class="day__deco" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div>
    <div class="day__marquee u-en" aria-hidden="true"><div class="day__marquee-track"><span class="day__marquee-item">A Day at Work.</span><span class="day__marquee-item">A Day at Work.</span><span class="day__marquee-item">A Day at Work.</span><span class="day__marquee-item">A Day at Work.</span><span class="day__marquee-item">A Day at Work.</span><span class="day__marquee-item">A Day at Work.</span></div></div>
    <div class="day__box bracket">
      <span class="bracket__corner bracket__corner--tl"></span>
      <span class="bracket__corner bracket__corner--tr"></span>
      <span class="bracket__corner bracket__corner--bl"></span>
      <span class="bracket__corner bracket__corner--br"></span>
      <h2 class="day__title">仕事がある日のスケジュール</h2>
      <!-- --rows: PC で 2 列に分けるときの 1 列あたりの件数（件数 ÷ 2 の切り上げ） -->
      <ol class="day__list" style="--rows: <?php echo (int) ceil( count( $ni_schedule ) / 2 ); ?>">
        <?php foreach ( $ni_schedule as $ni_item ) : ?>
        <li class="day__item">
          <img class="day__marker" src="<?php echo ni_img( 'interview/icon_time_marker.svg' ); ?>" alt="" width="42" height="17">
          <div class="day__txt">
            <p class="day__time"><?php echo esc_html( (string) $ni_item['schedule_time'] ); ?></p>
            <p class="day__desc"><?php echo nl2br( esc_html( trim( (string) $ni_item['schedule_body'] ) ) ); ?></p>
          </div>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </section>
  <?php endif; ?>

  <?php if ( $ni_related ) : ?>
  <!-- 関連インタビュー（855:27157 / SP 1140:19698）。同じタクソノミーの記事を 3 件まで（ni_interview_related()） -->
  <section class="lower-sec interview-related">
    <div class="sec-head sec-head--sub">
      <p class="sec-head__label u-grd-text">Related Interviews</p>
      <h2 class="sec-head__title sec-head__title--cap">関連インタビュー</h2>
    </div>
    <ul class="interview-related__list">
      <?php
      foreach ( $ni_related as $post ) :
      	setup_postdata( $post );
      	?>
      <li>
<?php get_template_part( 'template-parts/interview-card' ); ?>
      </li>
      	<?php
      endforeach;
      wp_reset_postdata();
      ?>
    </ul>
    <a class="btn btn--w interview-related__btn" href="<?php echo ni_url( '/interview/' ); ?>">記事一覧へ戻る<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
  </section>
  <?php endif; ?>

</main>
<?php
get_footer();
