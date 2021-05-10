<?php

declare(strict_types=1);

namespace GetResponse\GetResponseIntegration\Observer;

use Exception;
use GetResponse\GetResponseIntegration\Api\ApiService;
use GetResponse\GetResponseIntegration\Domain\GetResponse\Contact\Application\ContactService;
use GetResponse\GetResponseIntegration\Domain\GetResponse\Contact\ContactCustomFieldsCollectionFactory;
use GetResponse\GetResponseIntegration\Domain\GetResponse\SubscribeViaRegistration\SubscribeViaRegistrationService;
use GetResponse\GetResponseIntegration\Domain\Magento\LiveSynchronization;
use GetResponse\GetResponseIntegration\Domain\Magento\PluginMode;
use GetResponse\GetResponseIntegration\Domain\Magento\Repository;
use GetResponse\GetResponseIntegration\Helper\MagentoStore;
use GetResponse\GetResponseIntegration\Logger\Logger;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Newsletter\Model\Subscriber;
use Magento\Newsletter\Model\SubscriptionManager;

class CustomerRegisterSuccess implements ObserverInterface
{
    private $request;
    private $subscriptionManager;
    private $magentoStore;
    private $logger;
    private $repository;

    public function __construct(
        RequestInterface $request,
        SubscriptionManager $subscriptionManager,
        MagentoStore $magentoStore,
        Repository $repository,
        Logger $logger
    ) {
        $this->request = $request;
        $this->repository = $repository;
        $this->subscriptionManager = $subscriptionManager;
        $this->magentoStore = $magentoStore;
        $this->logger = $logger;
    }

    public function execute(Observer $observer): CustomerRegisterSuccess
    {
        try {
            $pluginMode = PluginMode::createFromRepository($this->repository->getPluginMode());
            if (!$pluginMode->isNewVersion()) {
                return $this;
            }

            $scope = $this->magentoStore->getCurrentScope();
            $liveSynchronization = LiveSynchronization::createFromRepository(
                $this->repository->getLiveSynchronization($scope->getScopeId())
            );

            if (!$liveSynchronization->shouldImportCustomer()) {
                return $this;
            }

            $subscriptionOption = $this->request->getParam('is_subscribed');
            if ((int)$subscriptionOption === Subscriber::STATUS_SUBSCRIBED) {
                $customerId = (int)$observer->getCustomer()->getId();
                $this->subscriptionManager->subscribeCustomer($customerId, (int)$scope->getScopeId());
            }
        } catch (Exception $e) {
            $this->logger->addError($e->getMessage(), ['exception' => $e]);
        }

        return $this;
    }

}
