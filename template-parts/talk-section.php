<?php
/**
 * 新卒 TOP・中途 TOP の「座談会（Cross Talk）」の節（.talk）
 *
 * get_template_part( 'template-parts/talk-section' ) で呼ぶ。出す記事は、表示中の固定ページの ACF「座談会（ピックアップ）」で
 * 選んだ座談会（最大 4 件。ni_talk_pickup()）。1 件目が最初に大きく出て、残りがサムネイルに並ぶ（切り替えは common.js）。
 * 番号 = 記事の番号（投稿順で自動。ni_cross_talk_number()）、タイトル = 投稿タイトル、メンバーの行 = 参加メンバーから
 * （ni_cross_talk_member_lines()）、写真 = アイキャッチ。未選択なら見出しと「すべての記事をみる」だけ出す。
 * 1 件だけのときはサムネイルと矢印を出さない（切り替える相手が無い）。
 */

$ni_talks = array();
foreach ( ni_talk_pickup() as $ni_talk_id ) {
	$ni_talks[] = array(
		'num'     => ni_cross_talk_number( $ni_talk_id ),
		'title'   => get_the_title( $ni_talk_id ),
		'url'     => get_permalink( $ni_talk_id ),
		'members' => ni_cross_talk_member_lines( $ni_talk_id ),
		'img'     => wp_get_attachment_image_src( get_post_thumbnail_id( $ni_talk_id ), 'large' ),
		'thumb'   => wp_get_attachment_image_src( get_post_thumbnail_id( $ni_talk_id ), 'medium' ),
	);
}
$ni_many = count( $ni_talks ) > 1;
?>
  <section class="talk">
    <div class="talk__main">
      <div class="talk__col">
        <div class="talk__head">
          <div class="sec-head sec-head--top">
            <h2 class="sec-head__en u-en">Cross<br class="u-pc"> Talk</h2>
            <div class="sec-head__body">
              <p class="sec-head__title sec-head__title--cap">座談会</p>
              <p class="sec-head__read">さまざまな切り口で紐解く、リアルな日本インフォメーション</p>
            </div>
          </div>
          <?php if ( $ni_talks ) : ?>
          <!-- 表示中の 1 件（選んだ記事を重ねて is-active をフェードで切り替え。common.js） -->
          <div class="talk__info">
            <?php foreach ( $ni_talks as $ni_i => $ni_talk ) : ?>
            <div class="talk__info-item<?php echo 0 === $ni_i ? ' is-active' : ''; ?>">
              <div class="talk__no">
                <p class="talk__num"><small>#</small><b><?php echo esc_html( $ni_talk['num'] ); ?></b></p>
                <h3 class="talk__title"><?php echo esc_html( $ni_talk['title'] ); ?></h3>
              </div>
              <?php if ( '' !== $ni_talk['members'] ) : ?>
              <p class="talk__members"><?php echo $ni_talk['members']; ?></p>
              <?php endif; ?>
            </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
        <?php if ( $ni_many ) : ?>
        <!-- サムネ（選んだ記事ぶん）。JS が 3 枠までに組み直し、表示中以外を出す（クリックで切り替え） -->
        <ul class="talk__thumbs">
          <?php foreach ( $ni_talks as $ni_i => $ni_talk ) : ?>
          <li><button type="button" class="talk-thumb" data-talk-to="<?php echo (int) $ni_i; ?>"><span class="talk-thumb__img"><?php
          if ( $ni_talk['thumb'] ) {
          	printf( '<img src="%s" alt="" width="%d" height="%d">', esc_url( $ni_talk['thumb'][0] ), (int) $ni_talk['thumb'][1], (int) $ni_talk['thumb'][2] );
          }
          ?></span><span class="talk-thumb__num">#<?php echo esc_html( $ni_talk['num'] ); ?></span><span class="talk-thumb__title"><?php echo esc_html( $ni_talk['title'] ); ?></span></button></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
      <?php if ( $ni_talks ) : ?>
      <!-- 大きな写真（記事へのリンク）。重ねて is-active をクロスフェード -->
      <div class="talk__img">
        <?php foreach ( $ni_talks as $ni_i => $ni_talk ) : ?>
        <a class="talk__img-item<?php echo 0 === $ni_i ? ' is-active' : ''; ?>" href="<?php echo esc_url( $ni_talk['url'] ); ?>"><?php
        if ( $ni_talk['img'] ) {
        	printf( '<img src="%s" alt="%s" width="%d" height="%d">', esc_url( $ni_talk['img'][0] ), esc_attr( $ni_talk['title'] ), (int) $ni_talk['img'][1], (int) $ni_talk['img'][2] );
        }
        ?></a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
    <div class="talk__foot">
      <?php if ( $ni_many ) : ?>
      <div class="slider-nav">
        <button type="button" class="arrow-pill arrow-pill--prev" aria-label="前へ"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></button>
        <button type="button" class="arrow-pill" aria-label="次へ"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></button>
      </div>
      <?php endif; ?>
      <a class="btn btn--w" href="<?php echo ni_url( '/cross-talk/' ); ?>">すべての記事をみる<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
    </div>
  </section>
