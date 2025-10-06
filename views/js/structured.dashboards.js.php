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
        chkbxRange.update('dashboardids');
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