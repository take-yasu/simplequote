<?php
namespace App\Library;

use Illuminate\Support\Facades\Auth;
use App\MitsumoriHeader;
use App\MitsumoriDetail;
use TCPDF;


class GetQuotation{
    public function createPdf($denpyou_number){
        $items = MitsumoriHeader::with('mitsumoriDetails')->where('denpyou_number', '=', $denpyou_number)->first();
        $tax = round($items->total_sales * config('const.TAX'));


        $pdf = new TCPDF("P", "mm", "A4", true, "UTF-8" );
        $pdf->SetMargins(0, 0, 0); //マージン無効
        $pdf->SetAutoPageBreak(false); //自動改ページ無効
        $pdf->setPrintHeader(false); //ヘッダー無効
        $pdf->setPrintFooter(false); //フッター無効

        $pdf->setFont('kozminproregular','',10);

        $pdf->addPage();
        $pdf->setFontSize(20);
        $pdf->text(90, 10, '御見積書');

        //伝票№、見積日
        $pdf->setFontSize(10);
        $pdf->text(161, 20, 'No.' . $items->denpyou_number);
        $pdf->Line(160, 25, 205, 25);
        $pdf->text(161, 30, '見積日 ' . mb_substr($items->estimated_Date, 0, 4) . '年' . mb_substr($items->estimated_Date, 5, 2) . '月' . mb_substr($items->estimated_Date, 8, 2) . '日');
        $pdf->Line(160, 35, 205, 35);

        //取引先会社名
        $pdf->setFontSize(17);
        $pdf->text(11, 35, Auth::user()->company_name . '　御中');
        $pdf->Line(10, 43, 90, 43);
        $pdf->setFontSize(12);
        $pdf->text(11, 45, Auth::user()->all_address);
        $pdf->text(11, 50, 'TEL:' . Auth::user()->tel . '  FAX:' . Auth::user()->fax);

        //自社名
        $pdf->setFontSize(15);
        $pdf->text(140, 45, '〇△販売株式会社');
        $pdf->setFontSize(10);
        $pdf->text(140, 55, '〒441-3421');
        $pdf->text(140, 61, '愛知県田原市田原町99-99');
        $pdf->text(140, 67, 'TEL:0531-999-9999');
        $pdf->text(140, 73, 'FAX:0531-888-8888');

        //見積総計
        $pdf->setFontSize(20);
        $pdf->text(15, 70, 'お見積金額  ' . number_format($items->total_sales + $tax) . ' 円');
        $pdf->setFontSize(10);
        $pdf->text(95, 74, '（消費税10％込）');
        $pdf->Line(20, 79, 110, 79);

        //明細
        $pdf->Line(10, 90, 200, 90);
        $pdf->Line(10, 90, 10, 220);
        $pdf->Line(35, 90, 35, 220);
        $pdf->Line(100, 90, 100, 220);
        $pdf->Line(125, 90, 125, 255);
        $pdf->Line(140, 90, 140, 220);
        $pdf->Line(170, 90, 170, 220);
        $pdf->Line(200, 90, 200, 255);
        $pdf->Line(10, 100, 200, 100);
        $pdf->Line(10, 220, 200, 220);
        $pdf->Line(125, 255, 200, 255);

        $pdf->setFontSize(12);
        $pdf->text(17, 93, '品番');
        $pdf->text(59, 93, '品　名');
        $pdf->text(105, 93, '数　量');
        $pdf->text(127, 93, '単位');
        $pdf->text(147, 93, '単　価');
        $pdf->text(177, 93, '金　額');

        $i = 103;
        $pdf->setFontSize(10);
        foreach($items->mitsumoriDetails as $item){
            $pdf->text(12, $i, $item->product_number);
            $pdf->text(40, $i, $item->product_name);
            $pdf->text(103, $i, $item->quantity);
            $pdf->text(127, $i, $item->unit);
            $pdf->SetXY(142, $i);
            $pdf->Cell(25, 5, number_format($item->unit_price), 0, 0, 'R');
            $pdf->SetXY(172, $i);
            $pdf->Cell(25, 5, number_format($item->subtotal), 0, 0, 'R');
            $i = $i + 10;
        }

        //合計
        $pdf->setFontSize(15);
        $pdf->text(135, 225, '小　計');
        $pdf->SetXY(160, 223);
        $pdf->Cell(35, 10, number_format($items->total_sales), 0, 0, 'R');
        $pdf->text(135, 235, '消費税');
        $pdf->SetXY(160, 233);
        $pdf->Cell(35, 10, number_format($tax), 0, 0, 'R');
        $pdf->text(135, 245, '総　計');
        $pdf->SetXY(160, 243);
        $pdf->Cell(35, 10, number_format($items->total_sales + $tax), 0, 0, 'R');

        $pdf->Rect(10, 260, 190, 30, 'D');
        $pdf->setFontSize(12);
        $pdf->text(11, 261, '備考');

        $pdf->output('test' . '.pdf', 'D');
        return;
    }
}
