<?php

namespace Elcodi\Component\Cart\Services;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Wrapper\EmptyMoneyWrapper;
use Exception;
use PHPExcel;
use PHPExcel_Writer_Excel2007;
use Symfony\Component\HttpFoundation\Response;

class ExcelOrderManager
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

    public function getExcelFromOrders($orders)
    {
        $array = $this->getArrayFromOrders($orders);
        $filename = 'Orders_' . date('d_m_Y_Hi') . '.xlsx';
        $excelFilePath = $this->createExcelFromArray($array, $filename);
        $this->downloadUtility->downloadFile($excelFilePath, $filename);
        die();
    }

    public function getArrayFromOrders($orders)
    {
        $array = array();
        $rowHeader = array();

        $rowHeader[] = 'ID Ordine';
        $rowHeader[] = 'Data ordine';
        $rowHeader[] = 'Cliente';
        // $rowHeader[] = 'Metodo di pagamento';
        // $rowHeader[] = 'Stato ordine';
        $rowHeader[] = 'Totale';
        $rowHeader[] = 'Valuta totale';
        // $rowHeader[] = 'Totale coupon';
        // $rowHeader[] = 'Valuta coupon';
        $array[] = $rowHeader;

        foreach ($orders as $order) {
            $row = array();
            $row[] = $order->getId();
            $row[] = $order->getCreatedAt()->format('d/m/Y');
            if ($order->getCustomer() == null) {
                $row[] = '';
            } else {
                $row[] = $order->getCustomer()->__toString();
            }

            // if ($order->getPaymentMethod() == null) {
            //     $row[] = '';
            // } else {
            //     $row[] = $this->translator->trans($order->getPaymentMethod()->getName());
            // }
            // $row[] = $this->translator->trans('common.order.states.' . $order->getShippingStateLineStack()->getLastStateLine()->getName());

            $row[] = $this->moneyPrinter->getDecimalPriceFromPrice($order->getPurchasableAmount());
            $row[] = $order->getPurchasableAmount()->getCurrency()->getIso();

            // $row[] = $this->moneyPrinter->getDecimalPriceFromPrice($order->getCouponAmount());
            // $row[] = $order->getCouponAmount()->getCurrency()->getIso();

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

        $objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->getFont()->setBold(true);

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
