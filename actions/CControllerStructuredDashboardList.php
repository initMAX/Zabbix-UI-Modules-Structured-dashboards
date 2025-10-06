<?php
/*
** Copyright (C) 2001-2024 initMAX s.r.o.
**
** This program is free software: you can redistribute it and/or modify it under the terms of
** the GNU Affero General Public License as published by the Free Software Foundation, version 3.
**
** This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
** without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
** See the GNU Affero General Public License for more details.
**
** You should have received a copy of the GNU Affero General Public License along with this program.
** If not, see <https://www.gnu.org/licenses/>.
**/


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
