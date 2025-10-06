<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Judul Kolom
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Nama File');
$sheet->setCellValue('C1', 'Gambar');

// Styling Header
$headerStyle = [
  'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
  'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
  'fill' => [
    'fillType' => Fill::FILL_SOLID,
    'startColor' => ['rgb' => '4F81BD'] // biru lembut ala Excel
  ],
  'borders' => [
    'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]
  ]
];
$sheet->getStyle('A1:C1')->applyFromArray($headerStyle);

// Data
$files = glob("uploads/*.*");
$row = 2;
foreach ($files as $index => $file) {
  $sheet->setCellValue("A{$row}", $index + 1);
  $sheet->setCellValue("B{$row}", basename($file));

  // Format kolom teks
  $sheet->getStyle("A{$row}:B{$row}")
    ->getAlignment()
    ->setVertical(Alignment::VERTICAL_CENTER);

  // Gambar (embed langsung)
  $drawing = new Drawing();
  $drawing->setPath($file);
  $drawing->setCoordinates("C{$row}");
  $drawing->setWidth(60);
  $drawing->setHeight(60);
  $drawing->setOffsetX(5);
  $drawing->setOffsetY(5);
  $drawing->setWorksheet($sheet);

  // Tinggi baris disesuaikan agar gambar gak kepotong
  $sheet->getRowDimension($row)->setRowHeight(50);

  // Tambahkan border di tiap baris
  $sheet->getStyle("A{$row}:C{$row}")->applyFromArray([
    'borders' => [
      'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]
    ]
  ]);

  $row++;
}

// Auto width kolom teks
foreach (['A', 'B'] as $col) {
  $sheet->getColumnDimension($col)->setAutoSize(true);
}
// Kolom gambar dikasih lebar pas
$sheet->getColumnDimension('C')->setWidth(15);

// Center semua isi kolom “No”
$sheet->getStyle('A2:A' . ($row - 1))
  ->getAlignment()
  ->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Freeze header biar gak ikut scroll
$sheet->freezePane('A2');

// Output Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="rekap_absensi.xlsx"');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
