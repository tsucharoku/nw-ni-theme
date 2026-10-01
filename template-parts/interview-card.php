<?php
/**
 * 社員インタビューのカード（.interview-card。社員インタビュー一覧の .interview-list__grid の中身）
 *
 * 投稿のループの中で get_template_part( 'template-parts/interview-card' ) で呼ぶ。
 * 一言 = 投稿タイトル、氏名・写真 = ACF（interview_name / interview_thumbnail）、
 * 入社区分・職種・タグ = タクソノミー（interview_entry_type / interview_job_type / interview_tag）。入力した内容だけ出す。
 */

$ni_name  = function_exists( 'get_field' ) ? (string) get_field( 'interview_name' ) : '';
$ni_img   = function_exists( 'get_field' ) ? get_field( 'interview_thumbnail' ) : null;
$ni_chips = array_merge( ni_interview_terms( 'interview_entry_type' ), ni_interview_terms( 'interview_job_type' ) );
$ni_tags  = ni_interview_terms( 'interview_tag' );
?>
        <a class="interview-card" href="<?php the_permalink(); ?>">
          <div class="interview-card__img"><?php
          if ( is_array( $ni_img ) && ! empty( $ni_img['url'] ) ) {
          	$ni_size = ! empty( $ni_img['sizes']['large'] ) ? 'large' : '';
          	printf(
          		'<img src="%s" alt="" width="%d" height="%d" loading="lazy">',
          		esc_url( $ni_size ? $ni_img['sizes'][ $ni_size ] : $ni_img['url'] ),
          		(int) ( $ni_size ? $ni_img['sizes'][ $ni_size . '-width' ] : $ni_img['width'] ),
          		(int) ( $ni_size ? $ni_img['sizes'][ $ni_size . '-height' ] : $ni_img['height'] )
          	);
          }
          ?></div>
          <div class="interview-card__body">
            <div class="interview-card__txt">
              <p class="interview-card__quote"><?php the_title(); ?></p>
              <?php if ( '' !== $ni_name ) : ?>
              <p class="interview-card__name"><?php echo esc_html( $ni_name ); ?></p>
              <?php endif; ?>
            </div>
            <?php if ( $ni_chips || $ni_tags ) : ?>
            <div class="interview-card__meta">
              <?php if ( $ni_chips ) : ?>
              <ul class="interview-card__chips"><?php foreach ( $ni_chips as $ni_term ) : ?><li><?php echo esc_html( $ni_term->name ); ?></li><?php endforeach; ?></ul>
              <?php endif; ?>
              <?php if ( $ni_tags ) : ?>
              <ul class="interview-card__tags"><?php foreach ( $ni_tags as $ni_term ) : ?><li># <?php echo esc_html( $ni_term->name ); ?></li><?php endforeach; ?></ul>
              <?php endif; ?>
            </div>
            <?php endif; ?>
          </div>
        </a>
