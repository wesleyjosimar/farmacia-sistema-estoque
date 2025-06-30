<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Product;
use app\models\StockMovement;
use yii\filters\AccessControl;

class ReportController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['estoque', 'movimentacoes'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionEstoque()
    {
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => Product::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('estoque', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExportEstoqueCsv()
    {
        $produtos = Product::find()->all();
        $filename = 'estoque_' . date('Ymd_His') . '.csv';
        $csv = "\xEF\xBB\xBF";
        $csv .= "ID;Nome;Categoria;Fabricante;Lote;Código de Barras;Quantidade;Estoque Mínimo;Validade\n";
        foreach ($produtos as $p) {
            $csv .= implode(';', [
                $p->id,
                $p->name,
                $p->category,
                $p->manufacturer,
                $p->batch,
                '"\t' . $p->barcode . '"',
                $p->quantity,
                $p->minimum_stock,
                $p->expiry_date ? '"' . date('d/m/Y', strtotime($p->expiry_date)) . '"' : ''
            ]) . "\n";
        }
        Yii::$app->response->sendContentAsFile($csv, $filename, [
            'mimeType' => 'text/csv',
            'inline' => false,
        ]);
        return;
    }

    public function actionExportEstoquePdf()
    {
        $produtos = Product::find()->all();
        $html = '<h1>Relatório de Estoque Atual</h1>';
        $html .= '<table border="1" cellpadding="5"><tr><th>ID</th><th>Nome</th><th>Categoria</th><th>Fabricante</th><th>Lote</th><th>Código de Barras</th><th>Quantidade</th><th>Estoque Mínimo</th><th>Validade</th></tr>';
        foreach ($produtos as $p) {
            $html .= '<tr>';
            $html .= '<td>' . $p->id . '</td>';
            $html .= '<td>' . $p->name . '</td>';
            $html .= '<td>' . $p->category . '</td>';
            $html .= '<td>' . $p->manufacturer . '</td>';
            $html .= '<td>' . $p->batch . '</td>';
            $html .= '<td>' . $p->barcode . '</td>';
            $html .= '<td>' . $p->quantity . '</td>';
            $html .= '<td>' . $p->minimum_stock . '</td>';
            $html .= '<td>' . $p->expiry_date . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        $pdf = new \mPDF();
        $pdf->WriteHTML($html);
        $pdf->Output('estoque_' . date('Ymd_His') . '.pdf', 'D');
        exit;
    }

    public function actionExportEstoqueXlsx()
    {
        $produtos = Product::find()->all();
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Cabeçalhos
        $headers = ['ID', 'Nome', 'Categoria', 'Fabricante', 'Lote', 'Código de Barras', 'Quantidade', 'Estoque Mínimo', 'Validade'];
        $sheet->fromArray($headers, null, 'A1');
        // Dados
        $row = 2;
        foreach ($produtos as $p) {
            $sheet->setCellValue('A'.$row, $p->id);
            $sheet->setCellValue('B'.$row, $p->name);
            $sheet->setCellValue('C'.$row, $p->category);
            $sheet->setCellValue('D'.$row, $p->manufacturer);
            $sheet->setCellValue('E'.$row, $p->batch);
            $sheet->setCellValueExplicit('F'.$row, $p->barcode, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('G'.$row, $p->quantity);
            $sheet->setCellValue('H'.$row, $p->minimum_stock);
            $sheet->setCellValue('I'.$row, $p->expiry_date ? date('d/m/Y', strtotime($p->expiry_date)) : '');
            $row++;
        }
        // Ajuste automático de largura
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        // Download
        $filename = 'estoque_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function actionMovimentacoes()
    {
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => \app\models\StockMovement::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('movimentacoes', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExportMovimentacoesCsv()
    {
        $movs = StockMovement::find()->orderBy(['created_at' => SORT_DESC])->all();
        $filename = 'movimentacoes_' . date('Ymd_His') . '.csv';
        $csv = "ID;Produto;Usuário;Tipo;Motivo;Quantidade;Data\n";
        foreach ($movs as $m) {
            $csv .= implode(';', [
                $m->id,
                $m->product ? $m->product->name : $m->product_id,
                $m->user ? $m->user->username : $m->user_id,
                $m->type,
                $m->reason,
                $m->quantity,
                $m->created_at ? date('d/m/Y H:i', $m->created_at) : ''
            ]) . "\n";
        }
        Yii::$app->response->sendContentAsFile($csv, $filename, [
            'mimeType' => 'text/csv',
            'inline' => false,
        ]);
        return;
    }

    public function actionExportMovimentacoesPdf()
    {
        $movs = StockMovement::find()->orderBy(['created_at' => SORT_DESC])->all();
        $html = '<h1>Relatório de Movimentações</h1>';
        $html .= '<table border="1" cellpadding="5"><tr><th>ID</th><th>Produto</th><th>Usuário</th><th>Tipo</th><th>Motivo</th><th>Quantidade</th><th>Data</th></tr>';
        foreach ($movs as $m) {
            $html .= '<tr>';
            $html .= '<td>' . $m->id . '</td>';
            $html .= '<td>' . ($m->product ? $m->product->name : $m->product_id) . '</td>';
            $html .= '<td>' . ($m->user ? $m->user->username : $m->user_id) . '</td>';
            $html .= '<td>' . $m->type . '</td>';
            $html .= '<td>' . $m->reason . '</td>';
            $html .= '<td>' . $m->quantity . '</td>';
            $html .= '<td>' . ($m->created_at ? date('d/m/Y H:i', $m->created_at) : '') . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        if (class_exists('mPDF')) {
            $pdf = new \mPDF();
            $pdf->WriteHTML($html);
            $pdf->Output('movimentacoes_' . date('Ymd_His') . '.pdf', 'D');
            exit;
        } else {
            return $this->renderContent('<div class="alert alert-danger">A extensão mPDF não está instalada. Instale via composer: <code>composer require mpdf/mpdf</code></div>' . $html);
        }
    }

    public function actionExportMovimentacoesXlsx()
    {
        $movs = StockMovement::find()->orderBy(['created_at' => SORT_DESC])->all();
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Cabeçalhos
        $headers = ['ID', 'Produto', 'Usuário', 'Tipo', 'Motivo', 'Quantidade', 'Data'];
        $sheet->fromArray($headers, null, 'A1');
        // Dados
        $row = 2;
        foreach ($movs as $m) {
            $sheet->setCellValue('A'.$row, $m->id);
            $sheet->setCellValue('B'.$row, $m->product ? $m->product->name : $m->product_id);
            $sheet->setCellValue('C'.$row, $m->user ? $m->user->username : $m->user_id);
            $sheet->setCellValue('D'.$row, $m->type);
            $sheet->setCellValue('E'.$row, $m->reason);
            $sheet->setCellValue('F'.$row, $m->quantity);
            $sheet->setCellValue('G'.$row, $m->created_at ? date('d/m/Y H:i', $m->created_at) : '');
            $row++;
        }
        // Ajuste automático de largura
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        // Download
        $filename = 'movimentacoes_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
} 