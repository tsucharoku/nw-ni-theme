<?php
/**
 * 募集要項の 1 行（募集要項一覧・カテゴリ一覧の .job__list の中身）
 *
 * 投稿のループの中で get_template_part( 'template-parts/job-item' ) で呼ぶ。
 */
?>
          <li><a class="job-item" href="<?php the_permalink(); ?>"><span class="job-item__text"><?php the_title(); ?></span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
