<?php


class CustomerManagementFramework_Rest_ExportController extends \Pimcore\Controller\Action\Webservice
{
    public function jsonAction()
    {
        $export = \CustomerManagementFramework\Factory::getInstance()->getRESTApiExport();

        $result = null;

        switch($this->getParam('restAction')) {
            case "customers":

                $limit = intval($this->getParam('pageSize', 100));
                $offset = intval($this->getParam('page', 1));

                $params = new \CustomerManagementFramework\Filter\ExportCustomersFilterParams;
                $params->setIncludeActivities($this->getParam('includeActivities') ? true : false);
                $params->setSegments($this->getParam('segments'));
                $params->setAllParams($this->getAllParams());

                $result = $export->customers($limit,$offset,$params);
                break;
            case "activities":
                $pageSize = intval($this->getParam('pageSize', 100));
                $page = intval($this->getParam('page', 1));
                
                $params = new \CustomerManagementFramework\Filter\ExportActivitiesFilterParams();
                $params->setType($this->getParam('type', false));
                $params->setModifiedSinceTimestamp($this->getParam('modifiedSinceTimestamp'));
                $params->setAllParams($this->getAllParams());

                $result = $export->activities($pageSize, $page, $params);
                break;
            case "deletions":

                $entityType = $this->getParam('entityType');
                $deletionsSinceTimestamp = $this->getParam('deletionsSinceTimestamp');

                $result = $export->deletions($entityType, $deletionsSinceTimestamp);
                break;
            case "segments":

                $result = $export->segments($this->getAllParams());
                break;
            case "segment-groups":

                $result = $export->segmentGroups($this->getAllParams());
                break;


        }

        $this->_helper->json($result);
    }
}
