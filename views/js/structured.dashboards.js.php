<?php
/*
** Copyright (C) 2021-2024 initMAX s.r.o.
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


?>

<script>
    (new class {

        init(options) {
            window.addEventListener('load', e => this.run(options));
        }

        run({form_name}) {
            this.form = document.forms[form_name];

            this.bindEvents();
            document.querySelectorAll('[data-checkall="dashboardids"]').forEach(checkbox => this.initCheckAllCheckbox(checkbox));
        }

        bindEvents() {
            this.form.addEventListener('click', e => this.checkAllClickHandler(e));
        }

        checkAllClickHandler(e) {
            const target = e.target;

            if (!target.matches('[data-checkall="dashboardids"]')) {
                return;
            }

            let checkboxes = target.closest('table').querySelectorAll('[name^="dashboardids["]');

            chkbxRange.checkObjectRange('dashboardids', checkboxes[0], checkboxes[checkboxes.length - 1], target.checked);
            //chkbxRange.update('dashboardids');
            chkbxRange.updateGoButton();
        }

        initCheckAllCheckbox(checkbox) {
            let unchecked = Array.prototype.filter.call(
                checkbox.closest('table').querySelectorAll('[name^="dashboardids["]'),
                node => !node.checked
            );

            checkbox.checked = unchecked.length == 0;
        }

    }).init(<?= json_encode([
        'form_name' => $data['form_name']
    ]) ?>);
</script>
