<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ReportController extends BaseController
{
    // создать отчет
    public function createReport(Request $request)
    {
        $data = $request->all();
        $city_id = $data['city_id'];

        $count_days = [];
        if (empty($data['range_date']['end'])) {
            // указано дата, а не диапозон
            $start = substr($data['range_date']['start'],0,10);
            $end = null;
            $count_days[] = (int) date('d', strtotime($start));
            $leads = Lead::where('city_id', '=', $city_id)->where(DB::raw('date_format(leads.tm, "%Y-%m-%d")'), '=', $start)->get();
        } else {
            // диапозон
            $start = substr($data['range_date']['start'],0,10);
            $end   = substr($data['range_date']['end'],0,10);
            $sec_start = strtotime($start);
            while ($sec_start <= strtotime($end)) {
                $count_days[] = (int) date('d', $sec_start);
                $sec_start += 86400;
            }
            $leads = Lead::where('city_id', '=', $city_id)->whereBetween(DB::raw('date_format(leads.tm, "%Y-%m-%d")'), [$start, $end])->get();
        }

        $records = array();
        foreach($leads as $lead){
            $type = (int) $lead->type;
            $source = $this->source_list[$type];

            if ($lead->type_app == 1) {
                $source = $source." - Whats'App";
            } elseif ($lead->type_app == 2) {
                $source = $source." - JivoSite";
            }

            $day_month = (int) date('d', strtotime($lead->tm));
            if (array_key_exists($source, $records)) {
                if (array_key_exists($day_month, $records[$source])) {
                    $records[$source][$day_month] += 1;
                } else {
                    $records[$source][$day_month] = 1;
                }
            } else {
                $records[$source][$day_month] = 1;
            }
        }

        $style_array = [
            'font'  => array(
                'size'  => 12,
                'name'  => 'Times New Roman',
                'bold'  => true,
            )
        ];
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'Запросы по группам: '.date('d.m.Y H:i:s'));
        $sheet->getStyle('A1')->applyFromArray([
            'font'  => array(
                'size'  => 16,
                'name'  => 'Times New Roman',
                'bold'  => true,
            )
        ]);
        $sheet->getStyle('A2')->applyFromArray($style_array);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->setCellValue('A2', 'Список источников');

        $columnIndex = 2;
        foreach ($count_days as $count_day){
            $sheet->setCellValueByColumnAndRow($columnIndex, 2, $count_day);
            $sheet->getStyle($this->getLetter($columnIndex).'2')->getAlignment()->setHorizontal('center');
            $sheet->getStyle($this->getLetter($columnIndex).'2')->applyFromArray([
                'font'  => array(
                    'size'  => 16,
                    'name'  => 'Times New Roman',
                    'bold'  => true,
                )
            ]);
            $columnIndex++;
        }

        $rowIndex = 3;
        foreach ($records as $site=>$record) {
            $sheet->setCellValue('A'.$rowIndex, $site);
            foreach($record as $day=>$count) {
                for($colIndex = 2; $colIndex < $columnIndex; $colIndex++) {
                    $letter = $this->getLetter($colIndex);
                    $cellValue = $sheet->getCell($letter.'2')->getValue();
                    if ($cellValue == $day) {
                        $sheet->setCellValue($letter.$rowIndex, $count);
                    } /*else {
                        $sheet->setCellValue($letter.$rowIndex, 0);
                    }*/
                    $sheet->getStyle($letter.$rowIndex)->getAlignment()->setHorizontal('center');
                }
            }
            $rowIndex++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('reports/test.xlsx');
        $filename = '/reports/test.xlsx';
        return $filename;
    }

    public function getLetter($number){
        $arr = [
            1 => 'A',2 => 'B',3 => 'C',4 => 'D',5 => 'E',6 => 'F',7 => 'G',8 => 'H',9 => 'I',10 => 'J',
            11 => 'K',12 => 'L',13 => 'M',14 => 'N',15 => 'O',16 => 'P',17 => 'Q',18 => 'R',19 => 'S',
            20 => 'T',21 => 'U',22 => 'V',23 => 'W',24 => 'X',25 => 'Y',26 => 'Z',27 => 'AA',28 => 'AB',
            29 => 'AC',30 => 'AD',31 => 'AE',32 => 'AF',33 => 'AG',34 => 'AH',35 => 'AI',36 => 'AJ',
            37 => 'AK',38 => 'AL',39 => 'AM',40 => 'AN',41 => 'AO',42 => 'AP',43 => 'AQ',44 => 'AR',
            45 => 'AS',46 => 'AT',47 => 'AU',48 => 'AV',49 => 'AW',50 => 'AX',51 => 'AY',52 => 'AZ',
            53 => 'BA',54 => 'BB',55 => 'BC',56 => 'BD',57 => 'BE',58 => 'BF',59 => 'BG',60 => 'BH',
            61 => 'BI',62 => 'BJ',63 => 'BK',64 => 'BL',65 => 'BM',66 => 'BN',67 => 'BO',68 => 'BP',
            69 => 'BQ',70 => 'BR',71 => 'BS',72 => 'BT',73 => 'BU',74 => 'BV',75 => 'BW',76 => 'BX',
            77 => 'BY',78 => 'BZ',79 => 'CA',80 => 'CB',81 => 'CC',82 => 'CD',83 => 'CE',84 => 'CF',
            85 => 'CG',86 => 'CH',87 => 'CI',88 => 'CJ',89 => 'CK',90 => 'CL',91 => 'CM',92 => 'CN',
            93 => 'CO',94 => 'CP',95 => 'CQ',96 => 'CR',97 => 'CS',98 => 'CT',99 => 'CU',100 => 'CV',
            101 => 'CW',102 => 'CY',103 => 'CZ'
        ];
        if(array_key_exists($number,$arr)){
            return $arr[$number];
        }
    }
}
