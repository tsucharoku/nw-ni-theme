<?php
/**
 * 共通の枠（ヘッダー・フッターだけ）。
 * 各ページの中身（front-page.php / page-○○.php / archive-○○.php / single-○○.php / 404.php）は未着手で、
 * できるまではどのページもこのテンプレートで表示される。
 */

get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">
</main>
<?php
get_footer();
