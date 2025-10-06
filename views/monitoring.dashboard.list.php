<?php

/**
 * @var CView $this
 */

if ($data['uncheck']) {
	uncheckTableRows('dashboard');
}
$this->addJsFile('layout.mode.js');

$this->enableLayoutModes();
$web_layout_mode = $this->getLayoutMode();

$html_page = (new CWidget())
	->setTitle(_('Dashboards'))
	->setWebLayoutMode($web_layout_mode)
	->setDocUrl(CDocHelper::getUrl(CDocHelper::MONITORING_DASHBOARD_LIST))
	->setControls(
		(new CTag('nav', true,
			(new CList())
				->addItem(
					(new CRedirectButton(_('Create dashboard'),
						(new CUrl('zabbix.php'))
							->setArgument('action', 'dashboard.view')
							->setArgument('new', '1')
							->getUrl()
					))->setEnabled($data['allowed_edit'])
				)
				->addItem(get_icon('kioskmode', ['mode' => $web_layout_mode]))
			)
		)->setAttribute('aria-label', _('Content controls'))
	);

if ($web_layout_mode == ZBX_LAYOUT_NORMAL) {
	$html_page
		->addItem((new CFilter())
			->setResetUrl((new CUrl('zabbix.php'))->setArgument('action', 'dashboard.list'))
			->setProfile($data['profileIdx'])
			->setActiveTab($data['active_tab'])
			->addFilterTab(_('Filter'), [
				(new CFormList())->addRow(_('Name'),
					(new CTextBox('filter_name', $data['filter']['name']))->setWidth(ZBX_TEXTAREA_FILTER_SMALL_WIDTH)
				),
				(new CFormList())->addRow(_('Show'),
					(new CRadioButtonList('filter_show', (int) $data['filter']['show']))
						->addValue(_('All'), DASHBOARD_FILTER_SHOW_ALL)
						->addValue(_('Created by me'), DASHBOARD_FILTER_SHOW_MY)
						->setModern(true)
				)
			])
			->addVar('action', 'dashboard.list')
		);
}

$form = (new CForm())->setName('dashboardForm');

// Create dashboard tables.
$table_template = (new CTableInfo())
	->addClass(ZBX_STYLE_DASHBOARD_LIST)
	->setHeader([
		(new CColHeader(
			(new CCheckBox('all_dashboards'))->setAttribute('data-checkall', 'dashboardids')
		))->addClass(ZBX_STYLE_CELL_WIDTH),
		make_sorting_header(_('Name'), 'name', $data['sort'], $data['sortorder'],
			(new CUrl('zabbix.php'))
				->setArgument('action', 'dashboard.list')
				->getUrl())
	]);

$tables = [];

foreach ($data['dashboards'] as $dashboard) {
	$tags = [];

	if ($dashboard['userid'] == CWebUser::$data['userid']) {
		$tags[] = (new CSpan(_('My')))->addClass(ZBX_STYLE_STATUS_GREEN);

		if ($dashboard['private'] == PUBLIC_SHARING || count($dashboard['users']) > 0
				|| count($dashboard['userGroups']) > 0) {
			$tags[] = ' ';
			$tags[] = (new CSpan(_('Shared')))->addClass(ZBX_STYLE_STATUS_YELLOW);
		}
	}

	// Create or use existing table for dashboard group.
	if (!array_key_exists($dashboard['dashboardGroup'], $tables)) {
		$tables[$dashboard['dashboardGroup']] = clone $table_template;
	}

	$tables[$dashboard['dashboardGroup']]->addRow([
		(new CCheckBox('dashboardids['.$dashboard['dashboardid'].']', $dashboard['dashboardid']))
			->setEnabled($dashboard['editable']),
		(new CDiv([
			new CLink($dashboard['name'],
				(new CUrl('zabbix.php'))
					->setArgument('action', 'dashboard.view')
					->setArgument('dashboardid', $dashboard['dashboardid'])
					->getUrl()
			),
			$tags ? new CDiv($tags) : null
		]))->addClass(ZBX_STYLE_DASHBOARD_LIST_ITEM)
	]);
}

foreach ($tables as $dashboardGroupName => $table) {
	$form->addItem([
		(new CTag('h1', true, $dashboardGroupName))->addStyle('margin-top: 10px;'),
		$table,
	]);
}

$form->addItem([
	$data['paging'],
	new CActionButtonList('action', 'dashboardids', [
		'dashboard.delete' => [
			'name' => _('Delete'),
			'confirm' => _('Delete selected dashboards?'),
			'disabled' => !$data['allowed_edit'],
			//'csrf_token' => CCsrfTokenHelper::get('dashboard')
		]
	], 'dashboard')
]);

$this->includeJsFile('structured.dashboards.js.php', [
	'form_name' => $form->getName()
]);
$html_page
	->addItem($form)
	->show();
