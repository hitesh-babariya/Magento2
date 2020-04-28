<?php

namespace CustomPackage\EstimatedProfit\Ui\Component\Listing\Column;
 
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\CatalogInventory\Api\StockStateInterface;
 
class EstimatedProfit extends Column
{
 
    /**
     * @var \Magento\Framework\Locale\CurrencyInterface
     */
    protected $localeCurrency;

    protected $_orderRepository;
    protected $_searchCriteria;
    protected $_customfactory;
 
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $criteria,
        \Magento\Framework\Locale\CurrencyInterface $localeCurrency,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        StockStateInterface $stockState,
        array $components = [], array $data = [])
    {
        $this->productRepository = $productRepository;
        $this->_searchCriteria  = $criteria;
        $this->localeCurrency = $localeCurrency;
        $this->storeManager = $storeManager;
        $this->stockState  = $stockState;        
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
 
    public function prepareDataSource(array $dataSource)
    {        
        if (isset($dataSource['data']['items'])) {

            $store = $this->storeManager->getStore(
                $this->context->getFilterParam('store_id', \Magento\Store\Model\Store::DEFAULT_STORE_ID)
            );
            $currency = $this->localeCurrency->getCurrency($store->getBaseCurrencyCode());

            foreach ($dataSource['data']['items'] as & $item) {
                $product  = $this->productRepository->getById($item["entity_id"]);

                
                $qty = $this->stockState->getStockQty($product->getId(), $product->getStore()->getWebsiteId());

                $estimatedProfit = '';
                if($product->getCost() != "" || $product->getCost() != null)
                {
                    $estimatedProfit = ($product->getPrice() - $product->getCost())* $qty;
                    $estimatedProfit = $currency->toCurrency(sprintf("%f", $estimatedProfit));
                }
                              
                $product->setEstimatedProfit($estimatedProfit)
                        ->save();

                
                $item['estimated_profit'] = $estimatedProfit;
            }
            
        }
        return $dataSource;
    }
}
