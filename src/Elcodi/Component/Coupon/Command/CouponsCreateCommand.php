<?php

namespace Elcodi\Component\Coupon\Command;

use Elcodi\Component\Core\Command\Abstracts\AbstractElcodiCommand;
use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CouponsCreateCommand extends AbstractElcodiCommand
{
    public $container;
    public $output;
    public $input;

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('elcodi:coupons:create')
            ->setDescription('Crea n coupons')
            ->addArgument('count', InputArgument::REQUIRED, 'Number of codes')
            ->addArgument('chars', InputArgument::REQUIRED, 'Number of characters')
            ->addArgument('amount', InputArgument::REQUIRED, 'Amount in cents')
            ->addArgument('base_name', InputArgument::REQUIRED, 'Base name')
            ->addArgument('free_shipping', InputArgument::REQUIRED, '')
            ->addArgument('start', InputArgument::REQUIRED, '')
            ->addArgument('end', InputArgument::REQUIRED, '')
            ->addArgument('color', InputArgument::REQUIRED, '')
        ;
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $defaultCount = 10;
        $defaultChars = 7;
        $defaultAmount = 100;
        $defaultBaseName = date('Ymd');
        $defaultFreeShipping = 0;
        $defaultStart = date('Ymd');
        $defaultEnd = '20991231';
        $defaultColor = '';

        $count = $this->getHelper('dialog')->askAndValidate($output, "<question>count:</question> [<comment>$defaultCount</comment>]", function ($typeInput) {
            return $typeInput;
        }, 3, $defaultCount);

        $chars = $this->getHelper('dialog')->askAndValidate($output, "<question>chars:</question> [<comment>$defaultChars</comment>]", function ($typeInput) {
            return $typeInput;
        }, 3, $defaultChars);

        $amount = $this->getHelper('dialog')->askAndValidate($output, "<question>amount:</question> [<comment>$defaultAmount</comment>]", function ($typeInput) {
            return $typeInput;
        }, 3, $defaultAmount);

        $baseName = $this->getHelper('dialog')->askAndValidate($output, "<question>baseName:</question> [<comment>$defaultBaseName</comment>]", function ($typeInput) {
            return $typeInput;
        }, 3, $defaultBaseName);

        $freeShipping = $this->getHelper('dialog')->askAndValidate($output, "<question>freeShipping:</question> [<comment>$defaultFreeShipping</comment>]", function ($typeInput) {
            return $typeInput;
        }, 3, $defaultFreeShipping);
        $start = $this->getHelper('dialog')->askAndValidate($output, "<question>start:</question> [<comment>$defaultStart</comment>]", function ($typeInput) {
            return $typeInput;
        }, 3, $defaultStart);
        $end = $this->getHelper('dialog')->askAndValidate($output, "<question>end:</question> [<comment>$defaultEnd</comment>]", function ($typeInput) {
            return $typeInput;
        }, 3, $defaultEnd);
        $color = $this->getHelper('dialog')->askAndValidate($output, "<question>color:</question> [<comment>$defaultColor</comment>]", function ($typeInput) {
            return $typeInput;
        }, 3, $defaultColor);

        $input->setArgument('count', $count);
        $input->setArgument('chars', $chars);
        $input->setArgument('amount', $amount);
        $input->setArgument('base_name', $baseName);
        $input->setArgument('free_shipping', $freeShipping);
        $input->setArgument('start', $start);
        $input->setArgument('end', $end);
        $input->setArgument('color', $color);

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->container = $this->getApplication()->getKernel()->getContainer();
        $this->output = $output;
        $this->input = $input;

        $this
            ->startCommand($output)
            ->createCoupons($input, $output)
            ->finishCommand($output);
    }

    protected function createCoupons(InputInterface $input, OutputInterface $output)
    {
        $count = $this->input->getArgument('count');
        $amount = $this->input->getArgument('amount');
        $chars = $this->input->getArgument('chars');
        $baseName = $this->input->getArgument('base_name');
        $freeShipping = $this->input->getArgument('free_shipping');
        $start = $this->input->getArgument('start');
        $end = $this->input->getArgument('end');
        $color = $this->input->getArgument('color');

        $currency = $this->container->get('elcodi.repository.currency')->findOneByIso('EUR');

        $createdCoupons = "";

        for ($i = 0; $i < $count; $i++) {
            $coupon = $this->generateUniqueCoupon($baseName, $chars);
            $coupon->setType(ElcodiCouponTypes::TYPE_AMOUNT);

            $money = \Elcodi\Component\Currency\Entity\Money::create(
                $amount,
                $currency
            );

            $coupon->setPrice($money);
            $coupon->setFreeShipping($freeShipping);
            $coupon->setColor($color);
            $coupon->setValidFrom(\DateTime::createFromFormat('Ymd', $start));
            $coupon->setValidTo(\DateTime::createFromFormat('Ymd', $end));

            $this->container->get('elcodi.director.coupon')->save($coupon);
            $this->output->writeln('Created coupon ' . $coupon->getCode());

            $createdCoupons .= $coupon->getCode() . "\r\n";
        }

        $filename = 'coupons_' . date('Ymd_hi') . '.txt';
        file_put_contents($filename, $createdCoupons);
        $this->output->writeln('Created file ' . $filename);

        return $this;
    }

    private function generateUniqueCoupon($baseName, $chars)
    {
        $coupon = null;
        while (true) {
            $coupon = $this->container->get('elcodi.manager.coupon')->generateBaseCoupon($baseName, $chars);
            $couponsWithCode = $this->container->get('elcodi.repository.coupon')->findByCode($coupon->getCode());
            if (count($couponsWithCode) == 0) {
                break;
            }
            echo "doppio";
        }
        return $coupon;
    }
}
