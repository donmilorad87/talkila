$(function () {
    window._token = $('meta[name="csrf-token"]').attr('content')

    moment.updateLocale('en', {
        week: { dow: 1 } // Monday is the first day of the week
    })

    if (document.getElementsByClassName('date')[0]) {
        $('.date').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: 'en',
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right'
            }
        })
    }

    if (document.getElementsByClassName('datetime')[0]) {
        $('.datetime').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            locale: 'en',
            sideBySide: true,
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right'
            }
        })
    }

    if (document.getElementsByClassName('timepicker')[0]) {
        $('.timepicker').datetimepicker({
            format: 'HH:mm:ss',
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right'
            }
        })
    }

    if (document.getElementsByClassName('select-all')[0]) {
        $('.select-all').on('click', function () {
            let $select2 = $(this).parent().siblings('.select2')
            $select2.find('option').prop('selected', 'selected')
            $select2.trigger('change')
        })
    }

    if (document.getElementsByClassName('deselect-all')[0]) {
        $('.deselect-all').on('click', function () {
            let $select2 = $(this).parent().siblings('.select2')
            $select2.find('option').prop('selected', '')
            $select2.trigger('change')
        })
    }

    if (document.getElementsByClassName('select2')[0]) {
        $('.select2').select2()
    }

    if (document.getElementsByClassName('treeview')[0]) {
        $('.treeview').each(function () {
            var shouldExpand = false
            $(this).find('li').each(function () {
                if ($(this).hasClass('active')) {
                    shouldExpand = true
                }
            })
            if (shouldExpand) {
                $(this).addClass('active')
            }
        })
    }

    if (document.getElementsByClassName('sidebar-togglerl')[0]) {
        $('button.sidebar-toggler').on('click', function () {
            setTimeout(function () {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            }, 275);
        })
    }

})
