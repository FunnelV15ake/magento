<?php
namespace GetResponse\GetResponseIntegration\Block;

use GetResponse\GetResponseIntegration\Domain\GetResponse\RepositoryException;
use GetResponse\GetResponseIntegration\Domain\GetResponse\RepositoryFactory;
use GrShareCode\ContactList\ContactListService;
use GrShareCode\ContactList\FromFieldsCollection;
use GrShareCode\GetresponseApiException;
use Magento\Framework\View\Element\Template\Context;
use GetResponse\GetResponseIntegration\Domain\Magento\Repository;
use Magento\Framework\View\Element\Template;
use GetResponse\GetResponseIntegration\Helper\Config;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface;

/**
 * Class Lists
 * @package GetResponse\GetResponseIntegration\Block
 */
class Lists extends Template
{
    /** @var Repository */
    private $repository;

    /** @var RepositoryFactory */
    private $repositoryFactory;

    /** @var RedirectFactory */
    private $redirectFactory;

    /** @var ManagerInterface */
    private $messageManager;

    /**
     * @param Context $context
     * @param Repository $repository
     * @param RepositoryFactory $repositoryFactory
     * @param RedirectFactory $redirectFactory
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        Context $context,
        Repository $repository,
        RepositoryFactory $repositoryFactory,
        RedirectFactory $redirectFactory,
        ManagerInterface $messageManager
    ) {
        parent::__construct($context);
        $this->repository = $repository;
        $this->repositoryFactory = $repositoryFactory;
        $this->redirectFactory = $redirectFactory;
        $this->messageManager = $messageManager;
    }

    /**
     * @return FromFieldsCollection|Redirect
     */
    public function getAccountFromFields()
    {
        try {
            $service = new ContactListService($this->repositoryFactory->createGetResponseApiClient());
            return $service->getFromFields();
        } catch (RepositoryException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->redirectFactory->create()->setPath(Config::PLUGIN_MAIN_PAGE);
        } catch (GetresponseApiException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->redirectFactory->create()->setPath(Config::PLUGIN_MAIN_PAGE);
        }
    }

    /**
     * @return array|Redirect
     */
    public function getSubscriptionConfirmationsSubject()
    {
        try {
            $countryCode = $this->repository->getMagentoCountryCode();
            $lang = substr($countryCode, 0, 2);
            $apiClient = $this->repositoryFactory->createGetResponseApiClient();
            return $apiClient->getSubscriptionConfirmationSubject($lang);
        } catch (RepositoryException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->redirectFactory->create()->setPath(Config::PLUGIN_MAIN_PAGE);
        } catch (GetresponseApiException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->redirectFactory->create()->setPath(Config::PLUGIN_MAIN_PAGE);
        }
    }

    /**
     * @return array|Redirect
     */
    public function getSubscriptionConfirmationsBody()
    {
        try {
            $countryCode = $this->repository->getMagentoCountryCode();
            $lang = substr($countryCode, 0, 2);
            $apiClient = $this->repositoryFactory->createGetResponseApiClient();
            return $apiClient->getSubscriptionConfirmationBody($lang);
        } catch (RepositoryException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->redirectFactory->create()->setPath(Config::PLUGIN_MAIN_PAGE);
        } catch (GetresponseApiException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->redirectFactory->create()->setPath(Config::PLUGIN_MAIN_PAGE);
        }
    }

    /**
     * @param string $backUrl
     * @return string
     */
    public function getBackUrl($backUrl = null)
    {
        if (null === $backUrl) {
            $backUrl = $this->getRequest()->getParam('back');
        }
        return $this->createBackUrl($backUrl);
    }

    /**
     * @param string $back
     * @return string
     */
    private function createBackUrl($back)
    {
        switch ($back) {
            case 'export':
                return 'getresponse/export/index';
                break;

            case 'registration':
                return 'getresponse/registration/index';
                break;

            case 'newsletter':
                return 'getresponse/newsletter/index';
                break;
        }
        return '';
    }
}
