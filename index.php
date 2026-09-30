<?php
/**
 * 共通の枠（ヘッダー・フッターだけ）。
 * 専用のテンプレート（front-page.php / page-○○.php / archive-○○.php / single-○○.php / taxonomy-○○.php / 404.php）が
 * 無いページは、このテンプレートで表示される。
 */

get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">
</main>
<?php
get_footer();
