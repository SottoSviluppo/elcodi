<?php

namespace Elcodi\Bundle\PermissionsBundle;

use Mmoreram\SymfonyBundleDependencies\DependentBundleInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Elcodi\Bundle\PermissionsBundle\CompilerPass\MappingCompilerPass;
use Elcodi\Bundle\PermissionsBundle\DependencyInjection\ElcodiPermissionsExtension;
use Elcodi\Bundle\CoreBundle\Abstracts\AbstractElcodiBundle;

class ElcodiPermissionsBundle extends AbstractElcodiBundle implements DependentBundleInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MappingCompilerPass());
    }

    /**
     * Returns the bundle's container extension.
     *
     * @return ExtensionInterface The container extension
     */
    public function getContainerExtension()
    {
        return new ElcodiPermissionsExtension();
    }

    /**
     * Create instance of current bundle, and return dependent bundle namespaces.
     *
     * @return array Bundle instances
     */
    public static function getBundleDependencies(KernelInterface $kernel)
    {
        return [
            'Elcodi\Bundle\UserBundle\ElcodiUserBundle',
            'Elcodi\Bundle\ProductBundle\ElcodiProductBundle',
            'Elcodi\Bundle\CurrencyBundle\ElcodiCurrencyBundle',
            'Elcodi\Bundle\CartBundle\ElcodiCartBundle',
            'Elcodi\Bundle\AttributeBundle\ElcodiAttributeBundle',
            'Elcodi\Bundle\CartCouponBundle\ElcodiCartCouponBundle',
            'Elcodi\Bundle\CartShippingBundle\ElcodiCartShippingBundle',
            'Elcodi\Bundle\CouponBundle\ElcodiCouponBundle',
            'Elcodi\Bundle\TaxBundle\ElcodiTaxBundle',
            'Elcodi\Bundle\RuleBundle\ElcodiRuleBundle',
            'Elcodi\Bundle\ShippingBundle\ElcodiShippingBundle',
            'Elcodi\Bundle\StoreBundle\ElcodiStoreBundle',
            'Elcodi\Bundle\CoreBundle\ElcodiCoreBundle',
        ];
    }
}