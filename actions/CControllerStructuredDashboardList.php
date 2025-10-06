<?php

namespace Modules\StructuredDashboard\Actions;

use CControllerDashboardList;
use CControllerResponseData;
use CControllerResponseFatal;

/**
 * Controller for Structured dashboard list
 */
class CControllerStructuredDashboardList extends CControllerDashboardList {

	protected function doAction() {
		parent::doAction();

		$response = $this->getResponse();

		if ($response instanceof CControllerResponseFatal) {
			return $response;
		}

		if ($response instanceof CControllerResponseData) {
			$data = $response->getData();
		} else {
			$data = [];
		}

		// Make dashboards structured
		foreach ($data['dashboards'] as &$dashboard) {
			$positionOfGroupSeparator = strpos($dashboard['name'], '/');

			if ($positionOfGroupSeparator !== false) {
				$dashboard['dashboardGroup'] = substr($dashboard['name'], 0, $positionOfGroupSeparator);
				$dashboard['name'] = substr($dashboard['name'], $positionOfGroupSeparator + 1);
			} else {
				$dashboard['dashboardGroup'] = 'Main dashboards';
			};
		}

		$response = new CControllerResponseData($data);
		$response->setTitle(_('Dashboards'));

		$this->setResponse($response);
	}
}
