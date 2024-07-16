

<?php
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');


// 出力バッファをクリア
ob_clean();

// テーブルのHTMLを受け取る
// $tableContent = $_POST['tableContent'];

// // 新しいPDFインスタンスを作成（向きを横向きに設定）
// $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// // PDFドキュメントプロパティを設定
// $pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor('Your Name');
// $pdf->SetTitle('HTML Table to PDF');
// $pdf->SetSubject('HTML Table to PDF');
// $pdf->SetKeywords('PDF, HTML, table');

// // ヘッダー／フッターのフォント設定
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// // ページのマージン設定
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// // フォントサブセットを有効にするかどうか
// $pdf->setFontSubsetting(true);

// // フォントを読み込む
// $pdf->SetFont('dejavusans', '', 10, '', true);

// // 新しいページを追加
// $pdf->AddPage();

// // HTMLテーブルを描画
// $pdf->writeHTML($tableContent, true, false, true, false, '');

// // PDFを出力（ファイルとしてダウンロード）
// $pdf->Output('table.pdf', 'D');


// テーブルのHTMLデータを取得します
$tableContent = $_POST['tableContent'];

// 新しいPDFインスタンスを作成します
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);


// PDFのメタデータを設定します
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Shift Schedule');
$pdf->SetSubject('Shift Schedule');
$pdf->SetKeywords('Shift, Schedule, PDF');

// 日本語フォント（IPAexゴシック）を追加します
$fontname = TCPDF_FONTS::addTTFfont('D:\xampp\htdocs\事例研究\kanri\vendor\tecnickcom\tcpdf\fonts\ipaexm.ttf', 'TrueTypeUnicode', '', 32);

// 追加されたフォントを使用します
$pdf->SetFont($fontname, '', 12);

// ページを追加します
$pdf->AddPage();

// // 日本語フォントを設定します
// $pdf->SetFont('ipaexg', '', 12);

// HTMLデータをPDFに描画します
$pdf->writeHTML($tableContent, true, false, true, false, '');

// ファイルを出力します（ダウンロードではなく）
$pdf->Output('shift_schedule.pdf', 'I');// ファイルをダウンロードさせる場合は以下のように変更します
// $pdf->Output('shift_schedule.pdf', 'D');
?>