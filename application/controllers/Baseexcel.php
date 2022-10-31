<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Baseexcel extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    cheknologin();
    $this->load->model(array('datarest'));
  }
  public function downloadlaporanaudit()
  {
    $title = $this->input->post('title', true);
    $tgl = $this->input->post('tgl', true);
    $store = $this->input->post('store', true);
    $search = $this->input->post('search', true);
    $cekaudit = $this->datarest->cekaudit($tgl, $store);
    $nama = 'Belum Di Audit';
    $staf = 'Belum Di Audit';
    $status = 'Belum Di Audit';
    if ($cekaudit->num_rows() > 0) {
      $nama = $cekaudit->row()->nama;
      $staf = $cekaudit->row()->pihak_2;
      $status = $cekaudit->row()->status_audit;
    }
    $dt = $this->datarest->exceldifrent($tgl, $store, $search)->result();
    $styleJudul = [
      'font' => [
        'color' => [
          'rgb' => 'FFFFFF'
        ],
        'bold' => true,
        'size' => 11
      ],
      'fill' => [
        'fillType' =>  fill::FILL_SOLID,
        'startColor' => [
          'rgb' => 'e74c3c'
        ]
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER
      ]

    ];
    $styletext = [
      'borders' => [
        'allBorders' => [
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
      ],

    ];
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $spreadsheet->getActiveSheet()->setTitle($title);
    //Set Default Teks
    $spreadsheet->getDefaultStyle()
      ->getFont()
      ->setName('Times New Roman')
      ->setSize(10);
    $spreadsheet->getActiveSheet()
      ->setCellValue('A1', $title);

    $spreadsheet->getActiveSheet()
      ->mergeCells("A1:J1");
    $spreadsheet->getActiveSheet()
      ->getStyle('A1')
      ->getFont()
      ->setSize(20);

    $spreadsheet->getActiveSheet()
      ->getStyle('A1:I1')
      ->getAlignment()
      ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $spreadsheet->getActiveSheet()
      ->setCellValue('C2',strtoupper($nama));
    $spreadsheet->getActiveSheet()
      ->setCellValue('A2', 'Staff Audit : ');
    $spreadsheet->getActiveSheet()
      ->setCellValue('J2',$tgl);
    $spreadsheet->getActiveSheet()
      ->setCellValue('I2', 'Periode : ');


    $spreadsheet->getActiveSheet()
      ->setCellValue('C3',strtoupper($staf));
    $spreadsheet->getActiveSheet()
      ->setCellValue('A3', 'Staff Store : ');
    $spreadsheet->getActiveSheet()
      ->setCellValue('J3',$status);
    $spreadsheet->getActiveSheet()
      ->setCellValue('I3', 'Status Audit : ');

    $spreadsheet->getActiveSheet()
      ->mergeCells("A2:B2");
    $spreadsheet->getActiveSheet()
      ->getStyle('A2')
      ->getFont()
      ->setSize(12);

    $spreadsheet->getActiveSheet()
      ->getStyle('A2:I2')
      ->getAlignment()
      ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $spreadsheet->getActiveSheet()
      ->mergeCells("A3:B3");
    $spreadsheet->getActiveSheet()
      ->getStyle('A3')
      ->getFont()
      ->setSize(12);

    $spreadsheet->getActiveSheet()
      ->getStyle('A3:I3')
      ->getAlignment()
      ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $spreadsheet->getActiveSheet()
      ->setCellValue('A4', "No")
      ->setCellValue('B4', "Ean")
      ->setCellValue('C4', "Item Description")
      ->setCellValue('D4', "Item ID")
      ->setCellValue('E4', "Waist")
      ->setCellValue('F4', "Inseam")
      ->setCellValue('G4', "Ohan QTY")
      ->setCellValue('H4', "Ohan Scan")
      ->setCellValue('I4', "Diffrent")
      ->setCellValue('J4', "Store Name");
    // STYLE judul table
    $spreadsheet->getActiveSheet()
      ->getStyle('A4:J4')
      ->applyFromArray($styleJudul);



    $no = 1;
    $x = 5;
    $qty = 0;
    $scan = 0;
    $diff = 0;
    foreach ($dt as  $row) {
      $diffrent = (int) $row->onhand_scan - (int) $row->onhand_qty;
        $qty +=$row->onhand_qty;
        $scan +=$row->onhand_scan;
        $diff +=$diffrent;
        $sheet->setCellValue('A' . $x, $no++);
        $sheet->setCellValue('B' . $x, $row->ean);
        $sheet->setCellValue('C' . $x, $row->item_description);
        $sheet->setCellValue('D' . $x, $row->item_id);
        $sheet->setCellValue('E' . $x, $row->waist);
        $sheet->setCellValue('F' . $x, $row->inseam);
        $sheet->setCellValue('G' . $x, $row->onhand_qty);
        $sheet->setCellValue('H' . $x, $row->onhand_scan);
        $sheet->setCellValue('I' . $x, $diffrent);
        $sheet->setCellValue('J' . $x, $this->session->userdata('storename'));
      $x++;
    }
    $ii = $x;
     $sheet->setCellValue('A' . $ii,'Total');
     $sheet->setCellValue('G' . $ii,$qty);
     $sheet->setCellValue('H' . $ii,$scan);
     $sheet->setCellValue('I' . $ii,$diff);
    for ($i = 'A'; $i != $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
      $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
    }
    $spreadsheet->getActiveSheet()
      ->getStyle('A5:J' . $x)
      ->applyFromArray($styletext);
    $writer = new Xlsx($spreadsheet);
    ob_start();
    $writer->save('php://output');
    $xlsData = ob_get_contents();
    ob_end_clean();

    $response =  array(
      'respon' => 'Berhasil Di Download',
      'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
    );

    die(json_encode($response));
  }
  public function downloaddiffrent()
  {
    $title = $this->input->post('title', true);
    $tgl = $this->input->post('tgl', true);
    $store = $this->input->post('store', true);
    $search = $this->input->post('search', true);
    $cekaudit = $this->datarest->cekaudit($tgl, $store);
    $nama = 'Belum Di Audit';
    $staf = 'Belum Di Audit';
    $status = 'Belum Di Audit';
    if ($cekaudit->num_rows() > 0) {
      $nama = $cekaudit->row()->nama;
      $staf = $cekaudit->row()->pihak_2;
      $status = $cekaudit->row()->status_audit;
    }
    $dt = $this->datarest->exceldifrent($tgl, $store, $search)->result();
    $styleJudul = [
      'font' => [
        'color' => [
          'rgb' => 'FFFFFF'
        ],
        'bold' => true,
        'size' => 11
      ],
      'fill' => [
        'fillType' =>  fill::FILL_SOLID,
        'startColor' => [
          'rgb' => 'e74c3c'
        ]
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER
      ]

    ];
    $styletext = [
      'borders' => [
        'allBorders' => [
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
      ],

    ];
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $spreadsheet->getActiveSheet()->setTitle($title);
    //Set Default Teks
    $spreadsheet->getDefaultStyle()
      ->getFont()
      ->setName('Times New Roman')
      ->setSize(10);
    $spreadsheet->getActiveSheet()
      ->setCellValue('A1', $title);

    $spreadsheet->getActiveSheet()
      ->mergeCells("A1:J1");
    $spreadsheet->getActiveSheet()
      ->getStyle('A1')
      ->getFont()
      ->setSize(20);

    $spreadsheet->getActiveSheet()
      ->getStyle('A1:I1')
      ->getAlignment()
      ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $spreadsheet->getActiveSheet()
      ->setCellValue('C2',strtoupper($nama));
    $spreadsheet->getActiveSheet()
      ->setCellValue('A2', 'Staff Audit : ');
    $spreadsheet->getActiveSheet()
      ->setCellValue('J2',$tgl);
    $spreadsheet->getActiveSheet()
      ->setCellValue('I2', 'Periode : ');


    $spreadsheet->getActiveSheet()
      ->setCellValue('C3',strtoupper($staf));
    $spreadsheet->getActiveSheet()
      ->setCellValue('A3', 'Staff Store : ');
    $spreadsheet->getActiveSheet()
      ->setCellValue('J3',$status);
    $spreadsheet->getActiveSheet()
      ->setCellValue('I3', 'Status Audit : ');

    $spreadsheet->getActiveSheet()
      ->mergeCells("A2:B2");
    $spreadsheet->getActiveSheet()
      ->getStyle('A2')
      ->getFont()
      ->setSize(12);

    $spreadsheet->getActiveSheet()
      ->getStyle('A2:I2')
      ->getAlignment()
      ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $spreadsheet->getActiveSheet()
      ->mergeCells("A3:B3");
    $spreadsheet->getActiveSheet()
      ->getStyle('A3')
      ->getFont()
      ->setSize(12);

    $spreadsheet->getActiveSheet()
      ->getStyle('A3:I3')
      ->getAlignment()
      ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $spreadsheet->getActiveSheet()
      ->setCellValue('A4', "No")
      ->setCellValue('B4', "Ean")
      ->setCellValue('C4', "Item Description")
      ->setCellValue('D4', "Item ID")
      ->setCellValue('E4', "Waist")
      ->setCellValue('F4', "Inseam")
      ->setCellValue('G4', "Ohan QTY")
      ->setCellValue('H4', "Ohan Scan")
      ->setCellValue('I4', "Diffrent")
      ->setCellValue('J4', "Store Name");
    // STYLE judul table
    $spreadsheet->getActiveSheet()
      ->getStyle('A4:J4')
      ->applyFromArray($styleJudul);



    $no = 1;
    $x = 5;
    foreach ($dt as  $row) {
      $diffrent = (int) $row->onhand_scan - (int) $row->onhand_qty;
      if ($diffrent != 0) {
        $sheet->setCellValue('A' . $x, $no++);
        $sheet->setCellValue('B' . $x, $row->ean);
        $sheet->setCellValue('C' . $x, $row->item_description);
        $sheet->setCellValue('D' . $x, $row->item_id);
        $sheet->setCellValue('E' . $x, $row->waist);
        $sheet->setCellValue('F' . $x, $row->inseam);
        $sheet->setCellValue('G' . $x, $row->onhand_qty);
        $sheet->setCellValue('H' . $x, $row->onhand_scan);
        $sheet->setCellValue('I' . $x, $diffrent);
        $sheet->setCellValue('J' . $x, $this->session->userdata('storename'));
      }
      $x++;
    }
    for ($i = 'A'; $i != $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
      $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
    }
    $spreadsheet->getActiveSheet()
      ->getStyle('A5:J' . $x)
      ->applyFromArray($styletext);
    $writer = new Xlsx($spreadsheet);
    ob_start();
    $writer->save('php://output');
    $xlsData = ob_get_contents();
    ob_end_clean();

    $response =  array(
      'respon' => 'Berhasil Di Download',
      'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
    );

    die(json_encode($response));
  }
  public function rekapchiperlab()
  {
    $title = $this->input->post('title', true);
    $tgl = $this->input->post('tgl', true);
    $store = $this->input->post('store', true);
    $search = $this->input->post('search', true);
    $cekaudit = $this->datarest->cekaudit($tgl, $store);
    $nama = 'Belum Di Audit';
    $staf = 'Belum Di Audit';
    $status = 'Belum Di Audit';
    if ($cekaudit->num_rows() > 0) {
      $nama = $cekaudit->row()->nama;
      $staf = $cekaudit->row()->pihak_2;
      $status = $cekaudit->row()->status_audit;
    }
    $dt = $this->datarest->datachiperlab($tgl, $store, $search)->result();
    $styleJudul = [
      'font' => [
        'color' => [
          'rgb' => 'FFFFFF'
        ],
        'bold' => true,
        'size' => 11
      ],
      'fill' => [
        'fillType' =>  fill::FILL_SOLID,
        'startColor' => [
          'rgb' => 'e74c3c'
        ]
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER
      ]

    ];
    $styletext = [
      'borders' => [
        'allBorders' => [
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
      ],

    ];
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $spreadsheet->getActiveSheet()->setTitle($title);
    //Set Default Teks
    $spreadsheet->getDefaultStyle()
      ->getFont()
      ->setName('Times New Roman')
      ->setSize(10);
    $spreadsheet->getActiveSheet()
      ->setCellValue('A1', $title);

    $spreadsheet->getActiveSheet()
      ->mergeCells("A1:F1");
    $spreadsheet->getActiveSheet()
      ->getStyle('A1')
      ->getFont()
      ->setSize(20);

    $spreadsheet->getActiveSheet()
      ->getStyle('A1:F1')
      ->getAlignment()
      ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $spreadsheet->getActiveSheet()
      ->setCellValue('C2',strtoupper($nama));
    $spreadsheet->getActiveSheet()
      ->setCellValue('A2', 'Staff Audit : ');
    $spreadsheet->getActiveSheet()
      ->setCellValue('F2',$tgl);
    $spreadsheet->getActiveSheet()
      ->setCellValue('E2', 'Periode : ');


    $spreadsheet->getActiveSheet()
      ->setCellValue('C3',strtoupper($staf));
    $spreadsheet->getActiveSheet()
      ->setCellValue('A3', 'Staff Store : ');
    $spreadsheet->getActiveSheet()
      ->setCellValue('F3',$status);
    $spreadsheet->getActiveSheet()
      ->setCellValue('E3', 'Status Audit : ');

    $spreadsheet->getActiveSheet()
      ->mergeCells("A2:B2");
    $spreadsheet->getActiveSheet()
      ->getStyle('A2')
      ->getFont()
      ->setSize(12);

    $spreadsheet->getActiveSheet()
      ->getStyle('A2:I2')
      ->getAlignment()
      ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $spreadsheet->getActiveSheet()
      ->mergeCells("A3:B3");
    $spreadsheet->getActiveSheet()
      ->getStyle('A3')
      ->getFont()
      ->setSize(12);

    $spreadsheet->getActiveSheet()
      ->getStyle('A3:I3')
      ->getAlignment()
      ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $spreadsheet->getActiveSheet()
      ->setCellValue('A4', "No")
      ->setCellValue('B4', "Ean")
      ->setCellValue('C4', "Item ID")
      ->setCellValue('D4', "Location")
      ->setCellValue('E4', "Ohan Scan")
      ->setCellValue('F4', "User");
    // STYLE judul table
    $spreadsheet->getActiveSheet()
      ->getStyle('A4:F4')
      ->applyFromArray($styleJudul);



    $no = 1;
    $x = 5;
    $scan = 0;
    foreach ($dt as  $row) {
        $scan +=$row->onganscan;
        $sheet->setCellValue('A' . $x, $no++);
        $sheet->setCellValue('B' . $x, $row->ean);
        $sheet->setCellValue('C' . $x, $row->item_id);
        $sheet->setCellValue('D' . $x, $row->flor);
        $sheet->setCellValue('E' . $x, $row->onganscan);
        $sheet->setCellValue('F' . $x, $row->nama);
      $x++;
    }
    $ii = $x;
     $sheet->setCellValue('A' . $ii,'Total');
     $sheet->setCellValue('E' . $ii,$scan);
    for ($i = 'A'; $i != $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
      $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
    }
    $spreadsheet->getActiveSheet()
      ->getStyle('A5:F' . $x)
      ->applyFromArray($styletext);
    $writer = new Xlsx($spreadsheet);
    ob_start();
    $writer->save('php://output');
    $xlsData = ob_get_contents();
    ob_end_clean();

    $response =  array(
      'respon' => 'Berhasil Di Download',
      'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
    );

    die(json_encode($response));
  }
  public function rekaphistoris()
  {
    $title = $this->input->post('title', true);
    $search = $this->input->post('search', true);
    $dt = $this->datarest->datahistoris($search)->result();
    $styleJudul = [
      'font' => [
        'color' => [
          'rgb' => 'FFFFFF'
        ],
        'bold' => true,
        'size' => 11
      ],
      'fill' => [
        'fillType' =>  fill::FILL_SOLID,
        'startColor' => [
          'rgb' => 'e74c3c'
        ]
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER
      ]

    ];
    $styletext = [
      'borders' => [
        'allBorders' => [
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
      ],

    ];
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $spreadsheet->getActiveSheet()->setTitle($title);
    //Set Default Teks
    $spreadsheet->getDefaultStyle()
      ->getFont()
      ->setName('Times New Roman')
      ->setSize(10);
    $spreadsheet->getActiveSheet()
      ->setCellValue('A1', $title);

    $spreadsheet->getActiveSheet()
      ->mergeCells("A1:F1");
    $spreadsheet->getActiveSheet()
      ->getStyle('A1')
      ->getFont()
      ->setSize(20);

    $spreadsheet->getActiveSheet()
      ->getStyle('A1:F1')
      ->getAlignment()
      ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $spreadsheet->getActiveSheet()
      ->setCellValue('A4', "No")
      ->setCellValue('B4', "Periode")
      ->setCellValue('C4', "Store Name")
      ->setCellValue('D4', "Staff Audit")
      ->setCellValue('E4', "Staff Store")
      ->setCellValue('F4', "Status Audit");
    // STYLE judul table
    $spreadsheet->getActiveSheet()
      ->getStyle('A4:F4')
      ->applyFromArray($styleJudul);



    $no = 1;
    $x = 5;
    foreach ($dt as  $row) {
        $sheet->setCellValue('A' . $x, $no++);
        $sheet->setCellValue('B' . $x, $row->periode_audit);
        $sheet->setCellValue('C' . $x, $row->nama);
        $sheet->setCellValue('D' . $x, $row->pihak_2);
        $sheet->setCellValue('E' . $x, $row->nama_store);
        $sheet->setCellValue('F' . $x, $row->status_audit);
      $x++;
    }

    for ($i = 'A'; $i != $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
      $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
    }
    $spreadsheet->getActiveSheet()
      ->getStyle('A5:F' . $x)
      ->applyFromArray($styletext);
    $writer = new Xlsx($spreadsheet);
    ob_start();
    $writer->save('php://output');
    $xlsData = ob_get_contents();
    ob_end_clean();

    $response =  array(
      'respon' => 'Berhasil Di Download',
      'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
    );

    die(json_encode($response));
  }
}
