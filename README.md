# 日本インフォメーション 採用サイト — WordPress テーマ

https://recruit.n-info.co.jp/ のテーマ。静的 HTML（リポジトリ `tsucharoku/nw-nihoninfo-recruit-html`、案件フォルダの `HTML/`）から起こした。
この README の「下層ページの実装メモ」以降は、静的 HTML の README をテーマ向けに直して持ってきたもの（演出と CSS / JS の説明）。

## いまの状態（2026-10-02）

**全 18 ページを静的なままテーマ化し、募集要項（一覧・カテゴリ一覧・詳細）と社員インタビュー一覧、固定ページの一部（ACF）が WP の内容を出している段階。** ヘッダー・メニュー・フッターは共通化し、ほかのテンプレートの `<main>` は静的 HTML の内容を固定で出している（WP の投稿内容はまだ出していない）。静的 HTML と全ページ・PC / SP で、要素の寸法と位置・リンク先・画像・文言が一致することを確認済み。

これから: 残りのページの投稿のループ、カスタムフィールド（ACF Pro）、カジュアル面談のフォーム（Contact Form 7）、ヘッダー・メニュー・フッターの募集要項カテゴリへのリンク。ページの種類は `制作進行資料.xlsx`「ディレクトリマップ」、入稿項目は仕様書の Figma を見て決める。

## ページとテンプレート

| URL | テンプレート | WP での種類 | Figma（PC / SP） | ページ用 CSS / JS |
|---|---|---|---|---|
| `/` TOP 扉 | `front-page.php` | サイトのトップ | 419:2708 / 474:10416 | `top.css` |
| `/beginner/` 新卒・中途（未経験者）TOP | `page-beginner.php` | 固定ページ | 176:152 / 470:2668 | `components.css` `beginner.css` / FV のモジュール一式 |
| `/career/` 中途（経験者）TOP | `page-career.php` | 固定ページ | 419:924 / 474:8465 | `components.css` `beginner.css` `career.css` / `fv-unfold.js` + FV のモジュール |
| `/about/` 3分でわかるNI | `page-about.php` | 固定ページ | 522:9048 / 1137:10919 | `about.css` / `about.js` |
| `/chart/` 仕事の相関図 | `page-chart.php` | 固定ページ | 720:6705 / 1137:10926 | `chart.css` / `chart.js` |
| `/development/` 教育・研修・キャリアパス | `page-development.php` | 固定ページ | 553:10756 / 1137:10920 | `development.css` / `development.js` |
| `/work-style/` 制度・環境 | `page-work-style.php` | 固定ページ | 557:13142 / 1137:10921 | `work-style.css` / `work-style.js` |
| `/office/` オフィス紹介 | `page-office.php` | 固定ページ | 562:14690 / 1137:10922 | `office.css` |
| `/casual-talk/` カジュアル面談フォーム | `page-casual-talk.php` | 固定ページ | 900:29128 / 1137:10932 | `form.css` / `form.js` |
| `/casual-talk/thanks/` 送信完了 | `page-thanks.php` | 固定ページ（casual-talk の子） | 900:29656 / 1137:10933 | `form.css` |
| `/interview/` 社員インタビュー一覧 | `archive-interview.php` | カスタム投稿 `interview` | 855:23614 / 1137:10928 | `interview.css` / `interview.js` |
| `/interview/{パーマリンク}/` 詳細 | `single-interview.php` | 同上 | 855:25987 / 1137:10929 | `interview.css` |
| `/cross-talk/` 座談会一覧 | `archive-cross-talk.php` | カスタム投稿 `cross-talk` | 892:27328 / 1137:10930 | `cross-talk.css` |
| `/cross-talk/{パーマリンク}/` 詳細 | `single-cross-talk.php` | 同上 | 900:28229 / 1137:10931 | `cross-talk.css` |
| `/job-opening/` 募集要項一覧 | `archive-job-opening.php` | カスタム投稿 `job-opening` | 562:15771 / 1137:10923 | （共通のみ） |
| `/job-opening/{カテゴリのスラッグ}/` カテゴリ | `taxonomy-job-category.php` | タクソノミー `job-category` | 562:16543 / 1137:10924 | `job-opening.css` / `job-opening.js` |
| `/job-opening/{パーマリンク}/` 詳細 | `single-job-opening.php` | カスタム投稿 `job-opening` | 565:17162 / 1137:10925 | `job-opening.css` `editor-style.css` `form.css` / `job-opening.js` `form.js` |
| 404 | `404.php` | 404 | 900:30217 / 1137:10934 | `form.css` |

デザイン未 FIX で未着手: プロジェクトストーリー（`/beginner/story-1/` ほか）/ メッセージ（`/message/`）/ 業界の未来（`/future/`）。メニュー・フッターのリンクは `#` のまま。ほかに `#` のままのリンク: 公式採用インスタグラム / マイナビ新卒2028 / 個人情報保護方針 / コーポレートサイト。

## テーマの構成

```
acf-json/                ACF のフィールドグループの定義（管理画面で編集すると ACF がここに保存する）
functions.php            テーマの設定、ni_img() / ni_url() / ni_job_category_url()、<title>・description の受け渡し（ni_head()）、WP の絵文字スクリプトの停止
inc/post-types.php       カスタム投稿 interview / cross-talk / job-opening とタクソノミー（job-category、社員インタビューの interview_entry_type / interview_job_type / interview_tag）の登録、/job-opening/○○/ の振り分け、募集要項の並び順、社員インタビュー一覧の全件出力
inc/page.php             いまのページの種類（top / beginner / career / lower）と、ページごとの CSS・JS の対応表。<body> のクラス
inc/assets.php           CSS・JS の読み込み、three.js の import map、ES モジュール
inc/editor.php           ブロックエディタ: ブロックスタイル（is-style-○○）の登録、editor-style.css とフォントをエディタに読み込む
inc/cf7.php              Contact Form 7: 自動 <p> を切る、メールアドレス（確認用）の一致チェック、完了ページの URL、CSS・JS を読むページ
cf7/                     CF7 のフォームの中身（entry-form.txt）とメール本文（entry-mail.txt）。管理画面の CF7 に貼る元
header.php               <head> 〜 ハンバーガーメニューまで
template-parts/menu.php      ハンバーガーメニュー
template-parts/fv-frame.php  FV の青いフレーム（新卒 TOP・中途 TOP）
template-parts/job-item.php  募集要項の 1 行（一覧・カテゴリ一覧の共通）
footer.php               フッター 〜 </html>
front-page.php ほか      上の表のテンプレート（<main> の中身）
index.php                専用のテンプレートが無いページ用（ヘッダー・フッターだけ）
assets/                  CSS / JS / 画像 / 動画 / vendor（静的 HTML の assets と同じ構成。下の「assets の構成」）
```

- **ページの種類で変わる共通部分**: 新卒 TOP はヘッダーに CTA ボタン 2 つ（`header--cta`）と「誰向けか」の表記、中途 TOP は表記だけ。新卒 TOP・中途 TOP は FV の青いフレームと `<body data-sweep="off">`、ヘッダーのリンクから自分を除く。新卒 TOP のフッターにだけ `data-header-hide`。
- **`<body>` のクラス**は静的 HTML と同じ `page-top` / `page-beginner` / `page-career` / `page-lower page-○○`（`inc/page.php`）。WP 標準のクラスも一緒に付く。
- **`<title>` と meta description** は、各テンプレートが `get_header()` の前に `ni_head()` で渡している（静的 HTML の値のまま）。
- **リンクと画像**: サイト内リンクは `ni_url( '/about/' )`、画像は `ni_img( 'common/logo_black.svg' )`（`assets/img/` 以下）。
- **3分でわかるNI の数字のカードは管理画面で編集**（`page-about.php`）: 固定ページ `about` の ACF「3分でわかるNI」（`acf-json/group_ni_about.json`、タブ 3 つ = 会社・事業規模 / 仕事・リサーチ環境 / 働き方・カルチャー）。設計書は「NI採用サイト_ACFフィールド設計書_3分でわかるNI.xlsx」。カードの数・並び・ページ頭・セクション見出し・社員に聞きましたは固定。
  - 入力した内容だけを出す（初期値・ダミーは出さない。2026-10-02 ユーザー指示）。未入力の画像は出さない。テストサーバー・本番では全項目の入力が要る。値はフィールドキー（`field_ni_about_○○`）で引く（名前で引くと、一度も保存していないページでは ACF がフィールドを特定できない）。
  - 改行は入力した改行どおり `<br>`（PC だけ・SP だけの改行は無い）。
  - 設計書から変えたところ（2026-10-02 にユーザーと決定）: 業界成長率のサブコピーは作らず、グラフ画像の欄 = 右のアイコンの差し替え / コミュニケーションランチに数値・単位、AI ツールにカード見出し、社内懇親会・無料軽食・制度の柔軟性にリード（大きい文字）を追加 / 制度の柔軟性・パネルリーチ規模の写真（イラスト）は作らない（今のデザインに無い）/ パネルリーチ規模・平均勤続年数は数値と単位に分ける / 異業種からの活躍例は前職・今の役職の 2 欄 / タイトル・リードは改行できるようテキストエリア / 男女比はグラフにしない（今のデザインどおり数字 2 つ。説明文の初期値は設計書の例）。
  - 年間調査件数の円グラフ = 手法内訳（リピーター）から `conic-gradient` で描く。割合は合計に対する比、色は 4 色（#11296b → #4a94e8）を上から繰り返す、ラベルは扇の中央・中心から 70px、下の内訳の文と aria-label も内訳から作る。未入力なら円グラフと内訳の文は出さない（ダミーは出さない）。
- **教育・研修・キャリアパスの「キャリアパス」は管理画面で編集**（`page-development.php`）: 固定ページ `development` の ACF「キャリアパス」（`acf-json/group_ni_development.json`、設計書は「NI採用サイト_ACFフィールド設計書_キャリアパス.xlsx」）。それ以外の節（研修・成長ステップなど）は固定。
  - 路線リスト（リピーター `route_list`）= タブ 1 つずつ（路線タイトル `route_label`）→ CASE リスト（`route_case_list`: 出発職種・到達職種・説明文・タイムラインステップ（年次バッジ・タイトル・本文）・関連インタビュー記事）。CASE が複数あれば縦に並べ（間 80px。デザインに無い）、CASE 番号は路線ごとに 1 から自動。入力した内容だけ出す（路線が無ければ見出しと説明だけ）。
  - 設計書と Figma の注釈（「3 路線は固定で表示・非表示をチェックボックス」）が食い違っていたが、2026-10-02 にユーザーと設計書どおり（リピーター）に決定。
  - **未対応**: 関連インタビューのカードは、社員インタビューの入力項目（写真・名前・一言・入社区分・職種・ハッシュタグ）が未定のため、いまは記事のタイトルとリンクだけ（記事にアイキャッチがあれば写真も出すが、interview はまだアイキャッチ非対応）。未選択ならカードを出さない。
- **制度・環境は管理画面で編集**（`page-work-style.php`）: 固定ページ `work-style` の ACF「制度・環境」（`acf-json/group_ni_work_style.json`、タブ 5 つ。設計書は「NI採用サイト_ACFフィールド設計書_制度・環境.xlsx」）。固定はページ頭・カルチャー・各セクションの見出しと説明・働き方の大カード 2 枚の見出し・本文・アイコン。
  - ACF: 働き方の社員の声（写真・役職年次・引用）× 2 / ミニカード・福利厚生カード（支援内容 = 大きい金額の行、PC のみ）・社内コミュニケーションのミニカード・制度カード（リピーター、アイコン SVG 可）/ 社内コミュニケーションの大カード 3 枚（タイトル・写真・サブタイトル・本文。並びは表彰 → サンクス → ランチで固定）/ 写真の帯（ギャラリー）。必須は設計書どおり。入力した内容だけ出す（未入力のリピーター・写真の帯は丸ごと出さない）。
  - 設計書から足したもの（2026-10-02 にユーザーと決定）: 写真の帯のギャラリー（Figma の注釈「画像は全て差し替え可能にする」）、制度カードのアイコン（デザインにある）。
- **SVG のアップロードは管理者だけ許可**（`functions.php` の `ni_upload_mimes_svg()` / `ni_check_filetype_svg()`。3分でわかるNI のアイコンなど、設計書「SVG 可」）。SVG は寸法を持たないので、出すときは width / height を付けず CSS で大きさを決める。
- **新卒 TOP の CTA（マイナビ新卒）は管理画面で編集**: 固定ページ `beginner` の ACF「新卒CTA」（ボタンテキスト `cta_text` / リンク先 `cta_url`。`acf-json/group_ni_beginner_cta.json`）。新卒 TOP のヘッダーのボタンと、Entry の新卒採用のボタン（PC / SP）の 3 か所で使う（`ni_beginner_cta()`）。空ならテキスト「マイナビ新卒2028」・リンク先 `#`。別タブで開く。隣の「募集職種一覧を見る」は固定。
  - ACF の場所「固定ページ ==」は、acf-json にページ ID ではなくパス（`beginner`）を書いている（ID は環境ごとに変わるため。`functions.php` の `ni_acf_match_page_path()` がパスで照合する）。管理画面でこのフィールドグループを開くと場所の値が正しく表示されない。そこで保存すると場所が書き換わるので、保存したら acf-json の `value` を `beginner` に戻す。
- **募集要項のカテゴリの URL**: `/job-opening/○○/` はカテゴリと詳細が同じ階層なので、タクソノミーには rewrite を付けず、○○ がカテゴリのスラッグならカテゴリ一覧に振り分けている（`ni_job_category_request()`）。同じスラッグの投稿があってもカテゴリが優先される。
- **募集要項の一覧・カテゴリ一覧は WP の内容**（仕様書 43:3721 / 69:4352）。カテゴリの数・名前・スラッグ・並びはコードに書いていない。
  - 一覧（`archive-job-opening.php`）: カテゴリごとに、ページ内リンク `カテゴリ名（件数）` → `#スラッグ`、英語表記・カテゴリ名・説明、職種を 5 件まで。**5 件以上あるカテゴリ**には「○○の募集一覧をみる」（カテゴリ一覧へ）を出す（仕様書の付箋「5件以上でアーカイブ同線表示」）。投稿が 1 件も無いカテゴリは出さない。ページ頭の見出し・リード文は固定。
  - カテゴリ一覧（`taxonomy-job-category.php`）: そのカテゴリの職種を全件出し、`lower.js` の `.js-more` が 10 件ずつ見せる（Ajax・ページ送りはしていない）。h1・パンくず・`<title>` は `カテゴリ名 + の募集一覧`。投稿が無いカテゴリの URL を直接開くと空の一覧になる（デザインなし）。
  - カテゴリの入稿項目: 名前 / スラッグ / 説明（WP 標準）/ 英語表記（ACF `label_en`。`acf-json/group_ni_job_category.json`）。英語表記・説明は空ならその行を出さない。
  - 並び順: 管理画面の並び替え（Intuitive Custom Post Order）の順。投稿は `menu_order` の小さい順 → 公開日の新しい順（`ni_job_orderby()`）、カテゴリはプラグインが付ける順。
  - **未対応**: ヘッダー「アルバイト」とメニュー・フッター「募集中の職種一覧」の 4 つのリンク。どれをどのカテゴリに向けるかが未定で、`ni_job_category_url()` が 4 つとも一覧（`/job-opening/`）に向けている。
- **募集要項詳細も WP の内容**（`single-job-opening.php`。仕様書 732:3342「全ブロック包含」。青文字 = CMS で編集、黒文字 = 固定）
  - カテゴリ = 投稿に付いた `job-category` の 1 つ目。ページ頭の小見出し・パンくず（→ カテゴリ一覧）・その他の募集職種に使う。
  - 職種名 = タイトル。リード文 = ACF `lead`（`acf-json/group_ni_job_opening.json`。仕様書には無くデザインにある。空なら出さない。改行は PC だけ `<br class="u-pc">`）。meta description はリード文、無ければ「日本インフォメーション株式会社 {カテゴリ}「{職種名}」の募集要項です。」
  - 本文 = Gutenberg。**エントリーフォームも本文の中**（仕様書・デザインともエディタの範囲内）: h2「エントリー」（HTML アンカー `entry`）+ CF7 本体の「Contact Form 7」ブロック（プルダウンでフォームを選ぶ）。白い箱は `job-opening.css` の `.job-detail .entry-content .wpcf7`。アルバイト用など別のフォームを作れば投稿ごとに選べる。
  - 左のアンカーナビ = 本文の h2 から自動で作る（仕様書でナビは青文字）。リンク先は h2 の「HTML アンカー」、空なら `job-sec-1` から順に付ける。h2 が無ければナビを出さない。
  - その他の募集職種 = 同じカテゴリの他の職種を**全件**（表示中の職種は除く、並びは `ni_job_orderby()`）。英字はカテゴリの英語表記（デザイン 576:7609。空なら出さない）。0 件なら一覧だけ出さず、見出しと「募集中の職種一覧に戻る」は出す。
- **社員インタビュー一覧は WP の内容**（`archive-interview.php`。仕様書 35:362、設計書は「NI採用サイト_ACFフィールド設計書_社員インタビュー.xlsx」）。ページ頭（見出し・リード文）は固定。**詳細（`single-interview.php`）はまだ静的**。
  - タクソノミー 3 つ: 入社区分 `interview_entry_type` / 職種 `interview_job_type` / タグ `interview_tag`。絞り込みとカードの表示に使うだけで、ターム別の一覧ページは無い（`public => false`）。タームはコードに書いていない。
  - ACF「社員インタビュー」（`acf-json/group_ni_interview.json`）: 氏名 `interview_name` / サムネイル用画像 `interview_thumbnail`。**一覧で使う 2 つだけ**。設計書にある詳細用の項目（アイキャッチ・サイド追従画像 `interview_side_image`・スケジュール `interview_schedule`）は詳細を作るときに足す。画像の戻り値は設計書の URL ではなく配列（width / height を出すため）。
  - 絞り込み: 公開記事があるタームだけ出す。見出しはデザインどおり「年次」（= 入社区分）/「職種」/「タグ」。年次・職種は件数つき（絞り込むたびに `interview.js` が数え直す）。タームの並びは管理画面の並び替え（Intuitive Custom Post Order）。
  - カード（`template-parts/interview-card.php`）: 一言 = 投稿タイトル、氏名、写真、入社区分 + 職種（丸チップ）、タグ（`# 名前`）。入力した内容だけ出す（写真が無ければ枠だけ）。
  - 全件を出力し（`ni_interview_archive_query()`、公開日の新しい順）、12 件ずつ見せるのと絞り込みは `interview.js`（Ajax・ページ送りはしていない）。カードの `data-type` / `data-job` / `data-tags` はタームの ID。件数は仕様書では 6 件ずつだが、デザイン（3 列・12 件ずつ）に合わせている。
- **WP の絵文字スクリプトは止めている**: 本文の絵文字（🎉 🏆）が `<img class="emoji">` に置き換わって文字幅が変わるため。

## WP 側に必要なデータ

テンプレートは URL（スラッグ）で決まるので、次のものが WP に無いとページが出ない。Local では WP-CLI で作成済み。テストサーバーでも同じものを作る。

- 固定ページ: `beginner` / `career` / `about` / `chart` / `development` / `work-style` / `office` / `casual-talk` / `casual-talk` の子の `thanks`
- 静的なあいだのサンプル（静的 HTML の `detail/` と同じ URL にするため）: `interview` / `cross-talk` / `job-opening` にスラッグ `detail` の投稿を 1 件ずつ。Local の `job-opening` の `detail`（アルバイト「定性調査のモデレーター」）には、静的 HTML の本文と同じブロック一式とエントリーフォーム、リード文を入れてある
- プラグイン: **Advanced Custom Fields PRO**（有効化するとテーマの `acf-json/` の項目が出る）、**Intuitive Custom Post Order**（設定 → 並び替え設定 で、投稿タイプ「募集要項」とタクソノミー「募集要項カテゴリ」、社員インタビューの「入社区分」「職種」「タグ（ハッシュタグ）」にチェック）、**Contact Form 7**（日本語の翻訳も入れる: `wp language plugin install contact-form-7 ja`）
- CF7 のフォーム「エントリーフォーム」: 新規作成し、「フォーム」タブに `cf7/entry-form.txt`、「メール」タブの本文に `cf7/entry-mail.txt` を貼る。メールの宛先 `[_site_admin_email]`、件名 `[_site_title] エントリー：[_post_title]（[your-name] 様）`、追加ヘッダー `Reply-To: [your-email]`、ファイル添付 `[resume]`（改行して）`[cv]`。メール (2)（自動返信）は使っていない。送信できたら `/casual-talk/thanks/` へ移る（`form.js` の [C]）。各募集要項の本文の最後に h2「エントリー」+ Contact Form 7 ブロックでこのフォームを置く
- 募集要項のカテゴリ（`job-category`）と投稿。Local にはサンプルとして、静的 HTML と同じ内容を入れてある: カテゴリ 4 つ（新卒採用 `new-graduate` / 中途採用(未経験) `mid-beginner` / 中途採用(経験者) `mid-career` / アルバイト `part-time`）、投稿 1 / 4 / 4 / 24 件
- 社員インタビューのターム（入社区分・職種・タグ）と投稿。Local にはサンプルとして、静的 HTML の一覧と同じ 18 件を入れてある: 入社区分 4 つ（新卒入社 / 中途入社(未経験) / 中途入社(経験者) / アルバイト）、職種 5 つ（営業 / リサーチャー / FW / IRG / NI研）、タグ 2 つ（フルリモート / 時短勤務）、写真はテーマの `assets/img/common/voice_card_01〜03.jpg` をメディアに取り込んだもの。1 件目はスラッグ `detail`（静的な詳細の URL）、ほかは `sample-02`〜`sample-18`
- 教育・研修・キャリアパス（固定ページ `development`）のキャリアパスは Local に Figma の 3 路線（各 CASE1・4 ステップ、関連インタビューはサンプルの `detail`）を入力済み。テストサーバーでも入れる
- 制度・環境（固定ページ `work-style`）の ACF は今のページと同じ内容を入力済み（Local。福利厚生はデザインの 7 枚、画像はテーマの `assets/img/work-style/` をメディアに取り込んだもの）
- 3分でわかるNI（固定ページ `about`）の ACF は全項目入力済み（Local）。写真・アイコンはテーマの `assets/img/about/` の今の画像をメディアライブラリに取り込んだもの。テストサーバーでも同じ内容を入れる（未入力の項目は何も出ない）
- パーマリンク設定は「投稿名」（`/%postname%/`）。投稿タイプを変えたらパーマリンクを保存し直す（`wp rewrite flush`）
- サイトの言語は日本語（`<html lang="ja">` になる）

## CSS / JS の読み込みとキャッシュ対策

- 読み込むファイルは `inc/page.php` の対応表（`ni_page_map()`）で決まる。順は静的 HTML と同じで、CSS は フォント → (Splide) → base → common → components → lower → ページ用、JS は (Splide) → common → footer-insight → lower → ページ用 → ES モジュール。TOP 扉は base / common / top だけ。
- `?ver=` はファイルの更新時刻（静的 HTML の `?v=YYYYMMDDHHMM` の置き換え）。CSS / JS を変えれば自動で変わる。
- **ES モジュール（FV の演出）だけ注意**: ブラウザは `?v=` まで含めた URL でモジュールを見分けるので、同じファイルを違う URL で読むと 2 回実行される。`fv-scroll.js` と `fv-about.js` はほかのモジュールから `import … from './fv-scroll.js?v=202609181000'` の形で読まれている。
  - `<script type="module">` 側の `?v=` は、import されているファイルなら import に書いてある値、それ以外は更新時刻が自動で付く（`inc/assets.php` の `ni_module_import_vers()`）。PHP 側で値を書き換える必要はない。
  - **`fv-scroll.js` か `fv-about.js` を直したら、`assets/js/*.js` の中の `?v=` を同じ新しい値に一括置換する**（値がばらけると進行度が共有されなくなる。置換しないと更新が端末に届かないことがある）。

## ローカル確認

Local（Flywheel）のサイト `http://ni.localhost/`。WP-CLI は案件フォルダで `source Local/app/.envrc` してから `Local/app/public` で `wp …`。
静的 HTML と見比べるときは `python3 -m http.server 8770 --directory HTML`（URL の構成は WP と同じ。404 だけ `/404.html`）。

## Figma

- デザイン: https://www.figma.com/design/opYGDQklgdjfC6rKNvw9jC/ni （view 権限のみで Figma MCP からは読めない）。MCP で読むときはユーザー所有の複製 `hu3TKQFAQ4B328fle7gPeP`（https://www.figma.com/design/hu3TKQFAQ4B328fle7gPeP/ni--Copy- 。2026-09-30 に複製し直したもの。ノード ID は同じ）
- 仕様書（画面設計）: fileKey `AGijGTgPtyohq1gAk8wVNz`（日本インフォメーション様_採用サイト_画面設計 の複製）
- デザイナーのデモ: 案件フォルダの `デモ/NI_TOP.html`（three.js。元データは `NI-FV/`）


## 下層ページの実装メモ

- **共通**: `assets/css/lower.css`（`.page-head` ページ頭 / `.breadcrumb`（1 行、最後の項目を … で省略）/ `.anchor-nav` ページ内リンクの丸ボタン / `.more-btn`「次の N 件をみる」/ `.lower-sec` 左右余白 / `.job-cat` 募集要項のカテゴリ行）と `assets/js/lower.js`（`[data-anim="inview"]` → `is-inview`、`.js-more`、`.js-accordion`）。読み込み順は base → common → components → lower → ページ用。
- **ヘッダー**: TOP 扉と同じ（CTA なし）。`.page-head` に `id="js-fv"` を付けてあり、通過すると common.js が `.header` に `is-fixed` を付ける（ハンバーガーに白い箱）。
- **ページ頭の背景のガラスの NI ロゴ**: Figma は白地の動画ポスター（ni-logo-only）を重ねたもの。白を透過に直した PNG（`assets/img/lower/pagehead_ni.png`）を静止画で置いている（下層では WebGL を使わない）。
  - **置き場所**: `.page-head` の中ではなく、`header.php` が `<main>` の前に 1 回だけ出す（`.page-ni`）。位置の基準は本文の枠（PC は最大 1440px で中央寄せ）の右上で、1440px より広い画面でも本文と同じ位置関係を保つ。横のはみ出しだけ画面の端で切り、縦は切らない（ページ頭が短いページでは本文の背後まで見える）。`.page-head` 自体も本文（`.lower-sec`）と同じ最大 1440px・中央寄せ。
  - **出すページ**は `inc/page.php` の `ni_logo`。Figma の見出し部品（H2）の中のロゴが非表示のページに合わせている（2026-10-01 に全ページ PC / SP を確認）: 募集要項カテゴリ・募集要項詳細は PC / SP とも出さない。社員インタビュー詳細・座談会詳細は PC は出さず SP だけ出す（Figma の PC と SP で違う。要確認）。それ以外の下層は出す。
- **募集要項詳細の本文 = Gutenberg**: `<div class="entry-content">` の中は Gutenberg が実際に出すマークアップ（`wp-block-heading` / `wp-block-image` / `wp-block-video` / `wp-block-list` / `wp-block-quote` / `wp-block-buttons` / `wp-block-media-text` / `wp-block-table` / `wp-block-columns` / `wp-block-details`）。コアに無い部品は `is-style-*` のブロックスタイル想定（HTML 内のコメントに「core/○○ + is-style-○○」と書いてある）。**レイアウトの仕組みは WP 標準のブロック CSS に任せる**（画像＋テキストのグリッド・画像の左右・メディアの幅・縦位置、カラムの並び・列の幅・モバイルで縦に並べる、ボタンの並び・幅、画像の幅、表の固定幅セル、埋め込みの縦横比 = `responsive-embeds`）。`assets/css/editor-style.css` は見た目（色・文字・角丸・部品の中の余白）だけを足す。デザインに近づけるのはブロックの設定で行う（サンプル投稿: 画像＋テキストのメディアの幅 35%・縦位置 上、コメントは 11%・モバイルでも横並び、プロフィールは 1 列目 80px・縦位置 上・モバイルでも横並び）。2026-10-01 にそれまで editor-style.css で flex や固定幅に組み直していたのを外した（左右の入れ替えや幅の設定が効かなかったため）。editor-style.css は先頭で base.css と同じトークンを `:root` に再掲、それ以外の全セレクタが `.entry-content` 始まり。エディタには `inc/editor.php` が読み込む（募集要項の編集画面だけ。`.entry-content` 自体 → `body`、`.entry-content > ` → `.is-root-container > `、それ以外の `.entry-content ` は外して渡し、エディタが `.editor-styles-wrapper` を付ける。エディタの見え方は近いが完全一致ではない）。ブロックスタイルは `inc/editor.php` で登録（ラベルは日本語）。フロントでは WP 標準のブロック CSS（`wp-block-*` / `global-styles` / `classic-theme-styles`）も読まれる。**未対応**: 標準 CSS の見た目でデザインとずれる箇所がある（画像キャプションの下余白 12px、表の thead の下の 3px の線、画像＋テキストの文の左右の余白 8% など）。見た目のずれだけ editor-style.css で上書きする予定（レイアウトの仕組みは上書きしない）。base.css のトークンを変えたらこのファイル先頭も合わせる。左の追従アンカーナビ・ページ頭・エントリーフォームの箱・その他の募集職種はテンプレート側（`job-opening.css`）。
- **フォーム = Contact Form 7**（募集要項詳細は本物の CF7。**未対応**: カジュアル面談はまだ静的なフォームのまま。CF7 の CSS・JS は募集要項詳細だけで読む（`inc/cf7.php`）。静的なフォームで読むと CF7 の JS が送信を横取りするため）: `.wpcf7` 以下は CF7 の出力 DOM に合わせてある（`span.wpcf7-form-control-wrap` / `.wpcf7-checkbox > .wpcf7-list-item` / `.wpcf7-acceptance` / `.wpcf7-file` / `.wpcf7-submit` / `.wpcf7-not-valid-tip` / `.wpcf7-response-output`）。行の構造（`.form__row` / `__label` / `__req` / `__field`）は CF7 のフォームテンプレートに書く部分。CF7 の自動 `<p>` / `<br>` は切る（`wpcf7_autop_or_not`）。`form.js` の [B]（必須チェック・同意で送信可・完了ページへ移動）は静的なフォームだけで動く（本物の CF7 のフォーム = 隠し項目 `_wpcf7` がある form では動かさない。カジュアル面談を CF7 にしたら [B] は消す）、[A]（select / date が空の間グレーにする）は残す、[C]（送信できたら form の `data-thanks` へ移動）は本物の CF7 のフォーム用。メールアドレス（確認用）の一致チェックは `inc/cf7.php`。**要確認**: CF7 のメールの宛先・件名・本文・自動返信の有無（いまは仮でサイト管理者宛て）。
- **ギミック**: 制度・環境の「社内コミュニケーション」= 中央 1 枚 → 背後のカードが左右にゆっくり開く → クリック / ドラッグ / 左右キーで入れ替え（`work-style.js`、Figma 付箋 1370:17451、参考 https://ni-communication.pages.dev ）。教育・研修の成長ステップ = 横スクロール + ヒント（PC マウス / SP 指のアイコン、バーのループ。付箋 1370:17427）。3分でわかるNI = 円グラフが回って出る（数字のカウントアップは 2026-10-02 に外した。指示の出典が無かったため）。インタビュー一覧 = 絞り込み（年次・職種は単一、タグは複数、グループ間 AND）。動きは `prefers-reduced-motion` で止まる。
- **仕事の相関図（`page-chart.php`）**: 図は `.chart` = Figma の img（722:8368）と同じ 1248×2372px 固定の「ステージ」。カードとラベルは HTML で、`style="--x:…;--y:…"`（Figma の座標そのまま）で絶対配置。線と矢印は `assets/img/chart/lines.svg`、イラストは `illust_*.svg`。どちらも Figma で図全体を SVG 書き出し（`download_assets` で 722:8368 を svg 指定。レイヤー名が id に残る）したものから、スクリプトでレイヤー単位に切り出した（ラベルと文字は除く）。デザインが変わったら同じ手順で切り出し直し、HTML の座標を直す。
  - PC: `chart.js` がステージを枠の幅に合わせて縮小するだけ（1440px 以上で等倍）。
  - SP: 図は Figma の SP と同じ**ボタンなしの画像**（`assets/img/chart/chart_sp.webp`。Figma 1456:21700 `img 3` の元画像 2237×4096 を可逆 WebP にしたもの）。2026-09-30 にユーザー確認のうえ HTML の図から切り替えた（全体表示ではボタンが押せない大きさになるので、Figma はボタンを図の外に出している）。枠（罫線 2px、内側 24 / 16）の中で、ピンチで拡大・縮小（上限 = PC の実寸 1248px 幅）、拡大中は 1 本指で移動、ダブルタップで拡大 / 戻す、リセットボタン。等倍のときの縦スワイプはページのスクロール（`touch-action: pan-y`）。付箋 1370:17497 の参考 CodePen は Cloudflare の確認画面で読めなかったので、付箋の文面から実装している。
  - SP の図の下に「各職種のインタビューを見る」（7 リンク、SP のみ）。リンク先は仮で `/interview/`（職種の絞り込みに差し替える）。
  - **文言やデザインを変えるとき**: PC は `page-chart.php` の HTML、SP は画像の差し替え（Figma から書き出し直し）の両方が要る。`.chart`（PC）と `.chart-pic`（SP）は `loading="lazy"` + `display: none` で、表示しない側の画像は読み込まれない。
  - Figma との差: 本部ブロックの下にある白い四角（`label/回答`、文字なしの消し忘れとみて）は PC の HTML には置いていない（SP の画像には Figma のまま残っている）/ SP のリンクの「経営企画部」は図の表記に合わせて「経営企画室」にした（要確認）。
- **確認用の全ページ撮影**: ヘッドレス Chrome で、URL に `?capture=1` を付けて撮る（付けないと 100vh の FV や動画で全体撮影が終わらないことがある）。
- **要確認（2026-09-27 時点）**: フォームの性別・興味のある職種の選択肢は仮 / 教育・研修は Figma の `get_metadata` がフレーム直下の子を返さず（レート上限とは別）座標照合なし / 「中途(リサーチ経験者)」タブと Case2・3 はダミー / 制度・環境 SP は福利厚生の金額行なし（Figma SP どおり）/ Figma の SP は Tight/S = 18px だが base.css の `--fs-tight-s` は SP 20px（下層は該当箇所を 18px 直指定）。

## About / Entry の切り替え（縦バーのスイープ）を一時停止するスイッチ

新卒 TOP・中途 TOP の `<body>` に `data-sweep="off"` が付いていると（`header.php` が付けている）、PC でも About の固定・モザイク（`fv-about.js`）と Entry の登場スイープ（`fv-entry.js`）を行わず、SP と同じ通常フローになる（`components.css` の `body[data-sweep="off"]` の上書き。Entry の前には fv-entry.js の GAP と同じ 200px を CSS で付ける）。2026-09-16 に「動きの確認のため一旦なくす」指示で付けた。**戻すときは `header.php` の `data-sweep="off"` を消すだけ**（JS / CSS の分岐は残してよい）。新卒の Message（画面固定）はそのままで、About が下からスクロールで重なって覆う。

## 背景動画の `<source>` の順

`fv_bg.mp4`（H.264）を先、`fv_bg.webm` を後にしている（2026-09-17）。webm は VP9 Profile 1（yuv444p）で、iOS Safari（iPhone 18.7 の実機で確認）は WebM を選ぶがデコードできず readyState 1 のまま止まり、新卒・中途では 3D ロゴの canvas が背景に動画を描けず真っ白になる（TOP 扉はポスターの静止画）。webm を使いたければ Profile 0（yuv420p）で再エンコードしてから順を戻す。実機の切り分けは URL に `?diag`（右下に状態表示、fps 付き）/ `?nowebgl`（WebGL 演出を全部止める）/ `?off=blob,field,logo,havefun,copy,photos,frame`（モジュール単位で止める。frame は青いフレームの層ごと非表示）/ `?novideo`（動画を止めてポスター静止画）/ `?full=res,dpr,rate,bloom`（SP のロゴの軽量設定を項目ごとに PC と同じに戻す。`all` で全部。res = 屈折の背後描画を等倍、dpr = canvas 2 倍、rate = 毎フレーム描画）/ `?lite=back`（SP でも裏面パスを切る。2026-09-17 に一度切ったが平たく見えたので戻した）を付ける。

## About / Entry の背景画像はソフトライト合成を焼き込み済み

`about_skyline_blend.png`（下地 #517ea6）と `entry_bg_blend.png`（下地 #b5cbdc）は、元画像（`about_skyline.png` / `entry_bg.png`、Figma 書き出し）に W3C の soft-light を単色下地で焼き込んだもの（2026-09-17）。以前は CSS の `mix-blend-mode: soft-light` だったが、iOS ではブレンドモードの層がスクロールで画面に入ると下の全レイヤーと毎フレーム合成し直すため、新卒 SP で About が入ってくる区間が重くなっていた。画像を差し替えるときは元画像を置き換えてから同じ式で焼き直す（チャンネルごとの 256 段 LUT。手順は静的 HTML のリポジトリの、この変更のコミット参照）。

## assets の構成

```
assets/
  css/
    base.css         リセット / トークン(CSS変数) / レイアウト補助 / 固定背景
    common.css       header / ハンバーガーメニュー / footer / ボタン / カッコ(.bracket)
    components.css   新卒・中途で共有するセクション（section-heading, message, about, info,
                     do, story, future, voice, talk, culture, job, entry）
    top.css          TOP扉のみ
    beginner.css     新卒TOPの Hero（FV）
    career.css       中途TOPの Hero / Message(navy) / Openings / Why / 固定バナー ほか
  js/common.js       メニュー開閉 / 追従ヘッダー(IntersectionObserver) / タブ / SPフッターアコーディオン / Story・Voice スライダー（Splide） / Cross Talk の切り替え
  js/fv-scroll.js    FV のスクロール進行度（デモの __fvP）とイントロの時計。ni-logo.js / fv-copy.js で共用
  js/ni-logo.js      FV のガラス製 NI ロゴ（WebGL, ESモジュール）。下記「FV の 3D ロゴ」参照
  js/fv-copy.js      新卒 FV コピーの演出（流れる光 × スクロールでガラスワイプ）。下記「FV コピーの演出」参照（中途は読み込まない）
  js/fv-unfold.js    中途 FV コピーの登場（文字が横に開く）。下記「FV コピーの登場（中途）」参照
  js/fv-havefun.js   新卒 Have Fun! の演出（画面固定・流れる光・左→右のガラスワイプで出現）。SP はロゴの前に出す（先頭の `SP_FRONT`。false でロゴの背面に戻る。2026-09-17）
  js/fv-frame.js     FV の青いフレーム（右上・左下）をスクロールで拡大して画面外へ逃がす（新卒・中途。TOP 扉は青いフレーム自体を出さない）
  js/fv-photos.js    新卒 FV の写真 4 枚を 3D ロゴと同じ WebGL シーンに置き、浮遊の揺れとスクロールで散って消える動き
  js/fv-message.js   Message の動き（新卒のみ）。demo と同じく画面固定にして JS で動かす（出現 → 定位置 → 半速で抜ける）。中途は読み込まない（静止）
  js/fv-message-card.js 中途 Message の紺のカードをロゴの奥（body 直下の absolute な DOM の板 + ロゴの背景板の層）に敷き、ガラスの NI ロゴが紺を屈折しながらカードの上に透けて見えるようにする
  js/fv-about.js     About を 1 画面に固定し、縦バーのモザイクで開示 → 次セクションが同じモザイクで覆って抜ける（新卒・中途）
  js/fv-entry.js     Entry を demo と同型の縦バーで登場させる（登場中は画面固定）（新卒）
  js/fv-field.js     ロゴまわりの青い点と線（漂う点＋ロゴの角の点。ガラスにも屈折）
  js/fv-blob.js      流体の光の背景。マウスの近くで白く光る（WebGL シェーダ、demo 原文）
  js/fv-intro.js     訪問時イントロ: FV の青いフレームの目型の穴を閉じた状態から開く（新卒のみ。中途・TOP 扉は読み込まない）
  js/footer-insight.js フッターの Insight 筆記体を FV のコピーと同じ左→右の手書きドローで登場させる（全ページ。CSS clip-path、デモの Footer Insight draw-on の移植）
  vendor/three/      three.js r178（min ビルド + 使うアドオンだけ）。import map で `three` / `three/addons/` に割り当て
  vendor/splide/     Splide 4.1.4（スライダー。min JS + core CSS + LICENSE）。Story / Voice で使用（common.js）
  img/common|top|beginner|career|lower|about|development|work-style|office|chart|interview|cross-talk|job-opening|form|editor
```

- BEM。共通パーツ（header / menu / footer）は `header.php` / `template-parts/menu.php` / `footer.php`。
- ブレイクポイント: `〜767px` SP（375基準）/ `768px〜` PC（1440基準、コンテナ max-width 1200/1248）。**境をまたいだら common.js が再読み込みする**（fv-message / fv-about / fv-entry / fv-havefun が読み込み時に PC / SP を決めるため。2026-09-17）。
- デザイントークン（色・フォントサイズ・余白）は `base.css` の `:root` に集約。和文フォント Gen Interface JP（jsDelivr）、欧文 Poppins（Google Fonts）、中途Futureの見出しのみ Shippori Antique。

## アニメーションの差し込み口（FV のロゴ以外は静止）

デザイナーのデモ（`デモ/NI_TOP.html`, three.js）を後で移植する前提で、対象要素に `data-anim` を付けてある。
**demo 準拠なのは新卒 TOP。中途 TOP の FV は Figma 準拠**（通常フローの固定高さ Hero、ロゴは定位置でその場回転、スクロール連動・登場演出なし。下記「FV の 3D ロゴ」参照）。

| data-anim | 要素 | 予定 |
|---|---|---|
| `fv-bg` / `fv-frame` | `.page-bg`（固定背景動画・青いフレーム。フレームはメニューと同じ目型パス＋逆算のインラインSVG） | **実装済み**: フレーム（`js/fv-frame.js`: 進行度 0.02〜0.32 で中心から 4.2 倍まで拡大し角が画面外へ）、流体の光（`js/fv-blob.js`）、点と線（`js/fv-field.js`）。いずれも demo と同じ式 |
| `fv` / `crystal` | `.hero` | **実装済み**: ガラスの NI ロゴを WebGL で描画（`js/ni-logo.js`、画面固定 canvas）。新卒 PC は位置・動きともデモ準拠。**新卒 SP は移動・縮小せず、最初から Figma 470:2672 の位置・大きさ**（`P.spFixed`: `.hero__stage` 比で中心 x 195 / y 524、高さ 288 @375×667。動画ノードとポスター内のロゴ外接矩形から逆算。回転は demo のまま。2026-09-15）。**新卒 SP はさらに、Message（`[data-logo-dock]`）上の定位置（Figma 470:2697 の Frame 2299 → 中心 x 187.8 / y 28.3 @375）がスクロールでロゴまで上がってきたら Message に乗り換え、Have Fun! と一緒に上へ抜ける**（`P.spDock`。2026-09-17 指示。PC は変えない）、写真 4 枚も同じシーンで浮遊・散り（`js/fv-photos.js`）。中途（`.hero[data-fv-static]`）は Figma の配置に固定してその場回転のみ |
| `draw` | `.hero__copy` / `.hero__txt` | **新卒は実装済み**（`js/fv-copy.js`: 手書き風の出現・流れる光・ガラスワイプ）。中途 `.hero__txt` は演出なし（Figma 準拠で CSS のグラデ文字のまま静止。fv-copy.js の DOM モードは残してあるが読み込まない） |
| `havefun` | `.message` | **新卒は実装済み**（`js/fv-havefun.js`）。Message 本文の出現・半速の抜けは `js/fv-message.js`（新卒。中途は静止） |
| `bracket` | `.bracket` | **Future は実装済み**（`js/fv-future.js`: 四隅カッコが中央から広がる・中身フェード・飾りの四角の浮遊）。中途 Info の `.bracket` は未 |
| `marquee` | `.future__marquee` | **実装済み**（`common.js` が 1 セット複製、CSS アニメ 72s で半分ずつ動かして無限ループ。demo の .mq と同じ速さ。視界に入ったら右下→左上へぬるっと登場（上 10vw + 左 9vw、1.25s、demo の .mq.in-view）） |
| `photo-carousel` | `.culture__photos` | 互い違い上下オートカルーセル |
| `entry-transition` | `.entry` | **実装済み**（`js/fv-entry.js`: About と同型の縦バーで下から登場。demo の Footer 下敷きリビールは未）。**SP はスイープなし**（通常フロー。2026-09-15） |
| （なし） | `.footer__deco`（フッターの Insight 筆記体） | **実装済み**（`js/footer-insight.js`: フッターが画面に 12% 入ったら 600ms 後、FV のコピーと同じ ez / 850ms / 上端が先行する斜めの縁で左→右に描かれる。デモの 1700ms ではなく FV の値。CSS clip-path を rAF で動かすので SVG はインライン化していない） |

Project Story（2 件）と Member's Voice（3 件）のスライダーは [Splide](https://splidejs.com/) 4.1.4（MIT、`assets/vendor/splide/`、core CSS のみ）。`common.js` で mount。ループ、カード幅は CSS のまま（`autoWidth`）、1 枚ずつ送り、矢印は既存の `.slider-nav` から `go('<')` / `go('>')`。ドラッグ / スワイプ可。Voice は SP のみスライダーで、PC は `destroy` して 3 枚並べる。

Cross Talk（座談会）は 4 件を HTML に持ち（見出し `.talk__info-item` × 4、大きな写真 `.talk__img-item` × 4、サムネ `.talk-thumb` × 4）、`common.js` が表示中の 1 件を右の大きな写真＋見出しに、残り 3 件を左のサムネ 3 枠に番号順（表示中を除く。左が #01）で出す。矢印（`.slider-nav`）とサムネのクリックで切り替え、写真・サムネ・見出しはいずれもフェード（CSS transition 0.5s。写真とサムネは下の 1 枚を残したまま上にフェードインするクロスフェード）。サムネは JS が `.talk__slot` 3 枠に組み直し、枠ごとに 4 件ぶんの複製を重ねて 1 件だけ `is-active` にする（枠内でクロスフェードさせるため。WP 化では 4 件をループで出すだけでよい）。#02〜#04 の大きな写真はサムネ画像の流用、#02〜#04 の参加者は「テキストテキスト」の仮置き（Figma に文言なし）。

追従ヘッダー（Message（Have Fun!）が出てきたら CTA 固定 / フッターに入る手前で消える。消えるのは **SP のみ**。PC は 2026-09-10 の指示で消さない）は実装済み（`.header.is-fixed` / `.is-hidden`。新卒の `<footer>` に `data-header-hide`、common.js がフッター上端が画面下端の 60px 手前に来たら付ける。2026-09-17 指示「フッターはいる手前で非表示に」。それ以前は Figma のメモ 834:18563「エントリーセクションに差し掛かったら消える」で `.entry` に付けていた。`is-hidden` の見た目は common.css の SP メディアクエリ内）。is-fixed は新卒では `fv-message.js` が Message の出現（entryK > 0.5）に合わせて付け外しし（`header.dataset.fixedBy = 'message'` で `common.js` の FV 通過判定を無効化）、中途（2026-09-13 から fv-message.js を読まない）と TOP 扉は `common.js` が FV `#js-fv` の通過で付ける。
PC の追従時の見た目は Figma 845:22459「追従ヘッダー」: 新卒（`.header--cta`）はボタン 2 つとハンバーガーをまとめて白 70%・ぼかし 4px・角丸 4px の箱（上 8 / 右 8 / 高さ 56）に入れる。箱は `.header__cta` 側に描き（右にハンバーガー 95 + 間隔 16 の余白）、ハンバーガーは透明で箱の右端に重ねる。CTA のない中途・TOP はハンバーガー単体が同じ白い箱（上 8 / 右 8）。
ハンバーガーメニューの開閉（紺の全面 → 目型の穴がまぶたのように開く。demo の `#menuOv` と同じ SVG マスク方式、3本線はバツに変形）も実装済み。穴の形は Figma の FV-Fream / SP_Menu の目型パスそのもので、デザインサイズ（1440x768 / 375x667）では完全一致。他のサイズは viewBox をウィンドウ px にし、右上の角の斜辺が上辺の右端から 192px（SP は 180px）を通る拡大率を JS が二分探索で逆算する。角度は変わらず欠けない。高さ方向は曲線の曲がりの分だけ十数 px 程度の差が出る。
PC は `.header__cta` が FV 内はヘッダー右上、追従時は白い箱。SP は最初から最後まで画面下に固定（Figma 845:18927 の追従ヘッダーも下にボタンが残る配置。以前は FV 通過後に上部へ移していた）。

## FV の 3D ロゴ（WebGL）

デザイナーのデモ（`デモ/NI_TOP.html`、元データは `NI-FV/`）の FV 実装を `assets/js/ni-logo.js` に移植した。新卒・中途の両 TOP で動く。**新卒は位置・大きさ・動きがすべてデモ準拠**（静止画 crystal.png は FV・Message から外した）。

**中途は Figma 準拠の「定位置固定モード」**（`.hero[data-fv-static]`。2026-09-13 に demo 準拠から直した）:
- Hero（`.hero--career`）は画面固定ではなく通常フローの固定高さ（PC 594px / SP 439px = Figma の Hero フレーム実寸。`career.css`）。余白 `.hero-spacer` なし。コピーは px 固定（ブラウザ幅に比例しない）
- ロゴは Hero（`.hero__stage`、PC は max-width 1440 で中央寄せ）座標の定位置に置く（`ni-logo.js` の `P.anchor`: PC はステージ右端から 377px の位置を中心に高さ 554px、SP は左 252.7px / 上 396.5px を中心に高さ 259px。Figma の動画ノード `ni-logo-only_988x936_36s` の配置とポスター内のロゴ外接矩形から逆算）。**PC はロゴを画面に固定**しておき（スクロール 0 のときの画面座標のまま）、Message カード（`[data-logo-dock]`）上の定位置（`P.anchor.pc.dock`: Figma 419:2031 の Frame 1963 → カード右端から 345px / 上から 170px を中心）がスクロールでそこまで上がってきたらカードに乗り換え、以降はカードと一緒に上へ抜ける（1440×768 ではスクロール 557px で乗り換え。x の 8px 差は手前 300px で寄せる）。**SP** は Figma にカード上のロゴが無く、Hero の位置で最初からカードに重なっている（下端が Hero を 87px 超える）ので、最初から文書に固定してページと一緒にスクロールする。どちらも毎フレーム `getBoundingClientRect` で画面座標に直す（canvas は画面固定のまま）
- 動きは Figma の動画（`ni-logo-only_988x936_36s.mp4`、36 秒ループ）と同じ: 縦軸（Y）まわりに一定速度で 36 秒で 1 周（`P.spinPeriod`。左端が手前に来る向き）、傾き `P.staticTilt`（-6°）固定、揺れなし。スクロール連動の移動・回転、イントロのせり上がり（introK）は使わない
- demo 由来の登場演出はなし: 訪問時イントロ（fv-intro.js / `html.is-intro`）、コピーの手書きドロー（fv-copy.js）、Message の出現（fv-message.js）は中途では読み込まない。コピーはデザイナー支給の「Unfold Horizontal」で登場（fv-unfold.js。下記）。青いフレームのスクロール退避（fv-frame.js）、流体の光（fv-blob.js）、点と線（fv-field.js）、About のモザイク（fv-about.js）は残す（進行度は Hero 自身のスクロールアウトで 0→1）

- ロゴ SVG → `ExtrudeGeometry`（面取り付き押し出し）→ `MeshPhysicalMaterial` の透過（transmission）。材質・光・ゆれ・配置の数値はデモの「NI ロゴ」FIX 値そのまま（`ni-logo.js` 冒頭の `P`）。
- canvas は画面固定（`.ni-logo`、`.page-bg` の直後、z-index 0 = 波背景の一つ上・本文 `.page-main`（z 1）の下。写真・コピー・セクション背景はロゴの上に重なる）。ロゴは FV 位置（`fvX / fvY / fvH`）からスクロールに合わせて定位置（`restX / restY / restH`）へ移動しながら 1 回転し、定位置ではゆっくり回り続ける。読み込み時は下から入ってくる（デモのイントロと同じタイミング）。
- 新卒の FV（`.hero`）は demo 準拠で画面固定（`position: fixed`、1 画面ぶん、`.page-main` 内 z -1。components.css。中途は上記のとおり career.css で通常フローに上書き）。コピー・写真はスクロールで流れず、演出がスクロール量に応じて動く。スクロール量は直後の `.hero-spacer`（`data-fv-scroll`。SP は demo FIX 版の scroll-wrap と同じ 150svh、**PC は 250vh**（2026-09-18: FV → Have Fun! の切り替えをゆっくりにする指示。PC の演出は全部進行度基準なので高さだけで全体が遅くなる。演出区間 = 余白 − 1 画面 − 終端 300px なので vh に比例しない: 150vh 211px / 200vh 468px / 220vh 622px / 250vh 852px @768））が担い、`fv-scroll.js` は「余白 − 1 画面」（SP 50svh、PC 100vh）を演出区間 total にする。`common.js` の追従ヘッダー判定もこの余白を見る（中途は余白がないので Hero `#js-fv` の通過を見る）。Message は新卒では `fv-message.js` が動かす。**新卒 PC**（`.message--fixed`）は demo と同じく通常のフローに置かず画面固定（`position: fixed`、フローの高さなし。**新卒 SP は 2026-09-15 からフローモード** = 中途と同じ B。components.css の SP 上書きで `position: relative`、出現だけ同じで以降は 1:1 でスクロールし About がそのまま続く。指示「Message も普通にスクロールして上がっていくように」）: 進行度 0.24〜0.35（**SP は開始だけ 0.20 に早めて 0.20〜0.31**。SP は Have Fun! が Message と一緒に動くので、demo の 0.24 開始だとコピーが消えてから Message が来るまでロゴだけの空白が長い。0.16 開始はコピー・写真と重なる。上がる速さは PC と同じ。2026-09-15）で画面下からヌルっと上げ（easeOutCubic）、上がり切ると見出しが画面上 28.77%（demo の s1-heading）の定位置へ。低い画面で文章の下端が画面下 160px 以内に入らないときは、はみ出し + 160px を進行度 0.28〜0.52（慣性なし・線形）で持ち上げる（demo の rise）。スクロール量が About 開始位置の 52% を超えたら、超えたぶんの 0.5 倍だけ上へ動かす（demo の s1w。通常スクロールの半分の速さで抜ける）。About に完全に覆われたら非表示。**中途**（`.message--card`）は Figma 準拠で Hero 直下に静止（出現アニメなし、`fv-message.js` は読み込まない）。新卒の Message セクションだけは demo と同じくウィンドウ幅に比例して大きくなる（components.css で文字・余白・ボタンを vw 指定。SP 375 / PC 1440 基準）。中途は career.css で px 固定に上書き（SP 本文 18px は Figma 474:9170 の実寸 273×324 = 18px × 行間 2 × 9 行から）。PC のカードは About などと同じくデザイン幅（1392 = 1440 − 24×2）以上には広がらず中央固定。下のセクションは固定サイズのまま。
- スクロール量 → 進行度 p はデモと同じ非線形マップ（FV の高さを total とし、前半 0〜0.36 で移動、終端 `tailPx` で 0.36〜1）に慣性（0.085）。ロゴは画面固定のまま（デモと同じ）。デモではその後 About が固定 FV を覆うので、ここでは波の動画背景が見える範囲だけ描く: `.about`（不透明背景を持つ最初のセクション。別の要素にしたければ `data-logo-end` を付ける）の上端より下を `clip-path` で切り取り、About が画面上端を越えたら描かない。中途は Openings / Pitch / Why の背後にも動画が見えるので、そこまでロゴが出る。
- 固定背景（動画 + 青ベール）を 2D canvas に合成してシーン内の「背景板」にし、ガラスに屈折させる。背景板は透過パスにだけ描くので canvas 自体は透明（下の `.page-bg` がそのまま見える）。裏面を先に別ターゲットへ描く二重屈折、白と青の板からの PMREM 環境光、透過光の ACES 逆変換もデモと同じ構成。
- WebGL が使えない / `prefers-reduced-motion` / URL に `?nowebgl` を付けた場合は何も描かない（FV にロゴは出ない）。
- three.js は `assets/vendor/three/`（r178 の min ビルド + SVGLoader / EffectComposer 系）。`inc/assets.php` が `<head>` に出す `<script type="importmap">` で `three` と `three/addons/` を割り当て、`</body>` の前の `<script type="module">` で読む。ビルド工程なし。ES モジュールなので `file://` では動かない（ローカルサーバで確認すること）。
- デモは PC 想定で vw/vh 基準・ブレイクポイントなし。SP でも同じ式で出るので、SP の見え方（大きさ・切れ方）は要確認。
- 開発用: コンソールの `window.__niLogo` から `P` の数値を変えて `applyMaterials()` / `buildEnv()` を呼ぶと反映される。`progress` で現在の進行度。
- 中途の Message（紺のカード）: **SP（〜767px）は何もしない**（`fv-message-card.js` は SP では init で抜ける）。Figma 474:8465 の SP にはカード上のロゴが無く、ロゴは Hero の下端（カード上端 439px）で紺に隠れるので、DOM の紺のカード（ロゴ canvas より上）がそのまま Hero からはみ出したロゴの下側を隠す（2026-09-15 指示「ロゴをデザインくらいの位置に」。ロゴの中心・大きさ自体は `P.anchor.sp` のまま = 動画ノード x 34.7 / y 204.8 / 435×419 からの逆算と一致）。以下は PC: Figma 419:2031 ではカードにロゴ画像が薄く置かれている。ここでは実物の 3D ロゴがカードの後ろ（画面固定、本文の下）にあるので、`fv-message-card.js` が DOM の紺を透明にし（`.is-card-fx`）、同じ矩形の紺の角丸の「板」（`.message-card-fx`、body 直下・ロゴ canvas の直前に置く `position: absolute` の DOM。文書座標なのでネイティブスクロールで本文の文字と同期する。位置・大きさはレイアウトが変わったときだけ書く）を敷き、同じ絵を画面に出さない canvas にも描いてロゴの背景板の層（Have Fun! と同じ `bgLayers` / `afterVeil`）に登録する。ガラスが紺を屈折するので透明感のあるロゴがカードの上に見える。「Have Fun!」は Figma（ロゴ画像が文字の上）に合わせて板の中に DOM の文字として置き（カード側の computed style からフォント・字間・skew・位置を写す）、カード側の DOM は visibility: hidden にするので、ロゴの奥でガラス越しに屈折する（新卒の fv-havefun.js と同じ考え方）。2026-09-13 までは板を画面固定 canvas にして rAF で追従させていたが、文字より 1〜2 フレーム遅れて見えたので DOM 化した。ロゴ自身は ni-logo.js が毎フレーム位置を計算するので、カードと一緒に動く区間では速いスクロール時にロゴだけ少し遅れる（許容）。MESSAGE / 見出し / 本文は DOM のままロゴの手前。ロゴの描画結果を紺の上に貼る方式（opacity / 乗算 / screen / overlay）は平板・黒い・薄いのいずれかで不採用。ロゴが無い環境は紺のカードのまま。
- まだ移植していないもの: 光の破片（ガラス越しの白い破片）、ヘッダーのバッジのまばたき、Have Fun! の中途版（次フェーズ）。

## FV コピーの登場（中途）: 文字が横に開く

デザイナー支給のサンプル HTML「Unfold Horizontal」を `assets/js/fv-unfold.js` に移植（2026-09-13）。中途 FV（`.hero[data-fv-static]`）のみ。

- 見出し `.hero__title` を 1 文字ずつ `<span class="hero__char">` に分け、`rotateY(-90deg)`・透明 → `rotateY(0)`・不透明 を 0.6s（CSS `hero-unfold`）。開始は 1 文字 0.05s ずつ遅らせ、左から右へ順に起き上がる。行は並行で、2 行目以降は行ごとに 0.25s 遅れて始まる（行はレイアウト上の位置で判定。PC は 2 行で最後の文字が 0.95s 後、SP は 3 行で 1.1s 後に動き出す）。サンプルは perspective なしだが、指示により見出しに `perspective: 800px` を付けて扉のように回す。`<br>`（PC / SP の改行）はそのまま残す
- サブコピー `.hero__sub` は小さいのでまとめてゆっくりフェードイン（見出しで最後に動き出す文字と同時に始まり 1.6s）
- 開始は読み込み直後（ロゴもせり上がりなしで即出る）。文字幅が確定してから動かすため Web フォントの確定（`document.fonts.ready`、最大 1.5s）を待つ。JS が分割するまでのちらつき防止に head のインラインスクリプト（`inc/assets.php`）が `html.is-fv-unfold` を付け、CSS で分割前の見出し・サブを隠す。動き抑制（prefers-reduced-motion）と `?capture` では付けない = 静止表示
- グラデ文字: transform した子には親の `background-clip: text` が効かないので、文字ごとの span に同じグラデを敷き、`background-size` を見出しの幅・`background-position` を文字の位置ぶんずらして行全体で 1 本に見せる。リサイズで測り直す。見出し自身のグラデは分割後に外す（残すと Chrome では文字が 3D 合成されている間だけ先頭に紺の塊が描かれる）

## FV コピーの演出（新卒。中途は 2026-09-13 に外した）

デモの「コピーの屈折ガラスワイプ（案7）」を `assets/js/fv-copy.js` にそのまま移植した。新卒は `.hero__copy`（SVG）が対象。中途の `.hero__txt`（テキスト）向けの DOM モードもコードには残っているが、中途は Figma 準拠で演出なしにしたので読み込んでいない。

- 文字の中を流れる光: 深いロイヤルブルーの面に 3 つの光源（水色・バイオレット・ミッドブルー）が交差するグラデを毎フレーム 2D canvas に描き、文字の形でくり抜く。Insight の筆記体だけ別のより明るく速い光（デモの paintTriLights / paintTriLightsB そのまま）。
- 出現: イントロでロゴが入り始めたら左→右へ手書き風に描かれる（850ms。デモは 1700ms だが速くする指示で短縮。`fv-copy.js` の `REV_DUR`）。
- 消える: ロゴが定位置へ動く間（進行度 0.06〜0.20）にガラス板が右から左へ通過し、屈折で歪ませ・白く漂白し・青→水色の残像を残して消す（WebGL シェーダはデモ原文）。消え切ったら焼き込みも描画も止める。
- 文字マスク（新卒）は現行デザインの `hero_txt.svg` / `hero_txt_sp.svg` から実行時に作る（全体 = レイヤー A、`#Vector_2` = Insight の筆記体 = レイヤー B）。SVG のグループ id を変えたら `fv-copy.js` の `INSIGHT_GROUP` を合わせること。
- 文字マスク（中途）は DOM のテキストから作る: 各行の位置を `Range.getClientRects` で拾い、computed style のフォント・太さ・字間で canvas に描く。CSS の改行・折り返し・フォントがそのまま反映され、Web フォント確定後（`document.fonts.ready`）とリサイズ時に作り直す。
- 配置: 新卒 PC はデモと同じ（画面基準で左 9.1% / 上 22% / 幅 62.639%）。新卒 SP と中途はデモにないので CSS（`.hero__copy` / `.hero__txt`）の位置に合わせる。
- 進行度（慣性つき）とイントロの時計は `fv-scroll.js` でロゴと共用。動き出したら `.hero` に `is-copy-fx` が付き、元の SVG / テキストは隠す（レイアウトと読み上げは残す）。WebGL 不可 / 動き抑制 / `?nowebgl` では静的な SVG / テキストのまま。

## FV の写真 4 枚（新卒）

デモの「FV写真をWebGLシーンに平面配置」を `assets/js/fv-photos.js` に移植した。**現在は PC / SP とも WebGL の板ではなく DOM の `<img>` を transform で動かしている**（2026-09-17。SP はロゴ canvas を 1 倍解像度にして写真が粗くなったため、PC も揃えて WebGL の描画を減らした。動きの式・重なり順は同じ）。PC の位置・大きさはデモの値なので JS で `.hero__stage` 相対の px に当て、SP は CSS のまま。`fv-photos.js` の `DOM_PC = false` で PC だけ WebGL の板（`ni-logo.js` の overlayScene に足し、描画直前のフック `window.__niLogo.hooks` で毎フレーム位置更新）に戻せる。URL `?photos=gl` で一時的に WebGL 版を見比べられる。DOM 版はガラスのロゴに写真が映り込まない（overlayScene に移した時点で映り込みは既になかった）。

- 位置・大きさは PC はデモの値（画面幅・高さに対する比率。左 / 右上 / 下 / 右下）。**SP（〜767px）は Figma 470:2672 の配置**: CSS の `.hero__photo--1〜4`（beginner.css。Figma の Mask group を `.hero__stage` 比で書いたもの）の画面上の矩形をそのまま板の位置・大きさにする（リサイズ時に測り直し。2026-09-14）。どの写真がどこかはデザインと違っていてよい（指示）。静的の hero_photo_01〜04 との対応は `fv-photos.js` の `PHOTOS` 参照。角丸は DOM の写真と同じ `--radius`（Figma のマスク矩形 rx=4）をシェーダで付けている。デモは PNG に約 8px の角丸を焼き込んでいたが、見た目はデザイン優先で 4px（影はなし）。
- 浮遊: 写真ごとに周期の違う sin / cos でゆらゆら（振幅は画面高さの 1.0% / 1.4%）。
- スクロールで消える: 進行度 0.08〜0.36 で上へ 2 画面ぶん抜けながら左右に散って傾き、抜け切ったら描画停止。フェードはしない。
- WebGL 版では板ができたら `.hero` に `is-photos-fx` が付き、DOM の写真は隠す。WebGL が使えなければ DOM の写真がそのまま。

## 訪問時イントロ（新卒のみ）

demo の「サイト訪問時イントロ（青一面→目が開く）」のタイミングを `assets/js/fv-intro.js` に移植。中途は 2026-09-13 に外した（head のインラインスクリプトと fv-intro.js を読み込まない。穴は最初から開いている）。demo は別の青いオーバーレイに小さなレンズ形の穴を開けるが、ここでは元からある FV の青いフレーム（`.page-bg__frame`、右上・左下の目型の穴）を「閉じた状態から開く」ことで表現する（二重にならない。色もフレームのグラデのまま）。

- フレームの SVG は `.page-bg` ではなく `.fv-frame-layer`（固定、z 5 = 本文・ロゴの上、ヘッダーの下。Figma のレイヤー順と同じ）に置く。穴が閉じている間はコンテンツを完全に覆う。
- head のインラインスクリプト（`inc/assets.php`）が `html.is-intro` を付け、JS が動くまで穴を閉じておく（全面フレーム色。ヘッダーも非表示）。TOP 扉は 2026-09-10 の指示でイントロと青いフレーム（右上・左下の三角）自体を外した（TOP 扉には `.fv-frame-layer` / `fv-intro.js` / `fv-frame.js` を出さない）。
- 180ms 待って穴が中央から縦に開く（820ms、easeOut 3.2 乗。開き方は common.js のメニューと同じ式）。開き切る前（180 + 820×0.55 ms）にヘッダーとハンバーガーを 0.5s で出す。
- 穴の開き具合は `window.__fvEyeK`（0〜1）で common.js の `applyEye` に渡す。ロゴが下から入るタイミング（`fv-scroll.js` の introK: 770ms 後）は demo と同じでこの時計と一致。
- 動き抑制 / `?nointro` / `?capture` / `?menu` では出さない。demo の「ヘッダーのバッジのまばたき」は未移植。

## About の固定とモザイク切り替え（新卒・中途）

demo の「メッセージ節 → About キューブ・ディゾルブ（bars モード）」を `assets/js/fv-about.js` に移植。

**SP（〜767px）は固定もモザイクもなし**（2026-09-15 指示「About と Entry の切り替えアニメーションを SP ではなくす」）。`fv-about.js` / `fv-entry.js` は SP では init で抜け、`window.__fvAbout` も作らない。components.css の SP 上書きで `.about-pin` は通常フロー（margin-top 0、高さ auto）、`.about` は sticky でなく通常のブロック、`.after-about` の margin-top 0。新卒の Message も SP ではフローモード（下記）なので、About は Message の直後に普通に続く。ロゴ / Have Fun! の見える範囲は About の上端で切る（`coverTop()` の代わりに `.about` の rect）。判定は読み込み時のみで、ブレイクポイントをまたぐリサイズには追従しない。

- HTML: `.about` を `.about-pin`（直前のフロー要素の下端の `calc(-100svh - 50px)` 手前から、高さ `210svh + 50px`。demo の about-pin と同じ。新卒は Message が画面固定でフローの高さを持たないので FV の余白の直後から始まる）で包み、それより下のセクションを `.after-about` で包む。
- `.about` は pin の中で sticky（`top: -4px`、高さ 1 画面 + 8px）。中身は上下中央、入り切らない低い画面では `.about__inner` を縮小して収める。
- 開示（zone1）: pin 先頭からのスクロールを 0.6 画面で正規化した z が 0.85〜1.25 の間に、縦バー 8 本が下からランダムな順にせり上がって About を覆い出す（`clip-path: path(...)`、256 段階に量子化してキャッシュ。式は demo の buildPath "bars" 原文）。
- 抜け（zone2）: pin 終端の 0.35 画面手前から `.after-about` を画面固定（`.is-fixlock`）にして同じ縦バーで About を覆い、終端で固定を解除（フロー位置と一致するので継ぎ目なし。demo と同じく 3px 手前で解除）。覆う側の先頭に固定背景のクローン（`.after-about__bg`: 白 + 波の動画の複製 + 青ベール、固定中だけ表示）を敷き、縦バーの中から About が透けないようにする（demo の `#fvbgfix` と同じ役割）。抜け終わったら About を `visibility: hidden` にする（透明なセクションの下から透けない）。上に戻れば元に戻る。
- ロゴと Have Fun! の見える範囲は About の上端ではなく「バーの前線」（`window.__fvAbout.coverTop()`）で切る。
- `clip-path: path()` 非対応ブラウザでは不透明度のフェードに落ちる。

## Entry の登場（新卒）

demo の「Entry/Footer の境界スイープ」のうち Entry 側を `assets/js/fv-entry.js` に移植（Footer の下敷きリビールは未）。

- `.entry` を `.entry-pin` で包み、JS がピンの `margin-top = gap(200px) − ex`、`padding-top = ex`、`min-height = Entry の高さ` を設定（ex = min(Entry の高さ, 画面高)）。直前セクションの下端が画面下端から 200px 上がった時点でゾーン開始。
- ゾーン中（z 0〜0.995）は Entry を画面固定（下端合わせ。Entry が画面より高ければ上端合わせ）にし、About と同じ縦バー（`buildBars`、96 段階）で下からせり上がって覆う。z = 1 で固定位置とフロー位置が一致するのでそのまま解除。
- Entry 自体は demo と同じく 1 画面の高さ（`min-height: 100svh`）で中身は上下中央。
- `fv-about.js` の `buildBars` を import して共用。

## Future の登場（新卒・中途）

demo の「Future: 視界到達→四隅へ分離」を `assets/js/fv-future.js` に移植。動きだけ demo 準拠で、見た目（色・サイズ・配置）は Figma のまま。

- 枠（`.future__box`）の上端が画面下端に入ったらすぐ `.is-open`（待ちなし）。demo は IntersectionObserver（セクション 4 割可視）で発火 → 0.4s 待ちだが、体感が遅いので前倒し・短縮している（`fv-future.js` の `LEAD` / `FIRE_DELAY`）。判定は rAF で毎フレーム（IO / scroll は保険）。
- 四隅カッコ（`.bracket__corner`）は最初、枠の中央やや上に小さなカッコとして寄り集まっている（寄せ量 `--cx/--cy` は JS が実寸から計算）。`.is-open` で 0.1s 静止（demo は 0.3s）→ 0.32s `cubic-bezier(.6,0,.9,.5)` で一気に四隅へ。
- 中身（見出し・本文・ボタン）は 0.5s 後に 0.7s でフェード＋16px せり上がり。
- 飾りの四角（`.future__squares span`）は demo の写真と同じく 0.3 倍から跳ねながら拡大して登場（`scale` 0.9s `cubic-bezier(.34,1.56,.64,1)` ＋ フェード 0.55s、遅れ 0.3〜0.95s で個体差）。以降 `ni-float` / `ni-float2`（transform）で浮遊（周期・位相は要素ごと）。
- 初期状態は JS が `.is-fx` を付けてから効く（JS なし・`prefers-reduced-motion` では静止状態のまま）。

## 背景の演出（新卒・中途）: 流体の光と点と線

- `assets/js/fv-blob.js`: demo の「WebGL流体ブロブ背景」。白地に淡いブルー〜ラベンダーの光が漂い、カーソルの近くで白く立ち上がる（動かすほど強く、止まると減衰。カーソルは慣性つきで追従）。固定背景 `.page-bg` の動画の上・フレームの下に画面サイズの WebGL canvas（透明度 0〜0.78）を置く。シェーダはデモ原文。
- `assets/js/fv-field.js`: demo の「背景の点と線」（F.field* の FIX 値）。青い点がロゴのまわり（ロゴの高さ × 1.9 の楕円）を漂い、近い点同士が細い線でつながる。ロゴの前面の角にも点を置く（押し出し形状の輪郭頂点から選ぶ）。FV を出るとフェードアウト（進行度 0.20〜0.27）。同じ canvas を `ni-logo.js` の背景合成にも重ねる（`window.__niLogo.bgLayers`）ので、ガラス越しでも点が屈折して見える。
- どちらも `?nowebgl` / 動き抑制では出ない。

## Have Fun! の演出（新卒。中途は未）

デモの「Have Fun!の屈折ガラスワイプ」を `assets/js/fv-havefun.js` に移植した。

- 位置（PC）は画面固定。左・上は Figma の Message 節の「Have Fun!」（x 705 / y 262 @1440×768 → hero 基準で左 48.96% / 上 34.15%）に合わせる（demo の 54.5% は Figma より右）。幅は demo の HF_W（42.63%。Figma の 188px 2 行の字面と同じ）。canvas は hero の右 60% を覆う。
- 位置（SP）は画面固定にしない（2026-09-14 指示）。Figma 470:2697 では Have Fun! は Message の先頭・本文の上（左 20 / 上 64、232×92、68px）なので、非表示のままの DOM `.message__havefun` の画面上の矩形（fv-message.js の transform 込み）に毎フレーム合わせて描く。大きさは DOM の高さ基準（SVG 255 = PC の DOM 高さ 248）、左右は DOM の中心。canvas は SP では全幅。Message と一緒に上がって半速で抜ける。
- 文字の中を流れる光は FV コピーと同じトリプル光源（位相ずらし）。出現はロゴが定位置へ動いた後（進行度 0.20〜0.32）にガラス板が左→右へ通過し、板の下で歪みながら現れて白く光ってから定着（シェーダはデモ原文）。
- About の上端より下は `clip-path` で切り、About が画面上端を越えたら描かない（動画背景が隠れる範囲＝ロゴと同じ基準。Message は早めに上がってくるので、その下端では切らない）。
- 出た後はそのまま表示し続ける。デモにあった「ロゴの奥の板に移して DOM 側を薄くする」処理は入れていない（このページはロゴが Have Fun! の下に重なる構成なので不要。指示によりフェードなし）。
- 動き出したら `body.is-havefun-fx` が付き、Message セクション側の `.message__havefun` は隠す（レイアウトは維持）。SP もデモの比率のまま出るので見え方は要確認。
- ロゴの背面に置く（demo と同じ）: canvas はロゴ canvas（`.ni-logo`）の直前に画面固定で差し込み（重なり順はロゴの下・波背景の上）、さらに ni-logo.js の `bgLayers` に `{canvas, rect(), afterVeil}` で登録してロゴの背景板の青ベールの後に不透明で描くので、ロゴ越しにはガラスで屈折した Have Fun! がはっきり見える（demo も同じ: Have Fun! の canvas をロゴの下に置き、背景合成に描き込んでいる）。描画はロゴの `hooks` から同じフレームで呼ぶ。ロゴが無いときは従来どおり hero の中（ロゴなしなので前後関係はない）。
- 文字マスクの SVG（`assets/img/beginner/havefun.svg`）の URL は、ページの URL ではなく JS ファイルの場所から解決している（`import.meta.url`。静的版はページからの相対パスだった）。

## 画像について（要差し替え）

- フッター（SP、2026-09-15）: Figma 474:8223 に合わせ、ロゴ（+ 楕円バッジ）を中央、アコーディオン 4 段、その下に Instagram バナー（335×89、グラデ背景・白丸 56 の中に公式グリフ 24・13px 2 行 + 18px）、56 空けて copyright（リンク → ©）。HTML は同じで、`.footer__brand` を `display: contents` にして order で並べ替え。Instagram のグリフは形（`instagram_glyph_mask.svg`、CSS mask）× 公式グラデ画像（`instagram_glyph_gradient.png`）の合成。PC も Figma 474:7156 の新レイアウト: 上 214 / 左右 60 / 下 40、ロゴ行（左ロゴ + バッジ、右に Instagram バナー 294×101）→ 24 → ナビ（上 40 空けて 4 列を両端揃え。「日本インフォメーションを知る」の列はリンク 3 つの右に小見出し 2 列を横並び）→ 56 → copyright。高さ 691（Figma 693.7）。1199px 以下はナビ 2 列×2 段のまま
- 写真は Figma MCP の `download_assets` で元画像（rawImages）を取得し、メタデータの配置座標で Figma のトリミング通りに切り出したもの（2倍解像度、角丸は付けず CSS 側で角丸）。フレームを直接書き出すと角丸や小数位置ずれが黒く出るため、この方式にしている。Figma 上のダミー写真なので、本番写真が決まったら差し替える。Voice の3枚と Project Story の画像は背景装飾込みの合成なのでフレーム書き出し（透明部分はページ地色で埋めて JPG 化）。Voice の背景の形は PC / SP で Figma の Frame 1900 の描かれ方が違うので別画像（`voice_bg_shape.svg` 1763x1230 / `voice_bg_shape_sp.svg` 1103x700。`<picture>` で切り替え。2026-09-15）。Cross Talk のサムネ3枚は元画像そのまま（CSS の cover でトリミング）。
- `img/common/crystal.png` は Figma 上の動画ノード（ni-logo-only）の1フレーム。FV・Message の仮置きは WebGL ロゴに置き換えたので現在は未使用。
- FV 背景は `assets/video/fv_bg.webm / .mp4`（デモ `NI_TOP.html` に base64 埋め込みだった 1920x1080・約20秒ループを抽出）。`img/common/bg_axion_*.png` はそのポスター（1フレーム静止画）。本番前に短尺化・軽量化を検討。
- People & Culture の写真は Figma の12枚を2倍解像度で書き出し済み（`culture_01〜12.jpg`）。
- Recruit pitch / 適性診断バナー / Instagramバナー はプレースホルダ。

## 開発用

- URL に `?capture=1` を付けると `html.is-capture` が付き、`100vh` の FV が固定高（768 / 667）になる。ヘッドレスChromeでフルページ撮影する時用。
- URL に `?menu=1` を付けるとメニューが開いた状態（アニメーションなし）で表示される。撮影・確認用。
- Figma のプロトタイプ用 Notes（追従ヘッダー・アニメーション指示）は Figma の各フレーム脇を参照。
