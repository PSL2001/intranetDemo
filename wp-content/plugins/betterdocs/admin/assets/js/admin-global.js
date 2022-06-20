(function ($) {
    "use strict";
    $(document).ready(function () {
        // Go To Sorting UI
        $("body.post-type-docs .wp-heading-inline").after(
            '<a href="admin.php?page=betterdocs-admin" class="page-title-action">' +
            betterdocs_admin.menu_title +
            "</a>"
        );
    });
})(jQuery);