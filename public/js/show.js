(function () {
    'use strict';

    $('#deleteButton').click(function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();

        $('#deleteModal').modal();
    });

    $('#confirmDelete').click(function(event) {
        $('#deleteForm').submit();
    });
})();
