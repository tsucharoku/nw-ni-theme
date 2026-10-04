<?php
/**
 * 新卒 TOP・中途 TOP の「社員インタビュー」のカード（.voice-card。スライダー .voice__list の中身）
 *
 * get_template_part( 'template-parts/voice-card', null, array( 'post' => 記事の ID, 'offset' => 2 枚目なら true ) ) で呼ぶ。
 * 一言 = 投稿タイトル、写真 = ACF（interview_thumbnail）、入社区分・職種・タグ = タクソノミー
 * （社員インタビュー一覧のカード template-parts/interview-card.php と同じ項目）。入力した内容だけ出す。
 */

$ni_id    = (int) $args['post'];
$ni_url   = get_permalink( $ni_id );
$ni_img   = function_exists( 'get_field' ) ? get_field( 'interview_thumbnail', $ni_id ) : null;
$ni_chips = array_merge( ni_interview_terms( 'interview_entry_type', $ni_id ), ni_interview_terms( 'interview_job_type', $ni_id ) );
$ni_tags  = ni_interview_terms( 'interview_tag', $ni_id );
?>
      <li class="splide__slide voice-card<?php echo ! empty( $args['offset'] ) ? ' voice-card--offset' : ''; ?>">
        <a class="voice-card__img" href="<?php echo esc_url( $ni_url ); ?>"><?php
        if ( is_array( $ni_img ) && ! empty( $ni_img['url'] ) ) {
        	$ni_size = ! empty( $ni_img['sizes']['large'] ) ? 'large' : '';
        	printf(
        		'<img src="%s" alt="" width="%d" height="%d">',
        		esc_url( $ni_size ? $ni_img['sizes'][ $ni_size ] : $ni_img['url'] ),
        		(int) ( $ni_size ? $ni_img['sizes'][ $ni_size . '-width' ] : $ni_img['width'] ),
        		(int) ( $ni_size ? $ni_img['sizes'][ $ni_size . '-height' ] : $ni_img['height'] )
        	);
        }
        ?></a>
        <div class="voice-card__body">
          <div class="voice-card__row">
            <p class="voice-card__quote"><?php echo esc_html( get_the_title( $ni_id ) ); ?></p>
            <a class="arrow-pill arrow-pill--l voice-card__arrow" href="<?php echo esc_url( $ni_url ); ?>" aria-label="記事を読む"><img src="<?php echo ni_img( 'common/arrow_pill_white_l.svg' ); ?>" alt="" width="20" height="24"></a>
          </div>
          <?php if ( $ni_chips || $ni_tags ) : ?>
          <div class="voice-card__meta">
            <?php if ( $ni_chips ) : ?>
            <ul class="voice-card__chips"><?php foreach ( $ni_chips as $ni_term ) : ?><li><?php echo esc_html( $ni_term->name ); ?></li><?php endforeach; ?></ul>
            <?php endif; ?>
            <?php if ( $ni_tags ) : ?>
            <ul class="voice-card__tags"><?php foreach ( $ni_tags as $ni_term ) : ?><li># <?php echo esc_html( $ni_term->name ); ?></li><?php endforeach; ?></ul>
            <?php endif; ?>
          </div>
          <?php endif; ?>
        </div>
      </li>
