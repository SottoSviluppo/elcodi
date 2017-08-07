<?php

namespace Elcodi\Component\User\Services;

use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Wrapper\EmptyMoneyWrapper;
use Exception;
use PHPExcel;
use PHPExcel_Writer_Excel2007;
use Symfony\Component\HttpFoundation\Response;

class ExcelCustomerManager
{
    public $translator;
    public $moneyPrinter;
    public $downloadUtility;

    public function __construct(
        $translator,
        $moneyPrinter,
        $downloadUtility
    ) {
        $this->translator = $translator;
        $this->moneyPrinter = $moneyPrinter;
        $this->downloadUtility = $downloadUtility;
    }

    public function getExcelFromCustomers($customers)
    {
        $array = $this->getArrayFromCustomers($customers);
        $filename = 'Customers_' . date('d_m_Y_Hi') . '.xlsx';
        $excelFilePath = $this->createExcelFromArray($array, $filename);
        $this->downloadUtility->downloadFile($excelFilePath, $filename);
        die();
    }

    public function getArrayFromCustomers($customers)
    {
        $array = array();
        $rowHeader = array();

        $rowHeader[] = 'Guest';
        $rowHeader[] = 'Nome';
        $rowHeader[] = 'Cognome';
        $rowHeader[] = 'Nazione';
        $rowHeader[] = 'Mail';
        $rowHeader[] = 'Creato il';
        $rowHeader[] = 'Indirizzo spedizione';
        $rowHeader[] = 'Città spedizione';
        $rowHeader[] = 'Provincia spedizione';
        $rowHeader[] = 'Nazione spedizione';

        $array[] = $rowHeader;

        foreach ($customers as $customer) {
            $row = array();
            $row[] = $customer->getId();
            $row[] = $customer->getFirstname();
            $row[] = $customer->getLastname();
            $row[] = $customer->getCountry();
            $row[] = $customer->getEmail();
            $row[] = $customer->getCreatedAt()->format('d/m/Y');

            // spedizione
            $address = $customer->getDeliveryAddress();
            if ($address) {
                $row[] = $address->getAddress() . ' ' . $address->getAddressMore();
                $row[] = $address->getCity();
                $row[] = $address->getProvince();
                $row[] = $address->getCountry();
            } else {
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
            }

            $row++;
            $array[] = $row;
        }
        return $array;
    }

    public function createExcelFromArray($array, $filename)
    {
        if (!file_exists('media/')) {
            mkdir('media/', 0777, true);
        }

        $path = 'media/' . $filename;

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $count = 0;
        // echo "<pre>";
        // print_r($array);die();
        foreach ($array[0] as $headerCell) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($count, 1, $headerCell);
            $count++;
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:AZ1')->getFont()->setBold(true);

        for ($y = 1; $y < count($array); $y++) {
            $row = $y + 1;
            $rowArray = $array[$y];

            for ($x = 0; $x < count($rowArray); $x++) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($x, $row, $rowArray[$x]);
            }
            $count++;
        }

        foreach (range('A', 'Z') as $letter) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
        }

        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Ordini');

        // Save Excel 2007 file
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($path);

        return $path;
    }

}
